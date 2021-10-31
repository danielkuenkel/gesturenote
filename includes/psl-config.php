<?php

// write environment wars into array
$envs = parse_ini_file(__DIR__ . '/../.env');
foreach ($envs as $key => $value) {
    $_ENV[$key] = $value;
}

//local
define("HOST", $_ENV['DB_HOST']);
define("USER", $_ENV['DB_USER']);
define("PASSWORD", $_ENV['DB_PASSWORD']);
define("DATABASE", $_ENV['DB_DATABASE']);
 
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");