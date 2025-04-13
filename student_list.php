<?php 
include 'includes/header.php';
require_once 'includes/db_connect.php';
?>

<style>
    /* Make the page content fill at least 100vh */
    main {
        min-height: calc(100vh - 120px); /* Subtract header and footer approximate heights */
    }
    
    #student-list-container { 
        padding: 5px 20px;
        background-color:rgb(231, 231, 231);
        border-radius: 10px;
        min-height: 70vh; /* Set minimum height for the results container */
    }
    #student-table {
        background-color: #f9f9f9; /* Soft gray background */
        width: 100%; 
    }
    #student-table tbody tr:hover {
        background-color: #f0f0f0;
    }
    /* Add black background and white text for table headers */
    #student-table thead tr th {
        background-color: #030303;
        color: white;
    }
    
    table caption {
        font-size: 24px;
        font-weight: bold; 
        text-align: left;
        border-bottom: 1px solid #ddd;
        margin-bottom: 10px;
    }
    
    /* Add these styles for page structure */
    .page-container {
        display: flex;
        flex-direction: column;
        min-height: calc(100vh - 100px);
    }
    
    .page-title {
        margin-bottom: 2rem;
        text-align: center;
        font-weight: normal;
    }
    
    /* Style for action buttons */
    .action-btn {
        padding: 5px 8px;
        margin-right: 5px;
        border-radius: 4px;
        cursor: pointer;
        color: white;
        text-decoration: none;
        display: inline-block;
    }
    
    .edit-btn {
        background-color: #4CAF50;
    }
    
    .delete-btn {
        background-color: #f44336;
    }
    
    .action-btn:hover {
        opacity: 0.8;
    }
</style>

<div class="page-container">
    <h2 class="page-title">Student List</h2>

    <div id="student-list-container">
        <?php
        
        $conn = connectDB();

        
        $sql = "SELECT id, name, student_id, department, major, email FROM students ORDER BY name";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0) {
            echo '<table id="student-table">';
            echo '<caption>Student List</caption>';
            echo '<thead><tr>';
            echo '<th>Name</th>';
            echo '<th>Student ID</th>';
            echo '<th>Department</th>';
            echo '<th>Major</th>';
            echo '<th>Email</th>';
            echo '<th>Actions</th>';
            echo '</tr></thead><tbody>';
            
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["student_id"] . "</td>";
                echo "<td>" . $row["department"] . "</td>";
                echo "<td>" . $row["major"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>
                        <a href='edit_student.php?id=" . $row["id"] . "' class='action-btn edit-btn'><i class='fas fa-edit'></i></a>
                        <a href='#' onclick='confirmDelete(\"" . $row["student_id"] . "\", \"" . $row["name"] . "\")' class='action-btn delete-btn'><i class='fas fa-trash'></i></a>
                      </td>";
                echo "</tr>";
            }
            
            echo '</tbody></table>';
        } else {
            echo '<div class="alert alert-info">No students found</div>';
        }
        
        mysqli_close($conn);
        ?>
    </div>
</div>

<script>
function confirmDelete(studentId, name) {
    if (confirm("Are you sure you want to delete " + name + "?")) {
        window.location.href = "delete_student.php?student_id=" + studentId;
    }
}
</script>

