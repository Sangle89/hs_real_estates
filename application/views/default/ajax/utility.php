<?php
foreach($results as $type => $result):
    print_r($result);
?>
<table class="table table-bordered">
<tr>
<th width="15%"><?php
if($type == 'restaurant') echo 'Nhà hàng';
elseif($type == 'store') echo 'Cửa hàng';
elseif($type == 'bank') echo 'Ngân hàng';
elseif($type == 'church') echo 'Nhà thờ';
elseif($type == 'atm') echo 'ATM';
?></th>
<th>Địa chỉ</th>
<th width="15%">Khoảng cách</th>
</tr>
<?php foreach($result->results as $row) : ?>
<tr>
<td width="20%"><?=$row['name']?></td>
<td width="70%"><?=$row['formatted_address']?></td>
<td></td>
</tr>
<?php endforeach?>
</table>
<?php endforeach; ?>                  