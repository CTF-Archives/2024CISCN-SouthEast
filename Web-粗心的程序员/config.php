<?php
$db_host = '127.0.0.1';
$db_name = 'ctf';
$db_user = 'root';
$db_pwd = 'root';
$dsn = "mysql:host=$db_host;dbname=$db_name";
$pdo = new PDO($dsn,$db_user,$db_pwd);
