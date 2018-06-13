<!-- #PLUGINS -->
		<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
		
        <!-- IMPORTANT: APP CONFIG -->
		<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/app.config.js"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
		<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 

		<!-- BOOTSTRAP JS -->
		<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/bootstrap/bootstrap.min.js"></script>

		<!-- CUSTOM NOTIFICATION -->
		<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/notification/SmartNotification.min.js"></script>

		<!-- JARVIS WIDGETS -->
		<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/smartwidgets/jarvis.widget.min.js"></script>

		<!-- EASY PIE CHARTS -->
		<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

		<!-- SPARKLINES -->
		<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/plugin/sparkline/jquery.sparkline.min.js"></script>

		<!-- JQUERY VALIDATE -->
		<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/plugin/jquery-validate/jquery.validate.min.js"></script>

		<!-- JQUERY MASKED INPUT -->
		<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

		<!-- JQUERY SELECT2 INPUT -->
		<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/plugin/select2/select2.min.js"></script>
        
        <script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/jquery.timepicker.js"></script>
        <script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/clockpicker.min.js"></script>

		
		<!-- browser msie issue fix -->
		<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

		<!-- FastClick: For mobile devices: you can disable this in app.js -->
		<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/plugin/fastclick/fastclick.min.js"></script>

		<!--[if IE 8]>
			<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
		<![endif]-->
        <script src="<?=base_url()?>public/plugins/jquery-window/jquery.window.min.js"></script>
        
        <!--Number Format-->
<script src="<?=base_url()?>public/plugins/jquery.price_format.2.0.js"></script>
        
		<!-- MAIN APP JS FILE -->
		<script src="<?=base_url()?>public/<?=ADMIN_FOLDER?>/js/app.js"></script>
        
		<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
		
        <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
        <script src="<?=base_url()?>public/plugins/fileupload/vendor/jquery.ui.widget.js"></script>
        <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
        <script src="<?=base_url()?>public/plugins/fileupload/load-image.all.min.js"></script>
        <!-- The Canvas to Blob plugin is included for image resizing functionality -->
        <script src="<?=base_url()?>public/plugins/fileupload/canvas-to-blob.min.js"></script>
        <!-- blueimp Gallery script -->
        <script src="<?=base_url()?>public/plugins/fileupload/jquery.blueimp-gallery.min.js"></script>
        <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
        <script src="<?=base_url()?>public/plugins/fileupload/jquery.iframe-transport.js"></script>
        <!-- The basic File Upload plugin -->
        <script src="<?=base_url()?>public/plugins/fileupload/jquery.fileupload.js"></script>
        <!-- The File Upload processing plugin -->
        <script src="<?=base_url()?>public/plugins/fileupload/jquery.fileupload-process.js"></script>
        <!-- The File Upload image preview & resize plugin -->
        <script src="<?=base_url()?>public/plugins/fileupload/jquery.fileupload-image.js"></script>
        <!-- The File Upload audio preview plugin -->
        <script src="<?=base_url()?>public/plugins/fileupload/jquery.fileupload-audio.js"></script>
        <!-- The File Upload video preview plugin -->
        <script src="<?=base_url()?>public/plugins/fileupload/jquery.fileupload-video.js"></script>
        <!-- The File Upload validation plugin -->
        <script src="<?=base_url()?>public/plugins/fileupload/jquery.fileupload-validate.js"></script>
        <script src="<?=base_url()?>public/plugins/bootstrap-img-upload/js/bootstrap-imgupload.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/plugins/jquery-upload-file/css/uploadfile.custom.css" />
        <script type="text/javascript" src="<?=base_url()?>public/plugins/jquery-upload-file/js/jquery.uploadfile.min.js"></script>

<!-- The main application script -->
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="<?=base_url()?>public/fileupload/fileupload/cors/jquery.xdr-transport.js"></script>
<![endif]-->
<script>
function deleteAction(msg, href) {
	$.SmartMessageBox({
                        "title": "<i class='fa fa-trash' style='color:red'></i> Delete",
                        "content": msg || "Bạn có chắc chấn muốn xóa?",
                        "buttons": "[No][Yes]"
                    }, function(b) {
                        //"Yes" == a && localStorage && (localStorage.clear(), location.reload())
                        if(b=="Yes") window.location.href = href;
                    });
}
function toggleMenu() {
	$.root_.hasClass("menu-on-top") ? $.root_.hasClass("menu-on-top") && $(window).width() < 979 && ($("html").toggleClass("hidden-menu-mobile-lock"), $.root_.toggleClass("hidden-menu"), $.root_.removeClass("minified")) : ($("html").toggleClass("hidden-menu-mobile-lock"), $.root_.toggleClass("hidden-menu"), $.root_.removeClass("minified"))
}
function UploadImage(Elem) {
    // Change this to the location of your server-side upload handler:
    var url = base_url + '<?=ADMIN_FOLDER?>/ajax/Upload/'+Elem,
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
    $('#' + Elem + 'upload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: <?=MAX_SIZE_UPLOAD?>,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').prop('class', 'thumb').appendTo('#'+Elem+'list');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text());
            /*if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }*/
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        $('#progress').css('display', 'block');
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        console.log(data);
        if(data.error) {
            alert(data.result.error);
            return false;
        } else {
            $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
                
                var input_hidden = $('<input>')
                .prop('type', 'hidden')
                .prop('name', 'images[]')
                .prop('value', file.name);
                $(data.context.children()[index]).append(input_hidden);
                
                var button_delete = '<button class="btn btn-danger btn-trash" data-type="'+file.deleteType+'" data-url="'+file.deleteUrl+'">Xóa</button>';
                $(data.context.children()[index]).append(button_delete);
                
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
            $('#progress').css('display','none');
            //setTimeout(function() {
              //  $('#progress .progress-bar').css({'width':'0'});
            //}, 1500);
        });
        }
        
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
        
    $('#'+Elem+'list').on('click', 'button', function (e) {
      e.preventDefault();
      
      var $link = $(this);
    
      var req = $.ajax({
        dataType: 'json',
        url: $link.data('url'),
        type: 'POST'
      });
    
      req.success(function () { 
        $link.parent().remove();
      });
    });
}



$(function () {
    'use strict';
    var city = $('select[name="city_id"]');
    var district = $('select[name="district_id"]');
    var ward = $('select[name="ward_id"]');
    var street = $('select[name="street_id"]');
    
    //City event
    city.change(function(){
       var selected = city.find('option:selected').val();
       $.ajax({
            url: '<?=admin_url('ajax/loadDistrict')?>',
            type: 'post',
            data: {city_id: selected},
            success: function(data) {
                district.html(data);
                console.log(data);
                $("select.select2").select2();
            }
       });
    });
    
    //District event
    district.change(function(){
       var selected = district.find('option:selected').val();
       $.ajax({
            url: '<?=admin_url('ajax/loadWard')?>',
            type: 'post',
            data: {district_id: selected},
            success: function(data) {
                ward.html(data);
                
                $("select.select2").select2();
            }
       });
    });
    
    //Ward event
    ward.change(function(){
       var selected = ward.find('option:selected').val();
       $.ajax({
            url: '<?=admin_url('ajax/loadStreet')?>',
            type: 'post',
            data: {ward_id: selected},
            success: function(data) {
                street.html(data);
                
                $("select.select2").select2();
            }
       });
    });
    /*$( ".datepicker" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });*/
});
</script>
