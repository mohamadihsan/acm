<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller']            = 'auth/User_Authentication';
$route['404_override']                  = '';
$route['translate_uri_dashes']          = TRUE;

// authentication 
$route['login']                         = 'auth/User_Authentication';
$route['verify']['POST']                = 'auth/User_Authentication/verify';

// master
$route['dashboard']                     = 'general/Dashboard';
$route['company']                       = 'master/Company_Management/show';
$route['company/all']                   = 'master/Company_Management/all';
$route['company/(:num)']                = 'master/Company_Management/ajax_edit/$1';
$route['company/delete/(:num)']         = 'master/Company_Management/ajax_delete/$1';
$route['company/add']                   = 'master/Company_Management/ajax_add';
$route['company/update']                = 'master/Company_Management/ajax_update';
$route['card']                          = 'master/Card_Management/show';
$route['card/all']                      = 'master/Card_Management/all';
$route['employee']                      = 'master/People_Management/show_employee';
$route['employee/all']                  = 'master/People_Management/all_employee';
$route['employee/(:num)']               = 'master/People_Management/ajax_edit/$1';
$route['employee/delete/(:num)']        = 'master/People_Management/ajax_delete/$1';
$route['employee/add']                  = 'master/People_Management/ajax_add';
$route['employee/update']               = 'master/People_Management/ajax_update';
$route['non_employee']                  = 'master/People_Management/show_non_employee';
$route['non_employee/all']              = 'master/People_Management/all_non_employee';
$route['non_employee/(:num)']           = 'master/People_Management/ajax_edit/$1';
$route['non_employee/delete/(:num)']    = 'master/People_Management/ajax_delete/$1';
$route['non_employee/add']              = 'master/People_Management/ajax_add';
$route['non_employee/update']           = 'master/People_Management/ajax_update';
$route['tenant']                        = 'master/People_Management/show_tenant';
$route['tenant/all']                    = 'master/People_Management/all_tenant';
$route['tenant/(:num)']                 = 'master/People_Management/ajax_edit/$1';
$route['tenant/delete/(:num)']          = 'master/People_Management/ajax_delete/$1';
$route['tenant/add']                    = 'master/People_Management/ajax_add';
$route['tenant/update']                 = 'master/People_Management/ajax_update';
$route['user']                          = 'master/User_Management';

// reporting
$route['excel/people/import']           = 'Excel/upload_people';

// transaction
$route['trans/deletion']                = 'transaction/Deletion/show';
$route['trans/deletion/all']            = 'transaction/Deletion/all';
$route['trans/deletion/(:num)']         = 'transaction/Deletion/ajax_edit/$1';
$route['trans/deletion/delete/(:num)']  = 'transaction/Deletion/ajax_delete/$1';
$route['trans/deletion/add']            = 'transaction/Deletion/ajax_add';
$route['trans/deletion/update']         = 'transaction/Deletion/ajax_update';
$route['trans/deletion/filter']         = 'transaction/Deletion/filter';
$route['trans/registration']            = 'transaction/Registration/show';
$route['trans/registration/all']        = 'transaction/Registration/all';
$route['trans/registration/filter']     = 'transaction/Registration/filter';
$route['trans/replacement']             = 'transaction/Replacement/show';
$route['trans/replacement/all']         = 'transaction/Replacement/all';
$route['trans/replacement/filter']      = 'transaction/Replacement/filter';
$route['trans/update_card']             = 'transaction/Update_Card/show';
$route['trans/update_card/all']         = 'transaction/Update_Card/all';
$route['trans/update_card/filter']      = 'transaction/Update_Card/filter';

// logout web
$route['logout']                        = 'auth/User_Authentication/logout';

// MY API Routes
// login & logout
$route['api/user_auth/login']['POST']           = 'api/Authentication/login'; //login
// $route['api/logout/(:num)/(:any)']['GET']       = 'api/Authentication/logout'; // logout aplikasi front end
$route['api/logout']['GET']                     = 'api/transaction/TLog_Logout_API/logout'; // logout aplikasi front end
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
