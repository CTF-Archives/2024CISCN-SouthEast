<?php
error_reporting(0);
include "default_info_auto_recovery.php";
session_start();
$p = $_SERVER["HTTP_X_FORWARDED_FOR"]?:$_SERVER["REMOTE_ADDR"];
if (preg_match("/\?|php|:/i",$p))
{
    die("");
}
$time = date('Y-m-d h:i:s', time());
$username = $_SESSION['username'];
$id = $_SESSION['id'];
if ($username && $id){
    echo "Hello,"."$username";
    $str = "//登陆时间$time,$username $p";
    $str = str_replace("\n","",$str);
    file_put_contents("config.php",file_get_contents("config.php").$str);
}else{
    die("NO ACCESS");
}
?>
<br>
<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="js/jquery.base64.js"></script>
<script>
    function submitData(){
        var obj = new Object();
        obj.name = $('#newusername').val();
        var str = $.base64.encode(JSON.stringify(obj.name).replace("\"","").replace("\"",""));
        $.post("edit.php",
            {
                newusername: str
            },
            function(str){
                alert(str);
                location.reload()
            });
    }

    jQuery.base64 = (function($) {

        var keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

        function utf8Encode(string) {
            string = string.replace(/\r\n/g,"\n");
            var utftext = "";
            for (var n = 0; n < string.length; n++) {
                var c = string.charCodeAt(n);
                if (c < 128) {
                    utftext += String.fromCharCode(c);
                }
                else if((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
                else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
            }
            return utftext;
        }

        function encode(input) {
            var output = "";
            var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
            var i = 0;
            input = utf8Encode(input);
            while (i < input.length) {
                chr1 = input.charCodeAt(i++);
                chr2 = input.charCodeAt(i++);
                chr3 = input.charCodeAt(i++);
                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                enc4 = chr3 & 63;
                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                } else if (isNaN(chr3)) {
                    enc4 = 64;
                }
                output = output +
                    keyStr.charAt(enc1) + keyStr.charAt(enc2) +
                    keyStr.charAt(enc3) + keyStr.charAt(enc4);
            }
            return output;
        }

        return {
            encode: function (str) {
                return encode(str);
            }
        };

    }(jQuery));

</script>
更改用户名<input type="text" name="newusername" id="newusername" value="">
<button type="submit" onclick="submitData()" >更改</button>
