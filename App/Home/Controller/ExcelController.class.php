<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\EntityService;
use Common\Service\ExportExcelService;
use Common\Service\FileCommitService;
use Common\Service\FileService;
use Common\Service\ImportExcelService;
use Common\Service\ProjectService;
use Common\Service\SchemaService;
use Common\Service\UserService;
use Common\Service\ViewService;


class ExcelController extends VerifyController
{
    /**
     * 导出excel
     * @return \Think\Response
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function exportExcel()
    {
        $param = $this->request->formatGridParam($this->request->param(), '');
        $column = $param["columns_data"];
        $filterData = $param["filter_data"];

        // 查询module数据
        $schemaService = new SchemaService();
        $moduleData = $schemaService->getModuleFindData(["id" => $filterData["module_id"]]);

        $gridData = [];
        switch ($moduleData["type"]) {
            case "fixed":
                $prefixName = "project_";
                // 去掉当前前缀
                $moduleCode = str_replace($prefixName, "", $filterData["schema_page"]);
                switch ($moduleCode) {
                    case "member":
                        $serviceClass = new ProjectService();
                        $gridData = $serviceClass->getProjectMemberGridData($filterData);
                        break;
                    case "admin_account":
                        $serviceClass = new UserService();
                        $gridData = $serviceClass->getUserGridData($filterData);
                        break;
                    case "file_commit":
                        $fileService = new FileCommitService();
                        $gridData = $fileService->getDetailGridData($filterData);
                        break;
                    default:
                        if (array_key_exists("horizontal_type", $filterData)) {
                            $detailsModule = $filterData["horizontal_type"] === "entity" ? "entity" : "base";
                            $class = '\\Common\\Service\\' . string_initial_letter($detailsModule) . 'Service';
                            $serviceObj = new $class();
                            $gridData = $serviceObj->getDetailGridData($filterData);
                        } else {
                            $class = '\\Common\\Service\\' . string_initial_letter($moduleCode) . 'Service';
                            $serviceObj = new $class();
                            if ($filterData["page"] === "details_base") {
                                $gridData = $serviceObj->getDetailGridData($filterData);
                            } else {
                                $function = "get" . string_initial_letter($moduleCode) . "GridData";
                                $gridData = $serviceObj->$function($filterData);
                            }
                        }
                        break;
                }
                break;
            case "entity":
                $serviceClass = new EntityService();
                if (array_key_exists("module_type", $filterData) && in_array($filterData['module_type'], ['horizontal_relationship', 'be_horizontal_relationship'])) {
                    $gridData = $serviceClass->getDetailGridData($filterData);
                } else {
                    $gridData = $serviceClass->getEntityGridData($filterData);
                }
                break;
        }

        // 导出路径
        $filePath = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . "/Uploads/excel/download";
        //格式化Excel名称
        $replace = ["(", ")", "*", ':', '/', '\\', '?', '[', ']', '.'];
        $replaceList = array_fill_keys($replace, "");
        $param["excel_name"] = replace_string_to_specified_value($param["excel_name"], $replaceList);
        // 调用excel数据层
        $exportService = new ExportExcelService();
        $savePath = $exportService->generateExcel($param["excel_name"], $column, $gridData["rows"], $filePath);

        // 记录下载文件地址
        $fileService = new FileService();
        $resData = $fileService->recordDownloadFile($param["excel_name"], $savePath);

        return json($resData);
    }

    /**
     * 格式化Excel粘贴
     */
    public function formatExcelPasteData()
    {
        $param = $this->request->param();
        $importExcelService = new ImportExcelService();
        $viewService = new ViewService();
        $importExcelService->paste($param["parsed"]);
        $hasHeader = $param["has_header"] == 0 ? false : true;
        $importExcelService->setHeaderStatus($hasHeader);
        $fieldsData = $viewService->getImportFields(["module_id" => $param['module_id'], "project_id" => $param['project_id'], "schema_page" => $param['schema_page']]);
        $excelData = [
            'header' => $importExcelService->getHeader(),
            'body' => $importExcelService->getBody(),
            'fields' => $fieldsData["fields"],
            'columns_field_config' => $fieldsData["columns_field_config"]
        ];
        return json(success_response('', $excelData));
    }

    /**
     * 上传Excel文件处理
     * @return \Think\Response
     * @throws \Exception
     */
    public function formatExcelFileData()
    {
        $viewService = new ViewService();
        $param = $this->request->param();
        $tempFile = $_FILES['Filedata']['tmp_name'];
        $fileInfo = pathinfo($_FILES['Filedata']['name']);
        $extension = strtolower($fileInfo['extension']);
        if (in_array($extension, ['csv', 'xls', 'xlsx'])) {
            $importExcelService = new ImportExcelService();
            // 上传文件到临时目录
            $tempExcelRelativePath = "/Uploads/temp/excel/excel_{$param['batch_number']}/";
            $tempExcelPath = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . $tempExcelRelativePath;
            create_directory($tempExcelPath);
            $excelTempName = 'excel_' . string_random(8);
            $targetFile = $tempExcelPath . $excelTempName . "." . $extension;
            move_uploaded_file($tempFile, $targetFile);

            // 格式化处理数据
            $importExcelService->file($targetFile, $tempExcelRelativePath);
            $hasHeader = $param["has_header"] == 0 ? false : true;
            $importExcelService->setHeaderStatus($hasHeader);

            $fieldsData = $viewService->getImportFields(["module_id" => $param['module_id'], "project_id" => $param['project_id'], "schema_page" => $param['schema_page']]);

            $excelData = [
                'header' => $importExcelService->getHeader(),
                'body' => $importExcelService->getBody(),
                'images_column' => $importExcelService->getHaveImageCell(),
                'fields' => $fieldsData["fields"],
                'columns_field_config' => $fieldsData["columns_field_config"]
            ];
            return json(success_response('', $excelData));
        } else {
            throw_strack_exception(L("Input_Excel_Ext_Limit"), 233004);
        }
    }

    /**
     * 提交导入excel
     * @return \Think\Response
     * @throws \Exception
     */
    public function submitImportExcelData()
    {
        $param = $this->request->param();
        $importExcelService = new ImportExcelService();
        $resData = $importExcelService->importExcelData($param);
        return json($resData);
    }
}