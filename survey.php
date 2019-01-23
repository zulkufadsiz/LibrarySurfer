<?php 
if ($_GET[action] == "delete") {
    $sil_sorgu     = "delete from surveys where id = $_GET[id]";
    $sil_exec      = mysqli_query($connect, $sil_sorgu);
    header("Location: ?page=survey&ok=delete");
}			
?>		
<?php
    if ($_GET[action] == "viewistatistic") { ?>
    <div class="card">
        <div class="card-header b-a-0">
            <h5 class="pull-left"> Sayfa: Anket Sonuçları - İstatistikler</h5>
            <div class="card-icon pull-right">
                <a href="?page=survey" title="Kullanıcı Bazlı Gör"><i class="fa fa-eye"></i></a>
                <a href="?page=survey&amp;action=viewistatistic" title="Genel İstatistik Gör"><i class="fa fa-bar-chart"></i></a>
            </div>  
        </div>
    </div>
    <div class="card-group text-xs-center m-b-1">
        <div class="card">
            <div class="card-header no-bg b-a-0">Genel cevap oranları (%)</div>
            <div class="card-block">
                <div id="canvas-holder">
                    <canvas id="chart-area"/>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header no-bg b-a-0">Genel cevap sayıları (Adet)</div>
            <div class="card-block">
                <div class="canvas-holder">
                    <canvas id="chart-area2"></canvas>
                </div>
            </div>
        </div>
    </div>

     <div class="card">
        <div class="card-block">
           <div class="no-more-tables">
                <table class="table table-bordered table-striped m-b-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Soru</th>
                            <th class="numeric">Çok İyi(5)</th>
                            <th class="numeric">İyi(4)</th>
                            <th class="numeric">Orta(3)</th>
                            <th class="numeric">Kötü(2)</th>
                            <th class="numeric">Çok Kötü(1)</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $count= 1;
                        $sorgu        = "select * from survey_questions WHERE id = 1";
                        $sorgu_calistir   = mysqli_query($connect, $sorgu);
                        $survey = mysqli_fetch_object($sorgu_calistir);
                        while ($count <= 12){//12 adet çoktan seçmeli soru olduğu için tablodan bu kadar cevabı çeksin
                            $question = "question$count";
                            $answer = "answer$count";
                            $perfect_count= 0; $good_count= 0; $intermediate_count= 0; $bad_count= 0; $verybad_count = 0;

                            $sorgu6 = "select ".$answer." from surveys";
                            $sorgu6_calistir   = mysqli_query($connect, $sorgu6);
                            while($all_answers = mysqli_fetch_object($sorgu6_calistir)){
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
                            }
                        ?> 
                        <tr>    
                            <td data-title="id"><?=$count?></td>
                            <td data-title="question"><?=$survey->$question;?></td>
                            <td data-title="perfectcount" class="numeric"><?=$perfect_count?></td>
                            <td data-title="goodcount" class="numeric"><?=$good_count?></td>
                            <td data-title="intermediatecount" class="numeric"><?=$intermediate_count?></td>
                            <td data-title="badcount" class="numeric"><?=$bad_count?></td>
                            <td data-title="verybadcount" class="numeric"><?=$verybad_count?></td>
                        </tr>
                    <?php 
                    $count++;
                    } ?>
                    </tbody>
                </table>
            </div>



        </div>
    </div>


<?php } ?>
<?php if (!$_GET[action]) { ?>      
    <div class="card">
        <div class="card-header b-a-0">
            <div class="card-icon pull-left">
                <i class="fa fa-list"></i>
            </div>                      
            <h5 class="pull-left"> Sayfa: Anket Sonuçları - Kullanıcı Bazlı</h5>
            <div class="card-icon pull-right">
                <a href="?page=survey" title="Kullanıcı Bazlı Gör"><i class="fa fa-eye"></i></a>
                <a href="?page=survey&amp;action=viewistatistic" title="Genel İstatistik Gör"><i class="fa fa-bar-chart"></i></a>
            </div>  
        </div>
        <div class="card-block">
            <table class="table table-striped table-bordered datatable">
                <thead>
                    <tr>
                       <th>ID</th>
                       <th>Firma</th>
                       <th>Yetkili</th>
                       <th>E-Posta</th>
                       <th>Telefon</th>
					   <th>Görüntüle / Sil</th>
                    </tr>
                </thead>
                <tbody>
                <?php
					$sorgu        = "select * from surveys order by id";
					$sorgu_calistir   = mysqli_query($connect, $sorgu);
					while ($survey = mysqli_fetch_object($sorgu_calistir)) {
                    ?>  
                    <tr role="row" class="odd">
                        <td><?=$survey->id?></td>
                        <td class="center"><?=$survey->company?></td>
                        <td class="center"><?=$survey->name?></td>
                        <td class="center"><?=$survey->email?></td>
						<td class="center"><?=$survey->phone?></td>
                        <td class="center">
                            <a class="btn btn-info" href="?page=survey&action=edit&id=<?=$survey->id?>">
                                <i class="fa fa-eye "></i>  
                            </a>
                            <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=survey&action=delete&id=<?=$survey->id;?>'>Evet</a>">
                                <i class="fa fa-trash-o "></i> 
                            </a>
                        </td>
                    </tr>
                   <?php } ?>
               </tbody>
            </table>
        </div>
    </div>
<?php } ?> <!-- !action-->

