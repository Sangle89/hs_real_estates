<?php if($deleted = $this->session->flashdata('info')) : ?>
<div class="alert alert-success">
    <p>Đã xóa: <?=$deleted['real_estate']?> tin rao, <?=$deleted['images']?> hình ảnh, <?=$deleted['router']?> router</p>
</div>
<?endif ?>
<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?=form_open_multipart()?>
            <div class="form-group">
                <label>Nhập danh sách ID</label>
                <span>Ví dụ: 3245,6576,4565,...</span>
                <textarea class="form-control" name="ids" rows="10" id="listLinks"></textarea>
                <div id="listL"></div>
            </div>
            <button type="submit" class="btn btn-primary" id="btnImport">Xóa</button>
            <?=form_close()?>
		</article>
	</div>