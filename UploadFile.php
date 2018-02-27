<?php
/**
 * Created by PhpStorm.
 * User: zsx
 * Date: 2018/2/23
 * Time: 10:29
 */

class UploadFile
{
    /**
     * @var string $name
     * @var string $tmp_name
     * @var int $error
     * @var string $type
     * @var int $size
     */
    var $name;
    var $tmp_name;
    var $error;
    var $type;
    var $size;
    var $md5;
    var $path;
    var $virtualPath;
}