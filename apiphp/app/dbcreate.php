<?php
/*
* Script para criar a base de dados e as tabelas necessárias
*/

$servername = "localhost";
$username = "admin";
$password = "mysqlsenha";
$database = "desenvolvedores";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === TRUE) {
  // echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS `devs` (
  `cod` int NOT NULL AUTO_INCREMENT,
  `id` varchar(64)  NOT NULL,
  `name` varchar(150)  NOT NULL,
  `sex` enum('M','F') DEFAULT NULL,
  `age` int DEFAULT NULL,
  `hobby` varchar(50)  DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `deleted` enum('Y','N')  DEFAULT 'N',
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `insert_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `id` (`id`),
  KEY `cod` (`cod`)
) ENGINE=InnoDB;";


if ($conn->query($sql) === TRUE) {
  // echo "Table created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

$conn->close();

