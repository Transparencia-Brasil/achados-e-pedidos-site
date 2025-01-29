<?php
include_once __DIR__ . "/../config/scw.php";

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
    header("Access-Control-Allow-Origin: * ");
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    
    exit(0);
}

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="SCW"');
    header('HTTP/1.0 401 Unauthorized');
    echo '-';
    exit;
} else {
    if (
        strcmp($_SERVER['PHP_AUTH_USER'] , INTEGRATION_USER) == 0&&
        strcmp($_SERVER['PHP_AUTH_PW'] , INTEGRATION_PWD) == 0)
    {
        $logName = str_replace("/", "", $_GET["name"]);
        $logName = str_replace("..", "", $logName);
        $file = __DIR__ . "/../logs/$logName.log";

        if(file_exists($file)) {
            echo file_get_contents($file);
            exit;
        }
        else {
            http_response_code(404);
            echo "NOT FOUND!";
            exit;
        }
    } else {
        header('WWW-Authenticate: Basic realm="SCW"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Invalid User/Password';
        exit;
    }
}