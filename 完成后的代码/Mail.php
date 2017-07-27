<?php

/*'624905942@qq.com'*/
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
$email = $_POST['Email'];

$sql1="SELECT `UserName` FROM `UserInfor` WHERE UserName='$username'";
$rst1=$link->query($sql1);

if($rst1)
{
  $sql2="SELECT `UserMail` FROM `UserInfor` WHERE UserName='$username'";
  $rst2=$link->query($sql2);
  $row=$rst2->fetch_assoc();
  if($email==$row['UserMail'])
  {
    require_once("functions.php");

    $rand_str = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890";//需要使用到验证的一些字母和数字
    $str_arr = array();    //命名一个数组
    for($i = 0;$i<8;$i++)
    {
       $pos = mt_rand(0,strlen($rand_str)-1);
       $str_arr[] = $rand_str[$pos];//临时交换
    }
    $string=implode('',$str_arr);

    session_start();
    $_SESSION["vstring"]=$string;
    $_SESSION["username"]=$username;

    $mailinfor="您在使用小钊云重置密码服务，验证码为：".''.$string;
    $flag = sendMail($email,'重置密码通知',$mailinfor);
    if($flag)
    {
        echo"<script>location='https://xiaozhaoyun.com/reset2.html';</script>";
    }
  }

}
else
{
    echo "<script type='text/javascript'>alert('No UserName!!!');location='https://xiaozhaoyun.com/reset.html';</script>";
}

mysqli_close($link);
?>
