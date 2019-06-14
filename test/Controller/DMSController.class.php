<?php

namespace Test\Controller;

use Common\Service\OptionsService;
use Think\Controller;
use Dms\Server;

class DMSController extends Controller
{

    /**
     * 测试连接服务器
     */
    public function connect()
    {
        echo '<pre>';
        $url = "http://192.168.31.108:9092";
        var_dump($url);
        $result = $this->httpCode($url);
        var_dump(date("Y-m-d", time()));
        var_dump($result);

        $url2 = "http://www.baidu.com";
        var_dump($url2);
        $result2 = $this->httpCode($url2);
        var_dump(date("Y-m-d", time()));
        var_dump($result2);
        echo '</pre>';
    }


    /**
     * 获取Cdn配置
     * @return mixed
     */
    protected function getCdnSetting()
    {
        $optionsService = new OptionsService();
        return $optionsService->getOptionsData("cdn_settings");
    }

    /**
     * 获取媒体
     * @param string $name
     */
    public function getMedia()
    {
        $cdnSetting = $this->getCdnSetting();
        $image = new Server($cdnSetting);
        var_dump($image);
    }


    /**
     * @param $url
     * @return mixed
     */
    function httpCode($url)
    {
        $ch = curl_init();
        $timeout = 10;
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_exec($ch);
        $httpData = [];
        $httpData["http_code"] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpData["connect_time"] = curl_getinfo($ch, CURLINFO_CONNECT_TIME);
        // 关闭cURL资源，并且释放系统资源
        curl_close($ch);
        return $httpData;
    }
}