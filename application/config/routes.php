<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller']    = 'User_Authentication';
$route['404_override']          = '';
$route['translate_uri_dashes']  = TRUE;

// authentication 
$route['login']                 = 'User_Authentication';
$route['verify']['POST']        = 'User_Authentication/verify';

// Menu
$route['dashboard']                     = 'Dashboard';
$route['card']                          = 'Card_Management';
$route['card']                          = 'Card_Management';
$route['employee']                      = 'People_Management/show_employee';
$route['employee/all']                  = 'People_Management/all_employee';
$route['employee/(:num)']               = 'People_Management/ajax_edit/$1';
$route['employee/delete/(:num)']        = 'People_Management/ajax_delete/$1';
$route['employee/add']                  = 'People_Management/ajax_add';
$route['employee/update']               = 'People_Management/ajax_update';
$route['excel/people/import']           = 'Excel/upload_people';
$route['Report']                        = 'Report';
$route['non_employee']                  = 'People_Management/show_non_employee';
$route['non_employee/all']              = 'People_Management/all_non_employee';
$route['non_employee/(:num)']           = 'People_Management/ajax_edit/$1';
$route['non_employee/delete/(:num)']    = 'People_Management/ajax_delete/$1';
$route['non_employee/add']              = 'People_Management/ajax_add';
$route['non_employee/update']           = 'People_Management/ajax_update';
$route['tenant']                        = 'People_Management/show_tenant';
$route['tenant/all']                    = 'People_Management/all_tenant';
$route['tenant/(:num)']                 = 'People_Management/ajax_edit/$1';
$route['tenant/delete/(:num)']          = 'People_Management/ajax_delete/$1';
$route['tenant/add']                    = 'People_Management/ajax_add';
$route['tenant/update']                 = 'People_Management/ajax_update';
$route['user']                          = 'User_Management';

// logout web
$route['logout']                        = 'User_Authentication/logout';

// MY API Routes
// login & logout
$route['api/user_auth/login']['POST']           = 'api/Authentication/login'; //login
// $route['api/logout/(:num)/(:any)']['GET']       = 'api/Authentication/logout'; // logout aplikasi front end
$route['api/logout']['GET']       = 'api/transaction/TLog_Logout_API/logout'; // logout aplikasi front end
// tacm.t_d_find_card
$route['api/find_card']['POST']                 = 'api/master/MCard_API/find'; // find card
$route['api/show_card']['GET']                  = 'api/master/MCard_API/show_all'; // show all card
// tacm.t_d_find_people
$route['api/find_people']['POST']               = 'api/master/MPeople_API/find'; // find people
$route['api/show_people']['POST']               = 'api/master/MPeople_API/show_people'; // show people
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
$route['api/check_token'] = 'api/authentication/check'; 
$route['api/extract_token'] = 'api/authentication/extract'; 


/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
