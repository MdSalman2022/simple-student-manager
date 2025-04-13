<?php
require_once 'includes/db_connect.php';


$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';

if (empty($student_id)) {
    
    header("Location: student_list.php");
    exit;
}


$conn = connectDB();


$sql = "DELETE FROM enrollments WHERE student_id = '$student_id'";
mysqli_query($conn, $sql);


$sql = "DELETE FROM students WHERE student_id = '$student_id'";
if (mysqli_query($conn, $sql)) {
    
    header("Location: student_list.php?status=delete_success");
} else {
    
    header("Location: student_list.php?status=delete_error&message=" . urlencode(mysqli_error($conn)));
}

mysqli_close($conn);