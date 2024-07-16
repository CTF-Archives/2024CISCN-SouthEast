<?php
include "default_info_auto_recovery.php";
include "config.php";
error_reporting(0);
session_start();
$type = $_POST['type'];
function Check($username,$passwd){
    if ((strlen($username) <5 || strlen($passwd) < 5) || (strlen($username) >10 || strlen($passwd) >10)){
        return "用户名和密码长度必须大于等于5或者小于等于10!";
    }
    else{
        return "ok";
    }
}

if (!$type){
    die("ERROR");
}
if ($type == "l"){
    $username = base64_encode($_POST['username']);
    $passwd = base64_encode($_POST['passwd']);
    $sql = "SELECT * FROM user WHERE username = ? and passwd = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1,$username);
    $stmt->bindValue(2,$passwd);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)){
        echo "<script>alert('账户名或密码错误');location.href='index.php';</script>";
        die();
    }else{
        $_SESSION['username'] = base64_decode($result[0]['username']);
        $_SESSION['id'] = $result[0]['id'];
        echo "<script>alert('登陆成功!');location.href='home.php';</script>";
        die();
    }
}
elseif ($type == "r")
{
    $username = $_POST['username'];
    $passwd = $_POST['passwd'];
    $passwd2 = $_POST['passwd2'];
    if ($passwd != $passwd2)
    {
        echo "<script>alert('两次密码输入不相同!');location.href='index.php';</script>";
        die();
    }
    $info = Check($username,$passwd);
    if ($info != "ok"){
        echo "<script>alert('$info');location.href='index.php';</script>";
        die();
    }
    $username = base64_encode($username);
    $passwd = base64_encode($passwd);
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1,$username);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $cont = count($result);
    if ($cont){
        echo "<script>alert('该用户已存在');location.href='index.php';</script>";
        die();
    }
    $sql = "INSERT INTO user (username,passwd) VALUES (?,?)";
    $stmt2 = $pdo->prepare($sql);
    $stmt2->bindValue(1,htmlspecialchars($username,ENT_QUOTES));
    $stmt2->bindValue(2,htmlspecialchars($passwd,ENT_QUOTES));
    $status = $stmt2->execute();
    if ($status){
        echo "<script>alert('注册成功!');location.href='index.php';</script>";
        die();
    }
}
else{
    die("ERROR");
}
?>