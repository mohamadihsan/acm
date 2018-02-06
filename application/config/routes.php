<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller']    = 'User_Authentication';
$route['404_override']          = '';
$route['translate_uri_dashes']  = TRUE;

// authentication 
$route['login']                 = 'User_Authentication';
$route['verify']['POST']        = 'User_Authentication/verify';

// logout web
$route['logout']                = 'User_Authentication/logout';

// MY API Routes
// login & logout
$route['api/user_auth/login']['POST']           = 'api/Authentication/login'; //login
$route['api/logout/(:num)/(:any)']['GET']       = 'api/Authentication/logout'; // logout aplikasi front end
// tacm.t_d_find_card
$route['api/find_card']['POST']               = 'api/master/MCard_API/find'; // find card
// tacm.t_d_find_people
$route['api/find_people']['POST']               = 'api/master/MPeople_API/find'; // find people
// macm.t_m_desc
$route['api/tmdesc/store']['GET']               = 'api/master/TMDesc_API/store'; // show data desc
$route['api/tmdesc/insert']['POST']             = 'api/master/TMDesc_API/desc_insert'; // insert data desc
$route['api/tmdesc/update/(:num)']['PUT']       = 'api/master/TMDesc_API/desc_update'; // update data desc
$route['api/tmdesc/delete/(:num)']['DELETE']    = 'api/master/TMDesc_API/desc_softdelete'; // delete data desc
// tacm.t_d_registration
$route['api/register']['POST']                  = 'api/transaction/TRegistration_API/registration'; // registration
// tacm.t_d_update_card
$route['api/updatecard']['POST']                = 'api/transaction/TUpdate_Card_API/update_card'; // update card
// tacm.t_d_replacement
$route['api/replacement']['POST']               = 'api/transaction/TReplacement_API/replacement'; // replacement card
// tacm.t_d_deletion_card
$route['api/deletion']['POST']                  = 'api/transaction/TDeletion_Card_API/deletion_card'; // deletion card




// cek token jwt
$route['api/check_token'] = 'api/authentication/check_token'; 


/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
