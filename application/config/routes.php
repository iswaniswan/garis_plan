<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/**
 * 
 * custom route
 * 
 */

$route['/'] = 'Home/index';
$route['auth/login'] = 'Home/login';
$route['auth/logout'] = 'Home/logout';

$route['dashboard/calendar'] = 'Home/calendar';
// $route['activity/event/room'] = 'Home/activity_room';
$route['activity/room/reservation/summary'] = 'Activity/room_reservation_summary';
$route['activity/room/reservation/order'] = 'Activity/room_reservation_order';
$route['activity/room/reservation/table'] = 'Activity/room_reservation_table';
$route['activity/room/reservation/table/get'] = 'Activity/room_reservation_table_get';
$route['activity/room/reservation/update/submit'] = 'Activity/room_reservation_update_submit';
$route['activity/room/reservation/delete/submit'] = 'Activity/room_reservation_delete_submit';


$route['activity/event/summary'] = 'Activity/event_summary';
$route['activity/event/order'] = 'Activity/event_order';
$route['activity/event/table'] = 'Activity/event_table';
$route['activity/event/table/get'] = 'Activity/event_table_get';
$route['activity/event/update/submit'] = 'Activity/event_update_submit';
$route['activity/event/delete/submit'] = 'Activity/event_delete_submit';

$route['activity/notification'] = 'Activity/notification';

$route['report/room/reservation'] = 'Report/room_reservation';
$route['report/event'] = 'Report/event';
$route['report/notification'] = 'Report/notification';

$route['settings/data/holiday'] = 'Settings/holiday';
$route['settings/data/holiday/order'] = 'Settings/holiday_order';
$route['settings/data/room'] = 'Settings/room';
$route['settings/data/facilities'] = 'Settings/facilities';
$route['settings/data/vehicle'] = 'Settings/vehicle';
$route['settings/data/user'] = 'Settings/user';

$route['api/room'] = 'Activity/room_get_data';

$route['api/users'] = 'Api/get_users';
$route['api/user'] = 'Api/get_user_by_id';