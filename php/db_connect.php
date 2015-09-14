<?php
define("HOST", "localhost");     // The host you want to connect to.
define("USER", "root");    // The database username. 
define("PASSWORD", "password");    // The database password. 
define("DATABASE", "cws");    // The database name.

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

if($mysqli->connect_error) {
	die("Error connecting to database: " . $mysqli->connect_error);
}