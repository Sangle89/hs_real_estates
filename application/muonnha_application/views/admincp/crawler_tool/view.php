<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?=form_open_multipart()?>
            <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    <select class="form-control" id="listCategory">
                        <option value="">Chọn danh mục</option>
                        <option value="cho-thue-phong-tro">Cho thuê phòng trọ</option>
                        <option value="nha-cho-thue">Nhà cho thuê</option>
                        <option value="cho-thue-can-ho">Cho thuê căn hộ</option>
                        <option value="cho-thue-mat-bang">Cho thuê mặt bằng</option>
                        <option value="tim-nguoi-o-ghep">Tìm người ở ghép</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" id="listPages">
                        <option value="0">--Chọn số trang--</option>
                        <option value="1">1 Trang</option>
                        <option value="2">2 Trang</option>
                        <option value="3">3 Trang</option>
                        <option value="4">4 Trang</option>
                        <option value="5">5 Trang</option>
                        <option value="6">6 Trang</option>
                        <option value="7">7 Trang</option>
                        <option value="8">8 Trang</option>
                        <option value="9">9 Trang</option>
                        <option value="10">10 Trang</option>
                        <option value="11">11 Trang</option>
                        <option value="12">12 Trang</option>
                        <option value="13">13 Trang</option>
                        <option value="14">14 Trang</option>
                        <option value="15">15 Trang</option>
                        <option value="16">16 Trang</option>
                        <option value="17">17 Trang</option>
                        <option value="18">18 Trang</option>
                        <option value="19">19 Trang</option>
                        <option value="20">20 Trang</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-danger" id="btnGetLink">Lấy danh sách link</button>
                </div>
            </div>
            
            </div>
            <div class="form-group">
                <label>Nhập danh sách link</label>
                <textarea class="form-control" rows="10" id="listLinks"></textarea>
                <div id="listL"></div>
            </div>
            <button type="button" class="btn btn-primary" id="btnImport">Start Import</button>
            <?=form_close()?>
		</article>
	</div>
<script>
$(document).ready(function() {
    
    $('#btnGetLink').on('click', function() {
        var cat = $('#listCategory').find('option:selected').val();
        var page = $('#listPages').find('option:selected').val();
        if(cat != '') {
            $('#btnGetLink').attr('disabled', 'desabled').text('Loading...');
            $.ajax({
                url: '<?=admin_url('crawler_tool/start_crawler')?>',
                type: 'post',
                dataType: 'json',
                data: {pathname: cat, page: page},
                success: function(res) {
                    console.log(res)
                    $('#listLinks').text(res.content)
                    $('#btnGetLink').removeAttr('disabled').text('Lấy danh sách link');
                }
            })
        }
    });
    $('#btnImport').on('click', function() {
        if($('#listLinks').val() == '') {
            alert('Bạn phải lấy danh sách link trước!');
        } else {
            var arrLinks = document.getElementById("listLinks").value.split("\n");
            var cat = $('#listCategory').find('option:selected').val();
            var total = arrLinks.length;
            var start = 0;
            $.each(arrLinks, function(key, value) {
                $('#btnImport').attr('disabled', 'desabled').text('Đang import...');
                $.ajax({
                    url: '<?=admin_url('crawler_tool/crawler')?>',
                    type: 'post',
                    dataType: 'json',
                    async:true,
                    data: {url: value, index: key, category_alias: cat},
                    success: function(res) {
                        start+=1;
                        $('#btnImport').removeAttr('disabled').text('Imported ' + start);
                    }
                })
            });
        }
    });
})
</script>