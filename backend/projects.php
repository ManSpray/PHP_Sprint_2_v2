<?php
    include './backend/projects_edit.php'
?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Project</th>
            <th>Engineers in</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php // READ ENGINEERS TABLE IN DATABASE
            $sql = 'SELECT projects.id, project_title, group_concat(engineer_name SEPARATOR "<br>")
                    FROM projects
                    LEFT JOIN engineers_projects
                    ON projects.id = project_id
                    LEFT JOIN engineers
                    ON engineer_id = engineers.id
                    GROUP BY projects.id;';
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
                    echo '<td><button><a href="?path=projects&action=update&id=' . $row['id'] . '">Update</a></button>'; // Update button
                    echo '<button><a href="?path=projects&action=delete&id=' . $row['id'] . '">Delete</a></button></td>'; // Delete button
                    echo '</tr>';
                }
            }
            echo '<tr><td></td><td><button><a href="?path=projects&action=add" class="add-btn">Create new Project</a></button></td></tr>'; // Inserting add button at the last table row
        ?>
    </tbody>
</table>

<?php // ADD NEW ENGINEER FORM
    if ($_GET['action'] == 'add') {
        echo '<form method="POST">
            <h3>Add new project</h3>
            <label for="project_title">Project name:</label>
            <input type="text" name="project_title" id="project_title">
            <button type="submit">Add</button>
        </form>';
    } // UPDATE EXISTING ENGINEER FORM
    elseif ($_GET['action'] == 'update') {
        
        $sql = 'SELECT project_title FROM projects WHERE id = ' . $_GET['id'];
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $_POST['project_title'] = $row['project_title'];

        echo '<form method="POST">
            <h3>Update project</h3>
            <label for="project_title">Project name:</label>
            <input type="text" name="project_title" id="project_title" value="' . $row['project_title'] . '">
            <button type="submit">Update</button>
        </form>';
    }
?>