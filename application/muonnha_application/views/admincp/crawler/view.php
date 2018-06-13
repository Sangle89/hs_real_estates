<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?=form_open_multipart()?>
            <div class="form-group">
            <div class="row">
                <div class="col-md-2">
                    <select class="form-control" name="site">
                        <option value="phongtro123.com" <?=isset($site) && $site=='phongtro123.com' ? 'selected="selected"':''?>>Phongtro123.com</option>
                        <option value="kenhnhatro.com" <?=isset($site) && $site=='kenhnhatro.com' ? 'selected="selected"':''?>>Kenhnhatro.com</option>
                        <option value="sosanhnha.com" <?=isset($site) && $site=='sosanhnha.com' ? 'selected="selected"':''?>>Sosanhnha.com</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" placeholder="Nhập URL..." name="url" value="" class="form-control" />
                </div>
                <div class="col-md-1">
                <button type="submit" class="btn btn-primary">Lấy danh sách</button>
                </div>
                </div>
            
            </div>
            <div class="form-group">
                
                <label>Danh sách link</label>
                
                <textarea class="form-control" style="height: 200px;" id="listLinks"><?=$results?></textarea>
                
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                    <?=_Dropdown('category_id', $this->category_model->_Dropdown_Category())?>
                    </div>
                    <div class="col-md-3">
                    <button class="btn btn-warning" id="btnImport" type="button">Import</button>
                    </div>
                </div>
                
            </div>
            <input type="hidden" name="sitename" value="" />
            <?=form_close()?>
		</article>
	</div>
 <div id="importing" style="position: fixed;left:0;top:0width:100%;height:100%;background:#222;color:#fff;text-align: center;display:none"><span>Đang import...</span></div>
 <script>
 function _import(url, category_id, sitename) {
    
    $.ajax({
                    url: '<?=admin_url('crawlersite/import')?>',
                    type: 'post',
                    dataType: 'json',
                    async: false,
                    beforeSend: function(){
                        // Handle the beforeSend event
                        $('#importing').show();
                    },
                    data: {url: url, category_id: category_id, sitename: sitename},
                    success: function(res) {
                        return true;
                    }
    });
 }
 function StartImport(obj) {
    var sitename = $('select[name="site"] option:selected').val();
        var category_id = $('select[name="category_id"] option:selected').val();
        if($('#listLinks').val() == '') {
            alert('Bạn phải lấy danh sách link trước!');
        } else if(category_id == 0) {
			alert('Bạn chưa chọn danh mục import!');
		} else {
            var arrLinks = document.getElementById("listLinks").value.split("\n");
            var total = arrLinks.length;
            var start = 0;
            var i =0;
            
            $.each(arrLinks, function(key, value) {
                _import(value, category_id, sitename);
                if(key == arrLinks.length - 1) {
                    $(obj).attr('disabled', 'desabled').text('Import hoàn tất');
                    alert('Đã import thành công ' + arrLinks.length + ' tin');
                    $('#importing').hide();
                }    
            });
            /*while(i < arrLinks.length) {
                $('#importing span').text(i);
                $('#importing').show();
                if(_import(arrLinks[i], category_id, sitename)) {
                    i++;
                    $(obj).text('Importing ' + i);
                }
                
                if(i==arrLinks.length) $('#importing').hide();
            }*/
        }
        return false;
 }
 $(document).ready(function() {
     $('#btnImport').on('click', function() {
        var sitename = $('select[name="site"] option:selected').val();
        var category_id = $('select[name="category_id"] option:selected').val();
        if($('#listLinks').val() == '') {
            alert('Bạn phải lấy danh sách link trước!');
        } else {
            var arrLinks = document.getElementById("listLinks").value.split("\n");
            var total = arrLinks.length;
            var start = 0;
            var i =0;
            $.each(arrLinks, function(key, value) {
                $('#btnImport').attr('disabled', 'desabled').text('Đang import...');
                $.ajax({
                    url: '<?=admin_url('crawlersite/import')?>',
                    type: 'post',
                    dataType: 'json',
                    async:true,
                    data: {url: value, index: key, category_id: category_id, sitename: sitename},
                    success: function(res) {
                        start+=1;
                        $('#btnImport').removeAttr('disabled').text('Imported ' + start + '/' + arrLinks.length);
                    }
                })
                if(key == arrLinks.length-1) {
                    $('#btnImport').removeAttr('disabled').text('Imported ' + start + '/' + arrLinks.length);
                }
            });
        }
        return false;
    });
 })
 </script>