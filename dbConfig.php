<?php
// Development
// $dbhost = '127.0.0.1:3306';
// $dbuser = 'root';
// $dbpassword = '';
// $dbname = 'escheer';

// Production
$dbhost = 'localhost';
$dbuser = 'escheer';
$dbpassword = 'R@gnBnMn897';
$dbname = 'escheer';

// (2) mysqli connection variable
$mysqli = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
if ($mysqli->connect_errno) 
{
echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
}
// echo '<p>' . $mysqli->host_info . '</p>';
