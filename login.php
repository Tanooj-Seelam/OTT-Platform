<!DOCTYPE html>
<html lang="en-US">


<head>
   <!-- Required meta tags -->
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Streamit</title>
   <!-- Favicon -->
   <link rel="shortcut icon" href="images/favicon.ico"/>
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="css/bootstrap.min.css"/>
   <!-- Typography CSS -->
   <link rel="stylesheet" href="css/typography.css">
   <!-- Style -->
   <link rel="stylesheet" href="css/style.css"/>
   <!-- Responsive -->
   <link rel="stylesheet" href="css/responsive.css"/>
</head>
<body>


<!-- MainContent -->
<section class="sign-in-page">
   <div class="container">
      <div class="row justify-content-center align-items-center height-self-center">
         <div class="col-lg-5 col-md-12 align-self-center">
            <div class="sign-user_card ">                    
               <div class="sign-in-page-data">
                  <div class="sign-in-from w-100 m-auto">
                     <h3 class="mb-3 text-center">Sign in</h3>
                     <form class="mt-4" action="#" method="POST">
                        <div class="form-group">
                           <label>Email ID</label>                                  
                           <input type="email" class="form-control mb-0" id="exampleInputEmail1" placeholder="Enter email"  name="Login" autocomplete="off" required>
                        </div>
                        <div class="form-group"> 
                           <label>Password</label>                                 
                           <input type="password" class="form-control mb-0" id="exampleInputPassword2" placeholder="Password" name="password" required>
                        </div>
                        
                           <div class="sign-info">
                              <button type="submit" class="btn btn-hover" name="sub" value="Sign In">Sign in</button>
                              <div class="custom-control custom-checkbox d-inline-block">
                                 <input type="checkbox" class="custom-control-input" id="customCheck">
                                 <label class="custom-control-label" for="customCheck">Remember Me</label>
                              </div>                                
                           </div>                                    
                        <?php
                        if(isset($_GET['error'])==true)
                        {
                            echo "&nbsp;<p style='text-aline:center; color:red;'> Invalid Email ID or Password </p>";
                        }
                        ?>
                     </form>
                  </div>
               </div>
               <div class="mt-3">
                  <div class="d-flex justify-content-center links">
                     Don't have an account? <a href="sign-up.html" class="text-primary ml-2">Sign Up</a>
                  </div>
                  <div class="d-flex justify-content-center links">
                     <a href="reset-password.html" class="f-link">Forgot your password?</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- MainContent End-->

<!-- back-to-top End -->
<!-- jQuery, Popper JS -->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="js/bootstrap.min.js"></script>
<!-- Slick JS -->
<script src="js/slick.min.js"></script>
<!-- owl carousel Js -->
<script src="js/owl.carousel.min.js"></script>
<!-- select2 Js -->
<script src="js/select2.min.js"></script>
<!-- Magnific Popup-->
<script src="js/jquery.magnific-popup.min.js"></script>
<!-- Slick Animation-->
<script src="js/slick-animation.min.js"></script>
<!-- Custom JS-->
<script src="js/custom.js"></script>
</body>

</html>

<?php
if(isset($_POST['sub']))
   {
      session_start();

      $key = 'fEkt9ZJ!qU64=TaNoOj_pTAW&27=<hjY-!cXy(MFM/gQ<am@gp!Tq>kAc!:F2000';

      define('DB_SERVER','__Server Name Here__');
define('DB_USER','__User Name Here__');
define('DB_PASS','__User Password Here__');
define('DB_NAME','__DataBase Name Here__');
      $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

      if (mysqli_connect_errno())
      {
         echo "Failed to connect Please Check Your Internet ";
      }
      
      $emailid=test_input($_POST['Login']);
      $password=test_input($_POST['password']);
      $query=mysqli_query($con,"SELECT * FROM 'ott'");
      while ($row = $query -> fetch_assoc())
      {
         $email = decrypt($row['$emailid'],$key);
         $pass = decrypt($row['Password'],$key);
      }
      $num=mysqli_fetch_array($query);
      if($password = $pass && $emailid = $email)
      {
            $_SESSION['login']=$_POST['exampleInputEmail1'];
            $_SESSION['sname']=$num['SName'];
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (60*15);
            $Systeminfo = encrypt($_SERVER['HTTP_USER_AGENT']);
            $ip = encrypt($_SERVER['REMOTE_ADDR']);
            $port = encrypt($_SERVER['REMOTE_PORT']);
            $query=mysqli_query($con,"INSERT INTO `client_info`(`EmailID`, `SystemInfo`, `IP`, `RemotePort`) VALUES ('$emailid','$Systeminfo','$ip','$port')");
            header("location:index.html");
      }
      else
      {
         header("location:login.php?error=1");
      }
   }

   function test_input($data)
   {
      $data = trim($data);
      $data = stripcslashes($data);
      $data = htmlspecialchars($data);
      return $data;
   }
   
   function decrypt($data , $key)
   {
      $encryption_key = base64_decode($key);
      list($encrypted_data,$iv) = array_pad(explode('::', base64_decode($data), 2),2,null);
      return openssl_decrypt($encrypted_data,'aes-256-cdc', $encryption_key, 0, $iv);
   }

   function encrypt($data , $key)
   {
      $encryption_key = base64_decode($key);
      $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cdc'));
      $encrypted = openssl_encrypt($data,'aes-256-cdc', $encryption_key, 0, $iv);
      return base64_encode($encrypted . '::' . $iv);
   }
   $con->close();
?>