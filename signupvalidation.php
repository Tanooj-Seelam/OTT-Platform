<?php
session_start();

$key = 'fEkt9ZJ!qU64=TaNoOj_pTAW&27=<hjY-!cXy(MFM/gQ<am@gp!Tq>kAc!:F2000';

define('DB_SERVER','__Server Name Here__');
define('DB_USER','__User Name Here__');
define('DB_PASS','__User Password Here__');
define('DB_NAME','__DataBase Name Here__');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

if (mysqli_connect_errno())
{
    echo "Faild to connect Please Check Your Internet ";
}

$userid=encrypt(test_input($_POST['Userid']),$key);
$uname=encrypt(test_input($_POST['name1']),$key);
$emailid=encrypt(test_input($_POST['Login']),$key);
$password=encrypt(test_input($_POST['password']),$key);
$query=mysqli_query($con,"INSERT INTO `ott` (`UserID`, `Name`, `EmailID`, `Password`) VALUES ('$userid','$uname','$emailid','$password')");
//$num=mysqli_fetch_array($query);
//$row_num=mysqli_num_rows($query);
//if($row_num > 0)
//{
$_SESSION['signin']=$_POST['emailid'];
$_SESSION['sname']=$num['SName'];
$_SESSION['start'] = time();
$_SESSION['expire'] = $_SESSION['start'] + (60*15);
header("location:login.php");
//}
/*else
{
    $_SESSION['errmsg']="Please Enter Vallid Details";
    header("location:login.html");
    exit;
}*/

function test_input($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function encrypt($data , $key)
{
    $encryption_key = base64_decode($key);
    $cipher_method = 'aes-256-ctr';
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
    $encrypted = openssl_encrypt($data,'aes-256-cdc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

$con->close();
?>