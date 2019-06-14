<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace Think\Exception;

class StrackException extends \RuntimeException
{
    private $errorCode;
    private $headers;
    private $responseData;
    private $responseType;

    /**
     * StrackException constructor.
     * StrackException constructor.
     * @param int $errorCode
     * @param null $message
     * @param array $data
     * @param string $type
     * @param \Exception|null $previous
     * @param array $headers
     */
    public function __construct($errorCode = 404, $message = null, $data = [], $type = 'json', \Exception $previous = null, array $headers = [])
    {
        $this->errorCode = $errorCode;
        $this->headers = $headers;
        $this->responseType = $type;

        $this->responseData = [
            "status" => $errorCode,
            "message" => $message,
            "data" => $data
        ];

        parent::__construct($message, $errorCode, $previous);
    }

    public function getResponseType()
    {
        return $this->responseType;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getResponseData()
    {
        return $this->responseData;
    }
}
