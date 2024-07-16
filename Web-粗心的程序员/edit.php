<?php
include "default_info_auto_recovery.php";
include "config.php";
error_reporting(0);
session_start();
function CheckNewUser($username){
    if (strlen($username) <5 || strlen($username) > 20){
        return "新用户名长度必须大于等于5或者小于等于10!";
    }
    else{
        return "ok";
    }
}
$id = $_SESSION['id'];
if (!$id){
    die("NO ACCESS!");
}
$newusername = $_POST['newusername'];
$info = CheckNewUser(base64_decode($newusername));
if ($info != "ok"){
    echo $info;
    die();
}
$sql = "SELECT * FROM user WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(1,$newusername);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$cont = count($result);
if ($cont){
    echo "该用户已存在!";
    die();
}
$sql = "UPDATE user SET username= ? where id=?";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(1,htmlspecialchars($newusername,ENT_QUOTES));
$stmt->bindValue(2,htmlspecialchars($id,ENT_QUOTES));
$status = $stmt->execute();
if ($status){
    $_SESSION['username'] = base64_decode($newusername);
    echo "修改成功!";
}else{
    echo "修改失败!";
}
