<?php
$user = $this->ion_auth->user()->row();
$avatar = $user->avatar;
$fullname = $user->first_name;
?>
<section class="main-content">
<?php $this->load->view('default/require/breadcrumb'); ?>
            <div class="main-wrap-content">
                <div class="pad10">
                    <div class="row">
				<?php $this->load->view('default/user/sidebar'); ?>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="user_main_title">Quản lý tin đăng</div>
                        <div class="property_type">
                        <form class="form-filter" action="" method="get">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Từ ngày</label>
                                <input type="text" class="form-control datepicker" name="from_date" value="<?=$this->input->get('from_date')?>" />
                            </div>
                            <div class="col-md-3">
                                <label>Đến ngày</label>
                                <input type="text" class="form-control datepicker" name="to_date" value="<?=$this->input->get('to_date')?>" />
                            </div>
                            <div class="col-md-3">
                                <label>Loại tin</label>
                                <select class="form-control" name="type">
                                    <option value="">Tất cả</option>
                                    <option value="1" <?php echo $_GET['type']==1 ? 'selected="selected"':''; ?>>Vip đặc biệt</option>
                                    <option value="2" <?php echo $_GET['type']==2 ? 'selected="selected"':''; ?>>Vip 1</option>
                                    <option value="3" <?php echo $_GET['type']==3 ? 'selected="selected"':''; ?>>Vip 2</option>
                                    <option value="4" <?php echo $_GET['type']==4 ? 'selected="selected"':''; ?>>Tin thường</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Trạng thái</label>
                                <select class="form-control" name="status">
                                    <option value="">Tất cả</option>
                                    <option value="hide" <?php echo $_GET['status']=='hide' ? 'selected="selected"':''; ?>>Ẩn</option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Mã tin</label>
                                <input type="text" class="form-control" name="product_id" value="<?=$this->input->get('product_id')?>" />
                            </div>
                            <div class="col-md-9">
                                <label>(Lưu ý khi nhập mã tin thì các bộ lọc khác không có tác dụng)</label><br />
                                <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i>&nbsp;Tìm kiếm</button>
                            </div>
                        </div>
                        </form>
                        <?php if($this->session->flashdata('renew_success')) echo '<div class="alert alert-success">'.$this->session->flashdata('renew_success').'</div>';?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover user-list-product">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;background:#eee;vertical-align: middle;">STT</th>
                                        <th style="text-align: center;background:#eee;vertical-align: middle;">Mã tin</th>
                                        <th style="text-align: center;background:#eee;vertical-align: middle;">Tiêu đề</th>
                                        <th style="text-align: center;background:#eee;vertical-align: middle;">Xem</th>
                                        <th style="text-align: center;background:#eee;vertical-align: middle;">Ngày bắt đầu</th>
                                        <th style="text-align: center;background:#eee;vertical-align: middle;">Ngày kết thúc</th>
                                        <th style="text-align: center;background:#eee;vertical-align: middle;">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(!empty($results)) {
                                    $stt = 1; 
                                    foreach($results as $result) { 
                                    $thumb = $this->main_model->_Get_Real_Estate_Image($result['id']);  
                                    $detail = $this->main_model->_Get_Real_Estate_By_Id($result['id']);  
                                    ?>
            						<tr>
                                        <td style="text-align: center;"><?=$stt?></td>
                                        <td style="text-align: center;">
                                            <?=$detail['id']?><br />
                                            <?php
                                            if($detail['type_id'] == 1)
                                                echo '<span style="color:red;text-transform:uppercase;font-weight:bold;">Vip đặc biệt</span>';
                                            elseif($detail['type_id'] == 2) 
                                                 echo '<span style="color:red;text-transform:capitalize;font-weight:bold;">Vip 1</span>';
                                            elseif($detail['type_id'] == 3)
                                                echo '<span style="color:orange;text-transform:capitalize;font-weight:bold;">Vip2</span>';
                                            else
                                                echo '<span style="color:#015f95;font-weight:bold;">Tin thường</span>';
                                            ?>
                                            <br />
                                            <?php
                                            if($detail['status'] == 'active') echo 'Đang hiển thị';
                                            elseif($detail['status'] == 'hide') echo 'Đang ẩn';
                                            ?>
                                        </td>
                                        <td width="330" style="position: relative;"><img style="float: left;" data-src="<?=base_url('timthumb.php?image='.$thumb.'&w=85&h=70&zc=1')?>" width="85" onerror="this.src='<?=base_url('theme/images/thumb.jpg')?>'" alt="<?=$detail['title']?>" class="lazy-hidden img-responsive">
                                            <div style="float:left;width:220px">
                                                <a href="<?=site_url($detail['alias'])?>"><?=$detail['title']?></a>
                                            </div>
                                            <div class="tools" style="position: absolute;bottom:0;right:5px">
                                                <a href="<?=base_url('trang-ca-nhan/uspg-updateproduct/'.$detail['id'])?>"><i class="fa fa-pencil"></i>&nbsp;Sửa</a> |
                                                <a href="<?=base_url('trang-ca-nhan/uspg-deleteproduct/'.$detail['id'])?>"><i class="fa fa-trash"></i>&nbsp;Xóa</a> |
                                                <a data-href="<?=base_url('trang-ca-nhan/uspg-downproduct/'.$detail['id'])?>"><i class="fa fa-angle-down"></i>&nbsp;Hạ</a>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            <?=$detail['views1']?><br />
                                            <?php if($detail['to_date'] < date("Y-m-d H:i:s", time())) : ?>
                                            <a href="<?=base_url('trang-ca-nhan/uspg-renewproduct/'.$detail['id'])?>"><i class="fa fa-refresh"></i></a>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?=_Format_Date($detail['from_date'])?>
                                        </td>
                                        <td style="text-align: center;"><?=_Format_Date($detail['to_date'])?></td>
                                        <td style="text-align: center;"></td>
                                    </tr>
                                    <?php $stt++; } 
                                    }else{ ?>
                                    <tr>
                                        <td colspan="7" class="center" style="text-align:center">Không có dữ liệu</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
					</div> 
                    <div class="page_indicator">
						<?=$pagination?>
					</div> 
                    </div>
                    
                </div>
                </div>
                
            </div>
        </section>
<script type="text/javascript" src="<?=base_url()?>theme/js/jquery-ui.min.js"></script>
<script type="text/javascript">
$( function() {
    $( ".datepicker" ).datepicker({
        dateFormat: 'dd/mm/yy'
    });
  } );
</script>