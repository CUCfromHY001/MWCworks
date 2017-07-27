<?php

    session_start();
    $vstring = $_SESSION["vstring"];
    $vcode = $_POST["Number"];

    //$password = $_GET["password"];
    // echo "$username";
    // echo "$password";
    // echo "$vcode";

    if ($vcode==$vstring) {
        echo "验证码正确！";
        //js重定向
        echo "<script>location='https://xiaozhaoyun.com/reset3.html'</script>";
    }else{
        echo "验证码错误！";
        //echo "<script>location='reg.html'</script>";
    }

?>
