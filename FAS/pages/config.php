<?php
     session_start();
   define('DB_SERVER', 'localhost:3308');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'waseem123123');
   define('DB_DATABASE', 'fasdb');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
?>