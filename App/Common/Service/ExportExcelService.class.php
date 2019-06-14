<?php
// +----------------------------------------------------------------------
// | Excel服务层
// +----------------------------------------------------------------------
// | 主要服务于Excel文件导出处理
// +----------------------------------------------------------------------
// | 错误编码头 234xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Think\Image;

class ExportExcelService
{
    /**
     * PhpSpreadsheet 对象
     * @var
     */
    protected $phpSpreadsheet;
    /**
     * excel待处理数据
     * @var
     */
    protected $sheetData;
    /**
     * 表头信息
     * @var
     */
    protected $headerData;
    /**
     * body信息
     * @var
     */
    protected $bodyData;
    /**
     * 单元格默认预设高度
     * @var int
     */
    protected $height = 42;
    /**
     * 单元格默认预设宽度
     * @var int
     */
    protected $width = 20;

    /** 列号默认预设
     * @param $index
     * @return mixed
     */
    protected function defaultColumnNumbers($index)
    {
        $excelPosition = [
            "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
            "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ",
            "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR", "BS", "BT", "BU", "BV", "BW", "BX", "BY", "BZ",
            "CA", "CB", "CC", "CD", "CE", "CF", "CG", "CH", "CI", "CJ", "CK", "CL", "CM", "CN", "CO", "CP", "CQ", "CR", "CS", "CT", "CU", "CV", "CW", "CX", "CY", "CZ",
            "DA", "DB", "DC", "DD", "DE", "DF", "DG", "DH", "DI", "DJ", "DK", "DL", "DM", "DN", "DO", "DP", "DQ", "DR", "DS", "DT", "DU", "DV", "DW", "DX", "DY", "DZ",
            "EA", "EB", "EC", "ED", "EE", "EF", "EG", "EH", "EI", "EJ", "EK", "EL", "EM", "EN", "EO", "EP", "EQ", "ER", "ES", "ET", "EU", "EV", "EW", "EX", "EY", "EZ",
            "FA", "FB", "FC", "FD", "FE", "FF", "FG", "FH", "FI", "FJ", "FK", "FL", "FM", "FN", "FO", "FP", "FQ", "FR", "FS", "FT", "FU", "FV", "FW", "FX", "FY", "FZ",
            "GA", "GB", "GC", "GD", "GE", "GF", "GG", "GH", "GI", "GJ", "GK", "GL", "GM", "GN", "GO", "GP", "GQ", "GR", "GS", "GT", "GU", "GV", "GW", "GX", "GY", "GZ",
            "HA", "HB", "HC", "HD", "HE", "HF", "HG", "HH", "HI", "HJ", "HK", "HL", "HM", "HN", "HO", "HP", "HQ", "HR", "HS", "HT", "HU", "HV", "HW", "HX", "HY", "HZ",
            "IA", "IB", "IC", "ID", "IE", "IF", "IG", "IH", "II", "IJ", "IK", "IL", "IM", "IN", "IO", "IP", "IQ", "IR", "IS", "IT", "IU", "IV", "IW", "IX", "IY", "IZ",
            "JA", "JB", "JC", "JD", "JE", "JF", "JG", "JH", "JI", "JJ", "JK", "JL", "JM", "JN", "JO", "JP", "JQ", "JR", "JS", "JT", "JU", "JV", "JW", "JX", "JY", "JZ",
            "KA", "KB", "KC", "KD", "KE", "KF", "KG", "KH", "KI", "KJ", "KK", "KL", "KM", "KN", "KO", "KP", "KQ", "KR", "KS", "KT", "KU", "KV", "KW", "KX", "KY", "KZ",
            "LA", "LB", "LC", "LD", "LE", "LF", "LG", "LH", "LI", "LJ", "LK", "LL", "LM", "LN", "LO", "LP", "LQ", "LR", "LS", "LT", "LU", "LV", "LW", "LX", "LY", "LZ",
            "MA", "MB", "MC", "MD", "ME", "MF", "MG", "MH", "MI", "MJ", "MK", "ML", "MM", "MN", "MO", "MP", "MQ", "MR", "MS", "MT", "MU", "MV", "MW", "MX", "MY", "MZ",
            "NA", "NB", "NC", "ND", "NE", "NF", "NG", "NH", "NI", "NJ", "NK", "NL", "NM", "NN", "NO", "NP", "NQ", "NR", "NS", "NT", "NU", "NV", "NW", "NX", "NY", "NZ",
            "OA", "OB", "OC", "OD", "OE", "OF", "OG", "OH", "OI", "OJ", "OK", "OL", "OM", "ON", "OO", "OP", "OQ", "OR", "OS", "OT", "OU", "OV", "OW", "OX", "OY", "OZ",
            "PA", "PB", "PC", "PD", "PE", "PF", "PG", "PH", "PI", "PJ", "PK", "PL", "PM", "PN", "PO", "PP", "PQ", "PR", "PS", "PT", "PU", "PV", "PW", "PX", "PY", "PZ",
            "QA", "QB", "QC", "QD", "QE", "QF", "QG", "QH", "QI", "QJ", "QK", "QL", "QM", "QN", "QO", "QP", "QQ", "QR", "QS", "QT", "QU", "QV", "QW", "QX", "QY", "QZ",
            "RA", "RB", "RC", "RD", "RE", "RF", "RG", "RH", "RI", "RJ", "RK", "RL", "RM", "RN", "RO", "RP", "RQ", "RR", "RS", "RT", "RU", "RV", "RW", "RX", "RY", "RZ",
            "SA", "SB", "SC", "SD", "SE", "SF", "SG", "SH", "SI", "SJ", "SK", "SL", "SM", "SN", "SO", "SP", "SQ", "SR", "SS", "ST", "SU", "SV", "SW", "SX", "SY", "SZ",
            "TA", "TB", "TC", "TD", "TE", "TF", "TG", "TH", "TI", "TJ", "TK", "TL", "TM", "TN", "TO", "TP", "TQ", "TR", "TS", "TT", "TU", "TV", "TW", "TX", "TY", "TZ",
            "UA", "UB", "UC", "UD", "UE", "UF", "UG", "UH", "UI", "UJ", "UK", "UL", "UM", "UN", "UO", "UP", "UQ", "UR", "US", "UT", "UU", "UV", "UW", "UX", "UY", "UZ",
            "VA", "VB", "VC", "VD", "VE", "VF", "VG", "VH", "VI", "VJ", "VK", "VL", "VM", "VN", "VO", "VP", "VQ", "VR", "VS", "VT", "VU", "VV", "VW", "VX", "VY", "VZ",
            "WA", "WB", "WC", "WD", "WE", "WF", "WG", "WH", "WI", "WJ", "WK", "WL", "WM", "WN", "WO", "WP", "WQ", "WR", "WS", "WT", "WU", "WV", "WW", "WX", "WY", "WZ",
            "XA", "XB", "XC", "XD", "XE", "XF", "XG", "XH", "XI", "XJ", "XK", "XL", "XM", "XN", "XO", "XP", "XQ", "XR", "XS", "XT", "XU", "XV", "XW", "XX", "XY", "XZ",
            "YA", "YB", "YC", "YD", "YE", "YF", "YG", "YH", "YI", "YJ", "YK", "YL", "YM", "YN", "YO", "YP", "YQ", "YR", "YS", "YT", "YU", "YV", "YW", "YX", "YY", "YZ",
            "ZA", "ZB", "ZC", "ZD", "ZE", "ZF", "ZG", "ZH", "ZI", "ZJ", "ZK", "ZL", "ZM", "ZN", "ZO", "ZP", "ZQ", "ZR", "ZS", "ZT", "ZU", "ZV", "ZW", "ZX", "ZY", "ZZ",
        ];
        return $excelPosition[$index];
    }

