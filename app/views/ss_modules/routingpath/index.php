<?php

$routes = [
  '/app/views/ss_modules/home' => '../../../views/ss_modules/ss_main/ss_admin_entry.php',
  '/app/views/ss_modules/testdraganddrop' => '../../../views/ss_modules/ss_main/testjavascript.php',
];

function routeToController($routes) {
  // Fetch the current URL
  $uri = $_SERVER['REQUEST_URI'];

  $parsedUri = parse_url($uri);
  $path = $parsedUri['path'];

  if (array_key_exists($path, $routes)) {
    require $routes[$path];
  } else {
    abort();
  }
}

function abort($code = 404) {
  http_response_code($code);
  require "views/{$code}.php";
  die();
}

// Call the function with the routes
routeToController($routes);
?>

