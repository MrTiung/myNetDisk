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
$uploadService->upload();
$message=new MessageWrapper();
$message->err="";
$message->errno="0";
echo json_encode($message);