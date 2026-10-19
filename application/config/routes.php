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
|	https://codeigniter.com/userguide3/general/routing.html
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

// Public & Course routes
$route['courses'] = 'Course/index';
$route['course/enroll-free/(:num)'] = 'Course/enrollFree/$1';
$route['course/(:any)'] = 'Course/detail/$1';

// Auth routes
$route['auth/login'] = 'Auth/login';
$route['auth/register'] = 'Auth/register';
$route['auth/logout'] = 'Auth/logout';

// Student & Checkout routes
$route['checkout/(:num)'] = 'Checkout/index/$1';
$route['checkout/submit/(:any)'] = 'Checkout/submitPayment/$1';
$route['my-courses'] = 'Student/myCourses';
$route['my-transactions'] = 'Student/transactions';

// Classroom routes
$route['learn/toggle-progress/(:num)/(:num)'] = 'Classroom/toggleProgress/$1/$2';
$route['learn/(:num)/(:num)'] = 'Classroom/learn/$1/$2';
$route['learn/(:num)'] = 'Classroom/learn/$1';

// Admin routes
$route['admin'] = 'Admin/index';
$route['admin/courses'] = 'Admin/courses';
$route['admin/courses/create'] = 'Admin/courseCreate';
$route['admin/courses/edit/(:num)'] = 'Admin/courseEdit/$1';
$route['admin/courses/delete/(:num)'] = 'Admin/courseDelete/$1';
$route['admin/courses/(:num)/lessons'] = 'Admin/lessons/$1';
$route['admin/lessons/create/(:num)'] = 'Admin/lessonCreate/$1';
$route['admin/lessons/edit/(:num)'] = 'Admin/lessonEdit/$1';
$route['admin/lessons/delete/(:num)'] = 'Admin/lessonDelete/$1';
$route['admin/transactions'] = 'Admin/transactions';
$route['admin/transactions/approve/(:num)'] = 'Admin/transactionApprove/$1';
$route['admin/transactions/reject/(:num)'] = 'Admin/transactionReject/$1';
$route['admin/students'] = 'Admin/students';
