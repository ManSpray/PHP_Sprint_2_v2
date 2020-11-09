<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "project_m_v2";
// Create connection
$conn = mysqli_connect($servername, $username, $password);
// Select database if already exist
$conn->select_db($dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Database (DB) setup 
if ($conn->select_db($dbname) === false) { // Runs only if DB has not been created yet
    $sql = 'CREATE SCHEMA IF NOT EXISTS project_m_v2;'; 
    $conn->query($sql); // Create DB
    $conn->select_db($dbname); //Select DB

    $sql = 'CREATE TABLE IF NOT EXISTS engineers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        engineer_name VARCHAR(32) NOT NULL);';
    $conn->query($sql); // Creating engineers table
    $sql = 'INSERT INTO engineers (engineer_name)
            VALUES ("Xiangling"), ("Chongyun"), ("Qiqi"),
            ("Fischl"), ("Diluc"), ("Venti"), ("Mona"),
             ("Kaqing"), ("Barbara"), ("Jean"), ("Klee");';
    $conn->query($sql); // Adding data to engineers table

    $sql = 'CREATE TABLE IF NOT EXISTS projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        project_title VARCHAR(32) NOT NULL);';
    $conn->query($sql); // Creating projects table
    $sql = 'INSERT INTO projects (project_title)
            VALUES ("River Island"), ("Hugo Boss"), ("Gucci"),
            ("Prada"), ("D&G"), ("Zara"), ("Mango");';
    $conn->query($sql); // Adding data to projects table

    $sql = 'CREATE TABLE IF NOT EXISTS engineers_projects (
        project_id INT,
        engineer_id INT,
        FOREIGN KEY (engineer_id) REFERENCES engineers(id) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY (project_id) REFERENCES projects(id) ON UPDATE CASCADE ON DELETE CASCADE);';
$conn->query($sql); // Creating id reference table ('engineers_projects')

$sql = 'INSERT INTO engineers_projects (project_id, engineer_id)
        VALUES (1,1), (3,2), (3,3), (1,4), (7,5), (6,6), (5,7), (5,9), (7,10), (4,11);';
$conn->query($sql); // Adding example data to id reference table ('engineers_projects')
}
?>