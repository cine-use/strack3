<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        // 暂时隐藏工作台 啥时候设计明白了就加回来
        $this->redirect('project/index');
    }
}