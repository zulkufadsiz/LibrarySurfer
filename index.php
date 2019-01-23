<?php 
session_start();
ob_start();
include 'inc/session.php';
include 'inc/config.php';
include 'inc/mysql.class.php'; 
include 'inc/functions.php';
// include 'inc/panel.class.php'; 
include 'inc/class.upload.php';
include 'inc/resimYukle.php';
include 'inc/dosyaYukle.php';
include('SimpleImage.php');
ini_set('display_errors', 0);
?>
<!doctype html>
<html lang="en">
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
    <title><?php echo $panel_adi;?></title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="styles/jquery-ui.min.css">
    <link rel="stylesheet" href="vendor/bower-jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="vendor/datatables/media/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="styles/app.min.css">
    <link rel="stylesheet" href="styles/redactor.css">  
    <link rel="stylesheet" href="styles/sweetalert.css">
    <link rel="stylesheet" href="../css/et-line-icons.css" />

    <link rel="stylesheet" href="styles/mystyle.css">

  <style>
  #sortable1, #sortable2 {
    border: 1px solid #eee;
    width: 100%;
    list-style-type: none;
    margin: 0;
    padding: 5px 0 0 0;
    float: left;
    margin-right: 10px;
  }
   #sortable1{
    min-height: 600px;
  }

  #sortable2{
    position: fixed;
    top: 205px;
    max-width: 250px;
    min-height: 250px;
    overflow-y: scroll;
    max-height: calc(100vh - 250px);
  }

     
  #sortable1 li, #sortable2 li {
    margin: 0 5px 5px 5px;
    padding: 5px;
    font-size: 1.2em;
    width: 100%;
  }
  </style>

</head>

