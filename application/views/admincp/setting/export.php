<script>
$(document).ready(function() {
   $('select[name="City"]').change(function() {
        var District = $('select[name="District"] option:selected').val();
        var City = $(this).val();
       window.location.href='<?=admin_url()?>/export?City=' + $(this).val() + '&District=' + District; 
   });
   $('select[name="District"]').change(function() {
        var City = $('select[name="City"] option:selected').val();
        var District = $(this).val();
       window.location.href='<?=admin_url()?>/export?City=' + City + '&District=' + District; 
   });
});
</script>
<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?=form_open_multipart()?>
            <div class="form-group">
                <label>Tỉnh/TP <span class="required">*</span></label>
                <?=_Dropdown('City', $dropdown_city, $city_id)?>
            </div>
            <div class="form-group">
                <label>Quận/huyện <span class="required">*</span></label>
                <?=_Dropdown('District', $districts, $district_id)?>
            </div>
            <label><input type="checkbox" name="empty_city" value="1" />Tỉnh/Thành trống</label><br />
            <label><input type="checkbox" name="empty_district" value="1" />Quận/Huyện trống</label><br />
            <label><input type="checkbox" name="empty_ward" value="1" />Phường trống</label><br />
            <label><input type="checkbox" name="empty_district" value="1" />Đường trống</label><br />
            <label><input type="checkbox" name="empty_content" value="1" />Nội dung trống</label><br />
            <label>Tổng cộng: <?=$total?></label>
            <div class="form-group">
            <select name="start" class="form-control">
                <option value="0">Vị trí bắt đầu</option>
                <?php
                $sodu = $total % 100;
                $songuyen = (int)($total / 100);
                for($i=0; $i<=$songuyen; $i++) {
                    echo '<option value="'. $i*100 .'">'. $i*100 .'</option>';
                }
                ?>
            </select>
            </div>
            <div class="form-group">
            <select name="limit" class="form-control">
                <option value="">Giới hạn</option>
                <?php
                $sodu = $total % 100;
                $songuyen = (int)($total / 100);
                for($i=1; $i<=$songuyen; $i++) {
                    echo '<option value="'. $i*100 .'">'. $i*100 .'</option>';
                }
                ?>
                <option value="<?=$total?>"><?=$total?></option>
            </select>
            </div>
            <button type="submit" class="btn btn-primary" id="btnImport">Xuất dữ liệu CSV</button>
            
            <?=form_close()?>
            <form action="<?=admin_url('export/view')?>" method="get">
            <input type="hidden" name="city_id" value="<?=$city_id?>" />
            <input type="hidden" name="district_id" value="<?=$district_id?>" />
            <button type="submit" name="export" class="btn btn-default">Xem dạng text</button>
            </form>
		</article>
</div>