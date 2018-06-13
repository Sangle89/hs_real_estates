<section id="widget-grid" class="form-list">

	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <div class="box box-primary">
                <div class="box-header">Quét tin từ trang <strong>Bannharieng.com</strong></div>
                <div class="box-body">
                    
                    <div class="pull-left">
                    <form class="form-inline" method="get" action="">
                        <div class="form-group">
                            <label>Đường dẫn trang</label>
                            <input type="text" name="url" value="<?=$this->input->get('url')?>" size="70" placeholder="Nhập đường dẫn" class="form-control" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Lọc dữ liệu</button>
                        </div>
                    </form>
                    </div>
                    <div class="pull-right">
                        <?php
                        if(!isset($_GET['page'])) {
                            $page = 1;
                        } else {
                            $page = $_GET['page'];
                        }
                        $next_page = $page+1;
                        if(isset($_GET['url'])) {
                            
                            $next_link = '?url='.$_GET['url'].'&page='. $next_page;
                        } else {
                            $next_link = '?page='.$next_page;
                        }
                        ?>
                        <a class="btn btn-warning" href="javascript:saveChecked()">Lưu chọn</a>
                        <a href="<?=current_url().$next_link?>" class="btn btn-primary">Trang kế</a>
                    </div>
                    
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Thông tin cơ bản</th>
                                <th>Tùy chọn</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $count=0; foreach($results as $row) : ?>
                        
                            <tr id="row<?=$count?>" style="position: relative;">
                                <td>
                                    <input type="checkbox" name="link[<?=$count?>]" value="<?=$row['href']?>" />
                                    <input type="hidden" name="image[<?=$count?>]" id="image<?=$count?>" value="<?=$row['image']?>" />
                                </td>
                                <td><img src="<?=$row['image']?>" width="50"></td>
                                <td><a href="<?=$row['href']?>" target="_blank"><?=$row['title']?></a></td>
                                <td>
                                    Giá: <?=$row['price_number'].' '.$row['price_unit']?><br />
                                    Diện tích: <?=$row['area']?><br />
                                    Địa chỉ: Quận <?=$row['district']?> Tình thành <?=$row['city']?><br />
                                    Ngày đăng: <?=$row['date']?>
                                </td>
                                <td><a class="btn btn-sm btn-primary" href="javascript:savePost(<?=$count?>,'<?=$row['href']?>', '<?=$row['image']?>')"><i class="fa fa-save"></i></a>&nbsp;<a class="btn btn-sm btn-danger" href="javascript:removeRow(<?=$count?>)"><i class="fa fa-trash"></i></a>
                                    <label style="position: absolute;left:0;bottom:0;display: none;text-align: center;width:100%;height:100%;background:#000;opacity: .6;color:#fff;" id="loading<?=$count?>">Đang lưu...</label>
                                </td>
                            </tr>
                        
                        <?php $count++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
		</article>
		<!-- WIDGET END -->

	</div>

	<!-- end row -->

	<!-- row -->


</section>
<script>
function removeRow(ID) {
    $('#row'+ID).remove();
}
function savePost(ID, Href, Img) {
    $('#loading'+ID).show();
    $.ajax({
        url: '<?=admin_url('ajax/save_post')?>',
        type: 'post',
        data: {href: Href, img: Img},
        dataType: 'json',
        success: function(res) {
            if(res.success == false) {
                alert('Tin bị trùng!');
            } else {
                alert('Đã Lưu thành công!');
            }    
            $('#loading'+ID).hide();
                removeRow(ID);        
        }
    })
}
function saveChecked() {
    $('input[type="checkbox"]').each(function(ID, Href) {
        if($(this).prop('checked')) {
            $('#loading'+ID).show();
            var Img = $('#image'+ID).val();
            $.ajax({
                url: '<?=admin_url('ajax/save_post')?>',
                type: 'post',
                data: {href: $(this).attr('value'),img: Img},
                dataType: 'json',
                success: function(res) {
                    if(res.success == false) {
                        alert('Tin bị trùng!');
                    } else {
                        alert('Đã Lưu thành công!');
                    }    
                    $('#loading'+ID).hide();
                    removeRow(ID);        
                },
                error: function() {
                    alert('Error');
                    $('#loading'+ID).hide();
                    
                }
            });
        }
    })
}
</script>