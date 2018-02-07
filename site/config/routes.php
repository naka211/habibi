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
$route['default_controller']             = "home";
$route['^dk/home/(.+)']                = "home/$1";
$route['home/(.+)']  				     = "home/$1";

$route['^dk/user/(.+)']                = "user/$1";
$route['user/(.+)']                    = "user/$1";

$route['^dk/invitationer/(.+)']        = "invitationer/$1";
$route['invitationer/(.+)']            = "invitationer/$1";

$route['^dk/tilbud/(.+)']              = "tilbud/$1";
$route['tilbud/(.+)']                  = "tilbud/$1";

$route['^dk/payment/(.+)']             = "payment/$1";
$route['payment/(.+)']                 = "payment/$1";

$route['^dk/ajax/(.+)']                = "ajax/$1";
$route['ajax/(.+)']                    = "ajax/$1";

$route['^dk/b2b/(.+)']                = "b2b/$1";
$route['b2b/(.+)']                    = "b2b/$1";

/** API*/
$route['^dk/api/(.+)']                 = "api/$1";
$route['api/(.+)']                     = "api/$1";

/** Change lang*/
$route['^dk$']                           = $route['default_controller'];
/** Default function at controller home*/
$route['^dk/(.*)']                       = $route['default_controller']."/$1";
$route['(.*)']                           = $route['default_controller']."/$1";
$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */