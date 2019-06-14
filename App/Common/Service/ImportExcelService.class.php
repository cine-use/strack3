<?php
// +----------------------------------------------------------------------
// | ImportExcel服务层
// +----------------------------------------------------------------------
// | 主要服务于Excel文件导入处理
// +----------------------------------------------------------------------
// | 错误编码头 217xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\EntityModel;
use Common\Model\StatusModel;
use Common\Model\StepModel;
use Common\Model\UserModel;
use Common\Model\VariableValueModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportExcelService
{

    /**
     * 待处理表格数据
     * @var array
     */
    protected $sheetData = [];

    /**
     * 保存列号
     * @var array
     */
    protected $columnNumberList = [];

    /**
     * 判断是否有表头
     * @var bool
     */
    protected $haveHeaderStatus = false;
    /**
     * 图片信息
     * @var array
     */
    protected $imageData = [];
    /**
     * @var array
     */
    protected $headerMap = [];

    /**
     * 实例化Spreadsheet对象
     * @param $filePath
     * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
     */
    protected function initSpreadsheet($filePath)
    {
        try {
            $spreadsheet = IOFactory::load($filePath);
            return $spreadsheet;
        } catch (\Exception $e) {
            throw_strack_exception($e->getMessage(), 217001);
        }
    }

    /**
     * 获取图像数据
     * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
     * @param $tempExcelRelativePath
     * @return array
     * @throws \Exception
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function getImages(\PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet, $tempExcelRelativePath)
    {
        $tempDirectoryName = '/excel_images/';
        $tempExcelPath = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . $tempExcelRelativePath;

        // 获取当前excel图片数据
        $imageDrawingData = [];
        foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {
            $zipReader = fopen($drawing->getPath(), 'r');
            $imageContents = '';
            while (!feof($zipReader)) {
                $imageContents .= fread($zipReader, 1024);
            }
            fclose($zipReader);

            //图片左上角所在单元格
            $coordinates = $drawing->getCoordinates();

            //保存图片目录
            $cellFileName = $tempDirectoryName . 'excel_image_temp' . string_random(8) . '.jpg';

            array_push($imageDrawingData, [
                "coordinates" => $coordinates,
                "name" => $cellFileName,
                "content" => $imageContents
            ]);
        }


        // 如果存在图片把它保存到临时目录
        $imageData = [];
        $imagesExitCoordinates = [];

        if (!empty($imageDrawingData)) {

            // 创建图片临时存放目录
            create_directory($tempExcelPath . $tempDirectoryName);

            // 遍历图片数据保存到临时目录
            foreach ($imageDrawingData as $value) {
                if (in_array($value["coordinates"], $imagesExitCoordinates)) {
                    // 同一个单元格不能存在多张图片，返回错误单元格,让用户手动修改
                    throw_strack_exception($value["coordinates"] . "_" . L("Excel_Image_Overlap"), 217002);
                } else {
                    array_push($imagesExitCoordinates, $value["coordinates"]);

                    // 保存到临时目录
                    $tempPath = $tempExcelPath . '' . $value["name"];
                    file_put_contents($tempPath, $value["content"]);

                    $imageData[$value["coordinates"]] = $tempExcelRelativePath . '' . $value["name"];
                }
            }
        }

        return $this->imageData = $imageData;
    }

    /**
     * 传入文件得到excel数据
     * @param $filePath
     * @param $tempExcelRelativePath
     * @throws \Exception
     */
    public function file($filePath, $tempExcelRelativePath)
    {
        // 初始化 Spreadsheet 对象
        $spreadsheet = $this->initSpreadsheet($filePath);
        $sheetData = $spreadsheet->getActiveSheet()->toArray('', true, true, true);
        if (empty($sheetData)) {
            throw_strack_exception('Input_Excel_Data_Require', 217004);
        }
        $this->columnNumberList = array_keys($sheetData[1]);
        // 获取图片数据
        $imagesData = $this->getImages($spreadsheet, $tempExcelRelativePath);
        foreach ($imagesData as $key => $value) {
            preg_match_all('/([0-9]+|[a-zA-Z]+)/', $key, $data);
            list($row, $column) = $data[0];
            $sheetData[$column][$row] = empty($sheetData[$column][$row]) ? $value : throw_strack_exception($row . $column . "_" . L("Image_Cells_Cannot_Have_Data"), 217003);
        }
        $this->sheetData = $sheetData;
    }


    /**
     * 粘贴数据
     * @param $data
     */
    public function paste($data)
    {
        $this->sheetData = $data;
    }


    /**
     * 获取待处理数据
     * @return array
     */
    public function getData()
    {
        return $this->sheetData;
    }

    /**
     * 获取第一行索引列表
     * @return array
     */
    protected function getFirstColumnIndex()
    {
        // 无表头取列标号作为表头例如 [A1,A2,A3]
        if (!empty($this->columnNumberList)) {
            // 存在序号列表直接返回
            return $this->columnNumberList;
        } else {
            // 不存在取第一行数据，组装返回
            $maxColumnNumber = count(reset($this->sheetData));
            $countColumnNumber = 0;
            for ($k = 'A'; $k <= 'ZZ'; $k++) {
                $countColumnNumber++;
                if ($countColumnNumber <= $maxColumnNumber) {
                    array_push($this->columnNumberList, $k);
                } else {
                    break;
                }
            }
            return $this->columnNumberList;
        }
    }

    /**
     * 设置是否有表头
     * @param $haveHeader
     */
    public function setHeaderStatus($haveHeader)
    {
        $this->haveHeaderStatus = $haveHeader;
    }

    /**
     * 获得表头
     * @return array
     */
    public function getHeader()
    {
        if (!empty($this->sheetData)) {

            $columnNumberList = $this->getFirstColumnIndex();
            $firstRowData = reset($this->sheetData);
            if (!in_array("id", $firstRowData)) {
                //最后一个key
                end($firstRowData);
                $last = key($firstRowData);
                $last++;
                $firstRowData[$last] = "id";
            }

            if ($this->haveHeaderStatus) {
                // 有表头取第一行字段
                $firstColumnKeyList = [];
                //处理掉特殊字符串
                $replace = ["(", ")", "*", ':', '/', '\\', '?', '[', ']', '.', ' '];
                $replaceList = array_fill_keys($replace, "");
                foreach ($firstRowData as $key => $value) {
                    $value = replace_string_to_specified_value($value, $replaceList);
                    if (!empty($value)) {
                        array_push($firstColumnKeyList, (string)$value);
                    } else {
                        // 当前单元格值为空，用列号补位
                        array_push($firstColumnKeyList, preg_replace('/[0-9]/', '', $key));
                    }
                }
                $header = $firstColumnKeyList;
            } else {
                $header = $columnNumberList;
            }
            if (!in_array("id", $header)) {
                array_push($header, "id");
            }
            $this->headerMap = array_combine(array_keys($firstRowData), $header);
            return $header;
        } else {
            // 不存在数据，报错
            throw_strack_exception(L("Input_Excel_Data_Require"), 217004);
        }
    }

    /**
     * 获取存在图片的单元格
     * @return array
     */
    public function getHaveImageCell()
    {
        if (!empty($this->imageData)) {
            $haveImageHeader = [];
            foreach ($this->imageData as $key => $value) {
                $cellIndex = preg_replace('/[0-9]/', '', $key);
                if (!in_array($cellIndex, $haveImageHeader)) {
                    array_push($haveImageHeader, $this->headerMap[$cellIndex]);
                }
            }
            return $haveImageHeader;
        } else {
            return [];
        }
    }

    /**
     * 获取表格正文数据
     * @return array
     */
    public function getBody()
    {
        if (!empty($this->sheetData)) {
            //body 数据键值为表头
            $data = [];
            $id = 0;
            foreach ($this->sheetData as $key => $value) {
                $rowData = [];
                foreach ($value as $k => $v) {
                    $rowData[$this->headerMap[$k]] = $v;
                }
                if (!array_key_exists("id", $rowData)) {
                    $rowData["id"] = $id++;
                }
                array_push($data, $rowData);
            }
            $this->sheetData = $data;
            if ($this->haveHeaderStatus) {
                // 有表头除去第一行字段
                $bodyData = $this->sheetData;
                array_shift($bodyData);
                return $bodyData;
            } else {
                // 无表头返回所有数据
                return $this->sheetData;
            }
        } else {
            // 不存在数据，报错
            throw_strack_exception(L("Input_Excel_Data_Require"), 217004);
        }
    }

    /**
     * 格式化字段数据
     * @param $format
     * @param $field
     * @param $item
     * @return mixed
     */
    protected function getFormatFieldData($format, $field, &$item)
    {
        // 查询status数据字典
        $statusModel = new StatusModel();
        $statusData = $statusModel->field("id,name,code")->select();
        $statusMapData = array_column($statusData, null, 'name');

        // 查询step数据字典
        $stepModel = new StepModel();
        $stepData = $stepModel->field("id,name,code")->select();
        $stepMapData = array_column($stepData, null, 'name');

        switch ($format) {
            case "status":
                $statusId = array_key_exists($item[$field], $statusMapData) ? $statusMapData[$item[$field]]["id"] : 0;
                $item[$field] = $statusId;
                break;
            case "step":
                $stepId = array_key_exists($item[$field], $stepMapData) ? $stepMapData[$item[$field]]["id"] : 0;
                $item[$field] = $stepId;
                break;
            case "user":
                $userModel = new UserModel();
                $userId = $userModel->where(["name" => $item[$field]])->getField("id");
                $item[$field] = $userId > 0 ? $userId : 0;
                break;
            case "entity":
                $entityModel = new EntityModel();
                $entityId = $entityModel->where(["name" => $item[$field]])->getField("id");
                $item[$field] = $entityId > 0 ? $entityId : 0;
                break;
            case "date":
            case "datetime":
                $item[$field] = strtotime($item[$field]);
                break;
        }
        return $item;
    }

    /**
     * 获取导入字段
     * @param $importField
     * @param $param
     * @return array
     */
    protected function getImportGridField($importField, $param)
    {
        // 获取映射的字段配置
        $viewService = new ViewService();
        $fieldsData = $viewService->getImportFields([
            "module_id" => $param["module_id"],
            "project_id" => $param['project_id'],
            "schema_page" => $param['schema_page']
        ]);

        $fieldMapping = [];
        foreach ($fieldsData["fields"] as $fieldItem) {
            if (array_key_exists($fieldItem["fields"], $importField)) {
                switch ($fieldItem["fields"]) {
                    case "status_id":
                        $format = "status";
                        break;
                    case "step_id":
                        $format = "step";
                        break;
                    case "user_id":
                        $format = "user";
                        break;
                    case "entity_id":
                        $format = "entity";
                        break;
                    default:
                        $format = array_key_exists("format", $fieldItem) ? $fieldItem["format"] : "";
                        break;
                }
                $fieldMapping[$fieldItem["fields"]] = [
                    "column" => $importField[$fieldItem["fields"]],
                    "field_type" => $fieldItem["field_type"],
                    "module_code" => $fieldItem["module_code"],
                    "format" => $format,
                    "table" => $fieldItem["table"],
                    "variable_id" => array_key_exists("variable_id", $fieldItem) ? $fieldItem["variable_id"] : 0,
                ];
            }
        }

        return $fieldMapping;
    }

    /**
     * 获取导入数据格式
     * @param $gridData
     * @param $param
     * @param $masterCode
     * @param $fieldMapping
     * @return array
     */
    protected function getImportGridData($gridData, $param, $masterCode, $fieldMapping)
    {
        // 处理成添加的格式
        $columnFieldData = [];
        foreach ($gridData as $key => $item) {
            $addData = [];
            foreach ($fieldMapping as $fieldKey => $fieldItem) {
                // 格式化需要的数据格式
                $this->getFormatFieldData($fieldItem["format"], $fieldItem["column"], $item);
                if ($fieldItem["field_type"] == "custom") {
                    $addData["relation_data"][$fieldItem["module_code"]][] = [
                        "variable_id" => $fieldItem["variable_id"],
                        "value" => $item[$fieldItem["column"]],
                        "module_id" => $param["module_id"],
                        "field_type" => $fieldItem["field_type"],
                        "table" => $fieldItem["table"],
                    ];
                } else {
                    // 处理主表
                    if ($fieldItem["module_code"] == $masterCode) {
                        $addData["master_data"][$fieldKey] = $item[$fieldItem["column"]];
                        $addData["master_data"]["project_id"] = $param["project_id"];
                        $addData["master_data"]["module_id"] = $param["module_id"];
                    } else { // 处理关联表
                        if ($fieldItem["module_code"] == "media") {
                            $addData["relation_data"][$fieldItem["module_code"]] = [
                                "thumb" => $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . $item[$fieldItem["column"]],
                                "field_type" => $fieldItem["field_type"],
                                "table" => $fieldItem["table"],
                            ];
                        } else {
                            $addData["relation_data"][$fieldItem["module_code"]] = [
                                $fieldKey => $item[$fieldItem["column"]],
                                "field_type" => $fieldItem["field_type"],
                                "table" => $fieldItem["table"],
                            ];
                        }
                    }
                }
            }
            array_push($columnFieldData, $addData);
        }

        return $columnFieldData;
    }

    /**
     * 导入Excel
     * @param $param
     * @return array
     */
    public function importExcelData($param)
    {
        // 获取module信息
        $schemaService = new SchemaService();
        $moduleData = $schemaService->getModuleFindData(["id" => $param["param"]["module_id"]]);
        $moduleCode = $moduleData["type"] === "entity" ? $moduleData["type"] : $moduleData["code"];

        // 获取导入的字段
        $fieldMapping = $this->getImportGridField($param["field_mapping"], $param["param"]);
        // 获取导入数据
        $columnFieldData = $this->getImportGridData($param["grid_data"], $param["param"], $moduleData["code"], $fieldMapping);

        // 实例化Model类
        $class = '\\Common\\Model\\' . string_initial_letter($moduleCode) . 'Model';
        $modelObj = new $class();

        $total = 0;
        $successTotal = 0;
        $modelObj->startTrans();
        try {
            // 保存数据
            foreach ($columnFieldData as $columnItem) {
                // 保存主表
                $masterData = $modelObj->addItem($columnItem["master_data"]);
                if (!$masterData) {
                    $total++;
                    throw new \Exception($modelObj->getError());
                } else {
                    if (array_key_exists("relation_data", $columnItem) && !empty($columnItem["relation_data"])) {
                        // 保存关联表
                        foreach ($columnItem["relation_data"] as $relationKey => $relationItem) {
                            if ($relationKey == $moduleData["code"]) { // 保存自定义字段
                                $relationModel = new VariableValueModel();
                                foreach ($relationItem as &$variableItem) {
                                    $customFilter = [
                                        "module_id" => $variableItem["module_id"],
                                        "link_id" => $masterData["id"],
                                        "variable_id" => $variableItem["variable_id"]
                                    ];
                                    // 因为存在异步event队列首先判断是否存在
                                    if ($relationModel->where($customFilter)->count() > 0) {
                                        $resData = $relationModel->where($customFilter)->save(["value" => $variableItem["value"]]);
                                    } else {
                                        $customFilter["value"] = $variableItem["value"];
                                        $resData = $relationModel->addItem($customFilter);
                                    }
                                    if (!$resData) {
                                        throw new \Exception($relationModel->getError());
                                    }
                                }
                            } else {
                                if ($relationKey === "media") { // 上传媒体图片
                                    $mediaService = new MediaService();
                                    $uploadData = $mediaService->uploadMedia($relationItem["thumb"]);
                                    if ($uploadData) {
                                        $mediaData["link_id"] = $masterData["id"];
                                        $mediaData["module_id"] = $param["param"]["module_id"];
                                        $mediaData["media_server"] = $uploadData["media_server"];
                                        $mediaData["media_data"] = $uploadData["media_data"];
                                        $mediaData["mode"] = "single";
                                        $mediaService->saveMediaData($mediaData);
                                    }
                                }
                            }
                        }
                    }
                    $total++;
                    $successTotal++;
                }
            }

            $modelObj->commit(); // 提交事物
            // 返回成功数据
            return success_response($modelObj->getSuccessMassege(), ["total" => $total, "success_total" => $successTotal]);
        } catch (\Exception $e) {
            $total++;
            $modelObj->rollback(); // 事物回滚
            // 添加数据失败错误码 005
            throw_strack_exception($e->getMessage(), 217005, ["line" => $total, "message" => $e->getMessage()]);
        }
    }
}