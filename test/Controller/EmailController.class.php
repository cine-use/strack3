<?php

namespace Test\Controller;


use Think\Controller;
use Ws\Http\Request;
use Ws\Http\Request\Body;


class EmailController extends Controller
{
    protected $_headers = ['Accept' => 'application/json'];

    public $param = [
        "config" => [
            "host" => "smtp.qq.com",
            "port" => "465",
            "username" => "480442942@qq.com",
            "password" => "sofecpkrvldkbgcd",
            "addresser" => "480442942@qq.com",
            "addresser_name" => "发件人名称",
            'addressee' => 'sep9999@126.com',
            'addressee_name' => '收件人名称',
            "subject" => "Strack_Subject",
            "addAddress" => "sep9999@126.com",
            'language' => 'zh-cn',
            'smtp_secure' => 'ssl',
            "charset" => "UTF-8"
        ],
        "template" => "invite.html",
        "content" => [
            "subject" => "标题",
            "synopsis" => "找回密码操作",
            "url" => "https://www.baidu.com",
            "message" => "消息",
            "username" => "strack用户",
            "operate" => "点击此处登录系统",
            "forData" => [
                "data" => "第一步",
                "data2" => "第一步",
                "data3" => "第三部"
            ],
            "stepData" => [
                "第一步" => "正文内容",
                "第二步" => "正文内容"
            ],
            "itemData" => [
                "负责人" => "sep",
                "任务内容" => "测试邮件模板"
            ],
            "urlOperate" => "url操作",
            "footer" => "Copyright © 2016-2018 Strack . All rights reserved.",
        ],

    ];


    /**
     * 远程请求数据
     * @param $data
     * @param $url
     * @return \Ws\Http\Response
     */
    protected function postData($data, $url)
    {
        $http = Request::create();
        $body = Body::form($data);
        $responseData = $http->post($url, $this->_headers, $body);
        return $responseData;
    }


    /**
     *发送邮件
     */
    public function send()
    {
        $url = 'http://192.168.31.36:9082/email/send?sign=e50c2b047b3ac26953582c5434c08090';
        for ($i = 0; $i < 200; $i++) {
            $resData = $this->postData($this->param, $url);
            dump($resData);
        }
    }

    /**
     * 测试邮件发送
     */
    public function testSend()
    {
        $url = 'http://192.168.31.36:9082/email/test?sign=e50c2b047b3ac26953582c5434c08090';
        $resData = $this->postData($this->param, $url);
        dump($resData);
    }

}