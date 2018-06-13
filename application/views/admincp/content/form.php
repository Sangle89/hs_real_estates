<script src="<?=base_url()?>assets/plugins/ajaxupload/SimpleAjaxUploader.min.js"></script>
<?php
$id = isset($post['id']) ? $post['id'] : '';
$title = isset($post['title']) ? $post['title'] : '';
$meta_title = isset($post['meta_title']) ? $post['meta_title'] : '';
$alias = isset($post['alias']) ? $post['alias'] : '';
$keywords = isset($post['keywords']) ? $post['keywords'] : '';
$description = isset($post['description']) ? $post['description'] : '';
$short_content = isset($post['short_content']) ? $post['short_content'] : '';
$content = isset($post['content']) ? $post['content'] : '';
$category_id = isset($post['category_id']) ? $post['category_id'] : $this->uri->segment(4);
$sort_order = isset($post['sort_order']) ? $post['sort_order'] : $this->content_model->_Get_Max_Sort_Order() + 1;
$status = isset($post['status']) ? $post['status'] : 'active';
$feature = isset($post['feature']) ? $post['feature'] : 0;
$image = isset($post['image']) ? $post['image'] : '';
$string_image = '';
if($image) {
    $string_image .='<div class="ajax-file-upload-statusbar odd">';
                $string_image .= '<img src="'.base_url().'uploads/news/'.$image.'" class="ajax-file-upload-preview" width="100">';
                $string_image .= '<div class="ajax-file-upload-red" style="" onclick="deleteImage(this,\''.$image.'\');">Delete</div>';
                $string_image .= '<input type="hidden" name="image" value="'.$image.'">';
                $string_image .= '</div>';
}
else $string_image = '';
?>
<section id="widget-grid" class="form-add">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
            if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
                $action = $id ==''? admin_url($this->uri->segment(2) . '/add/') : admin_url($this->uri->segment(2) . '/change/' . $id);
                echo form_open_multipart($action, array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
                //Vietnamese
                $this->table->add_row(
                    array('data'=>'Tiêu đề', 'width' => '20%'),
                    array('data' => _Input('title', $title))
                );
                $this->table->add_row(
                    array('data'=>'Meta Title', 'width' => '20%'),
                    array('data' => _Input('meta_title', $meta_title))
                );
                $this->table->add_row(
                    array('data'=>'Alias', 'width' => '20%'),
                    array('data' => '<input type="text" name="alias" id="alias" value="'.$alias.'" class="form-control" onBlur="javascript:update_alias();"/>')
                );
                $this->table->add_row(array(
                    'Từ khóa',
                    _Input('keywords', $keywords)
                ));
                $this->table->add_row(array(
                    'Mô tả từ khóa',
                    _Input('description', $description)
                ));
                $this->table->add_row(
                    array(
                        'Nội dung tóm tắt',
                        _Textarea('short_content', $short_content)
                    )  
                );
                $this->table->add_row(
                    array(
                        'Nội dung',
                        _Textarea('content', $content)
                    )  
                );
                $this->table->add_row(
                    array(
                        'Hình ảnh',
                        '<ul class="upload_multi_image">'.$image_template.'<li></li></ul>'
                    )
                );
                
                $this->table->add_row(array(
                    'Thuộc nhóm danh mục',
                    _Dropdown('category_id', $category, $category_id)
                ));
                
                $this->table->add_row(array(
                    'Thứ tự',
                    _Input('sort_order', $sort_order)
                ));  
                $this->table->add_row(array(
                    'Trạng thái',
                    _Status('status', $status)
                ));
                $this->table->add_row(array(
                    'Nổi bật',
                    form_checkbox('feature', $feature, $feature==1?true:false)
                ));
                echo $this->table->generate();
                echo widget_submit(array(
                    _Submit('save', 'Lưu lại','save').' '.
                    _Submit('save_new', 'Lưu lại & tạo mới','save')
                ));
                echo form_close(); 
                
?>
		</article>
	</div>
</section>
<script src="<?php echo base_url()?>public/ckeditor/ckeditor.js"></script>
<script>
CKEDITOR.replace('content');
</script>
<script>
var current_alias = '<?=$alias?>';
$(document).ready(function() {
   $('input[name="meta_title"]').blur(function(){
        JS_bodau_tv('input[name="meta_title"]', 'input[name="alias"]', 0);
        update_alias();
   }); 
});
function update_alias() {
    var id = <?=$id?>;
    var alias = $('#alias').val();
    if(alias != current_alias) {
        $('#loading').show();
        $.ajax({
            url: '<?=admin_url('ajax/update_alias')?>',
            type: 'post',
            dataType: 'json',
            data: {id: id, alias: alias, table: 'contents'},
            success: function(res) {
                console.log(res);
                if(res.updated==true) current_alias = res.alias;
                $('#loading').hide();
            }
        })   
    }
}
</script>