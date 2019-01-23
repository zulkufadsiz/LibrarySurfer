<?php
session_start();
ob_start();
ini_set('display_errors','0');
require_once 'inc/config.php';
require_once 'inc/mysql.class.php'; 
?>
<!doctype html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="<?php echo $sitename?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="<?php echo $sitename?>">
    <meta name="theme-color" content="#4C7FF0">
    <title><?php echo $sitename?></title>
       <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="styles/app.min.css">
    <link rel="stylesheet" href="styles/mystyle.css">
</head>

<body>
    <div class="app no-padding no-footer layout-static">
        <div class="session-panel">
            <div class="session">
                <div class="session-content">
                    <div class="card card-block form-layout">
                    <?php
					  // Kullanıcı adı ve parola kontrol edilir. 
					  $email   = mysqli_real_escape_string($connect, $_POST['email']);
					  $email   = trim($email);
					  $password   = mysqli_real_escape_string($connect, $_POST['password']);
					  $password   = sha1(md5(trim($password)));

					  $user_s   = "select * from sp_users WHERE status = '1' AND email = '$email' AND password = '$password'";
					  // echo $user_s;
					  $user_x    = mysqli_query($connect, $user_s);
                      $user_satir   = mysqli_num_rows($user_x);
					  if ($user_satir == 1)
					    {  
                          $user_sonuc = mysqli_fetch_object($user_x);
					      $user_session = "$user_sonuc->id";
					      $_SESSION['user_session'] = $user_session;
					      //echo "test: $_SESSION[user_session]";
					      header("Location: index.php?page=main");
					    }
					?>				
                        <form role="form" action="" method="post" id="validate">
                            <div class="text-xs-center m-b-3"><img src="<?php echo $logo_url?>" alt="" class="m-b-1 login-logo">
                                <h5>Yönetim Paneli</h5>
                            </div>
                            <fieldset class="form-group">
                                <label for="username">Mail adresi</label>
                                <input type="text" class="form-control form-control-lg" name="email" id="username" placeholder="E-Posta" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="password">Şifre</label>
                                <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="********" required>
                            </fieldset>
                            <button class="btn btn-primary btn-block btn-lg" type="submit">Giriş</button>
                            <a href="register.php" class="btn btn-primary btn-block btn-lg">Kayıt Ol</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        window.paceOptions = {
            document: true,
            eventLag: true,
            restartOnPushState: true,
            restartOnRequestAfter: true,
            ajax: {
                trackMethods: ['POST', 'GET']
            }
        };
    </script>
    <script src="scripts/app.min.js"></script>
    <script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $('#validate').validate();
    </script>
</body>

</html>