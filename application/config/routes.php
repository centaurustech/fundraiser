<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['404_override'] = '';

// $route['login'] 	= "home/login";
// $route['logout'] 	= "home/logout";
// $route['register'] 	= "home/register";
// $route['email'] 	= "home/email";


$route['facebook/(.*)'] 	= "fb/$1";
$route['profile'] 	= "profile";
$route['profile/(.*)'] 	= "profile/$1";
$route['auth/(.*)'] 	= "auth/$1";
$route['ad']        = "ad";
$route['ad/(.*)'] 	= "ad/$1";
$route['transaction/(.*)'] 	= "transaction/$1";

$route['pay'] 	= "pay";
$route['pay/(.*)'] 	= "pay/$1";

$route['(.*)'] 	= "home/$1";





// $route['email/(:any)/(:any)/(:any)'] 	= "home/email/$1/$2/$3";
// $route['email/(:any)/(:any)'] 	= "home/email/$1/$2";
// $route['email/(:any)'] 	= "home/email/$1";



/* End of file routes.php */
/* Location: ./application/config/routes.php */