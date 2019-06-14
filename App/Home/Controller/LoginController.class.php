<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\MfaService;
use Common\Service\LoginService;
use Common\Service\MessageService;
use Common\Service\OptionsService;
use Common\Service\UserService;

class LoginController extends VerifyController
{

    /**
     * 获取备案号
     */
    protected function assignBeiAnNumber()
    {
        $optionsService = new OptionsService();
        $defaultSettings = $optionsService->getOptionsData("default_settings");
        $beianNumber = "";
        if (!empty($defaultSettings) && array_key_exists("default_beian_number", $defaultSettings)) {
            $beianNumber = $defaultSettings["default_beian_number"];
        }
        $this->assign("beian_number", $beianNumber);
    }

    /**
     * 判断是否显示注册按钮
     */
    protected function checkShowRegisterButton()
    {
        $optionsService = new OptionsService();
        $defaultSettings = $optionsService->getOptionsData("default_mode");
        $allowRegister = "no";
        if (!empty($defaultSettings) && array_key_exists("open_register", $defaultSettings)) {
            $allowRegister = $defaultSettings["open_register"] == 1 ? "yes" : "no";
        }
        $this->assign([
            'allow_register' => $allowRegister
        ]);
    }

    /**
     * 显示登录页面
     */
    public function index()
    {
        $this->assignBeiAnNumber();
        // 判断是否显示注册按钮
        $this->checkShowRegisterButton();
        return $this->display();
    }


    /**
     * 显示找回用户登录密码
     */
    public function forget()
    {
        $this->assignBeiAnNumber();
        return $this->display();
    }

    /**
     * 显示注册页面
     * @return mixed
     */
    public function register()
    {
        $this->assignBeiAnNumber();
        return $this->display();
    }

    /**
     * 身份二次验证
     */
    public function identity2fa()
    {
        if(session("?user_id")){
            $this->assignBeiAnNumber();
            return $this->display();
        }else{
            $this->redirect('/login');
        }
    }

    /**
     * 回退到登录页面
     */
    public function backToLoginPage()
    {
        // session
        session(null);
        return success_response();
    }

    /**
     * 验证登陆二次验证
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     * @throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
     */
    public function verify2faCode()
    {
        $param = $this->request->param();
        $mfaService = new MfaService();
        $resData = $mfaService->verify2faCode($param["login_2fa_code"]);
        return $resData;
    }

    /**
     * 获取注册验证码
     */
    public function verifyCode()
    {
        $Verify = new \Think\Verify();
        $Verify->entry('register');
    }

    /**
     * 发送验证短信
     * @return \Think\Response
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * @throws \Overtrue\EasySms\Exceptions\NoGatewayAvailableException
     */
    public function sendSMS()
    {
        $param = $this->request->param();
        // 验证
        $messageService = new MessageService();
        $resData = $messageService->sendRegisterSMS($param);
        return json($resData);
    }

    /**
     * 提交注册用户
     * @return \Think\Response
     */
    public function registerUser()
    {
        $param = $this->request->param();
        $userService = new UserService();
        $resData = $userService->registerUser($param);
        return json($resData);
    }

    /**
     * 重置密码页面
     */
    public function resetPassword()
    {
        $param = $this->request->param();
        $this->assignBeiAnNumber();
        // 验证找回密码页面token是否合法
        $userService = new UserService();
        $resData = $userService->verifyPassRequest($param["token"]);
        $this->assign($resData);
        return $this->display();
    }

    /**
     * 验证登录操作
     * @throws \Exception
     */
    public function verifyLogin()
    {
        $param = $this->request->param();
        $loginService = new LoginService();
        $resData = $loginService->login($param);
        return json($resData);
    }


    /**
     * 获取第三方登录服务列表
     */
    public function getThirdServerList()
    {
        $optionsService = new OptionsService();
        $resData = $optionsService->getThirdServerList();
        return json($resData);
    }


    /**
     * 获取找回密码请求地址
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getForgetLoginRequest()
    {
        $param = $this->request->param();
        $userService = new UserService();
        $resData = $userService->getForgetLoginRequest($param);
        return json($resData);
    }

    /**
     * 修改用户密码
     */
    public function modifyUserPassword()
    {
        $param = $this->request->param();
        $userService = new UserService();
        $resData = $userService->modifyUserPassword($param);
        return json($resData);
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        // session
        session(null);

        // 跳转
        $this->redirect('/Login/index');
    }

}