    /**
     * 生成Excel
     * @param $name
     * @param $header
     * @param $data
     * @param $savePath
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function generateExcel($name, $header, $data, $savePath)
    {
        if (empty($name)) {
            throw_strack_exception(L("Excel_Name_Require"), 234004);
        }
        if (count($data) > 200) {
            throw_strack_exception(L("Exports_Maximum_Number_Of_Is") . '200', 234003);
        }
        $this->data($header, $data);
        $this->formatBodyData();
        $this->generateHeader();
        $this->generateBody();
        return $this->save($name, $savePath);
    }

    /**
     * 传入数据 判断表头
     * @param $header
     * @param $data
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function data($header, $data)
    {
        $this->phpSpreadsheet = new Spreadsheet();
        //默认单元格样式
        $this->phpSpreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight($this->height);
        $this->phpSpreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth($this->width);
        //所有单元格居中显示
        $this->phpSpreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $this->phpSpreadsheet->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $headerNumber = count($header);
        //判断有几层表头
        if ($headerNumber >= 2) {
            $this->formatComplexHeader($header);
        } else {
            $this->formatSimpleHeader($header);
        }
        //待处理数据
        $this->sheetData = $data;
    }


    /**
     * 获取当前单元格列号
     * @param $index
     * @param $location
     * @return string
     */
    protected function getCellColumnNumber($index, $location)
    {
        $cellName = $this->defaultColumnNumbers($index) . "" . $location;
        return $cellName;
    }

