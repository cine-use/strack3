<?php
// +----------------------------------------------------------------------
// | 关注方法服务层
// +----------------------------------------------------------------------
// | 主要服务于关注数据处理
// +----------------------------------------------------------------------
// | 错误编码头 207xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\UserModel;
use PragmaRX\Google2FAQRCode\Google2FA;

class MfaService
{
    protected $google2fa;

    protected $companyName = 'strack';

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }


    /**
     * 生成密钥
     * @param int $userId
     * @return string
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     */
    protected function generateSecretKey()
    {
        return $this->google2fa->generateSecretKey();
    }

    /**
     * 获取用户二次验证所需要数据
     * @param $userId
     * @return mixed
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     */
    protected function getUserLoginSecretData($userId)
    {
        $userModel = new UserModel();
        $userData = $userModel->field("email,login_secret_key")->where(["id" => $userId])->find();
        if (!(array_key_exists("login_secret_key", $userData) && !empty($userData["login_secret_key"]))) {
            $userData["login_secret_key"] = $this->generateSecretKey();
            $userModel->where(["id" => $userId])->setField("login_secret_key", $userData["login_secret_key"]);
        }
        return $userData;
    }

    /**
     * 保存创建用户登录秘钥
     * @param $userId
     * @param $loginSecretKey
     */
    protected function saveUserLoginSecret($userId, $loginSecretKey)
    {
        $userModel = new UserModel();
        $userModel->where(["id" => $userId])->setField("login_secret_key", $loginSecretKey);
    }

    /**
     * 获取二维码路径 strack_admin 数据['company'=> 'cineuse', 'holder'=>'strack@foxmail.com', 'secret'=>'RFASLZAGI3GKDNNT']
     * @param $userId
     * @return string
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     */
    public function getQRCodeUrl($userId)
    {
        $userData = $this->getUserLoginSecretData($userId);
        $inlineUrl = $this->google2fa->getQRCodeInline(
            'strack',
            $userData["email"],
            $userData["login_secret_key"]
        );
        return $inlineUrl;
    }

    /**
     * @param $code
     * @return bool|int
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     * @throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
     */
    public function verify2faCode($code)
    {
        $userId = session("user_id");
        $userData = $this->getUserLoginSecretData($userId);
        $valid = $this->google2fa->verifyKey($userData["login_secret_key"], $code);
        if ($valid) {
            session("mfa_verify_expire_time", time() + 3600);
            return success_response(L("Login_2FA_Code_Verify_SC"));
        } else {
            throw_strack_exception(L("Login_2FA_Code_Verify_Error"));
        }
    }
}