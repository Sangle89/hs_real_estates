<section id="widget-grid" class="form-add">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
        <?php
        echo validation_errors();
        echo form_open_multipart(admin_url($this->uri->segment(2) . '/create_user'), array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                
        ?>
            <table class="table table-striped">
              <tr>
                <td>Firstname</td>
                <td><?=form_input($first_name)?></td>
              </tr>
              <tr>
                <td>Last name</td>
                <td><?=form_input($last_name)?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td><?=form_input($email)?></td>
              </tr>
              <tr>
                <td>Mobiphone</td>
                <td><?=form_input($phone)?></td>
              </tr>
              <tr>
                <td>Address</td>
                <td><?=form_input($address)?></td>
              </tr>
              <tr>
                <td>Company</td>
                <td><?=form_input($company)?></td>
              </tr>
              <tr>
                <td>Password</td>
                <td><?=form_input($password)?></td>
              </tr>
              <tr>
                <td>Password confirm</td>
                <td><?=form_input($password_confirm)?></td>
              </tr>
              <!--<tr>
                <td>Group</td>
                <td>
                <?php
                if ($this->ion_auth->is_admin()) {
                    $user_group = '';
                    foreach ($groups as $group){
                        $user_group .= '<label class="checkbox">';
                        
                        $gID=$group['id'];
                          $checked = null;
                          $item = null;
                          $i_fa = '';
                          foreach($currentGroups as $grp) {
                              if ($gID == $grp->id) {
                                  $checked= ' checked="checked"';
                                  
                              break;
                              }
                          }
                        $user_group .= form_checkbox('groups[]', $group['id'], $checked) . '<i></i>';
                        $user_group .= htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');
                        $user_group .= '</label>';
                    }
                    //echo $user_group;
                }
                ?>
                </td>
              </tr>-->
            </table>
            <button type="submit" class="btn btn-primary">Luu</button>
            
		</article>
	</div>
</section>