<?php if ($_GET[action] == "edit") { 

$sorgu        = "select * from surveys where id = '$_GET[id]'";
$sorgu_calistir   = mysqli_query($connect, $sorgu);
$survey_answers         = mysqli_fetch_object($sorgu_calistir);

?>
<div class="card">
    <div class="card-header b-a-0">
        <div class="card-icon pull-left">
                <i class="fa fa-edit"></i>
        </div>                      
        <h5 class="pull-left"> Sayfa: Anket Sonuçları - Anket sonucu görüntüleme</h5>
        <div class="card-icon pull-right">
            <a href="?page=survey" title="Kullanıcı Bazlı Gör"><i class="fa fa-eye"></i></a>
            <a href="?page=survey&amp;action=viewistatistic" title="Genel İstatistik Gör"><i class="fa fa-bar-chart"></i></a>
        </div>  
    </div>
    <div class="card-block">
        <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=survey&action=edit&id=<?=$survey->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
            <div class="form-group col-md-3 col-sm-6 col-xs-12">
                <input type="text" name="cs_company" id="name" value="<?=$survey_answers->company?>" class="form-control" disabled>
            </div>
            <div class="form-group col-md-3 col-sm-6 col-xs-12">
                <input type="text" name="cs_name" id="authorized" value="<?=$survey_answers->name?>" class="form-control" disabled>
            </div>
            <div class="form-group col-md-3 col-sm-6 col-xs-12">
                <input type="text" name="cs_email" value="<?=$survey_answers->email?>" class="form-control" disabled>
            </div>
            <div class="form-group col-md-3 col-sm-6 col-xs-12">
                <input type="text" name="cs_phone" value="<?=$survey_answers->phone?>" class="form-control" disabled>
            </div>

            <?php
                $count= 1;
                $sorgu        = "select * from survey_questions WHERE id = 1";
                $sorgu_calistir   = mysqli_query($connect, $sorgu);
                $survey_questions = mysqli_fetch_object($sorgu_calistir);

                while ($count <= 13){//12 adet çoktan seçmeli soru olduğu için tablodan bu kadar cevabı çeksin 1 tane metin için if koyduk
                    $question = "question$count";
                    $answer = "answer$count";
                
                    if ($count <= 12) {
                ?> 

                <div class="form-group col-xs-12">
                <label><?=$count?>- <?=$survey_questions->$question;?></label>
                <div class="row question-row">
                    <div class="col-sm-12">
                        <label><input type="radio" name="cs_answer<?=$count?>" value="perfect" <?php if ($survey_answers->$answer == "perfect") {?> checked <?php }else{?> disabled <?php } ?> > Çok İyi(5)</label>
                        <label><input type="radio" name="cs_answer<?=$count?>" value="good" <?php if ($survey_answers->$answer == "good") {?> checked <?php }else{?> disabled <?php } ?>> İyi(4)</label>
                        <label><input type="radio" name="cs_answer<?=$count?>" value="intermediate" <?php if ($survey_answers->$answer == "intermediate") {?> checked <?php }else{?> disabled <?php } ?>> Orta(3)</label>
                        <label><input type="radio" name="cs_answer<?=$count?>" value="bad" <?php if ($survey_answers->$answer == "bad") {?> checked <?php }else{?> disabled <?php } ?>> Kötü(2)</label>
                        <label><input type="radio" name="cs_answer<?=$count?>" value="verybad" <?php if ($survey_answers->$answer == "verybad") {?> checked <?php }else{?> disabled <?php } ?>> Çok Kötü(1)</label>
                    </div>
                </div>
            </div>
                   
            <?php 
                }else{ ?>
                <div class="form-group col-xs-12">
                    <label><?=$count?>- <?=$survey_questions->$question;?></label>
                    <textarea name="cs_answer<?=$count?>" rows="3" disabled><?=$survey_answers->$answer ?></textarea>
                </div>
               <?php }
             ?>
            <?php 
            $count++;
            } ?>

            
       </form>
    </div>
</div>
<?php } ?>					