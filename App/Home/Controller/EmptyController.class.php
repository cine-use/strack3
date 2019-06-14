<?php

namespace Home\Controller;

use Think\Controller;

class EmptyController extends Controller
{
    protected function _empty()
    {
        $this->redirect('/error/e404');
    }
}