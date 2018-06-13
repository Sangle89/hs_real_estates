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
                    <div class="pull-right"><a href="<?=admin_url('category_tags/add')?>" class="btn btn-primary">Thêm</a></div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="10%">Danh mục</th>
                                <th width="10%">Tỉnh thành</th>
                                <th width="10%">Quận huyện</th>
                                <th width="10%">Phường xã</th>
                                <th width="10%">Đường</th>
                                <th width="40%">Tags</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($category as $row) : ?>
                        <tr>
                            <td>
                            <?php
                            $category = $this->category_model->_Get_By_Id($row['category_id']);
                            echo $category['title'];
                            ?>
                            </td>
                            <td>
                            <?php
                            $category = $this->city_model->_Get_By_Id($row['city_id']);
                            echo $category['title'];
                            ?>
                            </td>
                            <td>
                            <?php
                            $category = $this->district_model->_Get_By_Id($row['district_id']);
                            echo $category['title'];
                            ?>
                            </td>
                            <td>
                            <?php
                            $category = $this->ward_model->_Get_By_Id($row['ward_id']);
                            echo $category['title'];
                            ?>
                            </td>
                            <td>
                            <?php
                            $category = $this->street_model->_Get_By_Id($row['street_id']);
                            echo $category['title'];
                            ?>
                            </td>
                            
                            <td>
                            <?php
                            $tags_id = explode(",", $row['tags']);
                            foreach($tags_id as $tag_id) {
                                $tag = $this->tags_model->_Get_By_Id($tag_id);
                                echo $tag['title'].' , ';
                            }
                            ?>
                            </td>
                            <td class="center">
                                <a href="<?=admin_url('category_tags/change/'.$row['id'])?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a href="<?=admin_url('category_tags/delete/'.$row['id'])?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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