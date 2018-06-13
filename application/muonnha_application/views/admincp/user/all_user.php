	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
		<?php
        echo _Show_Message('success', $this->session->flashdata('message'));
        ?>
        <?php 
			echo form_open_multipart(current_url(),array('method'=>'post'));
            $button_add = _Button_Add(admin_url($this->uri->segment(2) . '/create_user'));
            $button_update = _Submit('submit_sort','Cập nhật');
			
			$this->table->set_heading(array(
                array('data' => form_label('Tổng cộng: ['.$total .']', 'thongke'), 'colspan'=>3),
                array('data' => $button_add, 'class' => 'right'),
            ));
            
            $this->table->add_row(array(
                array('data' => _Input('search_input', '', 'form-control', 'id="searchInput" data-type="search_user" placeholder="Nhập từ khóa cần tìm.."'), 'colspan'=>5)
            ));
            
            echo $this->table->generate();
            
        ?>
        <table class="table table-bordered table-hover table-striped table-list">
            <thead>
                <tr>
                    <th class="text-center">STT</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Group</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($users as $key => $user) : 
            $user_group = '';
                foreach($user->groups as $group) {
                    $user_group .= $group->name . ', ';
                }
            ?>
            <tr>
                <td class="text-center"><?=($key+1)?></td>
                <td class="text-center"><?=$user->email?></td>
                <td class="text-center"><?=$user->mobiphone?></td>
                <td class="text-center"><?=$user->address?></td>
                <td class="text-center"><?=$user_group?></td>
                <td class="text-center"><?=date('d/m/Y', $user->created_on)?></td>
                <td class="text-center"><?=$user->active==1?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>'?>
                <?php if($user->active == 0):?>
                <a href="<?=base_url('user/activate/'.$user->id.'/'.$user->activation_code)?>" target="_blank">Active</a>
                <?php endif ?>
                </td>
                <td class="text-center">
                <a title="Edit" class="btn btn-primary btn-sm" href="<?=admin_url($this->uri->segment(2) . '/edit_user/' . $user->id)?>"><i class="fa fa-pencil"></i></a>
                <a title="Reset password: 12345678" class="btn btn-warning btn-sm" href="<?=admin_url($this->uri->segment(2) . '/resetpass/' . $user->id)?>" onclick="return confirmDelete();"><i class="fa fa-key"></i></a>
                <a title="Delete" class="btn btn-danger btn-sm" href="<?=admin_url($this->uri->segment(2) . '/delete_user/' . $user->id)?>" onclick="return confirmDelete();"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        <?php echo form_close(); ?>
		</article>
		<!-- WIDGET END -->

	</div>