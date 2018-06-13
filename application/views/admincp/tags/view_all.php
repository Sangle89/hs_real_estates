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
                    <div class="pull-left">Quản lý Tags</div>
                    <div class="pull-right"><a href="<?=admin_url('tags/add')?>" class="btn btn-primary">Thêm</a></div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Tiêu đề</th>
                                <th>Alias</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($category as $row) : ?>
                        <tr>
                            <td><?=$row['title']?></td>
                            <td><?=$row['alias']?></td>
                            <td class="center">
                                <a href="<?=admin_url('tags/change/'.$row['id'])?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a href="<?=admin_url('tags/delete/'.$row['id'])?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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