<body>
    <div class="app">
        <div class="off-canvas-overlay" data-toggle="sidebar"></div>
        <div class="sidebar-panel">
            <div class="brand"> <a href="javascript:;" data-toggle="sidebar" class="toggle-offscreen hidden-lg-up"><i class="material-icons">menu</i> </a>
                <a class="brand-logo hidden-sm-down"><img class="expanding-hidden" src="<?php echo $logo_url?>" alt="" style="width: %88"> </a>
            </div>
			<div class="nav-profile dropdown">
				<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                <?php 
                    $sorgu              = "select * from users where id = $user_id";
                    $sorgu_calistir     = mysqli_query($connect, $sorgu);
                    $user_information              = mysqli_fetch_object($sorgu_calistir);
                ?>      
					<div class="user-image"><img src="<?php echo $pic_url?>/<?php echo $user_information->picture?>" class="avatar img-circle" alt="user" title="user"></div>
					<div class="user-info expanding-hidden"><?php echo $user_information->name ?> <small class="bold"><?php if ($user_information->level == 1 ) { echo "Yönetici";} else{ echo "Yönetici";}?></small></div>
				</a>
				<div class="dropdown-menu">
                    <a class="dropdown-item" href="index.php?page=profile&action=edit">Ayarlar</a> 
                    <a class="dropdown-item" href="logout.php">Çıkış</a>
                </div>
			</div>
            <nav>
                <p class="nav-title">PANEL MENÜSÜ</p>
                <ul class="nav">
                    <li><a href="index.php?page=main"><i class="material-icons text-primary">assessment</i> <span>Panel</span></a></li>
                    <li><a href="index.php?page=author"><i class="material-icons text-info">supervisor_account</i> <span>Yazar</span></a></li>
                    <li><a href="index.php?page=categories"><i class="material-icons text-danger">layers</i> <span>Kategori</span></a></li>
                    <li><a href="index.php?page=books"><i class="material-icons text-danger">library_books</i>Kitap</span></a></li>
                    <li><a href="logout.php"><i class="material-icons text-success">input</i> <span>Çıkış</span></a></li>
                   
                </ul>
            
         </nav>
    </div>
         <div class="main-panel">
            <nav class="header navbar">
                <div class="header-inner">
                    <div class="navbar-item navbar-spacer-right brand hidden-lg-up"> <a href="javascript:;" data-toggle="sidebar" class="toggle-offscreen"><i class="material-icons">menu</i> </a>
                        <a class="brand-logo hidden-xs-down"><img src="http://yasamedya.com/demo/kocaelitip/images/logo-wide-white.png" alt="logo"> </a>
                    </div><a class="navbar-item navbar-spacer-right navbar-heading hidden-md-down" href="#"><span>Yönetim Paneli 
                    <?php if ($_GET['ok']){ ?>
                    <?php if ($_GET['ok'] == "edit") { ?>
                             - <i class="fa fa-check"></i> İçerik Güncellendi
                    <?php } ?>
                    <?php if ($_GET['ok'] == "delete") { ?>
                             - <i class="fa fa-check"></i> İçerik Silindi
                    <?php } ?>                    
                    <?php if ($_GET['ok'] == "add") { ?>
                             - <i class="fa fa-check"></i> İçerik Eklendi
                    <?php } ?>   
                    <?php if ($_GET['ok'] == "error") { ?>
                             - <i class="fa fa-close"></i> Hata! Düzenleme Yapılamadı.
                    <?php } ?>
                    <?php if ($_GET['ok'] == "usererror") { ?>
                             - <i class="fa fa-close"></i> Hata! Sistemde bu mail ile kayıtlı kullanıcı var!..
                    <?php } ?>                                          
                <?php } ?>
                </span></a>
                    <!-- <div class="navbar-search navbar-item">
                        <form class="search-form"><i class="material-icons">search</i>
                            <input class="form-control" type="text" placeholder="Search">
                        </form>
                    </div> -->
                    <div class="navbar-item nav navbar-nav">
                        <div class="nav-item nav-link dropdown">
                            <a id="notification_panel" href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="material-icons">notifications</i> 
                        <?php 
                            $notification_query = "
                                SELECT cm.name,cm.create_date, nt.table_message, nt.page_link FROM contact_messages AS cm INNER JOIN notification_types AS nt ON cm.table_id = nt.id AND cm.notify_viewed = 0
                                ORDER BY create_date DESC";

                            $notification_query_calistir   = mysqli_query($connect, $notification_query);
                            $notification_count = mysqli_num_rows($notification_query_calistir);
                            
                            if ($notification_count != 0){ ?><span id="notification_count" class="tag tag-danger"><?php echo $notification_count?></span><?php } ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right notifications">
                                <div class="dropdown-item">
                                    <div class="notifications-wrapper">
                                        <ul class="notifications-list">
                                        <?php
                                            while ($query = mysqli_fetch_object($notification_query_calistir)) {
                                            ?>  
                                            <li>
                                                <a href="index.php?page=<?php echo $query->page_link ?>">
                                                    <div class="notification-icon">
                                                        <div class="circle-icon bg-success text-white"><i class="material-icons">notifications_active</i></div>
                                                    </div>
                                                    <div class="notification-message"><b><?php echo $query->name?></b> <?php echo $query->table_message ?></div>
                                                </a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="notification-footer">Bildirimler</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
 <div class="main-content">
    <div class="content-view">
        <?php include('inc/switch.php');?>
    </div>

	<div class="content-footer">
		<nav class="footer-left">
			<ul class="nav">
				<li><a href="http://zulkufadsiz.com.tr" target="_BLANK" title="Zülküf ADSIZ"><span>Copyright</span> &copy; <?php echo date("Y"); ?> ZÜLKÜF ADSIZ</a></li>
			</ul>
		</nav>
	</div>
</div>
    </div>
</div>
<script src="scripts/app.min.js"></script>
<script src="scripts/jquery-ui-1.10.3.custom.min.js"></script>
<script src="vendor/datatables/media/js/jquery.dataTables.js"></script>
<script src="vendor/datatables/media/js/dataTables.bootstrap4.js"></script>
<script src="scripts/redactor.min.js"></script>
<script src="scripts/imagemanager.js"></script>  
<script src="scripts/table.js"></script> 
<script src="scripts/sweetalert.min.js"></script>
<script src="scripts/validator.js"></script> 
<script src='scripts/tiny/tinymce.min.js'></script>
<?php if ($_GET[page] == "survey" && $_GET[action] == "viewistatistic"){?>
<script src="vendor/Chart.js/dist/Chart.bundle.js"></script>
<script src="vendor/Chart.js/dist/utils.js"></script>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script>
<?php
$perfect_count= 0; $good_count= 0; $intermediate_count= 0; $bad_count= 0; $verybad_count = 0;
$sorgu6 = "select * from surveys";
$sorgu6_calistir   = mysqli_query($connect, $sorgu6);
while($all_answers = mysqli_fetch_object($sorgu6_calistir)){
    $count= 1;

    while ($count <= 12) {
    $answer = "answer$count";
        switch ($all_answers->$answer) {
            case 'perfect':
                $perfect_count++;
                break;
            case 'good':
                $good_count++;
                break;
            case 'intermediate':
                $intermediate_count++;
                break;
            case 'bad':
                $bad_count++;
                break;
            case 'verybad':
                $verybad_count++;
                break;
            default:

                break;
        }
    $count++;    
    }
}
?>    
var total_count = <?php echo $perfect_count?> + <?php echo $good_count?> + <?php echo $intermediate_count?> + <?php echo $bad_count?> + <?php echo $verybad_count?>;
var perfect_count = <?php echo $perfect_count?> , good_count = <?php echo $good_count?>, intermediate_count = <?php echo $intermediate_count?>, bad_count = <?php echo $bad_count?>, verybad_count = <?php echo $verybad_count?>;
var perfect_raito = perfect_count / (total_count / 100);
var good_raito = good_count / (total_count / 100);
var intermediate_raito = intermediate_count / (total_count / 100);
var bad_raito = bad_count / (total_count / 100);
var verybad_raito = verybad_count / (total_count / 100);

var config = {
    type: 'pie',
    data: {
        datasets: [{
            data: [perfect_raito, good_raito, intermediate_raito, bad_raito, verybad_raito],
            backgroundColor: [
                'rgb(127, 195, 92)',
                'rgb(240, 197, 76)',
                'rgb(76, 195, 240)',
                'rgb(76, 127, 240)',
                'rgb(210, 109, 84)'
            ]
        }],
        labels: [
            "Çok iyi(5)",
            "İyi(4)",
            "Orta(3)",
            "Kötü(2)",
            "Çok kötü(1)"
        ]
    },
    options: {
        responsive: true
    }
};
var config2 = {
    type: 'bar',
    data: {
        datasets: [{
            data: [perfect_count, good_count, intermediate_count, bad_count, verybad_count],
            backgroundColor: [
                'rgb(127, 195, 92)',
                'rgb(240, 197, 76)',
                'rgb(76, 195, 240)',
                'rgb(76, 127, 240)',
                'rgb(210, 109, 84)'
            ]
        }],
        labels: [
            "Çok iyi(5)",
            "İyi(4)",
            "Orta(3)",
            "Kötü(2)",
            "Çok kötü(1)"
        ]
    },
    options: {
        responsive: true,
        scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
    }
};

window.onload = function() {
    var ctx = document.getElementById("chart-area").getContext("2d");
    window.myPie = new Chart(ctx, config);

    var ctx2 = document.getElementById("chart-area2").getContext("2d");
    window.myBar = new Chart(ctx2, config2);
};
</script>
<?php } ?>
<!-- End of statistics page scripts -->
<script src="scripts/custom.js"></script>
   
<script type="text/javascript">
    $('.demo9').on('click', function() {
    swal({
        title: 'Şifre değiştir!',
        text: '',
        type: 'input',
        showCancelButton: true,
        closeOnConfirm: false,
        animation: 'slide-from-top',
        inputType: 'password',
        inputPlaceholder: 'Şifre'
    }, function(inputValue) {
        if (inputValue === false) {
            return false;
        }
        if (inputValue === '') {
            swal.showInputError('Şifre boş bırakılamaz!');
            return false;
        }
        <?php if($_GET[id] != ""){ ?>
            var userid = <?php echo $_GET[id] ?>;
        <?php } else{ ?>
            var userid = <?php echo $user_information->id ?>;
        <?php } ?>

            var newpass = inputValue;
            var page = "<?php echo $_GET[page]?>";
                    // alert($(this).val());
            $.post("passwordchanger.php", {"user_id":userid , "newpassword":newpass , "currentpage":page}, function(sonuc){
            });

        swal('Şifre değiştirildi!', '', 'success');
    });
});
</script>
<script type="text/javascript">
    $('.remove-doc').on('click', function() {
    $(".document-area").remove();

    var item_id = <?php if (isset($_GET[id])) {echo $_GET[id];} else{ echo "0";} ?>;
    
    if (item_id != 0 ) {
        $.post("remove-document.php", {"item_id": item_id}, function(sonuc){
        });
    }
});
</script>
<script type="text/javascript">
    $("select[name=slider_type]").change(function(){
        var type = $(this).val();

        if (type == 1 ) {
            $("#title_1_tr").remove();
        }
        else{
            var page = '<?php echo $_GET[action]; ?>' ;
            if (page == "add") {
                $("#title_2_tr").before('<div class="form-group col-xs-6" id="title_1_tr"><label for="example-text-input" class=" col-form-label">Üst Başlık</label><input class="form-control" type="text" id="example-text-input" name="first_title_tr" value="<?php echo $_POST[first_title_tr];?>"></div>');
            }
            else{
                $("#title_2_tr").before('<div class="form-group col-xs-6" id="title_1_tr"><label for="example-text-input" class=" col-form-label">Üst Başlık</label><input class="form-control" type="text" id="example-text-input" name="first_title_tr" value="<?php echo str_replace(chr(34), "&quot;", stripslashes($query2->first_title_tr)); ?>"></div>');
            }
        }
    });
</script>
<script type="text/javascript">
    $("select[name=location_type]").change(function(){
    $("#surMansetPhoto").remove();

    var type = $(this).val();
    if (type == 2 ) {
        // alert($(this).val());
       <?php if ($_GET[action] == "add") {  ?>
        $("#location_selector").after('<div class="form-group col-xs-12" id="surMansetPhoto"><label for="example-text-input" class=" col-form-label">Sürmanşet Fotoğrafı (Habere kapak fotoğrafı girmeyi unutmayın!..)<span class="text-danger">*</span></label><input class="form-control focused" type="file" name="resim2" required></div>');
       <?php  }
        else if ($_GET[action] == "edit") {  ?>
        $("#location_selector").after('<div class="form-group col-xs-12" id="surMansetPhoto"><label for="example-color-input" class=" col-form-label">Sürmanşet Fotoğrafı (Habere kapak fotoğrafı girmeyi unutmayın!..)<span class="text-danger">*</span></label><input class="form-control focused" type="file" name="resim2"><p><img src="<?php echo $pic_url?>/<?php echo $query2->image_sur?>" width="200px" ></p></div>');
      <?php  } ?>
    }
});

</script>
</body>

</html>