    /**
     * 设置表头样式
     * @return array
     */
    protected function setHeaderStyle()
    {
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => [
                    'argb' => '00000000',
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startcolor' => [
                    'argb' => 'cdffcc',
                ],
            ]
        ];
        return $headerStyle;
    }

    /**
     * 设置内容样式
     */
    protected function setContentStyle()
    {
        $contentStyle = [
            'font' => [
                'size' => 11,
                'color' => [
                    'argb' => '00000000',
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startcolor' => [
                    'argb' => 'cdffcc',
                ],
            ]
        ];
        return $contentStyle;

    }

    /**
     * 设置边框样式
     * @param $color
     * @param $direction
     * @return array
     */
    public function setBorderStyle($color)
    {
        $bordersStyle = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => $color],
                ],
            ],
        ];
        return $bordersStyle;
    }

    /**
     * 简单表头
     * @param $header
     * @return mixed
     */
    public function formatSimpleHeader($header)
    {
        //获取字段
        foreach ($header as $item) {
            foreach ($item as $key => $val) {
                if (isset($val["field"]) && !empty($val["field"]) && isset($val["title"]) && !empty($val["title"])) {
                    $this->headerData["secondRowFields"][$val["field"]] = $val["title"];
                    $this->headerData["secondRowHeader"][] = $val["title"];
                } else {
                    throw_strack_exception(L("Excel_Header_Null"), 234001);
                }
            }
        }
        $this->headerData["firstRowHeaderPosition"] = [];
        $this->headerData["firstStepFields"] = [];
    }


    /**
     * 格式化复杂表头（目前系统特指Entity 表格数据）
     * @param $header
     */
    public function formatComplexHeader($header)
    {
        $firstHeader = [];
        $secondRowFields = [];
        list($firstHeaderRowData, $secondHeaderRowData) = $header;
        //统计表头数据,建立空数据
        $firstData = array_fill(0, count($secondHeaderRowData), "");
        $firstCellLocation = [];
        $stepFields = [];
        //一级表头
        foreach ($firstHeaderRowData as $value) {
            if (array_key_exists("fname", $value) && !empty($value["fname"]) && array_key_exists("title", $value) && !empty($value["title"])) {
                $fieldList = explode(',', $value['field_list']);
                array_unshift($fieldList, $value['first_field']);
                $fname = $value["fname"];
                $fieldListAssemblePrefix = array_map(function ($v) use ($fname) {
                    return $fname . '_' . $v;
                }, $fieldList);
                $value["field_list"] = $fieldListAssemblePrefix;
                $firstHeader[$fname] = $value;
                //获取工序字段
                $stepFields = array_merge($stepFields, $fieldListAssemblePrefix);
            }
        }
        $secondRowHeader = [];
        //工序字段和第二行字段有交集
        foreach ($secondHeaderRowData as $secondaryHeaderKey => $secondaryHeaderVal) {
            $secondField = $secondaryHeaderVal["field"];
            $secondTitle = $secondaryHeaderVal["title"];
            $secondRowFields[$secondField] = $secondTitle;
            $secondRowHeader[] = $secondTitle;
            foreach ($firstHeader as $value) {
                if (in_array($secondField, $value["field_list"])) {
                    $field = $value["fname"];
                    $firstOrderHeaderPosition[$field][] = $secondaryHeaderKey;
                    $firstCellLocation[$field] = [
                        "min" => min($firstOrderHeaderPosition[$field]),
                        "max" => max($firstOrderHeaderPosition[$field])
                    ];
                    $firstData[$firstCellLocation[$field]["min"]] = $field;
                    $firstData[$firstCellLocation[$field]["max"]] = $field;
                }
            }
        }

        $complexHeaderData =
            [
                //第一行表头
                "firstRowHeader" => $firstData,
                //第一行表头位置信息
                "firstRowHeaderPosition" => $firstCellLocation,
                //第一行表头的颜色,标题信息
                "firstRowData" => $firstHeader,
                //第一行字段
                "firstStepFields" => $stepFields,
                //第二行表头
                "secondRowHeader" => $secondRowHeader,
                //第二行表头字段
                "secondRowFields" => $secondRowFields
            ];
        $this->headerData = $complexHeaderData;
    }

    /**
     * 格式化单元格数据
     */
    public function formatBodyData()
    {
        if (empty($this->sheetData) || empty($this->headerData)) {
            throw_strack_exception("Input_Excel_Data_Require", 233002);
        }
        $secondFields = array_keys($this->headerData["secondRowFields"]);
        $firstStepFields = isset($this->headerData['firstStepFields']) ? $this->headerData['firstStepFields'] : [];
        $commonHeader = array_diff($secondFields, $firstStepFields);

        $baseData = [];
        $tableData = [];
        foreach ($this->sheetData as $gridDataKey => $gridDataVal) {
            $data = array_fill_keys($commonHeader, "");
            foreach ($gridDataVal as $k => $v) {
                //工序字段值
                $value = "";
                if (in_array($k, $firstStepFields)) {
                    $value = array_column(array_column($v, "fields"), "value");
                    array_walk($value, function (&$val) {
                        if (isset($val["rows"])) {
                            $val = implode(",", array_column($val["rows"], "name"));
                        }
                    });
                    $baseData[$gridDataKey][$k] = $value;
                } elseif (array_key_exists($k, $data)) {
                    if (is_array($v)) {
                        if (isset($v["rows"])) {
                            $value = implode(",", array_column($v["rows"], "name"));
                        }
                    } else {
                        $value = $v;
                    }
                    $data[$k] = $value;
                }
            }
            $tableData[$gridDataKey] = $data;
        }
        //数据返回
        $this->bodyData = ["table_data" => $tableData, "base_data" => $baseData];
    }

    /**
     * 生成表头
     */
    public function generateHeader()
    {
        if (empty($this->sheetData) || empty($this->headerData)) {
            throw_strack_exception("Input_Excel_Data_Require", 234002);
        }

        if (empty($this->headerData["firstRowHeader"])) {
            $header = [$this->headerData["secondRowHeader"]];
        } else {
            $header = array_merge([$this->headerData["firstRowHeader"]], [$this->headerData["secondRowHeader"]]);
        }
        $headerLineNumber = count($header);
        $headerCountSum = count($this->headerData["secondRowHeader"]);
        foreach ($header as $key => $item) {
            $index = 0;
            foreach ($item as $val) {
                $cellName = $this->getCellColumnNumber($index, $key + 1);
                $this->phpSpreadsheet->getActiveSheet()->setCellValue($cellName, ucfirst($val));
                //设置单元格颜色
                if (isset($this->headerData["firstRowData"][$val]["bgc"])) {
                    $bgc = $this->headerData["firstRowData"][$val]["bgc"];
                    $this->phpSpreadsheet->getActiveSheet()->getStyle($cellName)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($bgc);
                }
                $index++;
            }
        }
        //合并单元格
        foreach ($this->headerData["firstRowHeaderPosition"] as $val) {
            $initialValue = $this->getCellColumnNumber($val['min'], 1);
            $endValue = $this->getCellColumnNumber($val['max'], 1);
            $this->phpSpreadsheet->getActiveSheet()->mergeCells("$initialValue:$endValue");
        }
        //设置表头样式
        $styleTitle = $this->setHeaderStyle();

        for ($x = 0; $x < $headerLineNumber; $x++) {
            $row = $x + 1;
            //设置行高
            $this->phpSpreadsheet->getActiveSheet()->getRowDimension($row)->setRowHeight(30);
            //当前行
            $currentRow = "A" . $row;
            //设置样式
            $styleRow = $currentRow . ':' . $this->getCellColumnNumber($headerCountSum, $row);
            $this->phpSpreadsheet->getActiveSheet()->getStyle($styleRow)->applyFromArray($styleTitle);
        }
        //锁定行（行以上的)
        $lockRow = "A" . ($headerLineNumber + 1);
        $this->phpSpreadsheet->getActiveSheet()->freezePane($lockRow);
    }

    /**
     * 生成表
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function generateBody()
    {
        if (empty($this->bodyData) || empty($this->headerData)) {
            throw_strack_exception("Input_Excel_Data_Require", 234002);
        }
        $secondRowFieldsKeyList = array_keys($this->headerData["secondRowFields"]);
        //获取缩略图位置
        $thumbData = [];

        foreach ($secondRowFieldsKeyList as $key => $value) {
            if (strstr($value, "media_thumb")) {
                if (in_array($value, $this->headerData["firstStepFields"])) {
                    $thumbLocationList = array_column($this->bodyData["base_data"], $value);
                } else {
                    $thumbLocationList = array_column($this->bodyData["table_data"], $value);
                }
                $thumbData[$value] = $thumbLocationList;
            }
        }
        $this->downloadImage($thumbData);
        $secondRowFieldsKeyList = array_keys($this->headerData["secondRowFields"]);
        $secondRowFieldsKeyLocalList = array_flip($secondRowFieldsKeyList);
        //数据放置索引
        $dataIndex = array_fill_keys($secondRowFieldsKeyList, empty($this->headerData["firstRowHeader"]) ? 2 : 3);
        $stepCount = [];
        //写入工序信息
        foreach ($this->bodyData["base_data"] as $key => $item) {
            foreach ($item as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $this->phpSpreadsheet->getActiveSheet()->getRowDimension($dataIndex[$k])->setRowHeight($this->height);
                    $initialValue = $this->getCellColumnNumber($secondRowFieldsKeyLocalList[$k], $dataIndex[$k]++);
                    if (array_key_exists($k, $thumbData)) {
                        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                        $drawing->setOffsetY(0);
                        $drawing->setOffsetX(2);
                        $drawing->setCoordinates($initialValue);
                        $drawing->setPath($thumbData[$k][$key][$kk]);
                        $drawing->setWorksheet($this->phpSpreadsheet->getActiveSheet());
                    } else {
                        $this->phpSpreadsheet->getActiveSheet()->setCellValue($initialValue, $vv);
                    }
                }
                $stepCount[$key][$k] = count($v);
            }
        }
        //写入表格信息(合并单元格)
        foreach ($this->bodyData["table_data"] as $key => $item) {
            foreach ($item as $kk => $vv) {
                $count = (isset($stepCount[$key]) ? max($stepCount[$key]) : 1) - 1;
                $initialValue = $this->getCellColumnNumber($secondRowFieldsKeyLocalList[$kk], $dataIndex[$kk]);
                $endValue = $this->getCellColumnNumber($secondRowFieldsKeyLocalList[$kk], $dataIndex[$kk] + $count);
                $this->phpSpreadsheet->getActiveSheet()->getRowDimension($dataIndex[$kk])->setRowHeight($this->height);
                //写入图片
                if (array_key_exists($kk, $thumbData)) {
                    $yOffset = $count == 1 ? -20 : 2;
                    $imageCell = $this->getCellColumnNumber($secondRowFieldsKeyLocalList[$kk], $dataIndex[$kk] + (round($count / 2)));
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setOffsetY($yOffset);
                    $drawing->setOffsetX(2);
                    $drawing->setCoordinates($imageCell);
                    $drawing->setPath($thumbData[$kk][$key], true);
                    $drawing->setWorksheet($this->phpSpreadsheet->getActiveSheet());
                } else {
                    $this->phpSpreadsheet->getActiveSheet()->setCellValue($initialValue, $vv);
                }
                $this->phpSpreadsheet->getActiveSheet()->mergeCells("$initialValue:$endValue");
                $dataIndex[$kk] = $dataIndex[$kk] + $count;
                $dataIndex[$kk]++;
            }
        }

        //设置内容单元格统一样式
        $contentStyle = $this->setContentStyle();
        reset($this->sheetData);
        $firstKey = key($this->sheetData);
        $lastKey = count($this->headerData["secondRowHeader"]);
        $count = max($dataIndex) - 1;

        $positionCell = "{$this->getCellColumnNumber($firstKey, 1)}:{$this->getCellColumnNumber($lastKey, $count)}";
        //设置换行
        $this->phpSpreadsheet->getActiveSheet()->getStyle($positionCell)->getAlignment()->setWrapText(true);
        //设置字体样式
        $this->phpSpreadsheet->getActiveSheet()->getStyle($positionCell)->applyFromArray($contentStyle);
        //设置边框样式
        foreach ($this->headerData["firstRowHeaderPosition"] as $key => $value) {
            $positionCell = "{$this->getCellColumnNumber($value['min'], 1)}:{$this->getCellColumnNumber($value['max'], $count)}";
            $this->phpSpreadsheet->getActiveSheet()->getStyle($positionCell)->applyFromArray($this->setBorderStyle($this->headerData["firstRowData"][$key]["bgc"]));
        }

    }

    /**
     * 下载Excel图片
     * @param $data
     * @param int $width
     * @param int $height
     * @throws \Exception
     */
    private function downloadImage(&$data, $width = 140, $height = 55)
    {
        //默认图像
        $defaultPicture = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . "/Public/images/excel/excel_tasks.png";
        //保存图片目录
        $tempExcelPath = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . '/Uploads/temp/excel/download/images/';
        $tempDirectoryName = $tempExcelPath . 'excel_image_temp/';
        create_directory($tempDirectoryName);
        $image = new Image();
        array_walk_recursive($data, function (&$value) use ($image, $defaultPicture, $tempDirectoryName, $width, $height) {
            $tempName = string_random(8) . time();
            $fileName = $tempName . '.jpg';
            $fileLocation = $tempDirectoryName . $fileName;
            $download = download_remote_picture($value, $fileLocation, 1000);
            if (!$download) {
                copy($defaultPicture, $fileLocation);
            }
            //裁剪图片
            $image->open($fileLocation);
            $image->thumb($width, $height, Image::IMAGE_THUMB_FILLED);
            $image->save($fileLocation, 'jpg', 100);
            $value = $fileLocation;
        });


    }

    /**
     * 保存文件返回路径
     * @param $name
     * @param $filePath
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function save($name, $filePath)
    {
        if (empty($this->sheetData) || empty($this->bodyData)) {
            throw_strack_exception(L("Input_Excel_Data_Require"), 234002);
        }
        $exBasename = $name . '_' . string_random(8) . time();
        $fileName = $exBasename . '.xlsx';
        //设置sheet的名称
        $this->phpSpreadsheet->getActiveSheet()->setTitle($name);
        //创建Excel
        $objWriter = IOFactory::createWriter($this->phpSpreadsheet, 'Xlsx');
        //创建目录
        create_directory($filePath);
        $savePath = $filePath . "/" . $fileName;
        //保存文件
        $objWriter->save($savePath);
        //释放内存
        $this->phpSpreadsheet->disconnectWorksheets();
        unset($this->phpSpreadsheet);
        return $savePath;
    }
}