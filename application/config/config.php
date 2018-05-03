<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$config['base_url'] = 'http://localhost/acms/';

$config['index_page'] = '';

$config['uri_protocol']	= 'REQUEST_URI';

$config['url_suffix'] = '';

$config['language']	= 'english';

$config['charset'] = 'UTF-8';

$config['enable_hooks'] = FALSE;

$config['subclass_prefix'] = 'MY_';

$config['composer_autoload'] = TRUE;

$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

$config['log_threshold'] = 0;

$config['log_path'] = '';

$config['log_file_extension'] = '';

$config['log_file_permissions'] = 0644;

$config['log_date_format'] = 'Y-m-d H:i:s';

$config['error_views_path'] = '';

$config['cache_path'] = '';

$config['cache_query_string'] = FALSE;

$config['encryption_key'] = '';

$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = NULL;
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;

$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = 'csrf_token_acm';
$config['csrf_cookie_name'] = 'csrf_cookie_acm';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array(
    'api/deletion',
    'api/find_card',
    'api/find_people',
    'api/logout',
    'api/user/register',
    'api/register',
    'api/register/check',
    'api/replacement',
    'api/replacement/check',
    'api/show_people',
    'api/updatecard',
    'api/updatecard/check',
    'api/tmdesc/insert',
    'api/tmdesc/update',
    'api/tmdesc/delete', 
    'api/user_auth/login',
    'card/all',
    'card/export',
    'company/all',
    'company/add',
    'company/export',
    'company/update',
    'company/delete',
    'dashboard',
    'employee/all',
    'employee/add',
    'employee/update',
    'employee/delete',
    'group/all',
    'group/add',
    'group/update',
    'group/delete',
    'master/all',
    'master/add',
    'master/update',
    'master/delete',
    'non_employee/all',
    'non_employee/add',
    'non_employee/update',
    'non_employee/delete',
    'menu/all',
    'menu/add',
    'menu/update',
    'menu/delete',
    'tenant/all',
    'tenant/add',
    'tenant/update',
    'tenant/delete',
    'trans/blacklist/all',
    'trans/blacklist/restore',
    'trans/blacklist/delete',
    'trans/blacklist/filter',
    'trans/deletion/all',
    'trans/deletion/restore',
    'trans/deletion/delete',
    'trans/deletion/filter',
    'trans/registration/all',
    'trans/registration/filter',
    'trans/replacement/all',
    'trans/replacement/filter',
    'trans/update_card/all',
    'trans/update_card/filter',
    'user/all',
    'user/add',
    'user/update',
    'user/delete',
    'user_role/all',
    'user_role/add',
    'user_role/update',
    'user_role/delete',
    'user_role/filter',
    'excel/people/import',
    'logout',
    'report',
    'user',
    'verify'
);

$config['compress_output'] = FALSE;

$config['time_reference'] = 'local';

$config['proxy_ips'] = '';
