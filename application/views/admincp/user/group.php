<section id="widget-grid" class="form-list">

	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
		<?php
        echo _Show_Message('success', $this->session->flashdata('message'));
        ?>
        <?php 
			echo form_open_multipart(current_url(),array('method'=>'post'));
            $button_add = _Button_Add(admin_url($this->uri->segment(2) . '/add'));
            $button_update = _Submit('submit_sort','Cập nhật');
			
			$this->table->set_heading(array(
                array('data' => form_label('Tổng cộng: ['.$total .']', 'thongke'), 'colspan'=>2),
                array('data' => $button_add.' '.$button_update, 'class' => 'center'),
            ));
			
            $this->table->add_row(
                array(
                    'data' => 'Tên group',
                    'width' => '15%'
                ),
                array(
                    'data' => 'Permission',
                    'width' => '40%'
                ),
                array(
                    'data' => 'Tùy chọn',
                    'width' => '25%'
                )
            );
            
            foreach($groups as $group) {
                
                $this->table->add_row(
                    array(
                       $group->name,
                       $group->permission,
                        _Button_Change(admin_url($this->uri->segment(2) . '/edit_group/' . $group->id)).'&nbsp;'.
                        _Button_Delete(admin_url($this->uri->segment(2) . '/delete_group/' . $group->id))
                    )
                );
                
            }
        echo $this->table->generate();
		echo form_close();
       
     //   echo $this->pagination->create_links();
        ?>
		</article>
		<!-- WIDGET END -->

	</div>

	<!-- end row -->

	<!-- row -->


</section>