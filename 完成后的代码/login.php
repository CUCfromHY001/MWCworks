<?php
header("Content-Type: text/html;charset=utf-8");

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

$username = $_POST['UserName'];
$password = $_POST['password'];



$iterations = 1000;
// Generate a random IV using mcrypt_create_iv(),
// openssl_random_pseudo_bytes() or another suitable source of randomness
$salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
$hash = hash_pbkdf2("sha256", $password, $salt, $iterations, 20);

$sql="SELECT `UserName` FROM `UserInfor` WHERE UserName='$username'";
$rst=$link->query($sql);
if($rst)
{
  $sql2="SELECT `UserPass` FROM `UserInfor` WHERE UserName='$username'";
  $rst2=$link->query($sql2);
  $row=$rst2->fetch_assoc();

  $sql3="SELECT `PassSalt` FROM `UserInfor` WHERE UserName='$username'";
  $rst3=$link->query($sql3);
  $row3=$rst3->fetch_assoc();

  $salt = $row3['PassSalt'];
  $hash = hash_pbkdf2("sha256", $password, $salt, $iterations, 20);

  if($hash==$row['UserPass'])
  {
    setcookie("user", $username, time()+3600);

    echo "<script type='text/javascript'>location='https://xiaozhaoyun.com/main.html';</script>";
  }
  else
  {
    echo "<script type='text/javascript'>alert('用户名或密码错误');location='https://xiaozhaoyun.com/login.html';</script>";
  }
}




mysqli_close($link);


?>
