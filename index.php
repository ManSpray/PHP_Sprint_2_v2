<?php
include_once 'backend/database.php'; // Database connection and setup
// Table entry delete action (works for both: engineers and projects)
if ($_GET['action'] == 'delete') {
    $sql = 'DELETE FROM ' . $_GET['path'] . ' WHERE id = ' . $_GET['id'];
    $conn->query($sql);
    header('location:./?path=' . $_GET['path']);
    exit;
}
$_POST['asigned_project_id'] = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PM 3000</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="header container">
            <div class="link-wrap">
                <a href="./?path=engineers">Engineers</a>
                <a href="./?path=projects">Projects</a><br>
            </div>
            <h1><?php $path = $_GET['path'] ?? 'engineers';
                echo 'Project Manager' ?></h1>
        </div>
    </header>

    <div class="container">
        <?php
        if ($path == 'engineers') {
            include 'backend/engineers.php'; // Loads engineers data
        } else if ($path == 'projects') {
            include 'backend/projects.php'; // Loads projects data
        }
        ?>
    </div>
</body>
</html>