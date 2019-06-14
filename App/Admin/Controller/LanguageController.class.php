<?php

namespace Admin\Controller;

use Common\Service\SchemaService;

// +----------------------------------------------------------------------
// | 多语言数据控制层
// +----------------------------------------------------------------------

class LanguageController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 获取模块列表(只需要生成Entity类型)
     */
    public function getLanguageModuleData()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $colKey = explode(",", $param["col_key"]);
        $resData = $schemaService->getLanguageModuleData($colKey);
        return json($resData);
    }

    /**
     * 生成语言包
     */
    public function generateLanguagePackage()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $schemaService->saveLanguagePackage($param);
        $colKeys = explode(",", $param["col_key"]);
        // 生成语言包文件
        $this->doGenerateLanguagePackage($colKeys, $param["modules"]);
        return json(success_response(L("Lang_Generate_SC")));
    }

    /**
     * 写入语言包文件
     * @param $langFolder
     * @param $colKey
     * @param $baseConfig
     */
    protected function writeToLanguagePackageFile($langFolder, $colKey, $baseConfig)
    {
        file_put_contents($langFolder . '/default/' . $colKey . '.php', "<?php" . PHP_EOL);
        $fp = fopen($langFolder . '/default/' . $colKey . '.php', 'a+b');
        fwrite($fp, 'return ');
        fwrite($fp, var_export($baseConfig, true));
        fwrite($fp, ';');
        fclose($fp);
    }

    /**
     * 把php语言包写入变量
     * @param $baseConfig
     */
    protected function writeTolanguageHtmlFile($baseConfig)
    {
        $langFolder = ROOT_PATH . 'tpl/Public/lang.tpl';
        $langStringList = [];
        foreach ($baseConfig as $key => $value) {
            $langStringList[string_initial_letter($key, '_')] = '{$Think.lang.' . $key . '}';
        }
        $langHtml = '<script type="text/javascript">var StrackLang =' . json_encode($langStringList) . ' ;</script>';
        file_put_contents($langFolder, "");
        $fp = fopen($langFolder, 'a+b');
        fwrite($fp, $langHtml);
        fclose($fp);
    }

    /**
     * 执行生成系统语言包
     * @param $colKeys
     * @param $rows
     */
    protected function doGenerateLanguagePackage($colKeys, $rows)
    {
        $langFolder = ROOT_PATH . 'App/Common/Lang';
        $htmlHasGenerate = false;
        foreach ($colKeys as $colKey) {
            $baseConfig = require($langFolder . "/base/{$colKey}_fixed.php");
            foreach ($rows as $row) {
                $baseConfig = $this->appendLanguagePackage($baseConfig, $colKey, $row);
            }
            $this->writeToLanguagePackageFile($langFolder, $colKey, $baseConfig);
            if (!$htmlHasGenerate) {
                $this->writeTolanguageHtmlFile($baseConfig);
                $htmlHasGenerate = true;
            }
        }
    }

    /**
     * 基础语言包
     * @param $baseConfig
     * @param $colKey
     * @param $row
     * @return mixed
     */
    protected function appendLanguagePackage($baseConfig, $colKey, $row)
    {
        $prefix = ucfirst($row["code"]);
        $baseName = $row[$colKey];
        $baseConfig[$prefix] = $baseName;
        $baseConfig[$prefix . '_Name'] = $baseName;
        $baseConfig['Strack_' . $prefix] = 'Strack-' . $baseName;
        switch ($row["type"]) {
            case "entity":
                return $this->setEntityFieldLanguagePackage($baseConfig, $prefix, $colKey, $baseName);
        }
    }

    /**
     * 设置实体语言包
     * @param $baseConfig
     * @param $prefix
     * @param $colKey
     * @param $baseName
     * @return mixed
     */
    protected function setEntityFieldLanguagePackage($baseConfig, $prefix, $colKey, $baseName)
    {
        $lowerBaseName = strtolower($baseName);
        switch ($colKey) {
            case 'en-us':
                $baseConfig[$prefix . '_Id'] = $baseName . ' ID';
                $baseConfig[$prefix . '_Status'] = $baseName . ' status';
                $baseConfig[$prefix . '_Code'] = $baseName . ' code';
                $baseConfig[$prefix . '_Custom'] = $baseName . ' custom';
                $baseConfig[$prefix . '_Details'] = $baseName . ' details';
                $baseConfig[$prefix . '_Thumbnail'] = $baseName . ' thumbnail';
                $baseConfig[$prefix . '_Add_Title'] = 'Add ' . $lowerBaseName;
                $baseConfig['Please_Select_' . $prefix] = 'Please select ' . $lowerBaseName . ' .';
                $baseConfig[$prefix . '_status_id_Sc'] = 'Successfully update the ' . $lowerBaseName . ' status!';
                $baseConfig[$prefix . '_Step_Template_Sc'] = 'Successfully update the ' . $lowerBaseName . ' project template step settings!';
                $baseConfig[$prefix . '_Status_Template_Sc'] = 'Successfully update the ' . $lowerBaseName . ' project template status settings!';
                $baseConfig[$prefix . '_Sort_Template_Sc'] = 'Successfully update the ' . $lowerBaseName . ' project template sort settings!';
                $baseConfig[$prefix . '_Group_Template_Sc'] = 'Successfully update the ' . $lowerBaseName . ' project template group settings!';
                $baseConfig[$prefix . '_Step_Fields_Template_Sc'] = 'Successfully update the ' . $lowerBaseName . ' project template step fields settings!';
                $baseConfig[$prefix . '_Top_Field_Template_Sc'] = 'Successfully update the ' . $lowerBaseName . ' project template top field settings!';
                $baseConfig[$prefix . 'Link_Onset_Template_Sc'] = 'Successfully update the ' . $lowerBaseName . ' project template link onset settings!';
                $baseConfig[$prefix . '_Tag_Template_Sc'] = 'Successfully update the ' . $lowerBaseName . ' project template tag settings!';
                $baseConfig[$prefix . '_Tab_Template_Sc'] = 'Successfully update the ' . $lowerBaseName . ' project template tab settings!';
                $baseConfig['Add_' . $prefix . '_Sc'] = 'Successfully add the ' . $lowerBaseName . '!';
                $baseConfig['Delete_' . $prefix . '_Sc'] = 'Successfully delete the ' . $lowerBaseName . '!';
                $baseConfig['Modify_' . $prefix . '_Sc'] = 'Successfully update the ' . $lowerBaseName . '!';
                $baseConfig['Modify_' . $prefix . '_Name_Sc'] = 'Successfully update the ' . $lowerBaseName . 'name!';
                $baseConfig['Modify_' . $prefix . '_Code_Sc'] = 'Successfully update the ' . $lowerBaseName . 'code!';
                $baseConfig['Modify_' . $prefix . '_Project_Id_Sc'] = 'Successfully update the ' . $lowerBaseName . 'project id!';
                $baseConfig['Modify_' . $prefix . '_Status_Id_Sc'] = 'Successfully update the ' . $lowerBaseName . 'status!';
                $baseConfig['Modify_' . $prefix . '_Description_Sc'] = 'Successfully update the ' . $lowerBaseName . 'description!';
                $baseConfig['Modify_' . $prefix . '_Parent_Id_Sc'] = 'Successfully update the ' . $lowerBaseName . 'parent id!';
                $baseConfig['Modify_' . $prefix . '_Parent_Module_Id_Sc'] = 'Successfully update the ' . $lowerBaseName . 'parent module id!';
                $baseConfig['Modify_' . $prefix . '_Start_Time_Sc'] = 'Successfully update the ' . $lowerBaseName . 'start time!';
                $baseConfig['Modify_' . $prefix . '_End_Time_Sc'] = 'Successfully update the ' . $lowerBaseName . 'end time!';
                $baseConfig['Modify_' . $prefix . '_Duration_Sc'] = 'Successfully update the ' . $lowerBaseName . 'duration!';
                $baseConfig['Modify_' . $prefix . '_Workflow_Id_Sc'] = 'Successfully update the ' . $lowerBaseName . 'workflow id!';
                $baseConfig['Modify_' . $prefix . '_Json_Sc'] = 'Successfully update the ' . $lowerBaseName . 'json id!';
                break;
            case 'zh-cn':
                $baseConfig[$prefix . '_Id'] = $baseName . '编号';
                $baseConfig[$prefix . '_Status'] = $baseName . '状态';
                $baseConfig[$prefix . '_Code'] = $baseName . '编码';
                $baseConfig[$prefix . '_Custom'] = $baseName . '自定义';
                $baseConfig[$prefix . '_Details'] = $baseName . '详情';
                $baseConfig[$prefix . '_Thumbnail'] = $baseName . '缩略图';
                $baseConfig[$prefix . '_Add_Title'] = '添加' . $baseName;
                $baseConfig['Please_Select_' . $prefix] = '请选择' . $baseName . '。';
                $baseConfig[$prefix . '_status_id_Sc'] = $baseName . '状态更新成功！';
                $baseConfig[$prefix . '_Step_Template_Sc'] = '项目模板' . $baseName . '工序修改成功！';
                $baseConfig[$prefix . '_Status_Template_Sc'] = '项目模板' . $baseName . '状态修改成功！';
                $baseConfig[$prefix . '_Sort_Template_Sc'] = '项目模板' . $baseName . '排序修改成功！';
                $baseConfig[$prefix . '_Group_Template_Sc'] = '项目模板' . $baseName . '分组修改成功！';
                $baseConfig[$prefix . '_Step_Fields_Template_Sc'] = '项目模板' . $baseName . '工序基础字段修改成功！';
                $baseConfig[$prefix . '_Top_Field_Template_Sc'] = '项目模板' . $baseName . '详情页面顶部字段修改成功！';
                $baseConfig[$prefix . '_Link_Onset_Template_Sc'] = '项目模板' . $baseName . '关联现场数据修改成功！';
                $baseConfig[$prefix . '_Tag_Template_Sc'] = '项目模板' . $baseName . '标签修改成功！';
                $baseConfig[$prefix . '_Tab_Template_Sc'] = '项目模板' . $baseName . '标签栏修改成功！';
                $baseConfig['Add_' . $prefix . '_Sc'] = '添加' . $baseName . '成功！';
                $baseConfig['Delete_' . $prefix . '_Sc'] = '删除' . $baseName . '成功！';
                $baseConfig['Modify_' . $prefix . '_Sc'] = '修改' . $baseName . '成功！';
                $baseConfig['Modify_' . $prefix . '_Name_Sc'] = '修改' . $baseName . '名称成功！';
                $baseConfig['Modify_' . $prefix . '_Code_Sc'] = '修改' . $baseName . '编码成功！';
                $baseConfig['Modify_' . $prefix . '_Project_Id_Sc'] = '修改' . $baseName . '项目编号成功！';
                $baseConfig['Modify_' . $prefix . '_Status_Id_Sc'] = '修改' . $baseName . '状态编号成功！';
                $baseConfig['Modify_' . $prefix . '_Description_Sc'] = '修改' . $baseName . '描述成功！';
                $baseConfig['Modify_' . $prefix . '_Parent_Id_Sc'] = '修改' . $baseName . '父级编号成功！';
                $baseConfig['Modify_' . $prefix . '_Parent_Module_Id_Sc'] = '修改' . $baseName . '父级模块编号成功！';
                $baseConfig['Modify_' . $prefix . '_Start_Time_Sc'] = '修改' . $baseName . '开始时间成功！';
                $baseConfig['Modify_' . $prefix . '_End_Time_Sc'] = '修改' . $baseName . '结束时间成功！';
                $baseConfig['Modify_' . $prefix . '_Duration_Sc'] = '修改' . $baseName . '周期成功！';
                $baseConfig['Modify_' . $prefix . '_Workflow_Id_Sc'] = '修改' . $baseName . '工作流编号成功！';
                $baseConfig['Modify_' . $prefix . '_Json_Sc'] = '修改' . $baseName . 'Json成功！';
                break;
        }
        return $baseConfig;
    }
}