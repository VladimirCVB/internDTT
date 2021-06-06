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
    'Houses::test'
);

$router->addPut(
    '/houses',
);

$router->addDelete(
    '/houses',
);

// Listings Routes
$router->addGet(
    '/listings',
);

$router->addPost(
    '/listings',
);

$router->addPut(
    '/listings',
);

$router->addDelete(
    '/listings',
);

// Rooms Routes
$router->addGet(
    '/rooms',
);

$router->addPost(
    '/rooms',
);

$router->addPut(
    '/rooms',
);

$router->addDelete(
    '/rooms',
);


// Users Routes
$router->addGet(
    '/users',
);

$router->addPost(
    '/users',
);

$router->addPut(
    '/users',
);

$router->addDelete(
    '/users',
);

$router->handle($_SERVER['REQUEST_URI']);
