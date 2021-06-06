<?php

$router = $di->getRouter();

// Define your routes here

// House Routes
$router->addGet(
    '/houses',
    'Houses::getHousesAllResponse'
);

$router->addPost(
    '/houses',
    'Houses::post'
);

$router->addPut(
    '/houses',
    'Houses::put'
);

// Listings Routes
$router->addGet(
    '/listings',
    'Listings::getAll'
);

$router->addGet(
    '/listings/{id}',
    'Listings::getByUserId'
);

$router->addPost(
    '/listings',
    'Listings::post'
);

$router->addPut(
    '/listings',
    'Listings::put'
);

$router->addDelete(
    '/listings',
    'Listings::delete'
);

// Rooms Routes

$router->addPost(
    '/rooms',
    'Rooms::post'
);

$router->addPut(
    '/rooms',
    'Rooms::put'
);


// Users Routes
$router->addGet(
    '/users',
    'Users::getUserById'
);

$router->addPost(
    '/users',
    'Users::post'
);

$router->addPut(
    '/users',
    'Users::put'
);

$router->addDelete(
    '/users',
    'Users::delete'
);

$router->handle($_SERVER['REQUEST_URI']);
