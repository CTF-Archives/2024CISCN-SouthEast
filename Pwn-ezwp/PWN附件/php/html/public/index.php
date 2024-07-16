<?php
error_reporting(0);
highlight_file(__FILE__);
if(isset($_POST['code'])){
	if(preg_match('/[a-z,A-Z,0-9<>\?]/', $_POST['code']) === 0){
		eval($_POST['code']);
	}else{
		die();
	}
}else{
	phpinfo();
}
?>

