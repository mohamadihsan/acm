<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller']            = 'Home';
$route['404_override']                  = '';
$route['translate_uri_dashes']          = TRUE;

// authentication 
$route['login']                         = 'auth/User_Authentication';
$route['verify']['POST']                = 'auth/User_Authentication/verify';

// master
$route['dashboard']                     = 'general/Dashboard';
$route['company']                       = 'master/Company_Management/show';
$route['company/all']                   = 'master/Company_Management/all';
$route['company/export']                = 'master/Company_Management/exportExcel';
$route['company/(:num)']                = 'master/Company_Management/ajax_edit/$1';
$route['company/delete/(:num)']         = 'master/Company_Management/ajax_delete/$1';
$route['company/add']                   = 'master/Company_Management/ajax_add';
$route['company/update']                = 'master/Company_Management/ajax_update';
$route['card']                          = 'master/Card_Management/show';
$route['card/all']                      = 'master/Card_Management/all';
$route['card/export']                   = 'master/Card_Management/exportExcel';
$route['employee']                      = 'master/People_Management/show_employee';
$route['employee/all']                  = 'master/People_Management/all_employee';
$route['employee/(:num)']               = 'master/People_Management/ajax_edit/$1';
$route['employee/delete/(:num)']        = 'master/People_Management/ajax_delete/$1';
$route['employee/add']                  = 'master/People_Management/ajax_add';
$route['employee/update']               = 'master/People_Management/ajax_update';
$route['group']                         = 'master/GroupAccess_Management/show';
$route['group/all']                     = 'master/GroupAccess_Management/all';
$route['group/(:num)']                  = 'master/GroupAccess_Management/ajax_edit/$1';
$route['group/delete/(:num)']           = 'master/GroupAccess_Management/ajax_delete/$1';
$route['group/add']                     = 'master/GroupAccess_Management/ajax_add';
$route['group/update']                  = 'master/GroupAccess_Management/ajax_update';
$route['master']                        = 'master/People_Management/show_master';
$route['master/all']                    = 'master/People_Management/all_master';
$route['master/(:num)']                 = 'master/People_Management/ajax_edit/$1';
$route['master/delete/(:num)']          = 'master/People_Management/ajax_delete/$1';
$route['master/add']                    = 'master/People_Management/ajax_add';
$route['master/update']                 = 'master/People_Management/ajax_update';
$route['non_employee']                  = 'master/People_Management/show_non_employee';
$route['non_employee/all']              = 'master/People_Management/all_non_employee';
$route['non_employee/(:num)']           = 'master/People_Management/ajax_edit/$1';
$route['non_employee/delete/(:num)']    = 'master/People_Management/ajax_delete/$1';
$route['non_employee/add']              = 'master/People_Management/ajax_add';
$route['non_employee/update']           = 'master/People_Management/ajax_update';
$route['menu']                          = 'master/MenuUser_Management/show';
$route['menu/all']                      = 'master/MenuUser_Management/all';
$route['menu/(:num)']                   = 'master/MenuUser_Management/ajax_edit/$1';
$route['menu/delete/(:num)']            = 'master/MenuUser_Management/ajax_delete/$1';
$route['menu/add']                      = 'master/MenuUser_Management/ajax_add';
$route['menu/update']                   = 'master/MenuUser_Management/ajax_update';
$route['tenant']                        = 'master/People_Management/show_tenant';
$route['tenant/all']                    = 'master/People_Management/all_tenant';
$route['tenant/(:num)']                 = 'master/People_Management/ajax_edit/$1';
$route['tenant/delete/(:num)']          = 'master/People_Management/ajax_delete/$1';
$route['tenant/add']                    = 'master/People_Management/ajax_add';
$route['tenant/update']                 = 'master/People_Management/ajax_update';
$route['user']                          = 'master/User_Management/show';
$route['user/all']                      = 'master/User_Management/all';
$route['user/(:num)']                   = 'master/User_Management/ajax_edit/$1';
$route['user/delete/(:num)']            = 'master/User_Management/ajax_delete/$1';
$route['user/add']                      = 'master/User_Management/ajax_add';
$route['user/update']                   = 'master/User_Management/ajax_update';
$route['user_role']                     = 'master/UserRole_Management/show';
$route['user_role/all']                 = 'master/UserRole_Management/all';
$route['user_role/(:num)']              = 'master/UserRole_Management/ajax_edit/$1';
$route['user_role/delete/(:num)']       = 'master/UserRole_Management/ajax_delete/$1';
$route['user_role/add']                 = 'master/UserRole_Management/ajax_add';
$route['user_role/update']              = 'master/UserRole_Management/ajax_update';
$route['user_role/filter']              = 'master/UserRole_Management/filter';

// reporting
$route['excel/people/import']           = 'Excel/upload_people';

// transaction
$route['trans/blacklist']                = 'transaction/Blacklist/show';
$route['trans/blacklist/all']            = 'transaction/Blacklist/all';
$route['trans/blacklist/restore/(:num)'] = 'transaction/Blacklist/ajax_restore/$1';
$route['trans/blacklist/delete']         = 'transaction/Blacklist/ajax_add';
$route['trans/blacklist/filter']         = 'transaction/Blacklist/filter';
$route['trans/deletion']                = 'transaction/Deletion/show';
$route['trans/deletion/all']            = 'transaction/Deletion/all';
$route['trans/deletion/restore/(:num)'] = 'transaction/Deletion/ajax_restore/$1';
$route['trans/deletion/delete']         = 'transaction/Deletion/ajax_add';
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
// register
$route['api/user/register']['POST']             = 'api/master/MUser_API/register_user';
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
$route['api/register/check']['POST']            = 'api/transaction/TRegistration_API/check_registration'; // registration
$route['api/register']['POST']                  = 'api/transaction/TRegistration_API/registration'; // registration
// tacm.t_d_update_card
$route['api/updatecard/check']['POST']          = 'api/transaction/TUpdate_Card_API/check_update_card'; // update card
$route['api/updatecard']['POST']                = 'api/transaction/TUpdate_Card_API/update_card'; // update card
// tacm.t_d_replacement
$route['api/replacement/check']['POST']         = 'api/transaction/TReplacement_API/check_replacement'; // replacement card
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
