<?php
namespace Home\Controller;

use Think\Controller;
use Org\OAuth\ThinkOAuth2;

class OAuthController extends Controller
{

    private $oauth = NULL;
    private $_user_id;

    function _initialize()
    {
        $this->oauth = new ThinkOAuth2();
    }

    /**
     * 获取应用网站数据
     */
    public function getRedirectUri()
    {
        $clientId = $_GET['client_id'];
        $userId = $_SESSION['user_id'];

        if ($this->oauth->checkClientCredentials($clientId)) {

            //判断应用是否为授权应用
            $client = $this->oauth->getRedirectUri($clientId);
            $code = md5($clientId . $userId);

            //构建验证码  这里可以采用自己的一些加密手段
            $redirectUri = $client . '?code=' . $code;

            //定义回调函数
            if (!$this->oauth->getAuthCode($code)) {
                //判断验证码的存在，不存在就创建
                $this->oauth->setAuthCode($code, $userId, $clientId, $redirectUri, 3600);
            }

        }
        echo '<a href="' . $redirectUri . '">授权</a>';
    }

    /**
     * 获取到应用网站token
     */
    public function getAccessToken()
    {
        $userData = $this->oauth->checkUser($_POST['code']);
        $access_token = md5($userData['id'] . $_POST['code']);

        if (!$this->oauth->getAccessToken($access_token)) {
            //不存在登陆过的用户要创建授权码
            $this->oauth->setAccessToken($access_token, $userData['id'], $_POST['client_id'], $_POST['code'], time() + 3600);//为新用户创建授权码
        }

        //获取用户授权码
        $data = $this->oauth->getAccessToken($access_token);
        echo json_encode($data[0]);
    }

    /**
     * 获取用户信息
     */
    public function getLoggedInUser()
    {
        $access_token = $_GET['access_token'];
        $data = $this->oauth->getAccessToken($access_token);
        if ($access_token == md5($data[0]['user_id'] . $data[0]['refresh_token'])) {
            $user = M('member')->field('uid,username')->find($data[0]['user_id']);
            $user['uname'] = $user['username'];
        }
        echo json_encode($user);
    }
}