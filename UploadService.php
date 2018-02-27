<?php
/**
 * Created by PhpStorm.
 * User: zsx
 * Date: 2018/2/23
 * Time: 8:39
 */

require_once "UploadFile.php";
require_once "UploadDao.php";
require_once "MessageWrapper.php";

class UploadService
{
    var $dao;
    var $uploadDir;

    public function __construct()
    {
        $this->uploadDir="d:/php/upload/";
        $this->dao=new UploadDao();
    }
//upload about
    function upload(){
        $filesArray=$_FILES["uploadFiles"];
        $files=$this->fromFileArrayToFiles($filesArray);
        foreach ($files as $file){
            $this->uploadSingleFile($file);
        }
    }

    function uploadSingleFile(UploadFile $uploadFile){
        if ($uploadFile->error > 0)
        {
            echo "Error: " . $uploadFile->error . "<br />";
        }
        else
        {
            $this->saveFile($uploadFile);
        }
    }



    private function saveFile(UploadFile $uploadFile){
        try{
            $this->addDataToUploadFile($uploadFile);
            $localFile=$this->dao->getFilepathById($uploadFile->md5);
            if ($localFile==null){
                $this->transFile($uploadFile);
                $this->dao->saveFilePath($uploadFile);
            }
            $this->dao->saveFile($uploadFile);
        }catch (PDOException $e){
            $message=new MessageWrapper();
            $message->err=$e->getMessage();
            $message->errno=$e->getCode();
            if ($message->errno==23000){
                $message->err="文件已存在";
            }
            die(json_encode($message));
        }
    }

    private function addDataToUploadFile(UploadFile $uploadFile){
        $md5=md5_file($uploadFile->tmp_name);
        $uploadFile->md5=$md5;
        $uploadFile->virtualPath=$uploadFile->name;
    }

    private function fromFileArrayToFiles($fileArray){

        foreach ($fileArray["name"]as $num=>$name){
            $file=new UploadFile();
            $file->name=$name;
            $file->tmp_name=$fileArray["tmp_name"][$num];
            $file->error=$fileArray["error"][$num];
            $file->type=$fileArray["type"][$num];
            $file->size=$fileArray["size"][$num];
            $files[$num]=$file;
        }
        return $files;
    }

    function transFile(UploadFile $uploadFile){
        if(!is_dir($this->uploadDir)){
            mkdir($this->uploadDir,0777,true);
        }
        $tmp_name=$uploadFile->tmp_name;
        $name=time().$uploadFile->name;
        $dest=$this->uploadDir.$name;
        move_uploaded_file($tmp_name,$dest);
        $uploadFile->path=$dest;
    }
//verify about
    function verify(){
        foreach ($_POST as $key=>$value){
            $localFile=$this->dao->getFilepathById($value);
            if($localFile==null){
                $newFiles[$key]=1;
            }else{
                $newFiles[$key]=0;
            }
        }
        echo json_encode($newFiles);

    }

//is file exist
    function isFileExist(){
        foreach ($_POST as $key=>$value){
            $localFile=$this->dao->getFileByVirtualPath($value);
            if($localFile==null){
                $fileExist[$value]=0;
            }else{
                $fileExist[$value]=1;
            }
        }
        echo json_encode($fileExist);
    }
}