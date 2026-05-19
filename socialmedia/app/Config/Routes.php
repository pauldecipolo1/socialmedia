<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::register');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('profile-picture/(:segment)', 'Profile::picture/$1');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('feed', 'Home::index');
    $routes->post('posts/create', 'Post::create');
    $routes->post('posts/delete/(:num)', 'Post::delete/$1');
    $routes->post('posts/like/(:num)', 'Post::like/$1');
    $routes->post('posts/comment/(:num)', 'Post::comment/$1');

    $routes->get('profile/(:num)', 'Profile::show/$1');
    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/update', 'Profile::update');
    $routes->get('profile/(:num)/followers', 'Profile::followers/$1');
    $routes->get('profile/(:num)/following', 'Profile::following/$1');

    $routes->post('follow/(:num)', 'Follow::toggle/$1');
    $routes->get('search', 'Search::index');
    $routes->get('search/suggestions', 'Search::suggestions');
});
