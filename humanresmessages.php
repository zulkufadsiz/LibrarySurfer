 <?php if ($_GET[action] == "delete") {
        $sil_sorgu     = "DELETE FROM human_resources_messages WHERE id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=humanresmessages&ok=delete");
        }           
    ?>  
<?php if (!$_GET[action]) { ?>      

 <div class="row" >
    <div class="col-lg-4 col-md-6 col-sm-5 ">
            <div class="p-a-0 messages-list bg-white b-r">
              <table class="table messages-datatable">
                    <thead>
                        <tr>
                            <th>Ad / Eposta / Telefon</th>                                    
                            <th style="min-width: 70px;">Tarih</th>
                            <th style="min-width: 30px;">Sil</th>
                            <th style="min-width: 30px;">İndir</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT * FROM human_resources_messages ORDER BY status, create_date DESC";
                        $query_string1_calistir   = mysqli_query($connect, $query_string1);
                        while ($query1 = mysqli_fetch_object($query_string1_calistir)) {
                        ?>  
                        <tr class="human-list-item <?php if ($query1->status == 0){?>bg-info <?php } ?>" id="<?=$query1->id?>" role="row" class="odd">
                            <td class="center">
                            <span class="name"><?=$query1->name; ?> <?=$query1->lname; ?></span>
                            <span class="email"><?=$query1->email?></span>
                                <?=$query1->phone?></td>
                            <td class="center"><?=$query1->create_date ?></td>
                            <td class="center"><a class="btn btn-danger btn-sm" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger btn-sm' href='?page=humanresmessages&action=delete&id=<?=$query1->id;?>'>Evet</a>">
                                    <i class="fa fa-trash-o "></i> 
                                </a></td>
                                <td class="center"><a class="btn btn-info btn-sm" href="../basvurular/<?=$query1->id  ?>">
                                    <i class="fa fa-download "></i> 
                                </a></td>
                        </tr>
                       <?php } ?>
                   </tbody>
                </table>
            </div>
    </div>
    <div class="col-lg-8 col-md-6 col-sm-7">
        <div class="message-view">
        <div class="message-body">
        <?php
            $query_string2        = "SELECT * FROM human_resources_messages ORDER BY status, create_date DESC LIMIT 0,1";
            $query_string2_calistir   = mysqli_query($connect, $query_string2);
            $query2 = mysqli_fetch_object($query_string2_calistir);
            ?>  
            <div class="p-a-1">
                <div class="overflow-hidden">
                    <div class="date"><?=dateformat4($query2->create_date)?></div>
                    <h4 class="lead m-t-0"><?=$query2->subject ?></h4>
                    <div class="message-sender">
                        <p><b><?=$query2->name ?></b> (<?=$query2->email ?>)</p> 
                        <p><b>Telefon : </b> <?=$query2->phone ?></p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="p-a-1">
                <h4>Kişisel Bilgiler</h4>
                <div class="row">
                    <div class="col-xs-12"><label>Fotoğraf:</label><img src="../images/upload/<?=$query2->image;  ?>" style="max-width: 150px;"></div>
                    <div class="col-xs-12"><label>Ad Soyad:</label> <span><?=$query2->name ?></span></div>
                    <div class="col-xs-12"><label>Cinsiyet :</label> <span><?=$query2->gender ?></span></div>
                    <div class="col-md-12"><label>Doğum Tarihi :</label> <span><?=$query2->bday ?></span></div>
                    <div class="col-md-12"><label>Doğum Yeri :</label> <span><?=$query2->bplace ?></span></div>
                    <!-- <div class="col-xs-12"><label>Anne Adı:</label> <span><?=$query2->mother_name ?></span></div>
                    <div class="col-xs-12"><label>Baba Adı :</label> <span><?=$query2->father_name ?></span></div> -->
                    <div class="col-xs-12"><label>Askerlik Durumu :</label> <span><?=$query2->duty_status ?></span></div>
                    <div class="col-md-12"><label>Yabancı Dil Bilgisi :</label> <span><?=$query2->foreign_language ?></span></div>
                    <div class="col-md-12"><label>Askerlik Durumu :</label> <span><?=$query2->marital_status ?></span></div>
                    <div class="col-xs-12"><label>Ehliyet:</label> <span><?=$query2->driving_license ?></span></div>
                    <div class="col-xs-12"><label>Kan Grubu :</label> <span><?=$query2->blood_group ?></span></div>
                    <div class="col-xs-12"><label>Adres :</label> <span><?=$query2->address ?></span></div>
                    <div class="col-md-12"><label>E-Posta :</label> <span><?=$query2->email ?></span></div>
                    <div class="col-md-12"><label>Telefon :</label> <span><?=$query2->phone ?></span></div>
                    <div class="col-xs-12"><label>Maaş Beklentisi:</label> <span><?=$query2->salary_expectation ?></span></div>
                    <div class="col-xs-12"><label>Çalışmak İstenilen Departman :</label> <span><?=$query2->department_preference ?></span></div>
                    <div class="col-xs-12"><label>Kariyer Hedefleri :</label> <span><?=$query2->career_goals ?></span></div>
                    <div class="col-md-12"><label>Neden Biz ? :</label> <span><?=$query2->why_us ?></span></div>
                </div>
                     <h4>Eğitim Bilgileri</h4>
                <div class="row">
                    <div class="col-md-12"><label>Son Mezun Olunan Okul :</label> <span><?=$query2->highschool ?></span></div>
                    <div class="col-xs-12"><label>Bölüm:</label> <span><?=$query2->highschool_department ?></span></div>
                    <div class="col-xs-12"><label>Mezuniyet Yılı :</label> <span><?=$query2->highschool_graduate_year ?></span></div>
                    <div class="col-xs-12"><label>Diploma Notu :</label> <span><?=$query2->highschool_grade ?></span></div>

                   

                </div>
                <h4>Program Bilgileri</h4>
                <div class="row">
                    <div class="col-xs-6"><label>Program Bilgi Seviyesi :</label> <span><?=$query2->program_1 ?></span></div>
                   
                </div>
                
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-12 col-xs-12"><label>Firma Adı :</label> <span><?=$query2->work_1 ?></span></div>
                        <div class="col-sm-6 col-xs-12"><label>Pozisyon :</label> <span><?=$query2->work_position_1 ?></span></div>
                        <div class="col-sm-6 col-xs-12"><label>Süre :</label> <span><?=$query2->work_entrance_1 ?></span></div>
                        <div class="col-sm-6 col-xs-12"><label>Çıkış Nedeni</label> <span><?=$query2->work_quitreason_1?></span></div>
                        <div class="col-sm-6 col-xs-12"><label>Son Maaş</label> <span><?=$query2->work_salary_1?></span></div>
                    </div>
                    <?php if ($query2->work_2 != "") { ?>
                    <div class="form-group">
                        <div class="col-sm-12 col-xs-12"><label>Firma Adı :</label> <span><?=$query2->work_2 ?></span></div>
                        <div class="col-sm-6 col-xs-12"><label>Pozisyon :</label> <span><?=$query2->work_position_2 ?></span></div>
                        <div class="col-sm-6 col-xs-12"><label>Süre :</label> <span><?=$query2->work_entrance_2 ?></span></div>
                        <div class="col-sm-6 col-xs-12"><label>Çıkış Nedeni</label> <span><?=$query2->work_quitreason_2?></span></div>
                        <div class="col-sm-6 col-xs-12"><label>Son Maaş</label> <span><?=$query2->work_salary_2?></span></div>
                    </div>
                    <?php } 
                    if ($query2->work_3 != "") { ?>
                    <div class="form-group">
                        <div class="col-sm-12 col-xs-12"><label>Firma Adı :</label> <span><?=$query2->work_3 ?></span></div>
                        <div class="col-sm-6 col-xs-12"><label>Pozisyon :</label> <span><?=$query2->work_position_3 ?></span></div>
                        <div class="col-sm-6 col-xs-12"><label>Süre :</label> <span><?=$query2->work_entrance_3 ?></span></div>
                        <div class="col-sm-6 col-xs-12"><label>Çıkış Nedeni :</label> <span><?=$query2->work_quitreason_3?></span></div>
                        <div class="col-sm-6 col-xs-12"><label>Son Maaş :</label> <span><?=$query2->work_salary_3?></span></div>
                    </div>
                    <?php } ?>
                </div>
                <h4>Kişisel Notlar</h4>
                <div class="row">  
                    <div class="form-group">
                        <div class="col-sm-12 col-xs-12"><label>Engel Durumu :</label> <span><?=$query2->disabilities ?></span></div>
                        <div class="col-sm-12 col-xs-12"><label>Sağlık Durumu :</label> <span><?=$query2->health_issue ?></span></div>
                        <div class="col-sm-12 col-xs-12"><label>Açıklama :</label> <span><?=$query2->health_issue_explain?></span></div>
                        <div class="col-sm-12 col-xs-12"><label>Gece çalışması yapabilir misiniz ? :</label> <span><?=$query2->shift?></span></div>
                        <div class="col-sm-12 col-xs-12"><label>Ekstra mesai yapmayı kabul eder misiniz ? :</label> <span><?=$query2->overtime?></span></div>
                        <div class="col-sm-12 col-xs-12"><label>İlave Notlar :</label> <span><?=$query2->message?></span></div>

                    </div>
                    </div>
                </div>
            </div>
           
        </div>
        </div>
    </div>
</div>
<?php } ?> <!-- !action-->
