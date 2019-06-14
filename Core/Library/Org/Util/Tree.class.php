<?php
/**
 * Created by PhpStorm.
 * User: chengwei
 * Date: 2015/11/9
 * Time: 17:52
 */

namespace Org\Util;


class Tree{
    private $OriginalList;
    public $pk;//主键字段名
    public $parentKey;//上级id字段名
    public $childrenKey;//用来存储子分类的数组key名

    function __construct($pk="id",$parentKey="pid",$childrenKey="children"){
        if(!empty($pk) && !empty($parentKey) && !empty($childrenKey)){
            $this->pk=$pk;
            $this->parentKey=$parentKey;
            $this->childrenKey=$childrenKey;
        }else{
            return false;
        }
    }
    //载入初始数组
    function load($data){
        if(is_array($data)){
            $this->OriginalList=$data;
        }
    }

    /**
     * 生成嵌套格式的树形数组
     * array(..."children"=>array(..."children"=>array(...)))
     */
    function DeepTree($root=0){
        if(!$this->OriginalList){
            return FALSE;
        }
        $OriginalList=$this->OriginalList;
        $tree=array();//最终数组
        $refer=array();//存储主键与数组单元的引用关系
        //遍历
        foreach($OriginalList as $k=>$v){
            if(!isset($v[$this->pk]) || !isset($v[$this->parentKey]) || isset($v[$this->childrenKey])){
                unset($OriginalList[$k]);
                continue;
            }
            $refer[$v[$this->pk]]=&$OriginalList[$k];//为每个数组成员建立引用关系
        }
        //遍历2
        foreach($OriginalList as $k=>$v){
            if($v[$this->parentKey]==$root){//根分类直接添加引用到tree中
                $tree[]=&$OriginalList[$k];
            }else{
                if(isset($refer[$v[$this->parentKey]])){
                    $parent=&$refer[$v[$this->parentKey]];//获取父分类的引用
                    $parent[$this->childrenKey][]=&$OriginalList[$k];//在父分类的children中再添加一个引用成员
                }
            }
        }
        return $tree;
    }
}


