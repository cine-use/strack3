<div id="ex_fields_menu_wrap">
    <input id="excel_fields_val" type="hidden" autocomplete="off"/>
    <div id="excel_fields_menu" style="width:120px;display: none;">
        <div data-options="iconCls:'icon-edit'" data-bnt="cancel_mapping">{$Think.lang.Cancel_Mapping}</div>
        <div id="import_ex_must_wrap" class="import-ex-field">
            <span class="required">{$Think.lang.Import_Excel_Must_Field}</span>
            <div id="import_ex_must" style="width:150px;">
                <!--必须字段-->
            </div>
        </div>
        <div id="import_ex_other_wrap" class="import-ex-field">
            <span>{$Think.lang.Import_Excel_Other_Field}</span>
            <div id="import_ex_other" style="width:150px;">
                <!--其他字段-->
            </div>
        </div>
    </div>
</div>

<div class="import-excel-header">
    <div class="import-excel-title">
        {$Think.lang.Import_Excel}
    </div>
    <div class="import-excel-close">
        <a href="javascript:;" onclick="Strack.close_import_excel(this)">
            <i class="icon-uniE6DF"></i>
        </a>
    </div>
</div>
<div id="import_excel_step" class="import-excel-main step-body">

    <div class="excel-step-h">
        <div class="step-header">
            <ul>
                <li>
                    <span class="step-name">{$Think.lang.Select_Method}</span>
                </li>
                <li>
                    <span class="step-name">{$Think.lang.Import_Data}</span>
                </li>
                <li>
                    <span class="step-name">{$Think.lang.Mapping_Field}</span>
                </li>
                <li>
                    <span class="step-name">{$Think.lang.Import_Result}</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="project-step-content">
        <div id="import_ex_list" class="step-content-wrap step-content">
            <div class="step-list step-full-wrap">
                <!--选择excel导入方式-->
                <div class="ui two column grid select-excel-method">
                    <div class="column">
                        <a href="javascript:;"  class="import-excel-card" onclick="Strack.select_import_excel_method(this)" data-method="paste">
                            <div class="excel-card-title">
                                <div class="main">
                                    {$Think.lang.Paste_Data}
                                </div>
                                <div class="description">
                                    {$Think.lang.Paste_Excel_Content}
                                </div>
                            </div>
                            <div class="excel-card-img">
                                <img src="__COM_IMG__/excel_csv.png">
                            </div>
                        </a>
                    </div>
                    <div class="column">
                        <a href="javascript:;"  class="import-excel-card" onclick="Strack.select_import_excel_method(this)" data-method="file">
                            <div class="excel-card-title">
                                <div class="main">
                                    {$Think.lang.Upload_File}
                                </div>
                                <div class="description">
                                    {$Think.lang.Import_Excel_File}
                                </div>
                            </div>
                            <div class="excel-card-img">
                                <img src="__COM_IMG__/excel_file.png">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="step-list step-full-wrap">
                <!--格式化excel数据-->
                <div class="import-method-wrap">
                    <div id="excel_format_paste" class="import-method-panel import-method-paste" style="display: none">
                        <div class="import-method-title">
                            <i class="icon-uniEA30 icon-left" style="color:#faad14"></i>
                            {$Think.lang.Paste_Excel_Notice}
                        </div>
                        <div class="import-method-swicth">
                            {$Think.lang.Exist_Header}：<input id="method_paste_header" name="method_paste_header" autocomplete="off"/>
                        </div>
                        <textarea id="import_method_paste" class="form-control-excel form-input" autocomplete="off" placeholder="文本框"></textarea>
                    </div>
                    <div id="excel_format_file" class="import-method-panel import-method-file" style="display: none">
                        <div class="import-method-title">
                            <i class="icon-uniEA30 icon-left" style="color:#faad14"></i>
                            {$Think.lang.Upload_Excel_Notice}
                        </div>
                        <div class="import-method-swicth">
                            {$Think.lang.Exist_Header}：<input id="method_file_header" name="method_file_header" autocomplete="off"/>
                        </div>
                        <div id="import_method_queue" class="excel-file-queue"></div>
                    </div>
                </div>
            </div>
            <div id="mapping_fields" class="step-list" style="width: 100%;height: 100%;">
                <!--映射字段-->
                <div class="mapping-fields-wrap">
                    <table id="import_excel_datagrid"></table>
                </div>
            </div>
            <div class="step-list step-full-wrap">
                <!--导入结果-->
                <div id="excel_in_error" class="excel-in-submit">
                    <div class="ex-sub-notice" style="background: #EC364B;">
                        错误码: <span class="error-code"></span>
                    </div>
                    <div class="ex-sub-index">
                        错误行: <span class="error-line"></span>
                    </div>
                    <div class="ex-error-field">
                        错误信息: <span class="error-msg"></span>
                    </div>
                </div>
                <div id="excel_in_success" class="excel-in-submit">
                    <div class="ex-sub-notice" style="background: #13ce66;">
                        导入Excel成功。
                    </div>
                    <div class="ex-sub-index">
                        导入行数: <span class="success-number"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="project-step-bnt">
        <div class="step-bnt-footer">
            <div id="import_excel_bnt_upload" class="aign-left" style="display: none">
                <input id="excel_upload_widget" type="file">
            </div>
            <a id="import_excel_bnt_prev" href="javascript:;" class="st-dialog-button st-button-base button-dgsub" onclick="Strack.import_excel_step_prev();" style="display: none">{$Think.lang.Previous}</a>
            <a id="import_excel_bnt_next" href="javascript:;" class="st-dialog-button st-button-base button-dgsub" onclick="Strack.import_excel_step_next();">{$Think.lang.Next}</a>
            <a id="import_excel_bnt_submit" href="javascript:;" class="st-dialog-button st-button-base button-dgsub" onclick="Strack.close_import_excel_panel();" style="display: none">{$Think.lang.Done}</a>
        </div>
    </div>
</div>