<section class="main-content">
<?php $this->load->view('default/require/breadcrumb'); ?>
            <div class="main-wrap-content">
                <div class="pad10">
                <div class="row">
                    <?php $this->load->view('default/user/sidebar'); ?>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="user_main_title">Tin nhắn</div>
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Nội dung</th>
                                    <th>Ngày gửi</th>
                                    <th>Tùy chọn</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(empty($results)) : ?>
                            <tr>
                                <td colspan="6" align="center">Bạn chưa có tin nhắn.</td>
                            </tr>
                            <?php else: 
                            $stt = 1;
                            foreach($results as $row):
                            ?>
                            <tr>
                                <td><?=$stt?></td>
                                <td><?=$row['fullname']?></td>
                                <td><?=$row['email']?></td>
                                <td><?=$row['phone']?></td>
                                <td><?=$row['message']?></td>
                                <td><?=$row['create_time']?></td>
                                <td>
                                <a href="<?=base_url('trang-ca-nhan/uspg-view-message/'.$row['id'])?>"><i class="fa fa-eye"></i> Xem</a>&nbsp;
                                <a onclick="return confirmDelete();" href="<?=base_url('trang-ca-nhan/uspg-delete-message/'.$row['id'])?>"><i class="fa fa-trash"></i> Xóa</a></td>
                            </tr>
                            <?php $stt++;
                            endforeach;
                             endif ?>
                            </tbody>
                        </table>
                        
                        <?=$pagination?>
                    </div>
                    
                </div>
                </div>
                
            </div>
        </section>