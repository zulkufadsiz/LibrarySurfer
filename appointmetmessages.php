 <?php if ($_GET[action] == "delete") {
        $sil_sorgu     = "DELETE FROM appointment_messages WHERE id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=appointmetmessages&ok=delete");
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
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT * FROM appointment_messages ORDER BY status, create_date DESC";
                        $query_string1_calistir   = mysqli_query($connect, $query_string1);
                        while ($query1 = mysqli_fetch_object($query_string1_calistir)) {
                        ?>  
                        <tr class="appointment-list-item <?php if ($query1->status == 0){?>bg-info <?php } ?>" id="<?=$query1->id?>" role="row" class="odd">
                            <td class="center">
                            <span class="name"><?=$query1->name; ?> <?=$query1->lname; ?></span>
                            <span class="email"><?=$query1->email?></span>
                                <?=$query1->phone?></td>
                            <td class="center"><?=$query1->create_date ?></td>
                            <td class="center"><a class="btn btn-danger btn-sm" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger btn-sm' href='?page=appointmetmessages&action=delete&id=<?=$query1->id;?>'>Evet</a>">
                                    <i class="fa fa-trash-o "></i> 
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
            $query_string2        = "SELECT * FROM appointment_messages ORDER BY status, create_date DESC LIMIT 0,1";
            $query_string2_calistir   = mysqli_query($connect, $query_string2);
            $query2 = mysqli_fetch_object($query_string2_calistir);
            ?>  
            <div class="p-a-1">
                <div class="overflow-hidden">
                   <h2>E-Randevu Talep Formu</h2>
                   <div class="date"><?=dateformat4($query2->create_date) ?></div>
                    <h4 class="lead m-t-0"><?=$query2->subject ?></h4>
                    <div class="message-sender">
                        <p><b><?=$query2->name ?> (<?=$query2->email ?>)</b></p>
                        <p><b>Telefon : </b><?=$query2->phone ?></p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="p-a-1">
                <h4>Kişisel Bilgiler</h4>
                <div class="row">
                    <div class="col-xs-12"><label>T.C. Kimlik No :</label> <span><?=$query2->tc ?></span></div>
                    <div class="col-xs-12"><label>Ad :</label> <span><?=$query2->name ?></span></div>
                    <div class="col-xs-12"><label>Soyad :</label> <span><?=$query2->lname ?></span></div>
                    <div class="col-md-12"><label>E-Posta :</label> <span><?=$query2->email ?></span></div>
                    <div class="col-md-12"><label>Telefon :</label> <span><?=$query2->phone ?></span></div>
                </div>
                <h4>Randevu Bilgileri</h4>
                <div class="row">
                    <?php 
                        $cats = "SELECT * FROM categories WHERE id = $query2->department";
                        $cat_que = mysqli_query($connect,$cats);
                        $cat = mysqli_fetch_object($cat_que);
                        $docs = "SELECT * FROM products WHERE id = $query2->doctor";
                           $doc_que = mysqli_query($connect, $docs);
                         $doc = mysqli_fetch_object($doc_que);

                     ?>
                    <div class="col-md-12"><label>Bölüm :</label> <span><?=$cat->title_tr ?></span></div>
                    <div class="col-md-12"><label>Doktor :</label> <span><?=$doc->title_tr?></span></div>
                    <div class="col-md-12"><label>Randevu Tarihi :</label> <span><?=$query2->appointment_date ?></span></div>
                    
                </div>
            </div>
           
        </div>
        </div>
    </div>
</div>
<?php } ?> <!-- !action-->
