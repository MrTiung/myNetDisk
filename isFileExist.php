<?php
/**
 * Created by PhpStorm.
 * User: zsx
 * Date: 2018/2/25
 * Time: 21:28
 */
header("Content-type:text/json");
require_once 'UploadService.php';
$uploadService=new UploadService();
$uploadService->isFileExist();