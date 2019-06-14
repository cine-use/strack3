<?php


use Phinx\Migration\AbstractMigration;

class CreateOnsetTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('strack_onset', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '现场数据ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '现场数据名称'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '现场数据编码'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目ID'])
            ->addColumn('status_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '状态ID'])
            ->addColumn('clip_name', 'string', ['default' => '', 'limit' => 255, 'comment' => '素材名称'])
            ->addColumn('duration', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '素材时间（sec）'])
            ->addColumn('frames', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '素材帧数'])
            ->addColumn('source_file_date', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '源素材创建时间'])
            ->addColumn('registration_date', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '源素材录入时间'])
            ->addColumn('tc_in_point', 'string', ['default' => '', 'limit' => 64, 'comment' => '入点时间码'])
            ->addColumn('tc_out_point', 'string', ['default' => '', 'limit' => 64, 'comment' => '出点时间码'])
            ->addColumn('in_out_duration', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '出点帧数'])
            ->addColumn('audio_tc_offsets', 'string', ['default' => '', 'limit' => 255, 'comment' => '音频时间码偏移'])
            ->addColumn('tc_start', 'string', ['default' => '', 'limit' => 128, 'comment' => '起始时间码'])
            ->addColumn('tc_end', 'string', ['default' => '', 'limit' => 128, 'comment' => '结束时间码'])
            ->addColumn('reel', 'string', ['default' => '', 'limit' => 128, 'comment' => '卷名'])
            ->addColumn('look_source', 'string', ['default' => '', 'limit' => 255, 'comment' => '源素材LUT'])
            ->addColumn('look_source_name', 'string', ['default' => '', 'limit' => 255, 'comment' => '源素材LUT名称'])
            ->addColumn('cdl_nodes', 'string', ['default' => '', 'limit' => 255, 'comment' => 'CDL节点'])
            ->addColumn('sat_nodes', 'string', ['default' => '', 'limit' => 255, 'comment' => 'LCT节点'])
            ->addColumn('lut_nodes', 'string', ['default' => '', 'limit' => 255, 'comment' => 'LUT节点'])
            ->addColumn('codec', 'string', ['default' => '', 'limit' => 255, 'comment' => '解码器'])
            ->addColumn('file_type', 'string', ['default' => '', 'limit' => 128, 'comment' => '文件类型'])
            ->addColumn('resolution', 'string', ['default' => '', 'limit' => 128, 'comment' => '分辨率'])
            ->addColumn('color_space', 'string', ['default' => '', 'limit' => 128, 'comment' => '色彩空间'])
            ->addColumn('iso', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '感光度'])
            ->addColumn('whitepoint', 'string', ['default' => '', 'limit' => 128, 'comment' => '白平衡点'])
            ->addColumn('tint', 'string', ['default' => '', 'limit' => 128, 'comment' => '色彩'])
            ->addColumn('f_shot', 'string', ['default' => '', 'limit' => 128, 'comment' => 'f_光圈'])
            ->addColumn('t_stop', 'string', ['default' => '', 'limit' => 128, 'comment' => 't_光圈'])
            ->addColumn('shutter', 'string', ['default' => '', 'limit' => 128, 'comment' => '快门'])
            ->addColumn('shutter_degree', 'string', ['default' => '', 'limit' => 128, 'comment' => '快门角度'])
            ->addColumn('lens', 'string', ['default' => '', 'limit' => 128, 'comment' => '镜头'])
            ->addColumn('filter', 'string', ['default' => '', 'limit' => 128, 'comment' => '过滤'])
            ->addColumn('recorder_model', 'string', ['default' => '', 'limit' => 128, 'comment' => '相机型号'])
            ->addColumn('serial_number', 'string', ['default' => '', 'limit' => 255, 'comment' => '相机序列号'])
            ->addColumn('episode', 'string', ['default' => '', 'limit' => 128, 'comment' => '集数'])
            ->addColumn('scene', 'string', ['default' => '', 'limit' => 128, 'comment' => '场次'])
            ->addColumn('shot', 'string', ['default' => '', 'limit' => 128, 'comment' => '镜头'])
            ->addColumn('take', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '条数'])
            ->addColumn('camera', 'string', ['default' => '', 'limit' => 128, 'comment' => '机位'])
            ->addColumn('shot_descriptors', 'string', ['default' => '', 'limit' => 255, 'comment' => '镜头描述语言'])
            ->addColumn('shootting_data', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '拍摄时间'])
            ->addColumn('director', 'string', ['default' => '', 'limit' => 128, 'comment' => '导演'])
            ->addColumn('production', 'string', ['default' => '', 'limit' => 128, 'comment' => '制片'])
            ->addColumn('producer', 'string', ['default' => '', 'limit' => 128, 'comment' => '制片人'])
            ->addColumn('cinematographer', 'string', ['default' => '', 'limit' => 128, 'comment' => '摄像师'])
            ->addColumn('camera_assistant', 'string', ['default' => '', 'limit' => 128, 'comment' => '摄像助理'])
            ->addColumn('dit', 'string', ['default' => '', 'limit' => 128, 'comment' => '数字影像工程师'])
            ->addColumn('data_manager', 'string', ['default' => '', 'limit' => 128, 'comment' => '数据管理员'])
            ->addColumn('script_supervisor', 'string', ['default' => '', 'limit' => 128, 'comment' => '场记'])
            ->addColumn('sound_mixer', 'string', ['default' => '', 'limit' => 128, 'comment' => '混音师'])
            ->addColumn('location', 'string', ['default' => '', 'limit' => 128, 'comment' => '拍摄地'])
            ->addColumn('file_size', 'string', ['default' => '', 'limit' => 128, 'comment' => '文件大小'])
            ->addColumn('md5', 'string', ['default' => '', 'limit' => 255, 'comment' => 'MD5'])
            ->addColumn('burn_ins', 'string', ['default' => '', 'limit' => 128, 'comment' => '烧录'])
            ->addColumn('source_audio_tc_offset', 'string', ['default' => '', 'limit' => 128, 'comment' => '源音频时间码偏移值'])
            ->addColumn('audio_tc_offset', 'string', ['default' => '', 'limit' => 128, 'comment' => '音频时间码偏移值'])
            ->addColumn('param', 'json', ['null' => true, 'comment' => '预留json字段（方便用户随意存储）'])
            ->addColumn('created_by', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建者'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);
//            ->addColumn('unit', 'string', ['default' => 'A', 'limit' => 255, 'comment' => '默认拍摄分组A-Z'])
//            ->addColumn('number', 'string', ['default' => '', 'limit' => 255, 'comment' => '机器编号'])
//            ->addColumn('wrangler', 'string', ['default' => '', 'limit' => 255, 'comment' => '场记姓名'])
//            ->addColumn('location', 'string', ['default' => '', 'limit' => 255, 'comment' => '拍摄地点'])
//            ->addColumn('take_date', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '记录时间'])
//            ->addColumn('int_ext', 'enum', ['values' => 'interior,exterior', 'default' => 'interior', 'comment' => '内景 /外景'])
//            ->addColumn('day_night', 'enum', ['values' => 'daytime,dusk,night,dawn', 'default' => 'daytime', 'comment' => '日戏/夜戏'])
//            ->addColumn('hdri', 'string', ['default' => '', 'limit' => 255, 'comment' => 'HDRI 文件夹存储地址'])
//            ->addColumn('ref_pic', 'string', ['default' => '', 'limit' => 255, 'comment' => '参考图片存储地址'])
//            ->addColumn('clip_number', 'string', ['default' => '', 'limit' => 128, 'comment' => '场号'])
//            ->addColumn('vfx_task', 'text', ['null' => true, 'comment' => '制作内容'])
//            ->addColumn('lens', 'string', ['default' => '', 'limit' => 128, 'comment' => '镜头'])
//            ->addColumn('focal_length', 'char', ['default' => '', 'limit' => 20, 'comment' => '焦距'])
//            ->addColumn('filter', 'char', ['default' => '', 'limit' => 20, 'comment' => '滤镜'])
//            ->addColumn('shutter', 'char', ['default' => '', 'limit' => 12, 'comment' => '快门'])
//            ->addColumn('stop', 'char', ['default' => '', 'limit' => 8, 'comment' => '光圈'])
//            ->addColumn('height', 'string', ['default' => '', 'limit' => 64, 'comment' => '机器高度'])
//            ->addColumn('tilt_angle', 'string', ['default' => '', 'limit' => 64, 'comment' => '机器角度'])
//            ->addColumn('distance', 'string', ['default' => '', 'limit' => 64, 'comment' => '机器运动距离'])
//            ->addColumn('resolution', 'char', ['default' => '', 'limit' => 16, 'comment' => '分辨率'])
//            ->addColumn('frame_rate', 'char', ['default' => '', 'limit' => 8, 'comment' => '帧速率'])
//            ->addColumn('white_balance', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '白平衡'])
//

        //执行创建
        $table->create();

        /**
         * # 注解
         * - **加粗表示必须信息**
         * - *斜体表示不确定数据*
         * - ~~划掉信息表示无需录入信息~~
         * - 标记\*表示sliverstack软件中可以修改的信息
         *
         * # 素材信息
         *
         * ### 源素材
         * 1. **name 素材名***
         * 1. **duration 素材时间(sec)**
         * 2. **frames   素材帧数**
         * 3. **source file date 源素材文件创建时间**
         * 4. **registration date 软件中数据录入时间**
         * 5. *ceation date 同录入时间*
         *
         * ### 编辑数据
         * 1. **tc in point 入点时间码***
         * 2. **tc out point 出点时间码***
         * 3. **in/out duration 出入点帧数**
         * 4. *sync slate tc 同步吗*
         * 5. ~~caption 说明~~
         * 6. **audio tc offsets 音频时间码偏移值**
         * 7. ~~custom 1、2、3 软件自定义设置*~~
         *
         * ### Timecode 时间码
         * 1. **fps of tc 素材fps**
         * 2. **tc start 源素材起始时间码***
         * 3. **tc end 源素材结束时间码**
         * 4. **reel/tape 卷名***
         * 5. ~~ext. audio tc start 外置音频起始时间码~~
         * 6. ~~ext. audio tc end 外置音频结束时间码~~
         * 7. ~~soundroll~~
         *
         * ### 处理参数
         * 1. **look source***
         * 2. **look source name 源素材LUT名称**
         * 3. ~~grading mode 分级模式~~
         * 4. **CDL nodes CDL 节点**
         * 5. **SAT nodes SAT 节点**
         * 6. **LUT nodes**
         * 7. ~~ACES version~~
         * 8. ~~anamorphic 文件失真*~~
         * 9. ~~crop *~~
         * 10. ~~flip *~~
         *
         * ### 格式信息
         * 1. **codec 解码器**
         * 2. **file type 文件类型**
         * 3. **resolution 分辨率**
         * 5. **color space 色彩空间**
         * 6. ~~audio codec 音频解码器~~
         * 7. ~~audio tracks 音轨数量~~
         * 8. ~~audio track names 音轨名~~
         *
         * # 相机信息
         *
         * ### 设置参数
         * 1. **asa/iso 感光度***
         * 2. **whitepoint 白平衡点***
         * 3. *tint 色彩**
         * 4. **f-shot 光圈（额定，根据理论计算出进光量）***
         * 5. **t-stop 光圈（实际，根据传感器实际接收进光量）***
         * 6. **shutter 快门**
         * 7. **shutter degree 快门度数**
         * 7. **sensor fps 传感器fps**
         * 8. *lens 镜头**
         * 9. **look name 软件中设置的LUT名称***
         * 10. *filter 过滤**
         * 11. *distance to object **
         * 12. ~~gps position *~~
         * 13. *camera orientation 相机方位**
         *
         * ### 硬件信息
         * 1. ~~manuacturer 制造商~~
         * 2. **model/recorder model 型号**
         * 3. ~~device/recorder id 设备id~~
         * 4. **serial number 序列号**
         * 5. ~~firmware version 固件版本~~
         * 6. ~~identifier 标识符(device id)~~
         *
         * # 场记信息
         *
         * ### slate info 场记数据
         * 1. **episode 集数***
         * 2. **scene 场次***
         * 3. **shot 镜头号***
         * 4. **take 条数***
         * 5. **camera 机位***
         * 6. **shot descriptors 镜头描述语言***
         * 7. **shootting data 拍摄时间***
         *
         * ### 生产信息
         * 1. **director 导演***
         * 2. **production 制片***
         * 3. **producer 制片人***
         * 4. **cinematographer 摄像师***
         * 5. **camera assistant 摄像助理***
         * 6. **2nd camera assistant 二号摄像助理***
         * 7. **DIT 数字影像工程师***
         * 8. **data manager 数据管理员***
         * 9. **script supervisor 场记***
         * 10. **sound mixer 混音师***
         * 11. **location 拍摄地***
         * 12. ~~copyright infomation 版权信息*~~
         *
         * ### 软件标记数据
         * 1. ~~rating 评分*~~
         * 2. ~~comment 描述 *~~
         * 3. ~~flag/circled *~~
         * 4. ~~lebel 标签 *~~
         * 5. ~~Cue Points (Frame | Type| Duration | Name) 提示点*~~
         * 6. **Resources 源路径**
         * 7. ~~backups 备份数~~
         * 8. ~~missing 丢失文件数~~
         * 9. ~~playable 可播放文件~~
         * 10. ~~bin name 工程名*~~
         * 11. ~~caption 标题*~~
         * 12. **file size 文件大小**
         * 13. **volumes 存储盘**
         *
         * # 其他问题
         * 14. **MD5**
         * 15. ~~SHA1~~
         * 16. ~~XXHash~~
         * 17. ~~XXHash64~~
         * 18. ~~XXHash64 BE~~
         * 19. ~~Play Status 工程中播放状态~~
         * 20. ~~public uuid~~
         * 21. ~~tape 和reel重复~~
         * 21. ~~wild track~~
         * 22. ~~external audio clips 外部音频剪辑~~
         * 23. ~~transcoded clips 转码剪辑~~
         * 24. ~~Smp since Midnight~~
         * 25. *video clip name of source 视频剪辑来源*
         * 26. *Source Audio Clip Names 源音频剪辑名称*
         * 27. **Burn-Ins 烧录**
         * 28. ~~Framelines~~
         * 29. **source audio tc offset源音频偏移**
         * 30. **audio tc offse 音频偏移**
         * 30. *source soundroll 和 soundroll*
         * 31. *scrop*
         */
    }
}
