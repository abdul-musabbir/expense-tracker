<?php

    require "functions.php";

    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    $routes = [
        "/dashboard" => "routes/dashboard.php",
        "/budget" => "routes/budget.php",
        "/login" => "auth/login.php",
        "/logout" => "auth/logout.php",
        "/register" => "auth/register.php",
        "/profile" => "routes/profile.php",
        "/profile/edit" => "routes/profile-edit.php",
    ];

    if(array_key_exists($uri, $routes)){
        require $routes[$uri];
    } else {
        http_response_code(404);

        require "404/not-found.php";

        die();
    }

?>