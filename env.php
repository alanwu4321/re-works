<!-- //environment variables -->

<?php
$host = ($env == "dev") ? "" : "/~escheer/re-works";
if ($env == "dev") {
    $dbhost = '127.0.0.1:3306';
    $dbuser = 'root';
    $dbpassword = '';
    $dbname = 'escheer';
} else if ($env == "prod") {
    $dbhost = 'localhost';
    $dbuser = 'escheer';
    $dbpassword = 'R@gnBnMn897';
    $dbname = 'escheer';
}
