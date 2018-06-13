<html>
<body>
    <p>Chào bạn <?=$identity?></p>
    <p>Cảm ơn bạn đã đăng ký làm thành viên của muonnha.com.vn.</p>
<p>Để kích hoạt tài khoản, bạn vui lòng kích vào đường dẫn dưới đây (hoặc sao chép và dán vào thanh địa chỉ của trình duyệt) : <?=site_url('user/activate/'. $id .'/'. $activation)?>
<p><?=anchor('user/activate/'. $id .'/'. $activation, lang('email_activate_link'))?></p>
Thông tin tài khoản của bạn:<br />
•	Tên đăng nhập: <?=$identity?><br />
Xin vui lòng liên lạc với chúng tôi nếu Quý khách cần thêm thông tin.</p>
<p>
<span style="color: red;">*</span> Đây là email tự động. Việc hồi âm cho địa chỉ email này sẽ không được ghi nhận.
</p>
<p>
Trân trọng<br />
<strong>Phòng Dịch Vụ Khách Hàng</strong><br />
muonnha.com.vn <br />
muonnha.com.vn@gmail.com<br />
<img src="<?=base_url('theme/images/logo.png')?>">
</p>
</body>
</html>