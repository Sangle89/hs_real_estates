<section class="main-content">
<?php $this->load->view('default/require/breadcrumb'); ?>
            <div class="main-wrap-content">
                <div class="pad10">
                <div class="row">
                    <?php $this->load->view('default/user/sidebar'); ?>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="user_main_title">Cập nhật thông tin</div>
                        <div class="form-dangky">
                            <form method="post" action="" id="formRegister" enctype="multipart/form-data">
                                <?php 
                                if($this->session->flashdata('message')) echo '<div class="alert alert-success">'.$this->session->flashdata('message').'</div>';
                                ?>
                                <h3>Thông tin cá nhân</h3>
                                <?=validation_errors()?>
                                <table class="">
                                    <tr>
                                        <td>Họ tên <span class="required">(*)</span></td>
                                        <td><?=form_input($first_name)?>
                                        <label id="error_fullname" class="error"></label>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Di động <span class="required">(*)</span></td>
                                        <td><?=form_input($mobiphone)?>
                                        <label id="error_mobiphone" class="error"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Số điện thoại</td>
                                        <td><?=form_input($telephone)?></td>
                                    </tr>
                                    <tr>
                                        <td>Công ty</td>
                                        <td><?=form_input($company)?></td>
                                    </tr>
                                    <tr>
                                        <td>Giới tính</td>
                                        <td>
                                        <label><input type="radio" name="gender" value="1" <?php if($gender==1) echo 'checked="checked"'?> /> Nam</label>
                                        <label><input type="radio" name="gender" value="0" <?php if($gender==0) echo 'checked="checked"'?> /> Nữ</label>
                                        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Địa chỉ <span class="required">(*)</span></td>
                                        <td>
                                            <select class="select2" name="city_id" id="listCity2">
                                                <option value="-1">Tỉnh/thành phố</option>
                                                <?php
                                $all_city = $this->main_model->_Get_City();
                                foreach($all_city as $val) { 
                                    if($val['id'] == $city_id) {
                                ?>
								<option value="<?=$val['id']?>" selected="selected"><?=$val['title']?></option>
                                <?php }else{ ?>
                                <option value="<?=$val['id']?>"><?=$val['title']?></option>
                                <?php } ?>
                                <?php } ?>
                                            </select>
                                            <select class="select2" name="district_id" id="listDistrict2">
                                                <option value="-1">Quận/Huyện</option>
                                                <?php 
                                                if($city_id) {
                                                    $districts = $this->main_model->_Get_District($city_id);
                                                    foreach($districts as $district) {
                                                        if($district['id'] == $district_id)
                                                            echo '<option selected value="'.$district['id'].'">'.$district['title'].'</option>';
                                                        else
                                                            echo '<option value="'.$district['id'].'">'.$district['title'].'</option>';
                                                    }
                                                }
                                                ?>
                                                
                                                
                                            </select>
                                            <label id="error_city" class="error"></label>
                                            <label id="error_district" class="error"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bạn là</td>
                                        <td>
                                        <label><input type="radio" name="account_type" value="1" <?php if($gender==1) echo 'checked="checked"'?> /> Cá nhân</label>
                                        <label><input type="radio" name="account_type" value="0" <?php if($gender==0) echo 'checked="checked"'?> /> Doanh nghiệp</label>
                                        
                                        </td>
                                    </tr>
                                </table>
                                
                                <h3>Hình đại diện</h3>
                                <table>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <input type="hidden" name="avatar" value="<?=$avatar?>" id="avatar" />
                                            <?php if($avatar): ?>
                                            <img src="<?=base_url('uploads/avatar/'.$avatar)?>" width="100" />
                                            <?php endif; ?>
                                            <input type="file" name="uploadavatar" />
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td></td>
                                        <td><input type="submit" value="Cập nhật" class="btn btn-primary">
                                        
                                        </td>
                                    </tr>
                                </table>
                                <input type="hidden" name="id" value="<?=$user_id?>" />
                            </form>
                        </div>
                        
                    </div>
                    
                </div>
                </div>
                
            </div>
        </section>