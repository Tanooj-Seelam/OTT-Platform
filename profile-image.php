<?php
session_start();
$now = time();

if($now > $_SESSION['expire'])
{
    session_destroy();
    ?>
     <h1 style="text-align:center; color:blue">Your Session has expired ! <br><br></h1>
     <h2 style="text-align:center; color:red">Away For More Than 15min's </h2>
     <h1 style="text-align:center"><a href='login.html'>Log In</a></h1>
    <?php
}
define('DB_SERVER','__Server Name Here__');
define('DB_USER','__User Name Here__');
define('DB_PASS','__User Password Here__');
define('DB_NAME','__DataBase Name Here__');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

if (mysqli_connect_errno())
{
    echo "Faild to connect Please Check Your Internet ";
}
$file = $_FILES['image']['name'];
$query = "INSERT INTO `ott_images` (`Images`) VALUES ('$file')";
$res = mysqli_query($con,$query);

if ($res)
{
    move_uploaded_file($_FILES['image']['tmp_name'],"$file");
}
//$num=mysqli_fetch_array($query);
//$row_num=mysqli_num_rows($query);
//if($row_num > 0)
//{
$_SESSION['login']=$_POST['exampleInputEmail1'];
$_SESSION['sname']=$num['SName'];
$_SESSION['start'] = time();
$_SESSION['expire'] = $_SESSION['start'] + (60*15);
header("location:manage-profile.html");
/*}
else
{
    $_SESSION['errmsg']="Please Enter Vallid Details";
    echo "<script> alert('Please Enter Vallid Details')</script>";
    header("location:manage-profile.html");
    exit;
}*/
?>