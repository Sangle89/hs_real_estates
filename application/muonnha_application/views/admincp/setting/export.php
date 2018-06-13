<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?=form_open_multipart()?>
            <div class="form-group">
                <label>Tỉnh/TP <span class="required">*</span></label>
                <?=_Dropdown('city_id', $dropdown_city, $city_id)?>
            </div>
            <div class="form-group">
                <label>Quận/huyện <span class="required">*</span></label>
                <?=_Dropdown('district_id', $dropdown_district, $district_id)?>
            </div>
            <label><input type="checkbox" name="empty_city" value="1" />Tỉnh/Thành trống</label><br />
            <label><input type="checkbox" name="empty_district" value="1" />Quận/Huyện trống</label><br />
            <label><input type="checkbox" name="empty_ward" value="1" />Phường trống</label><br />
            <label><input type="checkbox" name="empty_district" value="1" />Đường trống</label><br />
            <label><input type="checkbox" name="empty_content" value="1" />Nội dung trống</label><br />
            <button type="submit" class="btn btn-primary" id="btnImport">Xuất dữ liệu</button>
            <?=form_close()?>
		</article>
</div>