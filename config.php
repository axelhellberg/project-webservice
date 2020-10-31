<?php 
// error_reporting(-1);
// ini_set("display_errors", 1);

spl_autoload_register(function ($class) { // autoload class files
    include "classes/" . $class . ".class.php";
});

// variables for database connection
define("DBHOST", "localhost");
define("DBUSER", "user");
define("DBPASS", "password");
define("DBNAME", "dbtest");

// database connection variable
$pdo = new PDO (
    "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4", DBUSER, DBPASS
);
// set pdo attributes
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$method = $_SERVER['REQUEST_METHOD']; // variable for request method
?>