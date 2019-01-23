$(document).ready(function(e) {
    $( "#sortable1, #sortable2" ).sortable({
      connectWith: ".connectedSortable"
    }).disableSelection();

    $('#checkForm').validator();
		
	$('.datatable').DataTable({
        drawCallback: function() {
            $("[data-toggle=tooltip]").tooltip();
            $("[data-toggle=popover]")
                .popover()
                .click(function(e) {
                    e.preventDefault();
            });
         },
          "order": []
    });

    $('.messages-datatable').DataTable({
		"order": [],
		"paging":   false,
		"info":   false,
		language: {
		    search: "_INPUT_",
		    searchPlaceholder: "Mesajlarda Ara"
		},
		"dom": '<lf<t>ip>'
    });

    $("select[name=shape]").change(function(){
        $(".area-row").remove();

        var shape = $(this).val();
        if (shape != 0 ) {
            $.post("areaselector.php", {"shape":shape}, function(sonuc){
                // alert($(this).val());
                $(".shape-row").after('<div class="form-group col-xs-12 area-row"><label for="exampleSelect1">Reklam Alanı<span class="text-danger">*</span></label><select class="form-control" name="ad_area_id" id="exampleSelect1"></select></div>');
                $("select[name = ad_area_id]").html(sonuc);
            });
        }
    });


    $("[data-toggle=tooltip]").tooltip();
    $("[data-toggle=popover]").popover().click(function(e) {
        e.preventDefault();
    });

    $('.message-list-item').on('click', function() {
        $(".message-body").remove();
        var message_id = $(this).attr('id');
        // alert($(this).attr('id'));
        if (message_id != 0 ) {
            $.post("message-details.php", {"message_id":message_id}, function(sonuc){
                // alert($(this).val());
                $(".message-view").html(sonuc);

            });
        };
        var result = $(this).hasClass("bg-info");
        // alert(result);
        if (result == true) {
            $(this).removeClass("bg-info");
        }
        $(this).css('background','#d4f5ff')
        $(this).siblings().css('background','#fff');
    });

    $('.human-list-item').on('click', function() {
        $(".message-body").remove();
        var message_id = $(this).attr('id');
        // alert($(this).attr('id'));
        if (message_id != 0 ) {
            $.post("humanres-details.php", {"message_id":message_id}, function(sonuc){
                // alert($(this).val());
                $(".message-view").html(sonuc);
            });
        }
        var result = $(this).hasClass("bg-info");
        // alert(result);
        if (result == true) {
            $(this).removeClass("bg-info");
        }
        $(this).css('background','#d4f5ff')
        $(this).siblings().css('background','#fff');
    });
    $('.appointment-list-item').on('click', function() {
        $(".message-body").remove();
        var message_id = $(this).attr('id');
        // alert($(this).attr('id'));
        if (message_id != 0 ) {
            $.post("appointment-details.php", {"message_id":message_id}, function(sonuc){
                // alert($(this).val());
                $(".message-view").html(sonuc);
            });
        }
        var result = $(this).hasClass("bg-info");
        // alert(result);
        if (result == true) {
            $(this).removeClass("bg-info");
        }
        $(this).css('background','#d4f5ff')
        $(this).siblings().css('background','#fff');
    });
    $('.cancelled-appointment-list-item').on('click', function() {
        $(".message-body").remove();
        var message_id = $(this).attr('id');
        // alert($(this).attr('id'));
        if (message_id != 0 ) {
            $.post("cancelled-appointment-details.php", {"message_id":message_id}, function(sonuc){
                // alert($(this).val());
                $(".message-view").html(sonuc);
            });
        }
        var result = $(this).hasClass("bg-info");
        // alert(result);
        if (result == true) {
            $(this).removeClass("bg-info");
        }
        $(this).css('background','#d4f5ff')
        $(this).siblings().css('background','#fff');
    });

    $('.result-list-item').on('click', function() {
        $(".message-body").remove();
        var message_id = $(this).attr('id');
        // alert($(this).attr('id'));
        if (message_id != 0 ) {
            $.post("result-details.php", {"message_id":message_id}, function(sonuc){
                // alert($(this).val());
                $(".message-view").html(sonuc);
            });
        }
        var result = $(this).hasClass("bg-info");
        // alert(result);
        if (result == true) {
            $(this).removeClass("bg-info");
        }
        $(this).css('background','#d4f5ff')
        $(this).siblings().css('background','#fff');
    });


    $('#notification_panel').on('click', function() {
        $("#notification_count").remove();
        $.post("notification_viewed.php",function(sonuc){});
    });


    var ul_sortable = $('.sortable'); //setup one variable for sortable holder that will be used in few places
    ul_sortable.sortable({
        revert: 100,
        placeholder: 'placeholder'
    });
    ul_sortable.disableSelection();
    var btn_save = $('button.save'), // select save button
        div_response = $('#response'); // response div

    btn_save.on('click', function(e){ // trigger function on save button click
        e.preventDefault(); 
        var sortable_data = ul_sortable.sortable('serialize'); // serialize data from ul#sortable
        div_response.text( 'Kaydediliyor...' ); //setup response information

        $.ajax({ //aja
            data: sortable_data,
            type: 'POST',
            url: 'gallery-process-sortable.php', // save.php - file with database update
            success:function(result) {
                div_response.text( 'Sıralama kaydedildi' );
            }
        });
     
    });

    var ul_sortable2 = $('.sortable-2'); //setup one variable for sortable holder that will be used in few places
    ul_sortable2.sortable();
    ul_sortable2.disableSelection();
    var btn_save2 = $('button.product-save'), // select save button
        div_response2 = $('#response2'); // response div
    btn_save2.on('click', function(e){ // trigger function on save button click
        e.preventDefault(); 

        var sortable_data2 = ul_sortable2.sortable('serialize'); // serialize data from ul#sortable

        div_response2.text( 'Kaydediliyor...' ); //setup response information

        $.ajax({ //aja
            data: sortable_data2,
            type: 'POST',
            url: 'picture-process-sortable.php', // save.php - file with database update
            success:function(result) {
                div_response2.text( 'Sıralama kaydedildi' );
            }
        });
     
    });

    var ul_sortable3 = $('.sortable-3'); //setup one variable for sortable holder that will be used in few places
    ul_sortable3.sortable({
        revert: 100,
        placeholder: 'placeholder'
    });
    ul_sortable3.disableSelection();
    var btn_save3 = $('button.services-save'), // select save button
        div_response3 = $('#response3'); // response div
    btn_save3.on('click', function(e){ // trigger function on save button click
        e.preventDefault(); 

        var sortable_data3 = ul_sortable3.sortable('serialize'); // serialize data from ul#sortable

        div_response3.text( 'Kaydediliyor...' ); //setup response information

        $.ajax({ //aja
            data: sortable_data3,
            type: 'POST',
            url: 'services-process-sortable.php', // save.php - file with database update
            success:function(result) {
                div_response3.text( 'Sıralama kaydedildi' );
            }
        });
     
    });

    var ul_sortable4 = $('.sortable-4'); //setup one variable for sortable holder that will be used in few places
    ul_sortable4.sortable({
        revert: 100,
        placeholder: 'placeholder'
    });
    ul_sortable4.disableSelection();
    var btn_save4 = $('button.about-save'), // select save button
        div_response4 = $('#response4'); // response div
    btn_save4.on('click', function(e){ // trigger function on save button click
        e.preventDefault(); 

        var sortable_data4 = ul_sortable4.sortable('serialize'); // serialize data from ul#sortable
        div_response4.text( 'Kaydediliyor...' ); //setup response information

        $.ajax({ //aja
            data: sortable_data4,
            type: 'POST',
            url: 'about-process-sortable.php', // save.php - file with database update
            success:function(result) {
                div_response4.text( 'Sıralama kaydedildi' );
            }
        });
     
    });

    var ul_sortable5 = $('.sortable-5'); //setup one variable for sortable holder that will be used in few places
    ul_sortable5.sortable({
        revert: 100,
        placeholder: 'placeholder'
    });
    ul_sortable5.disableSelection();
    var btn_save5 = $('button.about-doc-save'), // select save button
        div_response5 = $('#response5'); // response div
    btn_save5.on('click', function(e){ // trigger function on save button click
        e.preventDefault(); 
        var sortable_data5 = ul_sortable5.sortable('serialize'); // serialize data from ul#sortable
        div_response5.text( 'Kaydediliyor...' ); //setup response information

        $.ajax({ //aja
            data: sortable_data5,
            type: 'POST',
            url: 'about-docs-sortable.php', // save.php - file with database update
            success:function(result) {
                div_response5.text( 'Sıralama kaydedildi' );
            }
        });
    });

    var ul_sortable6 = $('.sortable-6'); //setup one variable for sortable holder that will be used in few places
    ul_sortable6.sortable({
        revert: 100,
        placeholder: 'placeholder'
    });
    ul_sortable6.disableSelection();
    var btn_save6 = $('button.about-doc-save'), // select save button
        div_response6 = $('#response6'); // response div
    btn_save6.on('click', function(e){ // trigger function on save button click
        e.preventDefault(); 

        var sortable_data6 = ul_sortable6.sortable('serialize'); // serialize data from ul#sortable
        div_response6.text( 'Kaydediliyor...' ); //setup response information

        $.ajax({ //aja
            data: sortable_data6,
            type: 'POST',
            url: 'about-other-docs-sortable.php', // save.php - file with database update
            success:function(result) {
                div_response6.text( 'Sıralama kaydedildi' );
            }
        });
    });
    
    var ul_sortable7 = $('.sortable-7'); //setup one variable for sortable holder that will be used in few places
    ul_sortable7.sortable();
    ul_sortable7.disableSelection();
    var btn_save7 = $('button.category-save'), // select save button
        div_response7 = $('#response7'); // response div
    btn_save7.on('click', function(e){ // trigger function on save button click
        e.preventDefault(); 

        var sortable_data7 = ul_sortable7.sortable('serialize'); // serialize data from ul#sortable

        div_response7.text( 'Kaydediliyor...' ); //setup response information

        $.ajax({ //aja
            data: sortable_data7,
            type: 'POST',
            url: 'picture-process-sortable.php', // save.php - file with database update
            success:function(result) {
                div_response7.text( 'Sıralama kaydedildi' );
            }
        });
     
    });
    var ul_sortable9 = $('.sortable-9'); //setup one variable for sortable holder that will be used in few places
    ul_sortable9.sortable();
    ul_sortable9.disableSelection();
    var btn_save9 = $('button.category-save'), // select save button
        div_response9 = $('#response9'); // response div
    btn_save9.on('click', function(e){ // trigger function on save button click
        e.preventDefault(); 

        var sortable_data9 = ul_sortable9.sortable('serialize'); // serialize data from ul#sortable

        div_response9.text( 'Kaydediliyor...' ); //setup response information

        $.ajax({ //aja
            data: sortable_data9,
            type: 'POST',
            url: 'picture-process-sortable.php', // save.php - file with database update
            success:function(result) {
                div_response9.text( 'Sıralama kaydedildi' );
            }
        });
     
    });

    var ul_sortable10 = $('.sortable-10'); //setup one variable for sortable holder that will be used in few places
    ul_sortable10.sortable();
    ul_sortable10.disableSelection();
    var btn_save10 = $('button.category-save'), // select save button
        div_response10 = $('#response10'); // response div
    btn_save10.on('click', function(e){ // trigger function on save button click
        e.preventDefault(); 

        var sortable_data10 = ul_sortable10.sortable('serialize'); // serialize data from ul#sortable

        div_response10.text( 'Kaydediliyor...' ); //setup response information

        $.ajax({ //aja
            data: sortable_data10,
            type: 'POST',
            url: 'picture-process-sortable.php', // save.php - file with database update
            success:function(result) {
                div_response10.text( 'Sıralama kaydedildi' );
            }
        });
     
    });


    var ul_sortable8 = $('.sortable-8'); //setup one variable for sortable holder that will be used in few places
    ul_sortable8.sortable();
    ul_sortable8.disableSelection();
    var btn_save8 = $('button.category-save'), // select save button
        div_response8 = $('#response8'); // response div
    btn_save8.on('click', function(e){ // trigger function on save button click
        e.preventDefault(); 

        var sortable_data8 = ul_sortable8.sortable('serialize'); // serialize data from ul#sortable

        div_response8.text( 'Kaydediliyor...' ); //setup response information

        $.ajax({ //aja
            data: sortable_data8,
            type: 'POST',
            url: 'treatments-process-sortable.php', // save.php - file with database update
            success:function(result) {
                div_response8.text( 'Sıralama kaydedildi' );
            }
        });
     
    });
    tinymce.init({
		selector: '.mytextarea',
		plugins: 'advlist autolink link lists charmap print preview media textcolor hr table image code powerpaste',
		toolbar: 'undo redo | insert | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent hr | link image table code ',
		powerpaste_word_import: "prompt",
		menubar: false,
		min_height: 300,
        entity_encoding : "raw",
		// enable title field in the Image dialog
		image_title: true, 
		// enable automatic uploads of images represented by blob or data URIs
		automatic_uploads: true,
		// URL of our upload handler (for more details check: https://www.tinymce.com/docs/configure/file-image-upload/#images_upload_url)
		images_upload_url: 'postAcceptor.php',
		// here we add custom filepicker only to Image dialog
		file_picker_types: 'image', 
		// and here's our custom image picker
		file_picker_callback: function(cb, value, meta) {
		var input = document.createElement('input');
		input.setAttribute('type', 'file');
		input.setAttribute('accept', 'image/*');

		input.onchange = function() {
		  var file = this.files[0];
		  
		  var reader = new FileReader();
		  reader.readAsDataURL(file);
		  reader.onload = function () {
		 
		    var id = 'blobid' + (new Date()).getTime();
		    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
		    var base64 = reader.result.split(',')[1];
		    var blobInfo = blobCache.create(id, file, base64);
		    blobCache.add(blobInfo);

		    // call the callback and populate the Title field with the file name
		    cb(blobInfo.blobUri(), { title: file.name });
		  };
		};
		input.click();
		}
	});

   ///Kategori - Yazar //

    var postSelect = $('#post_category_select').val();

    if(postSelect == '3') {
        $('#writer').show();
    } else {
        // If it's not, hide it.
        $('#writer').hide();
    }
    $('#post_category_select').change(function() {
        if($(this).val() == '3') {
            $('#writer').show();
        } else {
            $('#writer').hide();
        }
    });

});