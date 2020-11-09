<?php 
    if ($_POST['engineer_name'] != "") { // Check if name have been entered
        $sql = 'SELECT * FROM engineers WHERE engineer_name = "' . $_POST['engineer_name'] . '";'; // Check if duplicate entries does not already exist
        $result = $conn->query($sql);
        var_dump(mysqli_num_rows($result));

        // ADD NEW ENGINEER TO TABLE
        if (mysqli_num_rows($result) == 0 && $_GET['action'] == 'add') {
            // engineers table update
            $sql = 'INSERT INTO engineers (engineer_name) VALUES ("' . $_POST['engineer_name'] . '");';
            $conn->query($sql);
            unset($_POST['engineer_name']);

            // engineers_projects table update
            $sql = 'SET SESSION information_schema_stats_expiry=0;';
            $conn->query($sql);
            $sql = 'SHOW TABLE STATUS LIKE "engineers";';
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $next_id = $row['Auto_increment'] - 1;
            $sql = 'INSERT INTO engineers_projects VALUES (' . $_POST['project_id'] . ', ' . $next_id . ');';
            $conn->query($sql);

            header('location:./?path=' . $_GET['path']);
            exit;
        } // UPDATE EXISTING ENGINEER
        elseif ( $_GET['action'] == 'update') {
            // engineers table update
            $sql = 'UPDATE engineers SET engineer_name = "' . $_POST['engineer_name'] . '" WHERE id = '. $_GET['id'] . ';';
            print $sql;
            $conn->query($sql);
            unset($_POST['engineer_name']);

            // engineers_projects table update
            $sql = 'DELETE FROM engineers_projects WHERE engineer_id = ' . $_GET['id'] . ';';
            $conn->query($sql);
            $sql = 'INSERT INTO engineers_projects VALUES (' . $_POST['project_id'] . ', ' . $_GET['id'] . ');';
            $conn->query($sql);
            
            unset($_POST['project_title']);

            header('location:./?path=' . $_GET['path']);
            exit;
        }
    }
?>