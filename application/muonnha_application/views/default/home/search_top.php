<style>
.search_top{
    background: url(<?=base_url('theme')?>/images/bg_search.jpg) #ddd;
    text-align: center;
    height: 444px;
    display: table;
    width:100%;
}
.search_top .main-wrap-content{
    display: table-cell;
    vertical-align: middle;
}
.search_top .input-group{
    width: 50%;
    margin-left: 25%;
    border:1px solid #ddd;
    padding: 2px;
    background:#fff;
}
.search_top .search_title{
    font-size:30px;
    margin: 15px 0;
    text-align: center;
    font-weight:bold;
    color:#38a345;
}
.search_top .input-group input[type="text"]{
    font-size:15px;
    border:0;
}
.search_top .input-group-addon.btn-search{
    background:#ffffff;
    border:0;
    cursor: pointer;
}
.search_top .input-group-addon:last-child{
    background:#38a345;
    color:#fff;
    font-size: 14px;
    cursor: pointer;
}
</style>
<section class="search_top">
    <div class="main-wrap-content">
        <div class="search_title">Tìm thuê nhà cùng Muonnha.com.vn</div>
        <div class="input-group input-group-lg">
          <input type="text" class="form-control" placeholder="Nhập địa chỉ, tên đường..." id="search_input" aria-describedby="basic-addon1">
          <span class="input-group-addon btn-search" id="basic-addon1"><i class="fa fa-search"></i></span>
          <span class="input-group-addon btn-advance" id="basic-addon2">Nâng cao</span>
        </div>
    </div>
</section>