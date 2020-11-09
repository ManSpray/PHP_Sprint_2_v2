<?php
    include 'backend/engineers_edit.php'
?>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Engineer</th>
            <th>Project</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php 
            $sql = 'SELECT engineers.id, engineer_name, project_title
                    FROM engineers
                    LEFT JOIN engineers_projects
                    ON engineers.id = engineers_projects.engineer_id
                    LEFT JOIN projects
                    ON engineers_projects.project_id = projects.id
                    ORDER BY engineers.id;';
            $result = $conn->query($sql);


            if (mysqli_num_rows($result) > 0) { // Forming table with read data
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    for ($i = 0; $i < count($row); $i++) {
                        echo '<td>';
                        echo $row[array_keys($row)[$i]];
                        echo '</td>';
                    }
                    // Adding action buttons to each table entry
                    echo '<td><button><a href="?path=engineers&action=update&id=' . $row['id'] . '">Update</a></button>'; // Update button
                    echo '<button><a href="?path=engineers&action=delete&id=' . $row['id'] . '">Delete</a></button></td>'; // Delete button
                    echo '</tr>';
                }
            }
            echo '<tr><td></td><td><button><a href="?path=engineers&action=add" class="add-btn">Create new Engineer</a></button></td></tr>'; // Inserting add button at the last table row
        ?>
    </tbody>
</table>

<?php // Add new engineer form
    if ($_GET['action'] == 'add') {
        echo '<form method="POST">
            <h3>Add new engineer</h3>
            <label for="engineer_name">Engineer name:</label>
            <input type="text" name="engineer_name" id="engineer_name">
            <label for="project">Asigned project:</label>
            <select name="project_id" id="project">
                <option value="0">None</option>';
        $sql = 'SELECT DISTINCT projects.id, project_title FROM projects;';
        $conn->query($sql);
        $result = $conn->query($sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()){
                echo '<option value=' . $row['id'] . '>' . $row['project_title'] . '</option>';
            }
        }
                
        echo '  </select>
            <button type="submit">Add</button>
        </form>';
    } // Update existing engineer form
    elseif ($_GET['action'] == 'update') {
        
        $sql = 'SELECT engineer_name FROM engineers WHERE id = ' . $_GET['id'];
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $_POST['engineer_name'] = $row['engineer_name'];

        echo '<form method="POST">
                <h3>Update engineer</h3>
                <label for="engineer_name">Engineer name:</label>
                <input type="text" name="engineer_name" id="engineer_name" value="' . $row['engineer_name'] . '">
                <label for="project">Asigned project:</label>
                <select name="project_id" id="project">
                    <option value="0">None</option>';
        $sql = 'SELECT DISTINCT projects.id, project_title FROM projects;';
        $conn->query($sql);
        $result = $conn->query($sql);

        $sql = 'SELECT DISTINCT id, project_title FROM projects LEFT JOIN engineers_projects ON id = project_id WHERE engineer_id = ' . $_GET['id'] . ';';
        $result_p = $conn->query($sql);
        $asigned_project = $result_p->fetch_assoc();

        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()){
                if ($row['project_title'] == $asigned_project['project_title']) {
                    echo '<option value=' . $row['id'] . ' selected>' . $row['project_title'] . '</option>';
                    $_POST['asigned_engineer_id'] = $asigned_project['id'];
                } else {
                    echo '<option value=' . $row['id'] . '>' . $row['project_title'] . '</option>';
                }
            }
        }
                
        echo '  </select>   
                <button type="submit">Update</button>
            </form>';
    }
?>
