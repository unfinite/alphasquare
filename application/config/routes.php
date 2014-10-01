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

$route['default_controller'] = "main";
$route['404_override'] = '';

// Account pages
$route['^(login|logout|register|forgot_password)'] = 'account/$1';
$route['login/oauth/(Facebook|Google)'] = 'hauth/login/$1';

// Debates
$route['debate/report/(:num)'] = 'debate/report/$1';
$route['debate/([a-zA-Z0-9]+)/(:num)'] = 'debate/view/$1/$2';

// People pages
$route['people/action/(:any)'] = 'people/$1';
$route['people/list/(random|popular|new)'] = 'people/index/$1';
$route['people/([a-zA-Z0-9_]+)/?(\w+)?'] = 'people/profile/$1/$2';
$route['people/([a-zA-Z0-9_]+)/edit/(\w+)'] = 'people/edit_profile/$1/$2';

// Pages
$route['about/?(:any)?'] = 'page/about/$1';
$route['p/(:any)'] = 'page/show/$1';


/* End of file routes.php */
/* Location: ./application/config/routes.php */