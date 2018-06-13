<li id="Image<?=$cache_id?>">
<div class="btn btn-large btn-primary" type="button">
<p id="uploadImage<?=$cache_id?>">
	<?php if($value!='') : ?>
    <img src="<?=base_url('uploads/'.$folder_upload.'/'.$value)?>" style="max-height: 100%;max-width: 100%;"><br>
    <span>Chọn ảnh khác</span>
	<?php else: ?>
	<img src="<?=base_url('assets/images/bg-upload-image.png')?>"  style="max-height: 100%;max-width: 100%;"><br>
    <span>Click để upload ảnh</span>
	<?php endif; ?>
</p>
<a onclick="removeImage('<?=$cache_id?>');" class="remove_image" title="Xóa ảnh"><i class="fa fa-times"></i></a>
</div>
<input type="hidden" id="valueImage<?=$cache_id?>" name="<?=$name?>" value="<?=$value?>">
<div id="progressOuterImage<?=$cache_id?>" class="progress progress-striped active" style="display:none;">
    <div id="progressBarImage<?=$cache_id?>" class="progress-bar progress-bar-success"  role="progressBarImage" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
</div>
<div id="msgBoxImage<?=$cache_id?>"></div>
<script type="text/javascript">
var btn = document.getElementById('uploadImage<?=$cache_id?>'),
      progressBar = document.getElementById('progressBarImage<?=$cache_id?>'),
      progressOuter = document.getElementById('progressOuterImage<?=$cache_id?>'),
      msgBox = document.getElementById('msgBoxImage<?=$cache_id?>');
    var uploader = new ss.SimpleUpload({
        button: btn,
        url: ADMIN_URL + '/common/uploadBannerAdv',
        name: 'uploadfile',
        allowedExtensions: ["jpg", "jpeg", "png", "gif", "JPG", "JPEG", "PNG", "GIF"],
        multipart: true,
        maxSize: 3072, // 3Mb
        hoverClass: 'hover',
        focusClass: 'focus',
        responseType: 'json',
        startXHR: function() {
            progressOuter.style.display = 'block'; // make progress bar visible
            this.setProgressBar( progressBar );
        },
        onExtError( filename, extension ) {
            alert('Định dạng file không hỗ trợ, vui lòng chọn hình ảnh có định dạng jpg|jpeg|png|gif.');
        },
        onSizeError( filename, fileSize ) {
            alert('Dung lượng file upload tối đa là 3Mb.');
        },
        onSubmit: function() {
            //msgBox.innerHTML = ''; // empty the message box
            //btn.innerHTML = 'Uploading...'; // change button text to "Uploading..."
          },
        onComplete: function( filename, response ) {
            //btn.innerHTML = 'Choose Another File';
            progressOuter.style.display = 'none'; // hide progress bar when upload is completed
            
            if ( response.success === true ) {
                //msgBox.innerHTML = '<strong>' + ( filename ) + '</strong>' + ' successfully uploaded.';
                $('#uploadImage<?=$cache_id?> img').attr( 'src', response.file_url );
                $('#uploadImage<?=$cache_id?> span').text('Chọn ảnh khác');
                $('#valueImage<?=$cache_id?>').val(response.file_name);
            } else {
                if ( response.msg )  {
                    msgBox.innerHTML = ( response.msg );
                } else {
                    msgBox.innerHTML = 'An error occurred and the upload failed.';
                }
            }
          },
          onError( filename, errorType, status, statusText, response, uploadBtn, fileSize ) {
            progressOuter.style.display = 'none';
            alert(statusText);
            //msgBox.innerHTML = 'Unable to upload file 1';
          }
});
function removeImage(ElemID) {
  
    if($('#valueImage'+ElemID).val() != '') {
        $.ajax({
         url: ADMIN_URL + '/common/deleteBannerAdv/' + $('#valueImage'+ElemID).val(),
         type: 'get',
         success: function() {
              $('#uploadImage<?=$cache_id?> img').attr('src', '<?=base_url('assets/images/bg-upload-image.png')?>');
			  $('#uploadImage<?=$cache_id?> span').text('Click để upload ảnh');
         } ,
         onError: function() {
            alert('Error');
         }
      });
    }

    //$('#Image'+ElemID).remove();
    //if(num_image > 0) num_image--;
    /**/
}
</script>
</li>