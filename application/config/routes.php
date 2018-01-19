<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'user_authentication';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

// authentication 
$route['login'] = 'user_authentication';
$route['verify'] = 'user_authentication/verify';


// MY API Routes
$route['api/user_auth/login']['POST'] = 'api/authentication/login';
$route['api/post']['POST'] = 'api/authentication/user';



// cek token jwt
$route['api/check_token']['GET'] = 'api/authentication/check_token'; 


/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
