<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Think\Model;

use Common\Model\FieldModel;
use function GuzzleHttp\default_ca_bundle;
use Think\Model;
use Think\Hook;

/**
 * ThinkPHP关联模型扩展
 */
class RelationModel extends Model
{

    const HAS_ONE = 1;
    const BELONGS_TO = 2;
    const HAS_MANY = 3;
    const MANY_TO_MANY = 4;

    // 关联定义
    protected $_link = array();

    // 定义返回数据
    public $_resData = [];

    // 字段数据源映射源数据字段
    public $_fieldFromDataDict = [];

    // 远端一对多水平关联字段多个查询上一个查询方法
    protected $prevRemoteQueryMethod = '';

    // 远端一对多水平关联字段多个查询当前查询方法
    protected $currentRemoteQueryMethod = '';

    /**
     * 动态方法实现
     * @access public
     * @param string $method 方法名称
     * @param array $args 调用参数
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (strtolower(substr($method, 0, 8)) == 'relation') {
            $type = strtoupper(substr($method, 8));
            if (in_array($type, array('ADD', 'SAVE', 'DEL'), true)) {
                array_unshift($args, $type);
                return call_user_func_array(array(&$this, 'opRelation'), $args);
            }
        } else {
            return parent::__call($method, $args);
        }
    }

    /**
     * 数据库Event log Hook
     */
    protected function databaseEventLogHook($param)
    {
        Hook::listen('event_log', $param);
    }

    /**
     * 得到关联的数据表名
     * @param $relation
     * @return string
     */
    public function getRelationTableName($relation)
    {
        $relationTable = !empty($this->tablePrefix) ? $this->tablePrefix : '';
        $relationTable .= $this->tableName ? $this->tableName : $this->name;
        $relationTable .= '_' . $relation->getModelName();
        return strtolower($relationTable);
    }

    /**
     * 查询成功后的回调方法
     * @param $result
     * @param $options
     */
    protected function _after_find(&$result, $options)
    {
        // 获取关联数据 并附加到结果中
        if (!empty($options['link'])) {
            $this->getRelation($result, $options['link']);
        }
    }

    /**
     * 查询数据集成功后的回调方法
     * @param $result
     * @param $options
     */
    protected function _after_select(&$result, $options)
    {
        // 获取关联数据 并附加到结果中
        if (!empty($options['link'])) {
            $this->getRelations($result, $options['link']);
        }

    }

    /**
     * 写入成功后的回调方法
     * @param $pk
     * @param $pkName
     * @param $data
     * @param $options
     */
    protected function _after_insert($pk, $pkName, $data, $options)
    {
        //写入事件日志
        if ($options["model"] != "EventLog") {
            $this->databaseEventLogHook([
                'operate' => 'create',
                'primary_id' => $pk,
                'primary_field' => $pkName,
                'data' => $data,
                'param' => $options,
                'table' => $this->getTableName()
            ]);
        }

        // 关联写入
        if (!empty($options['link'])) {
            $this->opRelation('ADD', $data, $options['link']);
        }
    }

    /**
     * 更新成功后的回调方法
     * @param $result
     * @param $pkName
     * @param $data
     * @param $options
     * @param $writeEvent
     */
    protected function _after_update($result, $pkName, $data, $options, $writeEvent)
    {
        //写入事件日志
        if ($result > 0 && $options["model"] != "EventLog" && $writeEvent) {
            $this->databaseEventLogHook([
                'operate' => 'update',
                'primary_id' => $this->oldUpdateKey,
                'primary_field' => $pkName,
                'data' => ["old" => $this->oldUpdateData, "new" => $this->newUpdateData],
                'param' => $options,
                'table' => $this->getTableName()
            ]);
        }

        // 关联更新
        if (!empty($options['link'])) {
            $this->opRelation('SAVE', $data, $options['link']);
        }

    }

    /**
     * 删除成功后的回调方法
     * @param $result
     * @param $pkName
     * @param $data
     * @param $options
     */
    protected function _after_delete($result, $pkName, $data, $options)
    {
        //写入事件日志
        if ($result > 0 && $options["model"] != "EventLog") {
            $this->databaseEventLogHook([
                'operate' => 'delete',
                'primary_id' => $this->oldDeleteKey,
                'primary_field' => $pkName,
                'data' => $this->oldDeleteData,
                'param' => $options,
                'table' => $this->getTableName()
            ]);
        }

        // 关联删除
        if (!empty($options['link'])) {
            $this->opRelation('DEL', $data, $options['link']);
        }

    }

    /**
     * 对保存到数据库的数据进行处理
     * @access protected
     * @param mixed $data 要操作的数据
     * @return boolean
     */
    protected function _facade($data)
    {
        $this->_before_write($data);
        return $data;
    }

    /**
     * 获取返回数据集的关联记录
     * @access protected
     * @param array $resultSet 返回数据
     * @param string|array $name 关联名称
     * @return array
     */
    protected function getRelations(&$resultSet, $name = '')
    {
        // 获取记录集的主键列表
        foreach ($resultSet as $key => $val) {
            $val = $this->getRelation($val, $name);
            $resultSet[$key] = $val;
        }
        return $resultSet;
    }

