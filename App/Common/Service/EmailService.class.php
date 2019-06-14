<?php
// +----------------------------------------------------------------------
// | 邮件服务层
// +----------------------------------------------------------------------
// | 主要服务于邮件发送
// +----------------------------------------------------------------------
// | 错误编码头 204xxx
// +----------------------------------------------------------------------
namespace Common\Service;

class EmailService
{

    // 邮箱配置
    protected $emailConfig = [];

    // 错误信息
    protected $errorMessage = '';

    public function __construct()
    {
        // 获取当前系统邮箱配置
    }

    /**
     * 获取错误信息
     */
    public function getError()
    {

    }

    /**
     * 发送邮件
     * @param $mailData
     */
    public function send($mailData)
    {

    }
}