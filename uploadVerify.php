<?php
/**
 * Created by PhpStorm.
 * User: zsx
 * Date: 2018/2/22
 * Time: 16:22
 */
header("Content-type:text/json");
require_once 'UploadService.php';
$uploadService=new UploadService();
$uploadService->verify();