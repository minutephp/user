<?php

/** @var Router $router */
use Minute\Routing\Router;

$router->get('/admin/users', null, 'admin', 'users[5] ORDER BY user_id DESC', 'm_user_groups[users.user_id][3] as groups')
       ->setReadPermission('users', 'admin')->setDefault('users', '*');
$router->post('/admin/users', null, 'admin', 'users', 'm_user_groups as groups', 'm_user_data as data')
       ->setAllPermissions('users', 'admin')->setDeleteCascade('users', ['groups', 'data']);

$router->get('/admin/users/edit/{user_id}', 'Admin/Users/Edit', 'admin', 'users[user_id][1]', 'm_user_data[users.user_id][99] as data')
       ->setReadPermission('users', 'admin');
$router->post('/admin/users/edit/{user_id}', null, 'admin', 'users', 'm_user_data as data')
       ->setAllPermissions('users', 'admin')->setAllPermissions('data', 'admin');

$router->get('/admin/users/groups/{user_id}', 'Admin/Users/Groups', 'admin', 'users[user_id] as user', 'm_user_groups[user.user_id][9] as groups')
       ->setReadPermission('user', 'admin');
$router->post('/admin/users/groups/{user_id}', null, 'admin', 'm_user_groups as groups')
       ->setAllPermissions('groups', 'admin');

$router->get('/admin/users/logs/{user_id}', 'Admin/Users/Logs', 'admin', 'users[user_id] as user', 'm_user_activities[user.user_id][5] as logs ORDER by created_at DESC',
    'm_event_names[logs.event_name_id] as event')->setReadPermission('user', 'admin');
$router->post('/admin/users/logs/{user_id}', null, 'admin', 'm_user_activities as logs')
       ->setAllPermissions('logs', 'admin');

$router->post('/generic/uploader', 'Generic/UploadFiles', false);
$router->post('/generic/data-uploader', 'Generic/UploadData', false);

$router->post('/generic/proxy', 'Generic/Proxy', false);

$router->post('/generic/contact', 'Generic/Contact', false);

$router->post('/user/trigger_user_event', 'User/TriggerEvent', true)
       ->setDefault('_noView', true);

$router->get('/admin/users/login-as/{user_id}', 'Admin/Users/LoginAs', 'admin', 'users[user_id][1] as users')
       ->setReadPermission('users', 'admin')->setDefault('_noView', true);
$router->get('/admin/swap', 'Admin/Users/SwapLogin', true)
       ->setDefault('_noView', true);