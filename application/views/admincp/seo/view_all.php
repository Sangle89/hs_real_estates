<section id="widget-grid" class="form-list">
	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
        <?php
        echo _Show_Message('success', $this->session->flashdata('message'));
        ?>
            <div class="box-primary">
                <div class="box-header">
                    <div class="pull-left">Mô tả danh mục</div>
                    <div class="pull-right"><a href="<?=admin_url('seo/add')?>" class="btn btn-primary">Thêm</a></div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>URL</th>
                                <th>Title</th>
                                <th>Keyword</th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($category as $row) : ?>
                        <tr>
                            <td><?=$row['url']?></td>
                            <td><?=$row['title']?></td>
                            <td><?=$row['keyword']?></td>
                            <td><?=$row['description']?></td>
                            <td class="center">
                                <a href="<?=admin_url('seo/change/'.$row['id'])?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a href="<?=admin_url('seo/delete/'.$row['id'])?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
        </div>
        <?php
        echo $pagination;
        ?>
		</article>
		<!-- WIDGET END -->
	</div>
	<!-- end row -->
	<!-- row -->
</section>