<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main/index';
$route['tags/(:any)'] = 'main/tags/$1';
$route['tags/(:any)/p/(:num)'] = 'main/tags/$1/p/$2';
$route['huong-dan-dang-tin'] = 'main/page/11';
$route['gioi-thieu-bannhariengvn'] = 'main/page/14';
$route['quy-dinh-su-dung'] = 'main/page/15';
$route['lien-he'] = 'contact';

$route['error404'] = 'main/error404';

$route['dang-nhap'] = 'user/login';
$route['dang-ky'] = 'user/register';
$route['dang-ky-thanh-cong'] = 'user/register_success';
$route['kich-hoat-thanh-cong'] = 'user/activate_success';
$route['dang-xuat'] = 'user/dang_xuat';
$route['quen-mat-khau'] = 'user/forgot_password';
$route['dat-lai-mat-khau/(:any)'] = 'user/reset_password/$1';

$route['dang-tin-cho-thue-nha'] = 'user/newproduct';
$route['trang-ca-nhan'] = 'user/profile';
$route['trang-ca-nhan/uspg-thong-tin-ca-nhan'] = 'user/profile';
$route['trang-ca-nhan/uspg-doi-mat-khau'] = 'user/change_password';
$route['trang-ca-nhan/uspg-dang-xuat'] = 'user/logout';
$route['trang-ca-nhan/uspg-quan-ly-tin-rao'] = 'user/managerproduct';
$route['trang-ca-nhan/uspg-quan-ly-tin-nhap'] = 'user/managerproducttemp';
$route['trang-ca-nhan/uspg-updateproduct/(:num)'] = 'user/updateproduct/$1';
$route['trang-ca-nhan/uspg-deleteproduct/(:num)'] = 'user/deleteproduct/$1';
$route['trang-ca-nhan/uspg-renewproduct/(:num)'] = 'user/renewproduct/$1';
$route['trang-ca-nhan/uspg-downproduct/(:num)'] = 'user/downproduct/$1';
$route['tien-ich/uspg-thong-bao-tu-ban-quan-tri'] = 'utility/adminnotify';
$route['huong-dan/huong-dan-dang-tin'] = 'content/page/huong-dan-dang-tin';
$route['gioi-thieu-bannhariengvn'] = 'content/page/gioi-thieu-bannhariengvn';
$route['quy-dinh-su-dung'] = 'content/page/quy-dinh-su-dung';

$route['dang-tin-thanh-cong'] = 'user/dangtin_thanhcong';
$route['tim-kiem-tin-rao'] = 'search_page';
$route['tim-kiem'] = 'main/search_text';
$route['tim-kiem/p'] = 'main/search_text';
$route['tim-kiem/p/(:num)'] = 'main/search_text';
$route['tim-kiem/(:any)'] = 'main/search_text/$1';
$route['tim-kiem/(:any)/p/(:num)'] = 'main/search_text/$1';
$route['404_override'] = 'main/index';
$route['ajax/(:any)'] = 'ajax/$1';
$route['translate_uri_dashes'] = FALSE;

$route['admincp'] = 'admincp/home';
$route[ 'admincp/(:any)'] = 'admincp/$1';
$route[ADMIN_FOLDER . '/(:any)/p/(:num)'] = ADMIN_FOLDER . '/$1/index/$2';
$route[ADMIN_FOLDER . '/module/(:any)'] = ADMIN_FOLDER . '/module/$1';

/* Location: ./application/config/routes.php */