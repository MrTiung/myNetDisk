<?php
/**
 * Created by PhpStorm.
 * User: zsx
 * Date: 2018/2/23
 * Time: 9:10
 */

class UploadDao
{
    /**
     * @var PDO $conn
     *
     */
    var $conn;
    public function __construct()
    {
        $host="localhost";
        $user="root";
        $password="root";
        $dbname="upload";
        $port="3306";
        $this->conn=new PDO("mysql:host=$host;dbname=$dbname;port=$port",$user,$password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION );
    }
    public function query(string $sqlCommand){
        $this->conn->query($sqlCommand);
    }

    public function getFilepathById(string $md5){
        $stmt=$this->conn->prepare("select * from filepath WHERE id=:md5");
        $stmt->bindParam(":md5",$md5);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function saveFilePath(UploadFile $file){
        //save filePath
        $stmt=$this->conn->prepare("INSERT INTO filepath (id, path) VALUES (:md5,:path)");
        $stmt->bindParam(":md5",$file->md5);
        $stmt->bindParam(":path",$file->path);
        $stmt->execute();
    }

    public function saveFile(UploadFile $file){
        //save filePath
        $stmt=$this->conn->prepare("INSERT INTO file(filename,fileType,fileSize,md5,virtualPath) VALUES(:filename,:fileType,:fileSize,:md5,:virtualPath)");
        $stmt->bindParam(":filename",$file->name);
        $stmt->bindParam(":fileType",$file->type);
        $stmt->bindParam(":fileSize",$file->size);
        $stmt->bindParam(":md5",$file->md5);
        $stmt->bindParam(":virtualPath",$file->virtualPath);
        $stmt->execute();
    }

    public function getFileByVirtualPath(string $path){
        //save filePath
        $stmt=$this->conn->prepare("select * from file WHERE virtualPath=:path");
        $stmt->bindParam(":path",$path);
        $stmt->execute();
        return $stmt->fetch();
    }
}