<?php
session_start();
$servername = "localhost";
$dbname = "cart";
$user = "root";
$pass = "";
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
