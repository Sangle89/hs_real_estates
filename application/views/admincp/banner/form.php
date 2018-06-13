<script src="<?=base_url()?>assets/plugins/ajaxupload/SimpleAjaxUploader.min.js"></script>
<?php
$title = isset($post['title']) ? $post['title'] : '';
$link = isset($post['link']) ? $post['link'] : '';
$type = isset($post['type']) ? $post['type'] : 'image';
$adsense = isset($post['adsense']) ? $post['adsense'] : '';
$html5 = isset($post['html5']) ? $post['html5'] : '';
$content_cat_id = isset($post['content_cat_id'])?$post['content_cat_id']:0;
$position = isset($post['position']) ? $post['position'] : '';
$image_value = isset($post['image']) ? $post['image'] : '';
$image_show = isset($post['image']) && $post['image']!="" ? '<img width="100" src="'.base_url('uploads/slides/thumb/'.$post['image']).'"><a href="javascript:;" onclick="deleteImage();">Xóa</a>':'';
$sort_order = isset($post['sort_order']) ? $post['sort_order'] : $this->category->_Get_Max_Sort_Order() + 1;
$status = isset($post['status']) ? $post['status'] : 'active';
?>
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?=$heading_title?></h3>
                </div>
                <?php 
                if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
             
                $action = $this->uri->segment(3) == 'add' ? admin_url($this->uri->segment(2) . '/add/') : admin_url($this->uri->segment(2) . '/change/' . $this->uri->segment(4));
                echo form_open_multipart($action, array('method'=>'post','id'=>'myForm', 'class'=>'smart-form', 'role'=>'form')); 
                
                //Vietnamese
                $this->table->add_row(
                    array('data'=>'Tiêu đề', 'width' => '15%'),
                    array('data' => _Input('title', $title).form_error('title'))
                );
                $type_option = array(
                    'image' => 'Hình ảnh',
                    'adsense' => 'Google Adsense',
                    'html5' => 'HTML5'
                );
                $this->table->add_row(
                    array('data'=>'Loại banner', 'width' => '15%'),
                    array('data' => _Dropdown('type', $type_option, $type))
                );
                $this->table->add_row('Vị trí', _Dropdown('position', array(
                   1 => 'Home Top 3 (206x118px)',
                   2 => 'Trang chủ 1 (100%)',
                   16 => 'Trang chủ 2 (100%)',
                   3 => 'Bên trái (100x300px)',
                   4 => 'Bên phải (100x300px)',
                   5 => 'Sidebar 1 (425x250)',
                   10 => 'Sidebar 2 (425x...)',
                   6 => 'Chi tiết tin rao, dưới slide hình (585x90)',
                   7 => 'Chi tiết tin rao, dưới lưu ý (336x280)',
                   8 => 'Trên footer (980x90)',
                   9 => 'Danh sách tin rao (585x90)',
                   11 => 'News Sitebar 1',
                   12 => 'News Sitebar 2',
                   13 => 'News Sitebar 3',
                   14 => 'News Detail Bottom',
                   15 => '3 banner detail kinh nghiệm'
                   ),
                   
                   $position
                ));
                $cat_option = array(
                    0 => '--Chọn nhóm tin tức--',
                    1 => 'Kinh nghiệm',
                    2 => 'Kinh nghiệm đi thuê nhà',
                    3 => 'Kinh nghiệm cho thuê nhà'
                );
                $this->table->add_row(
                    array('data'=>'Nhóm tin tức', 'width' => '15%'),
                    array('data' => _Dropdown('content_cat_id', $cat_option, $content_cat_id))
                );
                $this->table->add_row(
                    array('data'=>'Liên kết', 'width' => '15%'),
                    array('data' => _Input('link', $link))
                );
                $this->table->add_row(
                    array(
                        'Hình ảnh',
                        '<ul class="upload_multi_image">'.$image_template.'<li></li></ul>'
                    )
                );
                $this->table->add_row(
                    array('data'=>'Google Adsense code<br><i>chỉ nhập khi loại banner là Adsense</i>', 'width' => '15%'),
                    array('data' => _Textarea('adsense', $adsense))
                );
                $this->table->add_row(
                    array('data'=>'Link HTML5<br><i>chỉ nhập khi loại banner là HTML5</i>', 'width' => '15%'),
                    array('data' => _Input('html5', $html5))
                );
                $this->table->add_row(array(
                    array('data'=>'Thứ tự', 'width'=>'15%'),
                    _Input('sort_order', $sort_order)
                ));  
                $this->table->add_row(array(
                    'Trạng thái',
                    _Status('status', $status)
                ));
                echo '<div class="box-body">';
                echo $this->table->generate();
                echo '</div>';
                echo '<div class="box-footer">';
                echo _Submit('save', 'Lưu lại', 'save');
                echo '</div>';
                echo form_close(); 
                ?>
            </div>
            
		</article>
	</div>

<script type="text/javascript">

</script>