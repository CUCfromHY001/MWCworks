<?php
header("Content-Type: text/html;charset=utf-8");
/* Connect to a MySQL server  连接数据库服务器*/
$fromurl="https://xiaozhaoyun.com"; //跳转往这个地址。
if( $_SERVER['HTTP_REFERER'] == "" )
{
header("Location:".$fromurl);
exit;
}

$link = mysqli_connect(
    'localhost',  /* The host to connect to 连接MySQL地址 */
    'root',      /* The user to connect as 连接MySQL用户名 */
    '2660276',  /* The password to use 连接MySQL密码 */
    'FileYun');    /* The default database to query 连接数据库名称*/

if (!$link)
{
    printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error());
    exit;
}
session_start();
$username = $_SESSION['username'];
$password = $_POST['pwd'];


$iterations = 1000;
// Generate a random IV using mcrypt_create_iv(),
// openssl_random_pseudo_bytes() or another suitable source of randomness
$salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
$hash = hash_pbkdf2("sha256", $password, $salt, $iterations, 20);
$sql2="UPDATE `UserInfor` SET `UserPass`='$hash', `PassSalt`='$salt' WHERE `UserName`='$username'";
$rst2=$link->query($sql2);

if(!$rst2)
{
   printf("Could not enter data:",mysqli_connect_error());
}
else
{
    echo "<script type='text/javascript'>alert('修改成功!!!');location='https://xiaozhaoyun.com/login.html';</script>";
}



/* Close the connection 关闭连接*/
mysqli_close($link);

 ?>