    /**
     * 获取返回数据的关联记录
     * @access protected
     * @param mixed $result 返回数据
     * @param string|array $name 关联名称
     * @param boolean $return 是否返回关联数据本身
     * @return array
     */
    protected function getRelation(&$result, $name = '', $return = false)
    {
        if (!empty($this->_link)) {
            foreach ($this->_link as $key => $val) {
                $mappingName = !empty($val['mapping_name']) ? $val['mapping_name'] : $key; // 映射名称
                if (empty($name) || true === $name || $mappingName == $name || (is_array($name) && in_array($mappingName, $name))) {
                    $mappingType = !empty($val['mapping_type']) ? $val['mapping_type'] : $val; //  关联类型
                    $mappingClass = !empty($val['class_name']) ? $val['class_name'] : $key; //  关联类名
                    $mappingFields = !empty($val['mapping_fields']) ? $val['mapping_fields'] : '*'; // 映射字段
                    $mappingCondition = !empty($val['condition']) ? $val['condition'] : '1=1'; // 关联条件
                    $mappingKey = !empty($val['mapping_key']) ? $val['mapping_key'] : $this->getPk(); // 关联键名
                    if (strtoupper($mappingClass) == strtoupper($this->name)) {
                        // 自引用关联 获取父键名
                        $mappingFk = !empty($val['parent_key']) ? $val['parent_key'] : 'parent_id';
                    } else {
                        $mappingFk = !empty($val['foreign_key']) ? $val['foreign_key'] : strtolower($this->name) . '_id'; //  关联外键
                    }
                    // 获取关联模型对象
                    $model = D($mappingClass);
                    switch ($mappingType) {
                        case self::HAS_ONE:
                            $pk = $result[$mappingKey];
                            $mappingCondition .= " AND {$mappingFk}='{$pk}'";
                            $relationData = $model->where($mappingCondition)->field($mappingFields)->find();
                            if (!empty($val['relation_deep'])) {
                                $model->getRelation($relationData, $val['relation_deep']);
                            }
                            break;
                        case self::BELONGS_TO:
                            if (strtoupper($mappingClass) == strtoupper($this->name)) {
                                // 自引用关联 获取父键名
                                $mappingFk = !empty($val['parent_key']) ? $val['parent_key'] : 'parent_id';
                            } else {
                                $mappingFk =
                                    !empty($val['foreign_key']) ? $val['foreign_key'] : strtolower($model->getModelName()) . '_id'; //  关联外键
                            }
                            $fk = $result[$mappingFk];
                            $mappingCondition .= " AND {$model->getPk()}='{$fk}'";
                            $relationData = $model->where($mappingCondition)->field($mappingFields)->find();
                            if (!empty($val['relation_deep'])) {
                                $model->getRelation($relationData, $val['relation_deep']);
                            }
                            break;
                        case self::HAS_MANY:
                            $pk = $result[$mappingKey];
                            $mappingCondition .= " AND {$mappingFk}='{$pk}'";
                            $mappingOrder = !empty($val['mapping_order']) ? $val['mapping_order'] : '';
                            $mappingLimit = !empty($val['mapping_limit']) ? $val['mapping_limit'] : '';
                            // 延时获取关联记录
                            $relationData = $model->where($mappingCondition)->field($mappingFields)->order($mappingOrder)->limit($mappingLimit)->select();
                            if (!empty($val['relation_deep'])) {
                                foreach ($relationData as $key => $data) {
                                    $model->getRelation($data, $val['relation_deep']);
                                    $relationData[$key] = $data;
                                }
                            }
                            break;
                        case self::MANY_TO_MANY:
                            $pk = $result[$mappingKey];
                            $prefix = $this->tablePrefix;
                            $mappingCondition = " {$mappingFk}='{$pk}'";
                            $mappingOrder = $val['mapping_order'];
                            $mappingLimit = $val['mapping_limit'];
                            $mappingRelationFk = $val['relation_foreign_key'] ? $val['relation_foreign_key'] : $model->getModelName() . '_id';
                            if (isset($val['relation_table'])) {
                                $mappingRelationTable = preg_replace_callback("/__([A-Z_-]+)__/sU", function ($match) use ($prefix) {
                                    return $prefix . strtolower($match[1]);
                                }, $val['relation_table']);
                            } else {
                                $mappingRelationTable = $this->getRelationTableName($model);
                            }
                            $sql = "SELECT b.{$mappingFields} FROM {$mappingRelationTable} AS a, " . $model->getTableName() . " AS b WHERE a.{$mappingRelationFk} = b.{$model->getPk()} AND a.{$mappingCondition}";
                            if (!empty($val['condition'])) {
                                $sql .= ' AND ' . $val['condition'];
                            }
                            if (!empty($mappingOrder)) {
                                $sql .= ' ORDER BY ' . $mappingOrder;
                            }
                            if (!empty($mappingLimit)) {
                                $sql .= ' LIMIT ' . $mappingLimit;
                            }
                            $relationData = $this->query($sql);
                            if (!empty($val['relation_deep'])) {
                                foreach ($relationData as $key => $data) {
                                    $model->getRelation($data, $val['relation_deep']);
                                    $relationData[$key] = $data;
                                }
                            }
                            break;
                    }
                    if (!$return) {
                        if (isset($val['as_fields']) && in_array($mappingType, array(self::HAS_ONE, self::BELONGS_TO))) {
                            // 支持直接把关联的字段值映射成数据对象中的某个字段
                            // 仅仅支持HAS_ONE BELONGS_TO
                            $fields = explode(',', $val['as_fields']);
                            foreach ($fields as $field) {
                                if (strpos($field, ':')) {
                                    list($relationName, $nick) = explode(':', $field);
                                    $result[$nick] = $relationData[$relationName];
                                } else {
                                    $result[$field] = $relationData[$field];
                                }
                            }
                        } else {
                            $result[$mappingName] = $relationData;
                        }
                        unset($relationData);
                    } else {
                        return $relationData;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * 操作关联数据
     * @access protected
     * @param string $opType 操作方式 ADD SAVE DEL
     * @param mixed $data 数据对象
     * @param string $name 关联名称
     * @return mixed
     */
    protected function opRelation($opType, $data = '', $name = '')
    {
        $result = false;
        if (empty($data) && !empty($this->data)) {
            $data = $this->data;
        } elseif (!is_array($data)) {
            // 数据无效返回
            return false;
        }
        if (!empty($this->_link)) {
            // 遍历关联定义
            foreach ($this->_link as $key => $val) {
                // 操作制定关联类型
                $mappingName = $val['mapping_name'] ? $val['mapping_name'] : $key; // 映射名称
                if (empty($name) || true === $name || $mappingName == $name || (is_array($name) && in_array($mappingName, $name))) {
                    // 操作制定的关联
                    $mappingType = !empty($val['mapping_type']) ? $val['mapping_type'] : $val; //  关联类型
                    $mappingClass = !empty($val['class_name']) ? $val['class_name'] : $key; //  关联类名
                    $mappingKey = !empty($val['mapping_key']) ? $val['mapping_key'] : $this->getPk(); // 关联键名
                    // 当前数据对象主键值
                    $pk = $data[$mappingKey];
                    if (strtoupper($mappingClass) == strtoupper($this->name)) {
                        // 自引用关联 获取父键名
                        $mappingFk = !empty($val['parent_key']) ? $val['parent_key'] : 'parent_id';
                    } else {
                        $mappingFk = !empty($val['foreign_key']) ? $val['foreign_key'] : strtolower($this->name) . '_id'; //  关联外键
                    }
                    if (!empty($val['condition'])) {
                        $mappingCondition = $val['condition'];
                    } else {
                        $mappingCondition = array();
                        $mappingCondition[$mappingFk] = $pk;
                    }
                    // 获取关联model对象
                    $model = D($mappingClass);
                    $mappingData = isset($data[$mappingName]) ? $data[$mappingName] : false;
                    if (!empty($mappingData) || 'DEL' == $opType) {
                        switch ($mappingType) {
                            case self::HAS_ONE:
                                switch (strtoupper($opType)) {
                                    case 'ADD': // 增加关联数据
                                        $mappingData[$mappingFk] = $pk;
                                        $result = $model->add($mappingData);
                                        break;
                                    case 'SAVE': // 更新关联数据
                                        $result = $model->where($mappingCondition)->save($mappingData);
                                        break;
                                    case 'DEL': // 根据外键删除关联数据
                                        $result = $model->where($mappingCondition)->delete();
                                        break;
                                }
                                break;
                            case self::BELONGS_TO:
                                break;
                            case self::HAS_MANY:
                                switch (strtoupper($opType)) {
                                    case 'ADD': // 增加关联数据
                                        $model->startTrans();
                                        foreach ($mappingData as $val) {
                                            $val[$mappingFk] = $pk;
                                            $result = $model->add($val);
                                        }
                                        $model->commit();
                                        break;
                                    case 'SAVE': // 更新关联数据
                                        $model->startTrans();
                                        $pk = $model->getPk();
                                        foreach ($mappingData as $vo) {
                                            if (isset($vo[$pk])) {
                                                // 更新数据
                                                $mappingCondition = "$pk ={$vo[$pk]}";
                                                $result = $model->where($mappingCondition)->save($vo);
                                            } else {
                                                // 新增数据
                                                $vo[$mappingFk] = $data[$mappingKey];
                                                $result = $model->add($vo);
                                            }
                                        }
                                        $model->commit();
                                        break;
                                    case 'DEL': // 删除关联数据
                                        $result = $model->where($mappingCondition)->delete();
                                        break;
                                }
                                break;
                            case self::MANY_TO_MANY:
                                $mappingRelationFk = $val['relation_foreign_key'] ? $val['relation_foreign_key'] : $model->getModelName() . '_id'; // 关联
                                $prefix = $this->tablePrefix;
                                if (isset($val['relation_table'])) {
                                    $mappingRelationTable = preg_replace_callback("/__([A-Z_-]+)__/sU", function ($match) use ($prefix) {
                                        return $prefix . strtolower($match[1]);
                                    }, $val['relation_table']);
                                } else {
                                    $mappingRelationTable = $this->getRelationTableName($model);
                                }
                                if (is_array($mappingData)) {
                                    $ids = array();
                                    foreach ($mappingData as $vo) {
                                        $ids[] = $vo[$mappingKey];
                                    }

                                    $relationId = implode(',', $ids);
                                }
                                switch (strtoupper($opType)) {
                                    case 'ADD': // 增加关联数据
                                        if (isset($relationId)) {
                                            $this->startTrans();
                                            // 插入关联表数据
                                            $sql = 'INSERT INTO ' . $mappingRelationTable . ' (' . $mappingFk . ',' . $mappingRelationFk . ') SELECT a.' . $this->getPk() . ',b.' . $model->getPk() . ' FROM ' . $this->getTableName() . ' AS a ,' . $model->getTableName() . " AS b where a." . $this->getPk() . ' =' . $pk . ' AND  b.' . $model->getPk() . ' IN (' . $relationId . ") ";
                                            $result = $model->execute($sql);
                                            if (false !== $result) // 提交事务
                                            {
                                                $this->commit();
                                            } else // 事务回滚
                                            {
                                                $this->rollback();
                                            }
                                        }
                                        break;
                                    case 'SAVE': // 更新关联数据
                                        if (isset($relationId)) {
                                            $this->startTrans();
                                            // 删除关联表数据
                                            $this->table($mappingRelationTable)->where($mappingCondition)->delete();
                                            // 插入关联表数据
                                            $sql = 'INSERT INTO ' . $mappingRelationTable . ' (' . $mappingFk . ',' . $mappingRelationFk . ') SELECT a.' . $this->getPk() . ',b.' . $model->getPk() . ' FROM ' . $this->getTableName() . ' AS a ,' . $model->getTableName() . " AS b where a." . $this->getPk() . ' =' . $pk . ' AND  b.' . $model->getPk() . ' IN (' . $relationId . ") ";
                                            $result = $model->execute($sql);
                                            if (false !== $result) // 提交事务
                                            {
                                                $this->commit();
                                            } else // 事务回滚
                                            {
                                                $this->rollback();
                                            }

                                        }
                                        break;
                                    case 'DEL': // 根据外键删除中间表关联数据
                                        $result = $this->table($mappingRelationTable)->where($mappingCondition)->delete();
                                        break;
                                }
                                break;
                        }
                        if (!empty($val['relation_deep'])) {
                            $model->opRelation($opType, $mappingData, $val['relation_deep']);
                        }
                    }
                }
            }
        }
        return $result;
    }

    /**
     * 进行关联查询
     * @access public
     * @param mixed $name 关联名称
     * @return Model
     */
    public function relation($name)
    {
        $this->options['link'] = $name;
        return $this;
    }

    /**
     * 关联数据获取 仅用于查询后
     * @access public
     * @param string $name 关联名称
     * @return array
     */
    public function relationGet($name)
    {
        if (empty($this->data)) {
            return false;
        }

        return $this->getRelation($this->data, $name, true);
    }

    /**
     * 新增数据，成功返回当前添加的一条完整数据
     * @param array $param 新增数据参数
     * @return array|bool|mixed
     */
    public function addItem($param = [])
    {
        $this->resetDefault();
        if ($this->create($param, self::MODEL_INSERT)) {
            $result = $this->add();
            if (!$result) {
                //新增失败
                return false;
            } else {
                //新增成功，返回当前添加的一条完整数据
                $pk = $this->getPk();
                $this->_resData = $this->where([$pk => $result])->find();
                $this->successMsg = L('Add_' . $this->name . '_SC');
                return $this->_resData;
            }
        } else {
            //数据验证失败，返回错误
            return false;
        }
    }

    /**
     * 修改数据，必须包含主键，成功返回当前修改的一条完整数据
     * @param array $param 修改数据参数
     * @return array|bool|mixed
     */
    public function modifyItem($param = [])
    {

        $this->resetDefault();
        if ($this->create($param, self::MODEL_UPDATE)) {
            $result = $this->save();
            if (!$result) {
                // 修改失败
                if ($result === 0) {
                    // 没有数据被更新
                    $this->error = L('_NO_DATA_CHANGED_');
                    return false;
                } else {
                    return false;
                }
            } else {
                // 修改成功，返回当前修改的一条完整数据
                $pk = $this->getPk();
                $this->_resData = $this->where([$pk => $param[$pk]])->find();
                $this->successMsg = L('Modify_' . $this->name . '_SC');
                return $this->_resData;
            }
        } else {
            // 数据验证失败，返回错误
            return false;
        }
    }

    /**
     * 更新单个组件基础方法
     * @param $data
     * @return array|bool|mixed
     */
    public function updateWidget($data)
    {
        $this->resetDefault();
        if ($this->create($data, self::MODEL_UPDATE)) {
            $result = $this->save();
            if (!$result) {
                if ($result === 0) {
                    // 没有数据被更新
                    $this->error = L('_NO_DATA_CHANGED_');
                    return false;
                } else {
                    return false;
                }
            } else {
                $pk = $this->getPk();
                $this->_resData = $this->where([$pk => $data[$pk]])->find();
                return $this->_resData;
            }
        } else {
            // 数据验证失败，返回错误
            return false;
        }
    }


    /**
     * 删除数据
     * @param array $param
     * @return mixed
     */
    public function deleteItem($param = [])
    {
        $this->resetDefault();
        $result = $this->where($param)->delete();
        if (!$result) {
            // 数据删除失败，返回错误
            if ($result == 0) {
                // 没有数据被删除
                $this->error = L('_NO_DATA_CHANGED_');
                return false;
            } else {
                return false;
            }
        } else {
            // 删除成功，返回当前添加的一条完整数据
            $this->successMsg = L('Delete_' . $this->name . '_SC');
            return true;
        }
    }

    /**
     * 获取一条数据
     * @param array $options
     * @param bool $needFormat
     * @return array|mixed
     */
    public function findData($options = [], $needFormat = true)
    {
        if (array_key_exists("fields", $options)) {
            // 有字段参数
            $this->field($options["fields"]);
        }

        if (array_key_exists("filter", $options)) {
            //有过滤条件
            $this->where($options["filter"]);
        }

        $findData = $this->find();
        if (empty($findData)) {
            $this->error = L('_DATA_NOT_EXIST_');
            return [];
        }

        // 数据格式化
        if ($needFormat) {
            $dataFormat = $this->formatSelectData($findData, $this->getTableName(), 'find');
            return $dataFormat;
        } else {
            return $findData;
        }
    }


    /**
     * 获取多条数据
     * @param array $options
     * @param bool $needFormat
     * @return array
     */
    public function selectData($options = [], $needFormat = true)
    {

        if (array_key_exists("filter", $options)) {
            // 有过滤条件
            $this->where($options["filter"]);
        }

        // 统计个数
        $total = $this->count();

        // 获取数据
        if ($total > 0) {

            if (array_key_exists("fields", $options)) {
                // 有字段参数
                $this->field($options["fields"]);
            }

            if (array_key_exists("filter", $options)) {
                // 有过滤条件
                $this->where($options["filter"]);
            }

            if (array_key_exists("page", $options)) {
                // 有分页参数
                $pageSize = $options["page"][1] > C("DB_MAX_SELECT_ROWS") ? C("DB_MAX_SELECT_ROWS") : $options["page"][1];
                $this->page($options["page"][0], $pageSize);
            } else {
                if (array_key_exists("limit", $options) && $options["limit"] <= C("DB_MAX_SELECT_ROWS")) {
                    // 有limit参数
                    $this->limit($options["limit"]);
                } else {
                    $this->limit(C("DB_MAX_SELECT_ROWS"));
                }
            }

            if (array_key_exists("order", $options)) {
                // 有order参数
                $this->order($options["order"]);
            }

            $selectData = $this->select();

        } else {
            $selectData = [];
        }

        if (empty($selectData)) {
            $this->error = L('_DATA_NOT_EXIST_');
            return ["total" => 0, "rows" => []];
        }

        // 数据格式化
        if ($needFormat) {
            $dataFormat = $this->formatSelectData($selectData, $this->getTableName(), 'select');
            return ["total" => $total, "rows" => $dataFormat];
        } else {
            return ["total" => $total, "rows" => $selectData];
        }
    }

    /**
     * 获取当前表的字段配置
     * @param $tableName
     * @param $moduleCode
     * @return mixed
     */
    public function getTableFieldsConfig($tableName, $moduleCode = '')
    {
        $fieldModel = new FieldModel();
        return $fieldModel->getTableFieldsConfig($tableName, $moduleCode);
    }

    /**
     * 格式化字段值
     * @param $formatParam
     * @param $value
     * @param string $formatMode
     * @return string
     */
    protected function formatFieldData($formatParam, $value, $formatMode = 'grid')
    {
        if ($formatParam["type"] === "show_from") {
            // 数据来源显示（目前主要支持user 和 module 表）
            $rules = explode(".", $formatParam["format"]);
            $module = $rules[0];
            $field = $rules[1];

            if ($formatMode === "grid" && array_key_exists($module, $this->_fieldFromDataDict) && !empty($this->_fieldFromDataDict[$module][$value])) {
                return $this->_fieldFromDataDict[$module][$value][$field];
            } else {
                return $value;
            }
        } else {
            switch ($formatParam["format"]) {
                case "json":
                    return json_decode($value, true);
                case "date":
                case "datebox":
                    return get_format_date($value);
                case "datetime":
                case "datetimebox":
                    return get_format_date($value, 1);
                case "version":
                    return version_format($value);
                case "priority":
                    return L(string_initial_letter($value, '_'));
                case "combobox":
                    // 自定义字段特有
                    return !empty($value) ? $formatParam["data"][$value] : '';
                case "tag_type":
                    // tag 类型语言包
                    return !empty($value) ? tag_type($value)["name"] : '';
                case "status_correspond":
                    // 状态从属语言包
                    return !empty($value) ? status_corresponds_lang($value) : '';
                case "note_type":
                    // note类型语言包
                    return !empty($value) ? get_note_type($value)["name"] : '';
                case "action_type":
                    // 动作类型语言包
                    return !empty($value) ? get_action_type($value)["name"] : '';
                case "user_status":
                    // 用户状态语言包
                    return !empty($value) ? get_user_status($value)["name"] : '';
                case "public_type":
                    // 公开私有语言包
                    return !empty($value) ? public_type($value)["name"] : '';
                default:
                    return $value;
            }
        }
    }

    /**
     * 格式化查询数据
     * @param $data
     * @param $tableName
     * @param $type
     * @return mixed
     */
    public function formatSelectData($data, $tableName, $type)
    {
        //获取字段表中的config数据
        $fieldConfig = $this->getTableFieldsConfig($tableName);
        if (!empty($fieldConfig)) {
            if ($type === "find") {
                foreach ($fieldConfig as $fieldData) {
                    // 如果数组中存在format键值，并且类型为json，将json数据格式化返回
                    if (!empty($fieldData["format"]) && array_key_exists($fieldData["fields"], $data)) {
                        $data[$fieldData["fields"]] = $this->formatFieldData(
                            [
                                "format" => $fieldData["format"],
                                "type" => "built_in"
                            ],
                            $data[$fieldData["fields"]]
                        );
                    }
                }
            } else {
                // 生成字段隐射字典
                $fieldFormatMap = [];
                foreach ($fieldConfig as $fieldData) {
                    // 如果数组中存在format键值，并且类型为json，将json数据格式化返回
                    if (isset($fieldData["format"])) {
                        $fieldFormatMap[$fieldData["fields"]] = $fieldData["format"];
                    }
                }
                foreach ($data as &$item) {
                    foreach ($fieldFormatMap as $fields => $format) {
                        if (!empty($format) && array_key_exists($fields, $item)) {
                            $item[$fields] = $this->formatFieldData(
                                [
                                    "format" => $format,
                                    "type" => "built_in"
                                ],
                                $item[$fields]
                            );
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * 获取总条数
     * @param $aliasName
     * @param $filter
     * @param $hasOneQuery
     * @return mixed
     */
    private function getRelationQueryTotal($aliasName, $filter, $hasOneQuery)
    {
        // 组装join关联查询
        $this->dealHasOneQuery($hasOneQuery);

        // 查询当前过滤条件下总条数
        $totalCount = $this->alias($aliasName)->where($filter)->count();

        return $totalCount;
    }

    /**
     * 获取关联查询模型 Has One 查询结果
     * @param array $param
     * @return array
     */
    private function getHasOneRelationQueryData($param = [])
    {
        // 将查询的字段分割成以逗号隔开的字符串
        $masterField = $this->handelField($param['relation_structure']["fields"], "has_one");

        // 调用条件过滤方法
        $selectFilter = $this->buildFilterData($param['relation_structure']['table_alias'], $param['relation_structure'], $param['relation_structure']['filter']);

        // 主表别名
        $aliasName = $param['relation_structure']['table_alias'];

        // 拼装sql语句
        $this->alias($aliasName);

        // 处理HAS_ONE查询
        $hasOneQuery = [
            'relation_join' => $param['relation_structure']["relation_join"],
            'master_field' => $masterField,
            'master_alias_name' => $aliasName,
            'module_id' => $param['module_id'],
            'prefix' => C("DB_PREFIX"),
            'master_primary_key' => $param['relation_structure']["primary_key"],
            'master_module_type' => $param['relation_structure']['module_type'],
        ];

        // 组装join关联查询
        $this->dealHasOneQuery($hasOneQuery);


        // 判断是否有过滤条件
        if (array_key_exists("filter", $selectFilter) && !empty($selectFilter["filter"])) {
            $this->where($selectFilter["filter"]);
        }

        // 判断是否有排序条件
        if (array_key_exists("sort", $selectFilter) && !empty($selectFilter["sort"])) {
            $this->order($selectFilter["sort"]);
        }

        // 判断是否有分页条件
        if (array_key_exists("pagination", $param) && !empty($param["pagination"]["page_number"]) && !empty($param["pagination"]["page_size"])) {
            $this->page($param["pagination"]["page_number"], $param["pagination"]["page_size"]);
        } else {
            // 默认可查询最大行数
            $this->page(1, C("DB_MAX_SELECT_ROWS"));
        }

        // 查询 has one 数据
        $relationHasOneData = $this->select();

        // 统计查询总条数
        $totalCount = $this->getRelationQueryTotal($aliasName, $selectFilter["filter"], $hasOneQuery);

        return ["total" => $totalCount, "rows" => $relationHasOneData];
    }

    /**
     * 获取远端关联查询中间表过滤条件
     * @param $table
     * @param $param
     * @return array
     */
    private function getRelationQueryMiddleFilter($table, $param)
    {
        $middleMap = [];
        $middleIds = [];
        $belongToModel = new Model($table);
        $middleData = $belongToModel->field($param["fields"])->where($param["filter"])->select();

        foreach ($middleData as $middleItem) {

            if (array_key_exists($middleItem[$param['foreign_key']], $middleMap)) {
                array_push($middleMap[$middleItem[$param['foreign_key']]], $middleItem[$param["link_key"]]);
            } else {
                $middleMap[$middleItem[$param['foreign_key']]] = [$middleItem[$param["link_key"]]];
            }

            if (!in_array($middleItem[$param['foreign_key']], $middleIds)) {
                array_push($middleIds, $middleItem[$param['foreign_key']]);
            }
        }

        return ["middle_map" => $middleMap, "middle_ids" => $middleIds];
    }

    /**
     * 回填关联查询模型 Has Many 查询结果
     * @param $primaryMapData
     * @param $currentModuleKey
     * @param $hasManyRelationConfig
     * @param $middleHasManyData
     * @param $param
     * @return mixed
     */
    private function appendHasManyRelationQueryData(&$primaryMapData, $currentModuleKey, $hasManyRelationConfig, $middleHasManyData, $param)
    {
        if (!empty($param["middle_map"])) {
            // 如果有中间表先把中间表进行映射处理
            foreach ($middleHasManyData as $hasManyItem) {
                if (is_array($param["middle_map"][$hasManyItem["id"]])) {
                    $tempArray = $param["middle_map"][$hasManyItem["id"]];
                    foreach ($tempArray as $tempItemId) {
                        $this->generateHasManyQueryItem($primaryMapData, "normal", $currentModuleKey, $hasManyItem, [
                            "step_map" => $param["step_map"],
                            "primary_insert_id" => $param["has_many_key"],
                            "field_type" => $param["field_type"],
                            "format_prefix" => $param["format_prefix"],
                            "primary_id" => $tempItemId,
                            "format_mode" => $param["format_mode"],
                            "relation_module_id" => $param["relation_module_id"],
                            "relation_format_config" => $hasManyRelationConfig["relation_format_config"],
                            "is_belong_to_has_many" => $param["is_belong_to_has_many"],
                            "belong_to_has_many_map" => $param["belong_to_has_many_map"]
                        ]);
                    }
                } else {
                    $this->generateHasManyQueryItem($primaryMapData, "normal", $currentModuleKey, $hasManyItem, [
                        "step_map" => $param["step_map"],
                        "primary_insert_id" => $param["has_many_key"],
                        "field_type" => $param["field_type"],
                        "format_prefix" => $param["format_prefix"],
                        "primary_id" => $hasManyItem["id"],
                        "format_mode" => $param["format_mode"],
                        "relation_module_id" => $param["relation_module_id"],
                        "relation_format_config" => $hasManyRelationConfig["relation_format_config"],
                        "is_belong_to_has_many" => $param["is_belong_to_has_many"],
                        "belong_to_has_many_map" => $param["belong_to_has_many_map"]
                    ]);
                }
            }
        } else {
            // 直接 has many 数据不需要中间过程
            foreach ($middleHasManyData as $hasManyItem) {
                if ($param["format_mode"] === "grid" && $hasManyRelationConfig['master_alias_name'] === "entity" && $currentModuleKey === "base") {
                    // 格式化工序数据
                    if ($hasManyItem[$currentModuleKey . '_step_id'] > 0) {
                        $this->generateHasManyQueryItem($primaryMapData, "step", $currentModuleKey, $hasManyItem, [
                            "step_map" => $param["step_map"],
                            "primary_insert_id" => $param["has_many_key"],
                            "field_type" => $param["field_type"],
                            "format_prefix" => $param["format_prefix"],
                            "primary_id" => $hasManyItem[$currentModuleKey . '_' . $param["primary_key"]],
                            "format_mode" => $param["format_mode"],
                            "relation_module_id" => $param["relation_module_id"],
                            "relation_format_config" => $hasManyRelationConfig["relation_format_config"],
                            "is_belong_to_has_many" => $param["is_belong_to_has_many"],
                            "belong_to_has_many_map" => $param["belong_to_has_many_map"]
                        ]);
                    }
                } else {
                    $this->generateHasManyQueryItem($primaryMapData, "normal", $currentModuleKey, $hasManyItem, [
                        "step_map" => $param["step_map"],
                        "primary_insert_id" => $param["has_many_key"],
                        "field_type" => $param["field_type"],
                        "format_prefix" => $param["format_prefix"],
                        "primary_id" => $hasManyItem[$param["primary_key"]],
                        "format_mode" => $param["format_mode"],
                        "relation_module_id" => $param["relation_module_id"],
                        "relation_format_config" => $hasManyRelationConfig["relation_format_config"],
                        "is_belong_to_has_many" => $param["is_belong_to_has_many"],
                        "belong_to_has_many_map" => $param["belong_to_has_many_map"]
                    ]);
                }
            }
        }

        return $primaryMapData;
    }

    /**
     * 生成关联查询模型 Has Many 回插数据
     * @param $type
     * @param $currentModuleKey
     * @param $primaryMapData
     * @param $hasManyItem
     * @param $param
     * @return mixed
     */
    private function generateHasManyQueryItem(&$primaryMapData, $type, $currentModuleKey, $hasManyItem, $param)
    {
        if ($param["format_mode"] === "grid") {
            switch ($type) {
                case "step":
                    foreach ($hasManyItem as $baseDataKey => $baseDataItem) {
                        $stepItemData = $param["step_map"][$hasManyItem[$currentModuleKey . '_step_id']];
                        $stepFieldKey = "{$stepItemData['code']}_{$baseDataKey}";

                        if (array_key_exists($baseDataKey, $param["relation_format_config"])) {
                            $value = $this->formatFieldData($param["relation_format_config"][$baseDataKey], $hasManyItem[$baseDataKey], $param["format_mode"]);
                        } else {
                            $value = $hasManyItem[$baseDataKey];
                        }

                        $primaryMapData[$param["primary_id"]][$stepFieldKey][] = [
                            "primary" => [
                                "field" => $currentModuleKey . "_id",
                                "value" => $hasManyItem[$currentModuleKey . "_id"]
                            ],
                            "url" => generate_details_page_url($hasManyItem[$currentModuleKey . '_project_id'], $param["relation_module_id"], $hasManyItem[$currentModuleKey . "_id"]),
                            "fields" => [
                                "field" => $stepFieldKey,
                                "value" => $value,
                            ],
                            "module_id" => $param["relation_module_id"],
                            "is_step" => true
                        ];

                    }
                    break;
                default:
                    // 生成通用格式 {"total": 100, "row" : {}}
                    $this->formatRelationHasManyData($hasManyItem, $param, $param["format_mode"]);

                    if ($param["is_belong_to_has_many"]) {
                        $primaryInsertId = $param["belong_to_has_many_map"][$param["primary_id"]];
                    } else {
                        $primaryInsertId = $param["primary_id"];
                    }

                    if (array_key_exists($param["primary_insert_id"], $primaryMapData[$primaryInsertId])) {
                        $primaryMapData[$primaryInsertId][$param["primary_insert_id"]]["total"]++;
                        array_push($primaryMapData[$primaryInsertId][$param["primary_insert_id"]]["rows"], $hasManyItem);
                    } else {
                        $primaryMapData[$primaryInsertId][$param["primary_insert_id"]] = [
                            "total" => 1,
                            "rows" => [$hasManyItem]
                        ];
                    }
                    break;
            }
        } else {
            // api 请求一对多数据格式
            $this->formatRelationHasManyData($hasManyItem, $param, $param["format_mode"]);
            if ($param["field_type"] === "belong_to") {
                $primaryMapData[$param["primary_id"]][$param["primary_insert_id"]] = $hasManyItem;
            } else {
                $primaryMapData[$param["primary_id"]][$param["primary_insert_id"]][] = $hasManyItem;
            }
        }

        return $primaryMapData;
    }

    /**
     * 格式化 hasMany 一对多数据
     * @param $hasManyItem
     * @param $param
     * @param $formatMode
     * @return mixed
     */
    private function formatRelationHasManyData(&$hasManyItem, $param, $formatMode)
    {
        foreach ($hasManyItem as $field => &$value) {
            $formatKey = $param["format_prefix"] . "_" . $field;
            if (array_key_exists($formatKey, $param["relation_format_config"])) {
                $value = $this->formatFieldData($param["relation_format_config"][$formatKey], $value, $formatMode);
            }
        }
        return $hasManyItem;
    }

    /**
     * 获取entity下面step任务水平关联数据
     * @param $srcLinkIds
     * @param $config
     * @return array
     */
    private function getEntityStepHorizontalRelationData($srcLinkIds, $config)
    {
        $entityStepHorizontalData = [];
        foreach ($config as $configItem) {
            $middleFilterData = $this->getRelationQueryMiddleFilter("Horizontal", [
                "fields" => "src_link_id,dst_link_id",
                "filter" => [
                    'src_link_id' => ["IN", $srcLinkIds],
                    'src_module_id' => $configItem["src_module_id"],
                    'dst_module_id' => $configItem["dst_module_id"],
                    'variable_id' => $configItem["variable_id"]
                ],
                "foreign_key" => "dst_link_id",
                "link_key" => "src_link_id"
            ]);

            $entityStepHorizontalData[$configItem["field"]] = [];

            if (!empty($middleFilterData["middle_ids"])) {
                $filter = ["id" => ["IN", join(",", $middleFilterData["middle_ids"])]];
                switch ($configItem["dst_module_code"]) {
                    case "media":
                        $filter["relation_type"] = "horizontal";
                        $queryFields = "id,thumb,param";
                        break;
                    case "status":
                        $queryFields = "id,name,icon,color";
                        break;
                    default:
                        $queryFields = "id,name";
                        break;
                }
                $dstResData = M(string_initial_letter($configItem["dst_module_code"]))
                    ->field($queryFields)
                    ->where($filter)
                    ->select();

                $dstResDataDict = array_column($dstResData, null, "id");

                foreach ($middleFilterData["middle_map"] as $dstKey => $belongIds) {
                    foreach ($belongIds as $belongId) {
                        if ($configItem["dst_module_code"] === "media") {
                            if (!empty($dstResDataDict[$dstKey]) && !empty($dstResDataDict[$dstKey]["param"])) {
                                // 格式化json字段
                                $dstResDataDict[$dstKey]["param"] = json_decode($dstResDataDict[$dstKey]["param"], true);
                            }
                        }
                        $entityStepHorizontalData[$configItem["field"]][$belongId][] = $dstResDataDict[$dstKey];
                    }
                }
            }
        }
        return $entityStepHorizontalData;
    }

    /**
     * 获取关联查询模型 Has Many 查询结果
     * @param $hasManyRelationConfig
     * @param $primaryKey
     * @param $primaryIdsString
     * @param $primaryMapData
     * @param string $formatMode
     * @return array
     */
    private function getHasManyRelationQueryData($hasManyRelationConfig, $primaryKey, $primaryIdsString, $primaryMapData, $formatMode = "grid")
    {

        // 获取 step 数据索引
        $stepModel = new Model("Step");
        $stepData = $stepModel->field("id,name,code")->select();
        $stepMapData = array_column($stepData, null, 'id');

        // 主表在其关联表显示外键
        $masterForeignKey = "{$hasManyRelationConfig["master_alias_code"]}_id";

        // 组装一对多查询条件
        foreach ($hasManyRelationConfig['has_many_relation'] as $key => $relationItem) {

            if ($formatMode === "grid") {
                $hasManyKey = $hasManyRelationConfig['master_alias_code'] . "_" . $key;
            } else {
                // api数据回插键值
                $hasManyKey = $key;
            }

            // 获取hasMany格式化前缀
            $formatPrefix = $hasManyRelationConfig['master_alias_code'] . "_" . $relationItem["module_code"];

            $hasManyFields = '';
            $middleMap = [];
            $hasManyFilter = [];
            $relationFields = $relationItem["fields"];
            $middleHasManyData = [];
            $isBelongToHasMany = false;
            $isBelongToHasManyMap = [];

            if ($formatMode === "grid" && $hasManyRelationConfig["master_alias_name"] === "entity" && $relationItem["module_code"] === "base") {
                // 实体下面工序任务数据单独处理
                $primaryKey = "{$hasManyRelationConfig["master_alias_code"]}_id";
                // 过滤条件
                $baseFilter = [
                    "base.entity_id" => ["IN", $primaryIdsString]
                ];

                // 组装关联查询
                $hasManyModel = new Model("Base");
                $hasManyModel->alias("base");

                // 查询字段
                $baseFields = [
                    "base.id base_id",
                    "base.project_id base_project_id",
                    "base.step_id base_step_id",
                    "base.entity_id base_{$hasManyRelationConfig["master_alias_code"]}_id"
                ];

                // 水平关联字段数据
                $horizontalRelationshipConfig = [];
                $horizontalRelationshipFields = [];

                foreach ($relationItem["fields"] as $item) {
                    $tableName = strtolower($item["table"]);
                    if ($tableName !== "base") {
                        if ($item["field_type"] === "built_in") {
                            if ($tableName === "media") {
                                $hasManyModel->join("LEFT JOIN strack_{$item["table_alias"]} {$item["table_alias"]} ON {$item["table_alias"]}.link_id = base.id AND {$item["table_alias"]}.module_id = {$relationItem["module_id"]} AND relation_type = 'direct'");
                                $baseFields[] = "media.param base_media_param";
                            } else {
                                $hasManyModel->join("LEFT JOIN strack_{$item["table_alias"]} {$item["table_alias"]} ON {$item["table_alias"]}.id = base.{$item["foreign_key"]}");
                            }
                        } else if (!in_array($item['custom_type'], ["horizontal_relationship", "belong_to"])) {
                            $hasManyModel->join("LEFT JOIN strack_{$tableName} {$item["table_alias"]} ON {$item["table_alias"]}.link_id = base.id AND {$item["table_alias"]}.module_id = {$relationItem["module_id"]} AND {$item["table_alias"]}.variable_id = {$item["variable_id"]}");
                        }
                    }

                    if ($item["field_type"] === "built_in" || ($item["field_type"] === "custom" && !in_array($item['custom_type'], ["horizontal_relationship", "belong_to"]))) {
                        foreach ($item["list"] as $field) {
                            $baseFields[] = $field;
                        }
                    }

                    if ($item["field_type"] === "custom" && in_array($item['custom_type'], ["horizontal_relationship", "belong_to"])) {
                        $horizontalRelationshipConfig[] = [
                            "from_module_code" => "base",
                            "field" => $item["table_alias"],
                            "variable_id" => $item["variable_id"],
                            'src_module_id' => $item["horizontal_relationship_config"]["src_module_id"],
                            'src_module_code' => $this->_fieldFromDataDict["module"][$item["horizontal_relationship_config"]["src_module_id"]]["code"],
                            'dst_module_id' => $item["horizontal_relationship_config"]["dst_module_id"],
                            'dst_module_code' => $this->_fieldFromDataDict["module"][$item["horizontal_relationship_config"]["dst_module_id"]]["code"],
                        ];
                        $horizontalRelationshipFields[] = $item["table_alias"];
                    }
                }

                // 查询一对一数据
                $middleHasManyData = $hasManyModel->field(join(",", $baseFields))->where($baseFilter)->select();

                // 判断是否存在 horizontal_relationship 数据
                if (!empty($horizontalRelationshipConfig) && !empty($middleHasManyData)) {
                    $srcLinkIds = array_column($middleHasManyData, "base_id");
                    $entityStepHorizontalData = $this->getEntityStepHorizontalRelationData($srcLinkIds, $horizontalRelationshipConfig);
                    foreach ($middleHasManyData as &$middleHasManyItem) {
                        foreach ($horizontalRelationshipFields as $horizontalRelationshipField) {
                            if (!empty($entityStepHorizontalData[$horizontalRelationshipField])) {
                                if (array_key_exists($middleHasManyItem["base_id"], $entityStepHorizontalData[$horizontalRelationshipField])) {
                                    $middleHasManyItem[$horizontalRelationshipField] = [
                                        "total" => count($entityStepHorizontalData[$horizontalRelationshipField][$middleHasManyItem["base_id"]]),
                                        "rows" => $entityStepHorizontalData[$horizontalRelationshipField][$middleHasManyItem["base_id"]]
                                    ];
                                } else {
                                    $middleHasManyItem[$horizontalRelationshipField] = ["total" => 0, "rows" => []];
                                }
                            } else {
                                $middleHasManyItem[$horizontalRelationshipField] = ["total" => 0, "rows" => []];
                            }
                        }
                    }
                }
            } else {
                // belong to 关联查询
                if (array_key_exists("belong_to_config", $relationItem) && !empty($relationItem["belong_to_config"])) {

                    // 获取中间表查询预处理
                    $belongToSchemaData = $relationItem['belong_to_config'];

                    $middleFilterData = $this->getRelationQueryMiddleFilter(camelize($key), [
                        "fields" => $belongToSchemaData['foreign_key'] . ',link_id',
                        "filter" => [
                            'link_id' => ["IN", $primaryIdsString],
                            'module_id' => $hasManyRelationConfig["master_module_id"]
                        ],
                        "foreign_key" => $belongToSchemaData['foreign_key'],
                        "link_key" => "link_id"
                    ]);

                    $middleMap = $middleFilterData["middle_map"];
                    $hasManyFilter["id"] = ["IN", join(",", $middleFilterData["middle_ids"])];

                    // belong to 查询字段
                    $hasManyFields = $belongToSchemaData['format']['fields'];
                    $hasManyModel = new Model(camelize($belongToSchemaData['format']['table']));
                } else {
                    // 远端关联查询
                    if (in_array($relationItem['module_type'], ["horizontal_relationship", "belong_to"])) {
                        // 获取中间表查询预处理

                        // 外联表的水平关联
                        if ($relationItem["belong_module"] !== $hasManyRelationConfig["master_alias_code"]) {
                            $isBelongToHasMany = true;
                            $relationModuleData = $this->_fieldFromDataDict["module"][$relationItem["module_id"]];
                            $relationFieldName = $relationModuleData["type"] === "entity" ? "parent_id" : $relationModuleData["code"] . "_id";
                            $relationTable = string_initial_letter($hasManyRelationConfig["master_alias_name"]);
                            $relationPrimaryIdsData = M($relationTable)->field("id,{$relationFieldName}")->where(["id" => ["IN", $primaryIdsString], "parent_id" => ["NEQ", 0]])->select();
                            $primaryIdsString = join(",", array_column($relationPrimaryIdsData, $relationFieldName));

                            foreach ($relationPrimaryIdsData as $relationPrimaryIdsDataItem) {
                                $isBelongToHasManyMap[$relationPrimaryIdsDataItem[$relationFieldName]] = $relationPrimaryIdsDataItem["id"];
                            }

                            $hasManyKey = $hasManyRelationConfig['master_alias_code'] . "_" . $relationModuleData["code"] . "_" . $key;
                        }

                        $middleFilterData = $this->getRelationQueryMiddleFilter("Horizontal", [
                            "fields" => "src_link_id,dst_link_id",
                            "filter" => [
                                'src_link_id' => ["IN", $primaryIdsString],
                                'src_module_id' => $relationItem["module_id"],
                                'dst_module_id' => $relationItem["relation_module_id"],
                                'variable_id' => $relationItem["variable_id"]
                            ],
                            "foreign_key" => "dst_link_id",
                            "link_key" => "src_link_id"
                        ]);

                        $middleMap = $middleFilterData["middle_map"];
                        if (!empty($middleFilterData["middle_ids"])) {
                            $hasManyFilter["id"] = ["IN", join(",", $middleFilterData["middle_ids"])];
                        }

                        if ($relationItem["module_code"] === "media") {
                            $hasManyFilter["variable_id"] = $relationItem["variable_id"];
                        }

                        $primaryKey = "id";
                        $hasManyModel = new Model(camelize($relationItem["module_code"]));

                    } else {

                        // 获取查询的数据表
                        $moduleCode = $relationItem['module_type'] === 'entity' ? $relationItem['module_type'] : $relationItem['module_code'];

                        // 直接一对多查询
                        if (in_array($key, ["media"])) {
                            $primaryKey = "link_id";

                            $hasManyFilter = [
                                "link_id" => ["IN", $primaryIdsString],
                                "module_id" => $hasManyRelationConfig['master_module_id']
                            ];

                        } else {
                            if ($hasManyRelationConfig["master_alias_name"] === 'entity') {
                                if ($relationItem["module_type"] === "entity") {
                                    $primaryKey = "parent_id";
                                } else {
                                    $primaryKey = "entity_id";
                                }
                            } else {
                                $primaryKey = $masterForeignKey;
                            }

                            $hasManyFilter[$primaryKey] = ["IN", $primaryIdsString];

                            // 需要查询判断字段
                            $relationFields[] = [$primaryKey => "{$moduleCode}.{$primaryKey} {$moduleCode}_{$primaryKey}"];
                        }

                        $hasManyModel = new Model(camelize($moduleCode));
                    }


                    // 处理查询字段
                    if (!empty($relationItem["fields"])) {
                        $hasManyFields = $this->handelField($relationFields, "has_many");
                    }
                }

                if (!empty($hasManyFilter)) {
                    $middleHasManyData = $hasManyModel->field($hasManyFields)->where($hasManyFilter)->select();
                }
            }

            if (!empty($middleHasManyData)) {
                // 回填一对多关联查询数据
                $fieldType = array_key_exists("field_type", $relationItem) ? $relationItem["field_type"] : '';
                $this->appendHasManyRelationQueryData($primaryMapData, $key, $hasManyRelationConfig, $middleHasManyData, [
                    "has_many_key" => $hasManyKey,
                    "format_prefix" => $formatPrefix,
                    "is_belong_to_has_many" => $isBelongToHasMany,
                    "belong_to_has_many_map" => $isBelongToHasManyMap,
                    "primary_key" => $primaryKey,
                    "middle_map" => $middleMap,
                    "step_map" => $stepMapData,
                    "field_type" => $fieldType,
                    "format_mode" => $formatMode,
                    "relation_module_id" => $relationItem["module_id"]
                ]);
            }
        }

        return array_values($primaryMapData);
    }

    /**
     * 获取字段数据源映射
     */
    private function getFieldFromDataDict()
    {
        // 用户数据映射
        $allUserData = M("User")->field("id,name")->select();
        $allUserDataMap = array_column($allUserData, null, "id");
        $this->_fieldFromDataDict["user"] = $allUserDataMap;

        // 模块数据映射
        $allModuleData = M("Module")->field("id,name,code,type")->select();
        $moduleMapData = [];
        $moduleCodeMapData = [];
        foreach ($allModuleData as $allModuleDataItem) {
            $moduleMapData[$allModuleDataItem["id"]] = $allModuleDataItem;
            $moduleCodeMapData[$allModuleDataItem["code"]] = $allModuleDataItem;
        }

        $this->_fieldFromDataDict["module"] = $moduleMapData;
        $this->_fieldFromDataDict["module_code"] = $moduleCodeMapData;;
    }

    /**
     * 关联模型查询
     * @param array $param
     * @param string $formatMode
     * @return array
     */
    public function getRelationData($param = [], $formatMode = 'grid')
    {
        // 获取字段数据源映射
        $this->getFieldFromDataDict();

        // 查询 has one 数据
        $relationHasOneQueryData = $this->getHasOneRelationQueryData($param);
        // 主表主键
        $primaryKey = $param['relation_structure']['table_alias'] . "_id";

        // 关联格式化结构
        $relationFormatConfig = [
            "primary_key" => $primaryKey,
            "module_mapping" => $this->generateRelationConfigMapping($param['relation_structure']),
            "format_config" => $param['relation_structure']["format_list"],
        ];

        // 判断是否有 has many 查询条件
        if (!empty($param['relation_structure']["relation_has_many"]) && !empty($relationHasOneQueryData["rows"])) {
            // 一对多关联查询预处理
            $primaryIds = [];
            $primaryMapData = [];
            foreach ($relationHasOneQueryData["rows"] as $dataItem) {
                $primaryMapData[$dataItem[$primaryKey]] = $this->formatRelationData($dataItem, $relationFormatConfig, $formatMode);
                array_push($primaryIds, $dataItem[$primaryKey]);
            }
            $primaryIdsString = join(",", $primaryIds);

            $hasManyRelationConfig = [
                'master_alias_name' => $param['relation_structure']['table_name'],
                'master_alias_code' => $param['relation_structure']['table_alias'],
                'has_many_relation' => $param['relation_structure']['relation_has_many'],
                'master_module_id' => $param['module_id'],
                "relation_format_config" => $relationFormatConfig["format_config"]
            ];

            $relationResultData = $this->getHasManyRelationQueryData($hasManyRelationConfig, $primaryKey, $primaryIdsString, $primaryMapData, $formatMode);
        } else {
            // 处理id主键数据
            $relationResultData = $relationHasOneQueryData["rows"];
            foreach ($relationResultData as &$dataItem) {
                $dataItem = $this->formatRelationData($dataItem, $relationFormatConfig, $formatMode);
            }
        }

        return ["total" => $relationHasOneQueryData["total"], "rows" => $relationResultData];
    }

    /**
     * 生成关联结构配置映射
     * @param $relationStructure
     * @return array
     */
    private function generateRelationConfigMapping($relationStructure)
    {
        $relationConfigMapping = [];

        // 主表的
        foreach ($relationStructure["fields"] as $item) {
            foreach ($item as $field => $value) {
                $relationConfigMapping["{$relationStructure['table_alias']}_{$field}"] = [
                    "relation" => "one",
                    'mapping_type' => 'master',
                    "type" => "built_in",
                    "field" => $field,
                    "master" => true,
                    "module_code" => $relationStructure['table_alias']
                ];
            }
        }

        // 一对一关联数据集合
        $this->generateRelationMappingFieldConfig($relationConfigMapping, $relationStructure["relation_join"], "one", $relationStructure['table_alias']);

        // 一对多关联
        $this->generateRelationMappingFieldConfig($relationConfigMapping, $relationStructure["relation_has_many"], "many", $relationStructure['table_alias']);

        return $relationConfigMapping;
    }

    /**
     * 生成字段映射配置
     * @param $relationConfigMapping
     * @param $data
     * @param $relation
     * @param $masterCode
     */
    private function generateRelationMappingFieldConfig(&$relationConfigMapping, $data, $relation, $masterCode)
    {
        foreach ($data as $key => $moduleData) {
            foreach ($moduleData["fields"] as $item) {
                if (array_key_exists("list", $item)) {
                    // 特需不做处理
                    $fieldList = $item["list"];
                } else {
                    $fieldList = $item;
                }

                foreach ($fieldList as $field => $value) {
                    if ($moduleData["module_type"] !== "custom") {
                        $fieldMapKey = explode(" ", $value)[1];
                        if (!array_key_exists($fieldMapKey, $relationConfigMapping)) {
                            $relationConfigMapping[$fieldMapKey] = [
                                "relation" => $relation,
                                "mapping_type" => $moduleData["mapping_type"],
                                "type" => "built_in",
                                'relation_type' => 'master',
                                "field" => $field,
                                "master" => false,
                                "module_code" => $moduleData['module_code']
                            ];
                        }
                    } else {
                        if ($masterCode === $moduleData['belong_module'] && $relation !== "many") {
                            $isMaster = true;
                        } else {
                            $isMaster = false;
                        }
                        $fieldMapKey = "{$key}_{$field}";
                        if (!array_key_exists($fieldMapKey, $relationConfigMapping)) {
                            $relationConfigMapping[$fieldMapKey] = [
                                "relation" => $relation,
                                "mapping_type" => $moduleData["mapping_type"],
                                "type" => "custom",
                                "field" => str_replace_once("{$moduleData['belong_module']}_", "", $key),
                                "master" => $isMaster,
                                "module_code" => $moduleData['belong_module']
                            ];
                        }
                    }
                }
            }
        }
    }

    /**
     * 处理关联查询单条结果
     * @param $dataItem
     * @param $relationFormatConfig
     * @param string $formatMode
     * @return array
     */
    private function formatRelationData($dataItem, $relationFormatConfig, $formatMode = "grid")
    {
        $formatItemData = [];

        foreach ($dataItem as $field => $value) {

            $fieldMapConfig = $relationFormatConfig["module_mapping"][$field];
            $formatFieldKey = $fieldMapConfig["type"] === "custom" ? str_replace("_value", "", $field) : $field;

            if (!empty($relationFormatConfig["format_config"][$formatFieldKey])) {
                // 格式化数据
                $value = $this->formatFieldData($relationFormatConfig["format_config"][$formatFieldKey], $value, $formatMode);
            }

            if ($formatMode !== "grid") {
                // api接口拆分数据到不同数据表内
                if ($fieldMapConfig["master"]) {
                    // 主表字段
                    $formatItemData[$fieldMapConfig["field"]] = $value;
                } else {
                    // 其他字段分一对一处理 (判断是否是belong to 是则把主键加入到主表字段)
                    if ($fieldMapConfig["mapping_type"] === "belong_to" && $fieldMapConfig["field"] === "id") {
                        $formatItemData[$fieldMapConfig["module_code"] . "_id"] = $value ? $value : 0;
                    }
                    $formatItemData[$fieldMapConfig["module_code"]][$fieldMapConfig["field"]] = $value;
                }
            } else {
                // 前台页面使用数据不拆分
                $formatItemData[$field] = $value;
            }
        }

        if (!array_key_exists("id", $formatItemData)) {
            $formatItemData["id"] = $dataItem[$relationFormatConfig["primary_key"]];
        }

        return $formatItemData;
    }

    /**
     * 处理has one 查询
     * @param $hasOneQuery
     * @return Model
     */
    private function dealHasOneQuery($hasOneQuery)
    {
        $masterName = $hasOneQuery['master_alias_name'];
        $primaryKey = $hasOneQuery['master_primary_key'];

        $relationJoinField = [];
        // 循环处理has_one数据，拼装Join连接查询条件
        foreach ($hasOneQuery['relation_join'] as $key => $relationItem) {
            // 处理要查询的字段，处理成以逗号分割的字符串
            if (!empty($relationItem["fields"])) {
                $relationJoinField[] = $this->handelField($relationItem["fields"], "has_one");
            }
            $tableName = $relationItem['module_type'] == "fixed" ? $key : $relationItem['module_type'];

            // 如果为固定字段 连接条件为主表的主键和关联表的外键
            if ($relationItem["module_type"] === "custom" && !in_array($relationItem['field_type'], ["horizontal_relationship", "belong_to"])) {
                $connection = $key . "." . $relationItem['foreign_key'] . "=" . $relationItem["belong_module"] . "." . $primaryKey . " AND " . $key . ".module_id=" . intval($relationItem['module_id']) . " AND " . $key . ".variable_id=" . intval($relationItem['variable_id']);
                $this->join('LEFT JOIN ' . $hasOneQuery['prefix'] . $relationItem['module_code'] . ' ' . $key . ' on ' . $connection);
            } else {
                if (in_array($key, ["media"])) {
                    $connection = $masterName . "." . $primaryKey . "=" . $key . ".link_id AND " . $key . ".module_id=" . intval($hasOneQuery['module_id']);
                    if ($key == "media") {
                        $connection .= " AND {$key}.type='thumb' AND {$key}.relation_type= 'direct'";
                        // 增加media param 必查参数
                        $relationJoinField[] = "media.param {$hasOneQuery["master_alias_name"]}_media_param";
                    }
                } else {
                    if ($relationItem["mapping_type"] === "belong_to") {
                        $connection = $masterName . "." . $relationItem['foreign_key'] . "=" . $key . "." . $primaryKey;
                    } else {
                        $connection = $masterName . "." . $primaryKey . "=" . $key . "." . $relationItem['foreign_key'];
                    }
                }
                $this->join('LEFT JOIN ' . $hasOneQuery['prefix'] . $tableName . ' ' . $key . ' on ' . $connection);
            }
        }
        $relationHasOneField = implode(",", $relationJoinField);
        $relationJoinFields = !empty($relationHasOneField) ? [$hasOneQuery['master_field'] . "," . $relationHasOneField] : [$hasOneQuery['master_field']];
        return $this->field($relationJoinFields);
    }

    /**
     * 处理查询字段
     * @param $fieldConfig
     * @param $type
     * @param bool $isAlias
     * @return string
     */
    public function handelField($fieldConfig, $type, $isAlias = false)
    {
        $fieldData = [];
        $fieldString = "";
        switch ($type) {
            case "has_one":
                foreach ($fieldConfig as $fieldItem) {
                    foreach ($fieldItem as $fieldKey => $item) {
                        $fieldData[$fieldKey] = $item;
                    }
                }
                $fieldString = implode(",", $fieldData);
                break;
            case "has_many":
                foreach ($fieldConfig as $fieldItem) {
                    foreach ($fieldItem as $fieldKey => $item) {
                        if (!in_array($fieldKey, $fieldData)) {
                            if ($isAlias) {
                                $fieldData[] = $item;
                            } else {
                                $fieldData[] = $fieldKey;
                            }
                        }
                    }
                }
                $fieldString = implode(",", $fieldData);
                break;
        }
        return $fieldString;
    }

    /**
     * 处理过滤条件 (字段加命名空间)
     * @param $currentModule
     * @param $relationStructure
     * @param $filter
     * @return array
     */
    public function buildFilterData($currentModule, $relationStructure, $filter)
    {
        // 处理排序条件
        $sort = $this->buildSortRule($filter["sort"], $filter["group"]);

        // request 当前模块必须过滤条件 and
        $filterRequest = [];
        foreach ($filter["request"] as $item) {
            if ($currentModule == $item["module_code"]) {
                // 自身字段
                $filterRequest[$currentModule . '.' . $item["field"]] = [$item["condition"], $item["value"]];
            } else {
                // 关联字段 (必须字段也是当前表存在字段)
                $queryKey = $item["field"];
                $queryMap = [$item["field"] => [$item["condition"], $item["value"]]];
                $relationRequestData = $this->buildDirectFilter($queryKey, $queryMap, $queryKey, $item);
                $queryFieldKey = $item["module_code"] . '.' . $queryKey;
                if (!empty($relationRequestData)) {
                    if (array_key_exists($queryFieldKey, $filterRequest)) {
                        $relationConditionArray = explode(",", $relationRequestData[1]);
                        if (is_array($filterRequest[$queryFieldKey])) {
                            $relationRequestData[1] = unique_arr(array_merge($relationConditionArray, $filterRequest[$queryFieldKey]));
                            $filterRequest[$queryFieldKey] = ["IN", join(",", $relationRequestData)];
                        } else if (!in_array($filterRequest[$queryFieldKey], $relationConditionArray)) {
                            $filterRequest[$queryFieldKey] = ["IN", join(",", $relationRequestData)];
                        }
                    } else {
                        $filterRequest[$queryFieldKey] = ["IN", join(",", $relationRequestData)];
                    }
                } else {
                    $filterRequest[$queryFieldKey] = 0;
                }
            }
        }

        // filter_input 过滤框过滤条件 or 优先级最低
        $filterInput = !empty($filter["filter_input"]) ? $this->buildItemFilter($currentModule, $relationStructure, $filter["filter_input"], "OR", 'search_box') : [];

        // filter_panel 过滤面板过滤条件 and 一个条件不满足其他条件直接不满足 优先级次之
        $filterPanel = !empty($filter["filter_panel"]) ? $this->buildItemFilter($currentModule, $relationStructure, $filter["filter_panel"], "AND", 'search_bar') : [];

        // filter_advance 高级过滤面板过滤条件  根据不同分组来定义 优先级最高
        $filterAdvance = !empty($filter["filter_advance"]) ? $this->buildAdvanceFilter($currentModule, $relationStructure, $filter["filter_advance"]) : [];

        // 生成最终过滤条件
        if (count($filterAdvance) > 0) {
            $filterMain = $this->buildFinalFilter($filterRequest, $filterAdvance);
        } else if (count($filterPanel) > 0) {
            $filterMain = $this->buildFinalFilter($filterRequest, $filterPanel);
        } else if (count($filterInput) > 0) {
            $filterMain = $this->buildFinalFilter($filterRequest, $filterInput);
        } else {
            $filterMain = $this->buildFinalFilter($filterRequest, "");
        }

        return ["filter" => $filterMain, 'sort' => $sort];
    }

    /**
     * 生成排序规则
     * @param $sortRule
     * @param $groupRule
     * @return string
     */
    private function buildSortRule($sortRule, $groupRule = [])
    {
        if (!empty($sortRule) || !empty($groupRule)) {
            $sort = [];
            $sortRules = array_merge($sortRule, $groupRule);
            foreach ($sortRules as $ruleItem) {
                if (array_key_exists("module_code", $ruleItem) && !empty($ruleItem["module_code"])) {
                    if ($ruleItem["field_type"] === "built_in") {
                        $sort[] = "{$ruleItem["module_code"]}.{$ruleItem["field"]} {$ruleItem["type"]}";
                    } else {
                        $sort[] = "{$ruleItem["module_code"]}_{$ruleItem["field"]}.value {$ruleItem["type"]}";
                    }
                } else {
                    $sort[] = "{$ruleItem["field"]} {$ruleItem["type"]}";
                }
            }
            return join(",", $sort);
        } else {
            return "";
        }
    }

    /**
     * 生成最终过滤条件
     * @param $request
     * @param $other
     * @return array
     */
    private function buildFinalFilter($request, $other)
    {
        if (!empty($request)) {
            if (!empty($other)) {
                return [
                    $request,
                    $other,
                    "_logic" => "AND"
                ];
            } else {
                return $request;
            }
        } else {
            return $other;
        }
    }

    /**
     * 生成控件过滤条件
     * @param $item
     * @return array
     */
    private function buildWidgetFilter($item)
    {
        switch ($item["editor"]) {
            case "text":
            case "textarea":
                switch ($item["condition"]) {
                    case "LIKE":
                    case "NOTLIKE":
                        $value = "%" . $item["value"] . "%";
                        break;
                    default:
                        $value = $item["value"];
                        break;
                }
                $filter = [$item["condition"], $value];
                break;
            case "combobox":
            case "tagbox":
            case "horizontal_relationship":
            case "checkbox":
                $filter = [$item["condition"], $item["value"]];
                break;
            case "datebox":
            case "datetimebox":
                switch ($item["condition"]) {
                    case "BETWEEN":
                        $dateBetween = explode(",", $item["value"]);
                        $filter = [$item["condition"], [strtotime($dateBetween[0]), strtotime($dateBetween[1])]];
                        break;
                    default:
                        $filter = [$item["condition"], strtotime($item["value"])];
                        break;
                }
                break;
            default:
                $filter = [];
                break;
        }
        return $filter;
    }

    /**
     * 获取查询结构一对多映射字典数据
     * @param $relationStructure
     * @return array
     */
    private function getSchemaHasManyMap($relationStructure)
    {
        $relationStructureFilterMap = [];

        // 主表映射查询条件
        $relationStructureFilterMap[$relationStructure["table_alias"]] = [
            "mapping_type" => "master",
            "module_type" => $relationStructure["module_type"],
            "master_primary_key" => $relationStructure["primary_key"],
        ];

        // belong to 和 has one数据查询结构
        foreach ($relationStructure["relation_join"] as $key => $relationJoinItemConfig) {

            if ($relationStructure["table_name"] === "entity" && $relationJoinItemConfig["module_type"] === "entity") {
                $foreignKey = "parent_id";
            } else {
                $foreignKey = $relationJoinItemConfig["foreign_key"];
            }

            $relationStructureFilterMap[$key] = [
                "mapping_type" => $relationJoinItemConfig["mapping_type"],
                "module_id" => $relationJoinItemConfig["module_id"],
                "module_code" => $relationJoinItemConfig["module_code"],
                "module_type" => $relationJoinItemConfig["module_type"],
                "foreign_key" => $foreignKey
            ];
        }

        // 直接一对多 和 远端一对多查询结构
        foreach ($relationStructure["relation_has_many"] as $key => $relationHasManyItemConfig) {
            if (array_key_exists("belong_to_config", $relationHasManyItemConfig)) {
                // 远端关联查询
                $remoteConfig = $relationHasManyItemConfig["belong_to_config"];
                $relationStructureFilterMap[$remoteConfig["format"]["table"]] = [
                    "mapping_type" => "remote_has_many",
                    "primary_key" => $remoteConfig["primary_key"],
                    "module_code" => $remoteConfig["format"]["table"],
                    "middle_config" => [
                        "module_id" => $relationHasManyItemConfig["module_id"],
                        "module_code" => $relationHasManyItemConfig["module_code"],
                        "module_type" => $relationHasManyItemConfig["module_type"],
                        "master_foreign_key" => $remoteConfig["middle_key"],
                        "master_primary_key" => $remoteConfig["foreign_key"],
                        "master_module_id" => $relationStructure["module_id"],
                        "foreign_key" => $relationHasManyItemConfig["foreign_key"],
                        "column_field" => "module_id",
                        "belong_type" => "belong_to"
                    ]
                ];

            } else {

                if (in_array($relationHasManyItemConfig['module_type'], ["horizontal_relationship", "belong_to"])) {
                    $relationMapKey = $relationHasManyItemConfig["belong_module"] !== $relationStructure["table_alias"] ? "{$relationHasManyItemConfig["belong_module"]}_{$key}" : $key;
                    $relationStructureFilterMap[$relationMapKey] = [
                        "mapping_type" => "remote_has_many",
                        "primary_key" => "id",
                        "module_code" => $relationHasManyItemConfig["module_code"],
                        "middle_config" => [
                            "module_id" => $relationHasManyItemConfig["relation_module_id"],
                            "module_code" => "horizontal",
                            "module_type" => $relationHasManyItemConfig["module_type"],
                            "master_foreign_key" => "src_link_id",
                            "master_primary_key" => "dst_link_id",
                            "master_module_id" => $relationHasManyItemConfig["module_id"],
                            "foreign_key" => $relationHasManyItemConfig["foreign_key"],
                            "variable_id" => $relationHasManyItemConfig["variable_id"],
                            "column_field" => "src_module_id",
                            "belong_type" => "has_many"
                        ]
                    ];
                } else {
                    // 直接查询
                    if ($relationStructure["table_name"] === "entity" && $relationHasManyItemConfig["module_type"] === "entity") {
                        $foreignKey = "parent_id";
                    } else {
                        $foreignKey = "id";
                    }

                    $masterForeignKey = $relationStructure["module_type"] === "entity" ? "entity_id" : "{$relationHasManyItemConfig["module_code"]}_id";

                    $relationStructureFilterMap[$key] = [
                        "mapping_type" => $relationHasManyItemConfig["mapping_type"],
                        "module_id" => $relationHasManyItemConfig["module_id"],
                        "module_code" => $relationHasManyItemConfig["module_code"],
                        "module_type" => $relationHasManyItemConfig["module_type"],
                        "foreign_key" => $foreignKey,
                        "master_foreign_key" => $masterForeignKey
                    ];
                }


                if ($relationStructure["module_type"] === "entity" && $key === "base") {
                    // 实体下面任务的自定义字段查询
                    foreach ($relationHasManyItemConfig["fields"] as $hasManyBaseKey => $hasManyBaseConfig) {
                        if ($hasManyBaseConfig["field_type"] === "custom" && in_array($hasManyBaseConfig["custom_type"], ["belong_to", "horizontal_relationship"])) {
                            $relationStructureFilterMap[$hasManyBaseKey] = [
                                "mapping_type" => "has_many_has_many",
                                "module_id" => $relationHasManyItemConfig["module_id"],
                                "module_code" => $relationHasManyItemConfig["module_code"],
                                "module_type" => $relationHasManyItemConfig["module_type"],
                                "foreign_key" => $hasManyBaseConfig["foreign_key"],
                                "variable_id" => $hasManyBaseConfig["variable_id"],
                                "project_id" => $hasManyBaseConfig["project_id"],
                                "horizontal_relationship_config" => $hasManyBaseConfig["horizontal_relationship_config"]
                            ];
                        }
                    }
                }
            }
        }

        return $relationStructureFilterMap;
    }


    /**
     * 生成直接关联过滤条件
     * @param $queryKey
     * @param $queryMap
     * @param $primaryModuleKey
     * @param $item
     * @return array|string
     */
    private function buildDirectFilter($queryKey, $queryMap, $primaryModuleKey, $item)
    {
        $relationMap = M(string_initial_letter($item["table"]))->field($queryKey)->where($queryMap)->select();

        if (!empty($relationMap)) {
            return convert_select_data($primaryModuleKey, $relationMap, $queryKey);
        } else {
            return "";
        }
    }

    /**
     * 生成直接关联过滤条件
     * @param $filterData
     * @param $item
     * @param $queryKey
     * @param $primaryModuleKey
     * @param $currentModule
     * @param $logic
     * @return mixed
     */
    private function buildDirectWidgetFilter(&$filterData, $item, $queryKey, $primaryModuleKey, $currentModule, $logic)
    {
        if ($item["field_type"] == "custom") {
            $queryKey = "link_id";
            $queryMap = ["value" => $this->buildWidgetFilter($item), "variable_id" => $item["variable_id"]];
        } else {
            $queryField = $item["field"];
            $queryMap = [$queryField => $this->buildWidgetFilter($item)];
        }

        $directFilter = $this->buildDirectFilter($queryKey, $queryMap, $primaryModuleKey, $item);

        if (!empty($directFilter) || $logic == "AND") {
            $filterData[$currentModule . '.' . $primaryModuleKey] = $this->buildFilterDataSets($currentModule, $logic, $filterData, $primaryModuleKey, $directFilter, $item);
        } else {
            $filterData[$currentModule . '.' . $primaryModuleKey] = $this->buildFilterInData([], $item["field"], $item["condition"]);
        }

        return $filterData;
    }

    /**
     * @param $filterData
     * @param $field
     * @param $condition
     * @return array|null
     */
    private function buildFilterInData($filterData, $field, $condition)
    {
        if (!empty($filterData)) {
            if ($field !== "id" && in_array($condition, ["NEQ", "NOTLIKE", "NOT BETWEEN", "NOT IN"])) {
                array_push($filterData, 0);
            }
            return ["IN", join(",", $filterData)];
        } else {
            if (in_array($condition, ["NEQ", "NOTLIKE", "NOT BETWEEN", "NOT IN"])) {
                return ["IN", "0"];
            } else {
                return null;
            }
        }
    }


    /**
     * 处理过滤条件数据集
     * @param $currentModule
     * @param $logic
     * @param $filterData
     * @param $field
     * @param $newFilterItem
     * @return array|int
     */
    private function buildFilterDataSets($currentModule, $logic, $filterData, $field, $newFilterItem, $item)
    {
        if (array_key_exists($currentModule . '.' . $field, $filterData)) {
            $oldFilterItem = explode(",", $filterData[$currentModule . '.' . $field][1]);
            if ($logic == "OR") {
                // 求并集
                $filterItem = unique_arr(array_merge($oldFilterItem, $newFilterItem));
            } else {
                // 求交集
                $filterItem = array_intersect($oldFilterItem, $newFilterItem);
            }
            if (!empty($filterItem)) {
                return $this->buildFilterInData($filterItem, $field, $item["condition"]);
            }
        } else {
            if (!empty($newFilterItem)) {
                return $this->buildFilterInData($newFilterItem, $field, $item["condition"]);
            }
        }

        return $field === "id" ? 0 : $this->buildFilterInData([], $field, $item["condition"]);
    }

    /**
     * 生成远端管理自定义字段查询
     * @param $config
     * @param $filterItem
     * @return string
     */
    private function buildRemoteCustomItemFilter($config, $filterItem)
    {
        $filter = $this->buildWidgetFilter($filterItem);

        $linkIdData = M("VariableValue")->where("link_id")
            ->where([
                "variable_id" => $filterItem["variable_id"],
                "module_id" => $config["module_id"],
                "value" => $filter
            ])
            ->select();

        if (!empty($linkIdData)) {
            $linkIds = array_column($linkIdData, "link_id");
            $filterItem["value"] = join(",", $linkIds);
        } else {
            $filterItem["value"] = '';
        }

        $filterItem["table"] = ["module_code"];
        if (in_array($filterItem["condition"], ["NEQ", "NOT IN", "NOT BETWEEN"])) {
            $filterItem["condition"] = "NOT IN";
        } else {
            $filterItem["condition"] = "IN";
        }

        $filterItem["field"] = "id";
        $filterItem["field_type"] = "built_in";
        $filterItem["editor"] = "combobox";
        $filterItem["table"] = $filterItem["module_code"];

        return $filterItem;
    }


    /**
     * @param $moduleId
     * @param $currentModule
     * @return array
     */
    private function getRemoteHorizontalFilterParam($moduleId, $currentModule)
    {
        $horizontalMasterModuleData = $this->_fieldFromDataDict["module"][$moduleId];
        $horizontalFilterParam = [];
        if ($horizontalMasterModuleData["code"] === $currentModule) {
            // 本表
            $horizontalFilterParam["foreign_key"] = "id";
            $horizontalFilterParam["default_value"] = 0;
        } else {
            // 外联表
            $horizontalFilterParam["foreign_key"] = $horizontalMasterModuleData["type"] === "entity" ? "parent_id" : "{$horizontalMasterModuleData["code"]}_id";
            $horizontalFilterParam["default_value"] = NULL;
        }

        return $horizontalFilterParam;
    }


    /**
     * 生成过滤条件项
     * @param $currentModule
     * @param $relationStructure
     * @param $filter
     * @param $logic
     * @param string $type
     * @return array
     */
    private function buildItemFilter($currentModule, $relationStructure, $filter, $logic, $type = '')
    {
        $filterData = [];

        if (count($filter) > 0) {
            $relationStructureFilterMap = $this->getSchemaHasManyMap($relationStructure);
            foreach ($filter as $key => $item) {
                if (!in_array(strval($key), ["multiple", "logic", "number"])) {
                    // 获取映射键值
                    if (array_key_exists($item["module_code"], $relationStructureFilterMap)) {
                        switch ($relationStructureFilterMap[$item["module_code"]]["mapping_type"]) {
                            case "master":
                                // 当前模块过滤条件
                                if ($item["field_type"] === "custom") {
                                    // 判断是否是自定义字段
                                    $filterKey = "{$currentModule}_{$item["field"]}.value";
                                } else {
                                    $filterKey = $currentModule . '.' . $item["field"];
                                }
                                $filterData[$filterKey] = $this->buildWidgetFilter($item);
                                break;
                            case "belong_to":
                                // 从属于数据关联过滤条件
                                $queryKey = "id";
                                $primaryModuleKey = $relationStructureFilterMap[$item["module_code"]]["foreign_key"];
                                $this->buildDirectWidgetFilter($filterData, $item, $queryKey, $primaryModuleKey, $currentModule, $logic);
                                break;
                            case "has_one":
                                // 一对一数据关联过滤条件
                                $queryKey = $relationStructureFilterMap[$item["module_code"]]["foreign_key"];
                                $primaryModuleKey = "id";
                                $this->buildDirectWidgetFilter($filterData, $item, $queryKey, $primaryModuleKey, $currentModule, $logic);
                                break;
                            case "has_many":
                                // 一对多直接关联
                                $queryKey = $relationStructureFilterMap[$item["module_code"]]["module_type"] === "entity" ? "id" : $relationStructureFilterMap[$item["module_code"]]["master_foreign_key"];
                                $primaryModuleKey = $relationStructureFilterMap[$item["module_code"]]["foreign_key"];

                                if ($item["field_type"] === "custom") {
                                    // 先查自定义字段
                                    $item = $this->buildRemoteCustomItemFilter($relationStructureFilterMap[$item["module_code"]], $item);
                                }

                                $this->buildDirectWidgetFilter($filterData, $item, $queryKey, $primaryModuleKey, $currentModule, $logic);
                                break;
                            case "remote_has_many":
                                // 远端一对多关联
                                if ($item["field_type"] === "custom") {
                                    // 1. 先查自定义字段水平关联
                                    $remoteMap = $this->getRemoteHorizontalFilterData($item, $relationStructureFilterMap[$item["module_code"]]);

                                    $horizontalFilterParam = $this->getRemoteHorizontalFilterParam($relationStructureFilterMap[$item["module_code"]]["middle_config"]["master_module_id"], $currentModule);
                                    $horizontalFilterKey = $currentModule . '.' . $horizontalFilterParam["foreign_key"];
                                    if (!empty($remoteMap)) {
                                        $filterData[$horizontalFilterKey] = $this->mergeRemoteCustomFilteringConditions($horizontalFilterKey, $filterData, $remoteMap);
                                    } else {
                                        $filterData[$horizontalFilterKey] = $this->mergeRemoteCustomFilteringConditions($horizontalFilterKey, $filterData, $horizontalFilterParam["default_value"]);
                                    }

                                    // 保持上次查询方法
                                    $this->prevRemoteQueryMethod = $this->currentRemoteQueryMethod;
                                } else {
                                    // 固定字段远程一对多
                                    $remoteKey = $relationStructureFilterMap[$item["module_code"]]["primary_key"];

                                    $remoteFilterKey = $type === "search_box" ? $item["field"] : "id";

                                    // 1. 查询主表数据
                                    $remoteMap = M(string_initial_letter($relationStructureFilterMap[$item["module_code"]]["module_code"]))
                                        ->field($remoteKey)
                                        ->where([$remoteFilterKey => $this->buildWidgetFilter($item)])
                                        ->select();

                                    if (!empty($remoteMap)) {
                                        $remoteMapIds = array_column($remoteMap, $remoteKey);

                                        // 2.处理中间表查询
                                        $middleConfig = $relationStructureFilterMap[$item["module_code"]]["middle_config"];

                                        $middleFilter = [
                                            $middleConfig["master_primary_key"] => ["IN", join(",", $remoteMapIds)],
                                            $middleConfig["column_field"] => $middleConfig["master_module_id"]
                                        ];

                                        if ($middleConfig["belong_type"] === "has_many") {
                                            $middleFilter["variable_id"] = $middleConfig["variable_id"];
                                        }

                                        $middleMap = M($middleConfig["module_code"])
                                            ->field($middleConfig["master_foreign_key"])
                                            ->where($middleFilter)
                                            ->select();


                                        $remoteMidFilterKey = $currentModule . '.id';
                                        if (!empty($middleMap)) {
                                            $middleMapIds = array_column($middleMap, $middleConfig["master_foreign_key"]);
                                            $filterData[$remoteMidFilterKey] = $this->mergeRemoteFilteringConditions($remoteMidFilterKey, $filterData, $this->buildFilterDataSets($currentModule, $logic, $filterData, "id", $middleMapIds, $item));
                                        } else {
                                            $filterData[$remoteMidFilterKey] = $this->mergeRemoteFilteringConditions($remoteMidFilterKey, $filterData, 0);
                                        }
                                    } else {
                                        $filterData[$currentModule . '.id'] = 0;
                                    }
                                }
                                break;
                            case "has_many_has_many":
                                // 一对多远端一对多关联（entity base）
                                // 1.查找水平关联表 src_link_ids
                                $srcLinkIdData = M("Horizontal")->field("src_link_id")
                                    ->where([
                                        "variable_id" => $relationStructureFilterMap[$item["module_code"]]["variable_id"],
                                        "src_module_id" => $relationStructureFilterMap[$item["module_code"]]["horizontal_relationship_config"]["src_module_id"],
                                        "dst_module_id" => $relationStructureFilterMap[$item["module_code"]]["horizontal_relationship_config"]["dst_module_id"],
                                        "dst_link_id" => $this->buildWidgetFilter($item)
                                    ])
                                    ->select();
                                if (!empty($srcLinkIdData)) {
                                    // 有关联数据继续查询
                                    $currentModuleData = $this->_fieldFromDataDict["module_code"][$currentModule];
                                    $relationFilterIds = array_column($srcLinkIdData, "src_link_id");
                                    $relationFilterKey = $currentModuleData["type"] === "entity" ? "entity_id" : "{$currentModuleData["code"]}_id";

                                    $relationTable = $relationStructureFilterMap[$item["module_code"]]["module_type"] === "entity" ? "Entity" : string_initial_letter($relationStructureFilterMap[$item["module_code"]]["module_code"]);
                                    $middleMap = M($relationTable)->field($relationFilterKey)
                                        ->where(["id" => ["IN", join(",", $relationFilterIds)]])
                                        ->select();

                                    if (!empty($middleMap)) {
                                        $filterData[$currentModule . '.id'] = ["IN", join(",", array_column($middleMap, $relationFilterKey))];
                                    } else {
                                        $filterData[$currentModule . '.id'] = 0;
                                    }
                                } else {
                                    $filterData[$currentModule . '.id'] = 0;
                                }
                                break;
                        }
                    }
                }
            }


            if (count($filterData) > 0) {
                // 添加当前过滤逻辑
                $filterData['_logic'] = $logic;
            }
        }
        return $filterData;
    }

    /**
     * 合并远端查询过滤条件
     * @param $horizontalFilterKey
     * @param $filterData
     * @param $newValue
     * @return array|int
     */
    private function mergeRemoteFilteringConditions($horizontalFilterKey, $filterData, $newValue)
    {
        if (array_key_exists($horizontalFilterKey, $filterData)) {
            if ($filterData[$horizontalFilterKey] == 0 || $newValue == 0) {
                return 0;
            } else {
                $oldValueList = explode(",", $filterData[$horizontalFilterKey][1]);
                $newValueList = explode(",", $newValue[1]);
                return ["IN", unique_arr(array_merge($oldValueList, $newValueList))];
            }
        } else {
            return $newValue;
        }
    }

    /**
     * 合并远端自定义查询过滤条件
     * @param $horizontalFilterKey
     * @param $filterData
     * @param $newValue
     * @return array|int
     */
    private function mergeRemoteCustomFilteringConditions($horizontalFilterKey, $filterData, $newValue)
    {
        if (array_key_exists($horizontalFilterKey, $filterData)) {
            if ($filterData[$horizontalFilterKey] == 0 || $newValue == 0) {
                return 0;
            } else {
                $oldValueList = explode(",", $filterData[$horizontalFilterKey][1]);
                $newValueList = $newValue;
                $condition = 'IN';
                if ($filterData[$horizontalFilterKey][0] === 'NOT IN') {
                    if ($this->currentRemoteQueryMethod === 'NOT IN') {
                        $condition = 'NOT IN';
                        $resultList = $this->remoteCustomFilterMerge($newValueList, $oldValueList);
                    } else {
                        $resultList = $this->remoteCustomFilterExclude($newValueList, $oldValueList);
                    }
                } else {
                    if ($this->currentRemoteQueryMethod === 'NOT IN') {
                        $resultList = $this->remoteCustomFilterExclude($oldValueList, $newValueList);
                    } else {
                        $resultList = array_intersect($oldValueList, $newValueList);
                    }
                }

                return [$condition, join(',', $resultList)];
            }
        } else {
            $condition = $this->currentRemoteQueryMethod === 'NOT IN' ? 'NOT IN' : 'IN';
            if ($newValue === 0) {
                if ($condition === 'NOT IN') {
                    return ['NOT IN', ''];
                }
                return 0;
            }
            return [$condition, join(',', $newValue)];
        }
    }

    /**
     * 远程自定义查询条件交集
     * @param $valueList
     * @param $interList
     * @return array
     */
    private function remoteCustomFilterIntersection($valueList, $interList)
    {
        $newValueList = [];
        foreach ($valueList as $value) {
            if (in_array($value, $interList)) {
                $newValueList[] = $value;
            }
        }
        return $newValueList;
    }

    /**
     * 远程自定义查询条件排除Not in结果集
     * @param $valueList
     * @param $excludeList
     * @return array
     */
    private function remoteCustomFilterExclude($valueList, $excludeList)
    {
        $newValueList = [];
        foreach ($valueList as $value) {
            if (!in_array($value, $excludeList)) {
                $newValueList[] = $value;
            }
        }
        return $newValueList;
    }

    /**
     * 远程自定义查询条件合并
     * @param $oldValueList
     * @param $newValueList
     * @return array
     */
    private function remoteCustomFilterMerge($oldValueList, $newValueList)
    {
        return unique_arr(array_merge($oldValueList, $newValueList));
    }

    /**
     * 获取远端水平关联数据
     * @param $filterItem
     * @param $param
     * @return array
     */
    private function getRemoteHorizontalFilterData($filterItem, $param)
    {
        // api查询时，需要根据其他字段进行过滤数据
        if ($filterItem["field"] !== "id") {
            $dstLinkIdList = M(string_initial_letter($param["module_code"]))->field("id")
                ->where([
                    $filterItem["field"] => $this->buildWidgetFilter($filterItem)
                ])
                ->select();
            if (!empty($dstLinkIdList)) {
                $filter = ["IN", array_column($dstLinkIdList, "id")];
            } else {
                $filter = ["EQ", 0];
            }
        } else {
            $filter = $this->buildWidgetFilter($filterItem);
        }

        // 保持当前一对多水平关联查询方法
        $this->currentRemoteQueryMethod = $filter[0];

        // 查询水平关联数据
        $horizontalModel = M("Horizontal");
        $horizontalData = $horizontalModel->field("src_link_id")
            ->where([
                "dst_link_id" => $filter,
                "src_module_id" => $param["middle_config"]["master_module_id"],
                "variable_id" => $filterItem["variable_id"],
            ])
            ->select();

        $horizontalSourceLinkIds = array_column($horizontalData, "src_link_id");
        $horizontalLinkIds = [];
        // 需要判断当前查询方法
        switch ($filter[0]) {
            case "EQ":
                // 验证当前
                $srcHorizontalRelationData = $horizontalModel->field("src_link_id,dst_link_id")
                    ->where([
                        "src_link_id" => ["IN", join(",", $horizontalSourceLinkIds)],
                        "src_module_id" => $param["middle_config"]["master_module_id"],
                        "variable_id" => $filterItem["variable_id"],
                    ])
                    ->select();

                $srcHorizontalRelationFrequencyDict = [];
                foreach ($srcHorizontalRelationData as $srcHorizontalRelationItem) {
                    if (array_key_exists($srcHorizontalRelationItem['src_link_id'], $srcHorizontalRelationFrequencyDict)) {
                        $srcHorizontalRelationFrequencyDict[$srcHorizontalRelationItem['src_link_id']]++;
                    } else {
                        $srcHorizontalRelationFrequencyDict[$srcHorizontalRelationItem['src_link_id']] = 1;
                    }
                }

                foreach ($horizontalSourceLinkIds as $horizontalSourceLinkId) {
                    if (array_key_exists($horizontalSourceLinkId, $srcHorizontalRelationFrequencyDict) && $srcHorizontalRelationFrequencyDict[$horizontalSourceLinkId] === 1) {
                        array_push($horizontalLinkIds, $horizontalSourceLinkId);
                    }
                }
                break;
            case 'NOT IN':
                // 验证当前
                $srcHorizontalRelationData = $horizontalModel->field("src_link_id,dst_link_id")
                    ->where([
                        "src_module_id" => $param["middle_config"]["master_module_id"],
                        "variable_id" => $filterItem["variable_id"],
                    ])
                    ->select();


                $notInList = explode(",", $filter[1]);
                foreach ($srcHorizontalRelationData as $srcHorizontalRelationItem) {
                    if (in_array($srcHorizontalRelationItem['dst_link_id'], $notInList) && !in_array($srcHorizontalRelationItem['src_link_id'], $horizontalLinkIds)) {
                        array_push($horizontalLinkIds, $srcHorizontalRelationItem['src_link_id']);
                    }
                }
                break;
            default:
                $horizontalLinkIds = $horizontalSourceLinkIds;
                break;
        }

        return $horizontalLinkIds;
    }

    /**
     * 生成高级过滤条件
     * @param $currentModule
     * @param $relationStructure
     * @param $filter
     * @return array
     */
    private function buildAdvanceFilter($currentModule, $relationStructure, $filter)
    {
        if (!empty($filter)) {
            if ($filter["number"] > 1) {
                // 多组过滤条件
                $filterData = [];
                foreach ($filter as $key => $value) {
                    if (!in_array(strval($key), ["multiple", "logic", "number"])) {
                        $itemFilter = $this->advanceFilterBase($currentModule, $relationStructure, $value);
                        array_push($filterData, $itemFilter);
                    }
                }
                $filterData["_logic"] = $filter["logic"];
                return $filterData;
            } else {
                // 一组过滤条件
                return $this->advanceFilterBase($currentModule, $relationStructure, $filter);
            }
        } else {
            return [];
        }
    }

    /**
     * 高级查询基础模块
     * @param $currentModule
     * @param $relationStructure
     * @param $filterItem
     * @return array
     */
    private function advanceFilterBase($currentModule, $relationStructure, $filterItem)
    {
        return $this->buildItemFilter($currentModule, $relationStructure, $filterItem, $filterItem["logic"], 'advance');
    }
}
