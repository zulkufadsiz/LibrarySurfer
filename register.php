
<?php
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
    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <title><?php echo $sitename?></title>
  
    <link rel="stylesheet" href="styles/app.min.css">
     <link rel="stylesheet" href="styles/toastr.min.css">
    <link rel="stylesheet" href="styles/mystyle.css">
       <script src="scripts/app.min.js"></script>
      <script src="scripts/toastr.min.js"></script>
</head>

<body>
  
    <div class="app no-padding no-footer layout-static">
        <div class="session-panel">
            <div class="session">
                <div class="session-content">

                    <div class="card card-block form-layout">
                    <?php
                        if ($_POST) {
                           
                       echo $fullname   = mysqli_real_escape_string($connect, $_POST['fullname']);
                        $email      = mysqli_real_escape_string($connect, $_POST['email']);
                        $email      = trim($email);
                        $password   = mysqli_real_escape_string($connect, $_POST['password']);
                        $password   = sha1(md5(trim($password)));

                        $sql = "INSERT INTO sp_users(full_name,email,password,status) VALUES('$fullname','$email','$password','1')";
                        $query_run  = mysqli_query($connect, $sql);
                        }
					?>				
                        <form role="form" action="" method="post" id="validate">
                            <div class="text-xs-center m-b-3"><img src="<?php echo $logo_url?>" alt="" class="m-b-1 login-logo">
                                <h5>Kayıt Ol</h5>
                            </div>
                            <fieldset class="form-group">
                                <label for="username">Mail adresi</label>
                                <input type="text" class="form-control form-control-lg" name="email" id="email" placeholder="E-Posta" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="username">Ad Soyad</label>
                                <input type="text" class="form-control form-control-lg" name="fullname" id="fullname" placeholder="Adınız" required>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="password">Şifre</label>
                                <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="********" required>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="password">Şifre(Tekrar)</label>
                                <input type="password" class="form-control form-control-lg" name="confirm" id="confirm" placeholder="********" required>
                            </fieldset>
                            <button class="btn btn-primary btn-block btn-lg" type="submit">Kayıt Ol</button>
                         
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

   
    <script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script type="text/javascript">
        //$('#validate').validate();
        $( "#validate" ).validate({
          rules: {
            password: "required",
            confirm: {
              equalTo: "#password"
            },
             email: {
              required: true,
              email: true
            }
          }
        });
    </script>
     
</body>

</html>