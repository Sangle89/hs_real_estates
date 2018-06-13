<p><!-- BEGIN Main Container -->  
<div class="main-container col2-right-layout">
    <div class="main container"> 
        <div class="row">                        
            <div class="col-sm-12 bounceInUp animated">
                <div class="col-main">
                    <div id="main" class="blog-wrapper">
                    	<div id="primary" class="site-content">
                    		<div id="content" role="main">
                            <style type="text/css">
.h2-title {
clear: both;
color: #055699;
font-size: 16px;
font-weight: 700;
line-height: normal;
margin: 20px 0 10px;
}  
.rss-content {
}
.rss-content ul{
padding: 5px;
margin: 5px;
list-style: none;
}
.rss-content ul li 
{
clear: both;
padding-top: 5px;
padding-bottom: 5px;   
color: #555;
}
.rss-content ul li:hover {
background-color: #ededed;     
}
.rss-content .div-title {
clear: both;
float: left;
width: 220px;
}
.rss-content .div-link
{
width: 430px;
float: left;
font-weight: normal;
}
.rss-content .div-link a{ color: #055699;text-decoration: underline;}
.rss-content .div-right
{
width: 280px;
float: right;
}
li.level_1{ padding-left: 10px;  font-weight: bold;}
li.level_2{ padding-left: 20px;}
li.level_3{ padding-left: 30px;}
li.level_4{ padding-left: 40px;}
.level_1 .div-link{ padding-left: 10px; }
.rss-content h3{
color: #055699;
font-size: 16px;
padding: 5px 0;
}
.rss-intro ul {
list-style: none;
padding-left: 20px;
}
</style>
                                <h1 class="h2-title">RSS của muonnha.com.vn</h1>
                                <div class="rss-intro">
                                <ul>
                                <li>1. Rss là gì?</li>
                                <li>2. Chương trình đọc RSS là gì?</li>
                                <li>3. Các kênh RSS mà muonnha.com.vn cung cấp</li>
                                </ul>
                                </div>
                                <h2 class="h2-title">RSS là gì?</h2>
                                RSS (Really Simple Syndication) là định dạng dữ liệu dựa theo chuẩn XML được sử dụng để chia sẻ và phát tán nội dung Web. Việc sử dụng các chương trình đọc tin (News Reader, RSS Reader hay RSS Feeds) sẽ giúp bạn luôn xem được nhanh chóng tin tức mới nhất từ muonnha.com.vn
                                Mỗi tin dưới dạng RSS sẽ gồm : Tiêu đề, tóm tắt nội dung và đường dẫn đến trang chứa nội dung đầy đủ của tin.
                                <h2 class="h2-title">Chương trình đọc RSS là gì?</h2>
                                Rss Reader là phần mềm có chức năng tự động lấy tin tức đã được cấu trúc theo định dạng RSS. Một số phần mềm đọc RSS cho phép bạn lập lịch cập nhật tin tức. Với chương trình đọc RSS, bạn có thể nhấn chuột vào tiêu đề của 1 tin để đọc phần tóm tắt của hoặc mở ra nội dung của toàn bộ tin trong một cửa sổ trình duyệt mặc định.
                                Sử dụng chương trình đọc RSS (RSS Reader)<br><br>
                                1. Chép (copy) đường dẫn (URL) tương ứng với kênh RSS mà bạn ưa thích.<br>
                                2. Dán (paste) URL vào chương trình đọc RSS.<br>

                    			<h2 class="h2-title">Các kênh Rss của tin rao</h2>
                                <table class="table">
                                    <tbody>
                                    <?php
                                    $categories = $this->main_model->_Get_Real_Estate_Category();
                                    foreach($categories as $cat) :    
                                    ?>
                                    <tr class="level1">
                                        <td><strong><?php echo $cat['title']?></strong></td>
                                        <td><a href="<?php echo site_url('rss/detail?catid='.$cat['id'].'&type=1')?>" target="_blank"><?php echo site_url('rss/detail?catid='.$cat['id'].'&type=1')?></a></td>
                                    </tr>
                                        <?php
                                        $child_categories = $this->main_model->_Get_Real_Estate_Category($cat['id']);
                                        foreach($child_categories as $sub) :
                                        ?>
                                        <tr class="level2">
                                            <td width="40%">&nbsp;&nbsp;&nbsp;<?php echo $sub['title']?></td>
                                            <td><a href="<?php echo site_url('rss/detail?catid='.$sub['id'].'&type=1')?>" target="_blank"><?php echo site_url('rss/detail?catid='.$sub['id'].'&type=1')?></a></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <h2 class="h2-title">Các kênh Rss của tin tức</h2>
                                <table class="table">
                                    <tbody>
                                    <?php
                                    $categories = $this->main_model->_Get_Content_Category();
                                    foreach($categories as $cat) :    
                                    ?>
                                    <tr class="level1">
                                        <td><strong><?php echo $cat['title']?></strong></td>
                                        <td><a href="<?php echo site_url('rss/detail?catid='.$cat['id'].'&type=2')?>"><?php echo site_url('rss/detail?catid='.$cat['id'].'&type=2')?></a></td>
                                    </tr>
                                        
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <h2 class="h2-title">Các kênh Rss của dự án</h2>
                                <table class="table">
                                    <tbody>
                                    <?php
                                    $categories = $this->main_model->_Get_Project();
                                    foreach($categories as $cat) :    
                                    ?>
                                    <tr class="level1">
                                        <td width="40%"><strong><?php echo $cat['title']?></strong></td>
                                        <td><a href="<?php echo site_url('rss/detail?catid='.$cat['id'].'&type=3')?>" target="_blank"><?php echo site_url('rss/detail?catid='.$cat['id'].'&type=3')?></a></td>
                                    </tr>
                                        
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>			
                    		</div>
                    	</div>
                    </div> <!--#main wrapper grid_8-->
                </div> <!--col-main-->
            </div> <!--col-sm-8-->
        </div>    
    </div><!--main-container-->
</div> <!--col2-layout--></p>