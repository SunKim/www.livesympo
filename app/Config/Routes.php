<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');


// custom routing - 윤일철 팀장 요청. livesympo.kr/stream/apply/xxxx 형태를 livesympo.kr/xxxx 형태로
// 모든걸 다 stream/apply로 보내면 안되므로, 정상적으로 태워야 할 것들을 먼저 정의 후 나머지는 다 stream/apply로 보냄.
$routes->add('home', 'Home');
$routes->add('stream/save/(:segment)', 'Stream::save/$1');
$routes->add('stream/quest', 'Stream::quest');
$routes->add('stream/surveyAsw', 'Stream::surveyAsw');

// livesympo.kr/agenda/xxxx => Stream controller의 agenda로 연결 => agenda 별도페이지는 없애기로함.
// $routes->add('agenda/(:segment)', 'Stream::agenda/$1');

// livesympo.kr/stream/xxxx => Stream controller의 watch로 연결
$routes->add('stream/(:segment)', 'Stream::watch/$1');

// 그 외 livesympo.kr/xxxx 형태는 모두 => Stream controller의 apply로 연결
$routes->add('(:segment)', 'Stream::apply/$1');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
