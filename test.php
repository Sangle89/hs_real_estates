<?php
$number = 120000;
echo $number.'<br/>';
if(($number / 1000000) > 1) {
    echo ($number/1000000) . ' trieu';
} else {
    echo 'nghin';
}
?>