<?php
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('WebApiRequest');
    $file_handler = new \Monolog\Handler\StreamHandler("logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};
