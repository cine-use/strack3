<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\MfaService;
use Common\Service\UserService;

class UserController extends VerifyController
{
    /**
     * 获取个人偏好设置
     */
    public function getUserPreference()
    {
        $userService = new UserService();
        $userId = session('user_id');
        $resData = $userService->getUserSystemConfig($userId);
        return json($resData);
    }

    /**
     * 更新个人偏好设置
     */
    public function saveUserPreference()
    {
        $userId = session('user_id');
        $param = $this->request->param();
        $userService = new UserService();
        $resData = $userService->updateUserSystemConfig($userId, $param);
        return json($resData);
    }

    /**
     * 获取用户安全设置
     * @return \Think\Response
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     */
    public function getUserSecurity()
    {
        $userService = new UserService();
        $userId = session('user_id');
        $userSystemConfig = $userService->getUserSystemConfig($userId);
        if (array_key_exists("mfa", $userSystemConfig)) {
            $resData["mfa"] = $userSystemConfig["mfa"];
        } else {
            $resData["mfa"] = "no";
        }
        $mfaService = new MfaService();
        $resData["qrcode_url"] = $mfaService->getQRCodeUrl($userId);
        return json($resData);
    }

    /**
     * 保存用户安全设置
     */
    public function saveUserSecurity()
    {
        $userId = session('user_id');
        $param = $this->request->param();
        $userService = new UserService();
        $userPreferenceData = $userService->getUserSystemConfig($userId);
        $userPreferenceData["mfa"] = $param["mfa"] > 0 ? 'yes' : 'no';
        $resData = $userService->updateUserSystemConfig($userId, $userPreferenceData);
        return json($resData);
    }

    /**
     * 保存用户过滤面板设置
     */
    public function saveUserFilterKeepConfig()
    {
        $param = $this->request->param();
        $param['user_id'] = session('user_id');
        $param['type'] = "filter_stick";
        $userService = new UserService();
        $resData = $userService->savePreference($param, L("Modify_User_Filter_Keep_SC"), false);
        return json($resData);
    }

    /**
     * 获取当前用户信息
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getMyAccountData()
    {
        $userId = session('user_id');
        $userService = new UserService();
        $resData = $userService->getMyAccountData($userId);
        return json($resData);
    }

    /**
     * 修改当前用户信息
     */
    public function modifyMyAccount()
    {
        $userId = session('user_id');
        $param = $this->request->param();
        $userService = new UserService();
        $resData = $userService->modifyMyAccount($userId, $param);
        return json($resData);
    }

    /**
     * 获取头像 根据cookie来返回用户基本信息json
     */
    public function getUserInfo()
    {
        $userId = session('user_id');
        //读取redis中数据信息
        $userDataCache = S('user_' . $userId);
        if (!empty($userDataCache) && isset($userDataCache)) {
            return json($userDataCache);
        } else {
            //如果redis缓存不存在从数据库获取
            $userService = new UserService();
            $resData = $userService->getUserInfo($userId);
            return json($resData);
        }
    }

    /**
     * 保存更新面板设置
     */
    public function saveDialogSetting()
    {
        $requestParam = $this->request->param();
        $param = [
            'user_id' => session('user_id'),
            'config' => json_decode(htmlspecialchars_decode($requestParam["fields"]), true),
            'type' => $requestParam['type'],
            'page' => $requestParam['page']
        ];
        $userService = new UserService();
        $resData = $userService->saveDialogSetting($param);
        return json($resData);
    }

    /**
     * 保存用户配置
     */
    public function modifyUserConfig()
    {
        $param = $this->request->param();
        $userService = new UserService();
        $resData = $userService->modifyUserConfig($param);
        return json($resData);
    }

    /**
     * 保存用户模板配置
     * @return \Think\Response
     */
    public function modifyUserTemplateConfig()
    {
        $param = $this->request->param();
        $userService = new UserService();
        $updateData = [
            'page' => $param['module_code'],
            'type' => $param['category'],
            'template_id' => $param['template_id'],
            'config' => $param['config'],
            'user_id' => session('user_id')
        ];
        $resData = $userService->modifyUserConfig($updateData);
        return json($resData);
    }
}