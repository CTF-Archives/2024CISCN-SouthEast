<?php
// $path = "./uploads";
error_reporting(0);
$path = "./uploads";
$content = file_get_contents($_FILES['myfile']['tmp_name']);
$x=explode('.',$_FILES['myfile']['name']);
if($x[sizeof($x)-1]!='png'){
    die("只允许png哦!<br>");
}
$allow_content_type = array("image/png");
$type = $_FILES["myfile"]["type"];
if (!in_array($type, $allow_content_type)) {
    die("只允许png哦!<br>");
}

if (preg_match('/(<\?|php|script|xml|user|htaccess)/i', $content)) {
    // echo "匹配成功!";
    die('鼠鼠说你的内容不符合哦0-0');
} else {
    $file = $path . '/' . $_FILES['myfile']['name'];
echo $file;

if (move_uploaded_file($_FILES['myfile']['tmp_name'], $file)) {
        file_put_contents($file, $content);
        echo 'Success!<br>';
} else {
        echo 'Error!<br>';
}
}
?>

    

<!---->



