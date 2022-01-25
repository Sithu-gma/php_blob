<?php
$dbhost="localhost";
$dbname="testBlog";
$dbuser="root";
$dbpass="";

$pdo= new PDO(
   "mysql:host=$dbhost; dbname=$dbname", $dbuser,$dbpass,[
       PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    //    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
   ]
);