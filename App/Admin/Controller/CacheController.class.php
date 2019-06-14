<?php

namespace Admin\Controller;

// +----------------------------------------------------------------------
// | 后台缓存数据控制层
// +----------------------------------------------------------------------

class CacheController extends AdminController
{
    /**
     * 项目根目录
     * @return string
     */
    protected function getBasePath()
    {
        return $_SERVER['DOCUMENT_ROOT'] . __ROOT__;
    }

    /**
     * 格式化磁盘文件大小
     * @param $bytes
     * @return string
     */
    protected function formatDiskSize($bytes)
    {
        $si_prefix = array('B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB');
        $base = 1024;
        $class = min((int)log($bytes, $base), count($si_prefix) - 1);
        return sprintf('%1.2f', $bytes / pow($base, $class)) . ' ' . $si_prefix[$class];
    }


    /**
     * 获取磁盘信息
     * @return array
     */
    protected function getDiskInfo()
    {
        $diskTotalSpace = disk_total_space("/");
        $diskFreeSpace = disk_free_space("/");
        $diskUsedPercent = sprintf('%0.2f', (($diskTotalSpace - $diskFreeSpace) / $diskTotalSpace) * 100);
        $diskTotalSpaceSize = $this->formatDiskSize($diskTotalSpace);
        $diskFreeSpaceSize = $this->formatDiskSize($diskFreeSpace);
        return [
            'total' => $diskTotalSpaceSize,
            'free' => $diskFreeSpaceSize,
            'percent' => $diskUsedPercent,
        ];
    }

    /**
     * 获取系统缓存大小
     * @return string
     */
    protected function getSystemCacheSize()
    {
        $basePath = $this->getBasePath();
        $cachePath = "{$basePath}/Runtime/Cache/";
        create_directory($cachePath);
        return $this->formatDiskSize(get_directory_size($cachePath));
    }

    /**
     * 获取系统日志大小
     * @return string
     */
    protected function getSystemLogsSize()
    {
        $basePath = $this->getBasePath();
        $logsPath = "{$basePath}/Runtime/Logs/";
        create_directory($logsPath);
        return $this->formatDiskSize(get_directory_size($logsPath));
    }

    /**
     * 获取上传临时文件大小
     * @return string
     */
    protected function getUploadTempSize()
    {
        $basePath = $this->getBasePath();
        $logsPath = "{$basePath}/Uploads/temp/";
        create_directory($logsPath);
        return $this->formatDiskSize(get_directory_size($logsPath));
    }


    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 磁盘缓存大小统计
     */
    public function getCacheStatistics()
    {

        // 磁盘总大小和磁盘剩余大小
        $diskInfo = $this->getDiskInfo();

        // 系统缓存文件大小
        $systemCacheSize = $this->getSystemCacheSize();

        // 系统日志文件大小
        $systemLogsSize = $this->getSystemLogsSize();

        // 上传临时文件大小
        $uploadTempSize = $this->getUploadTempSize();

        // 返回数据
        $resData = [
            'disk_info' => $diskInfo,
            'system_cache' => $systemCacheSize,
            'system_log' => $systemLogsSize,
            'upload_temp' => $uploadTempSize
        ];

        return json($resData);
    }

    /**
     * 清空系统缓存文件夹
     * @return array
     */
    public function clearSystemCache()
    {
        $basePath = $this->getBasePath();
        delete_directory("{$basePath}/Runtime/Cache/");
        return json(success_response(L("Clear_System_Cache_SC")));
    }

    /**
     * 清空日志文件内容
     * @return array
     */
    public function clearSystemLogsCache()
    {
        $basePath = $this->getBasePath();
        delete_directory("{$basePath}/Runtime/Logs/");
        return json(success_response(L("Clear_System_Log_SC")));
    }

    /**
     * 清空系统缓存文件夹
     * @return array
     */
    public function clearUploadsTempCache()
    {
        $basePath = $this->getBasePath();
        // 清空 excel 临时文件
        delete_directory("{$basePath}/Uploads/temp/excel/");
        return json(success_response(L("Clear_Upload_Cache_SC")));
    }
}