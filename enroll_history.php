<?php 
include 'includes/header.php';
require_once 'includes/db_connect.php';
?>

<style>
    /* Make the page content fill at least 100vh */
    main {
        min-height: calc(100vh - 120px); /* Subtract header and footer approximate heights */
    }
    
    #enrollment-results{ 
        padding: 5px 20px;
        background-color:rgb(231, 231, 231);
        border-radius: 10px;
        min-height: fit; /* Set minimum height for the results container */
        padding-bottom: 20px;
    }
    #enrollment-table {
        background-color: #f9f9f9; /* Soft gray background */
        width: 100%; 
    }
    #enrollment-table tbody tr:hover {
        background-color: #f0f0f0;
    }
    /* Add black background and white text for table headers */
    #enrollment-table thead tr th {
        background-color: #060606;
        color: white;
    }
    .search-form {
        margin-bottom: 20px;
    }
    .search-form input {
        padding: 8px;
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color:rgb(231, 231, 231);
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
    }
</style>

<div class="page-container"> 
        <!-- Simple search input -->
    <div class="search-form">
        <label for="search_student_id" style="display: block; margin-bottom: 5px; font-size: 24px;">Enter student id</label>
        <input type="text" id="search_student_id" placeholder="Search by Student ID..." autocomplete="off">
    </div>
    <div id="enrollment-results">
        <?php
        // Connect to database
        $conn = connectDB();
        
        // Fetch all enrollments
        $sql = "SELECT e.course_code, e.course_title, e.semester, e.grade, e.student_id, s.name 
                FROM enrollments e
                JOIN students s ON e.student_id = s.student_id
                ORDER BY e.semester DESC, s.name";
        
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0) {
            echo '<table id="enrollment-table">';
            echo '<caption>Enrollment History</caption>'; // Added table caption
            echo '<thead><tr>';
            echo '<th>Course Code</th>';
            echo '<th>Course Title</th>';
            echo '<th>Semester</th>';
            echo '<th>Grade</th>';
            echo '</tr></thead><tbody>';
            
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr data-student-id='" . $row["student_id"] . "'>";
                echo "<td>" . $row["course_code"] . "</td>";
                echo "<td>" . $row["course_title"] . "</td>";
                echo "<td>" . $row["semester"] . "</td>";
                echo "<td>" . ($row["grade"] ?: "Not graded") . "</td>";
                echo "</tr>";
            }
            
            echo '</tbody></table>';
        } else {
            echo '<div class="alert alert-info">No enrollment history found.</div>';
        }
        
        mysqli_close($conn);
        ?>
    </div>
</div>

<!-- Simplified JavaScript for filtering -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search_student_id');
    const noResults = document.createElement('div');
    noResults.className = 'alert alert-info';
    noResults.textContent = 'No matching enrollments found.';
    noResults.style.display = 'none';
    document.getElementById('enrollment-results').appendChild(noResults);
    
    searchInput.addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#enrollment-table tbody tr');
        let visible = 0;
        
        rows.forEach(row => {
            const studentId = row.getAttribute('data-student-id').toLowerCase();
            const isVisible = studentId.includes(filter);
            row.style.display = isVisible ? '' : 'none';
            if (isVisible) visible++;
        });
        
        noResults.style.display = (visible === 0 && filter !== '') ? 'block' : 'none';
    });
});
</script>

