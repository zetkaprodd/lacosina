<?php

try {
    $host = "mysql8";
    $dbname = "lacosina";
    $user = "myuser";
    $password = "monpassword";

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}