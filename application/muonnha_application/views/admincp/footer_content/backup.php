<?php
$id = isset($post['id']) ? $post['id'] : '';
$title = isset($post['title']) ? $post['title'] : '';
$parent_id = isset($post['parent_id']) ? $post['parent_id'] : 0;
$link = isset($post['link']) ? $post['link'] : '';
$category_id = isset($post['category_id']) ? $post['category_id'] : 0;
$city_id = isset($post['city_id']) ? $post['city_id'] : 0;
$district_id = isset($post['district_id']) ? $post['district_id'] : 0;
$ward_id = isset($post['ward_id']) ? $post['ward_id'] : 0;
$street_id = isset($post['street_id']) ? $post['street_id'] : 0;
$project_id = isset($post['project_id']) ? $post['project_id'] : 0;
$sort_order = isset($post['sort_order']) ? $post['sort_order'] : '';
$status = isset($post['status']) ? $post['status'] : 'active';
$show_footer = isset($post['show_footer']) && $post['show_footer']==1 ? true : false;
$show_detail = isset($post['show_detail']) && $post['show_detail']==1 ? true : false;
$content = isset($post['content']) ? $post['content'] : '';
?>
<section id="widget-grid" class="form-add">
	<div class="row">
<?php
$title = isset($post['title']) ? $post['title'] : '';
$sort_order = isset($post['sort_order']) ? $post['sort_order'] : 0;
?>
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
            <?php 
                if(validation_errors()) echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
             $action = $id ? admin_url($this->uri->segment(2) . '/change/'.$id) : admin_url($this->uri->segment(2) . '/add');
                echo form_open_multipart($action, array('method'=>'post','id'=>'myForm', 'class'=>'smart-form')); 
                ?>
                
                <table class="table">
                    <tr>
                        <td width="10%">Nội dung</td>
                        <td><?=_Textarea('content', $content)?></td>
                    </tr>
                    <tr>
                        <td>Danh mục tin</td>
                        <td>
                        <?php foreach($dropdown_category as $category_id => $title):?>
                        <label><?=$title?>&nbsp;<input type="checkbox" name="category_id[]" value="<?=$category_id?>" <?php if(isset($category_selected) && in_array($category_id, $category_selected)) echo 'checked="checked"'?> /></label>&nbsp;&nbsp;
                        <?php endforeach ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Khu vực</td>
                        <td>
                        <?php foreach($dropdown_city as $city_id => $title):
                        $districts = $this->district_model->_Get_All($city_id);
                        if(!empty($districts) && $city_id>0):
                        ?>
                        <div class="panel-group">
                          <div class="panel panel-primary">
                            <div class="panel-heading">
                              <h4 class="panel-title">
                                <input type="checkbox" name="city_id[]" value="<?=$city_id?>" <?php if(isset($city_selected) && in_array($city_id, $city_selected)) echo 'checked="checked"'?> />&nbsp;<a data-toggle="collapse" href="#collapse_city_<?=$city_id?>"><?=$title?></a>
                              </h4>
                            </div>
                            <div id="collapse_city_<?=$city_id?>" class="panel-collapse collapse">
                              <div class="panel-body">
                              <?php 
                              
                              foreach($districts as $district):
                              ?>
                              <div class="panel-group">
                                  <div class="panel panel-info">
                                    <div class="panel-heading">
                                      <h4 class="panel-title">
                                        <input type="checkbox" name="district_id[]" value="<?=$district['id']?>" <?php if(isset($district_selected) && in_array($district['id'], $district_selected)) echo 'checked="checked"'?> />&nbsp;<a data-toggle="collapse" href="#collapse_district_<?=$district['id']?>"><?=$district['title']?></a>
                                      </h4>
                                    </div>
                                    <div id="collapse_district_<?=$district['id']?>" class="panel-collapse collapse">
                                      <div class="panel-body">
                                      <div class="panel panel-default">
                                        <div class="panel-heading"><label><input type="checkbox" onclick="checkAllWard(this, <?=$district['id']?>)" name="checkall_ward" />&nbsp;Checkall Ward</label></div>
                                      </div>
                                      <div class="panel-body">
                                      <?php
                                      $wards = $this->ward_model->_Get_All($district['id']);
                                      foreach($wards as $ward):
                                      ?>
                                      <label class="label label-success">
                                      <input type="checkbox" name="ward_id[<?=$district['id']?>][]" class="ward_<?=$district['id']?>" value="<?=$ward['id']?>" <?php if(isset($ward_selected) && in_array($ward['id'], $ward_selected)) echo 'checked="checked"'?> />&nbsp;Phường <?=$ward['title']?>
                                      </label>&nbsp;
                                      <?php endforeach ?>
                                      </div>
                                      
                                      <label><input type="checkbox" onclick="checkAllStreet(this, <?=$district['id']?>)" name="checkall_street" />Checkall Street</label><br />
                                      <?php
                                      $streets = $this->street_model->_Get_Street_By_District($district['id']);
                                      foreach($streets as $street):
                                      ?>
                                      <label class="label label-danger">
                                      <input type="checkbox" name="street_id[<?=$district['id']?>][]" class="street_<?=$district['id']?>" value="<?=$street['id']?>" <?php if(isset($street_selected) && in_array($street['id'], $street_selected)) echo 'checked="checked"'?> />&nbsp;<?=$street['title']?>
                                      </label>&nbsp;
                                      <?php endforeach?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              <?php endforeach ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php endif ?>
                        <?php endforeach ?>
                        
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?=_Submit('save', 'Lưu lại')?></td>
                    </tr>
                </table>
                
                <?php
                echo form_close(); 
                             
 ?>
		</article>
	</div>
</section>
<script src="/public/ckeditor/ckeditor.js"></script>
<script>
CKEDITOR.replace("content");
function checkAllWard(elem, id){
    var _class = '.ward_' + id;
    if($(elem).is(':checked'))
        $(_class).prop('checked', true);
    else
        $(_class).prop('checked', false);
}
function checkAllStreet(elem, id){
    var _class = '.street_' + id;
    if($(elem).is(':checked'))
        $(_class).prop('checked', true);
    else
        $(_class).prop('checked', false);
}
</script>