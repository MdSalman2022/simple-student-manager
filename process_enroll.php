<?php
require_once 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $student_id = mysqli_real_escape_string(connectDB(), $_POST['student_id']);
    $course_code = mysqli_real_escape_string(connectDB(), $_POST['course_code']);
    $course_title = mysqli_real_escape_string(connectDB(), $_POST['course_title']);
    $semester = mysqli_real_escape_string(connectDB(), $_POST['semester']);
    
    // Connect to database
    $conn = connectDB();
    
    // Check if student exists
    $check_query = "SELECT student_id FROM students WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $check_query);
    
    if(mysqli_num_rows($result) == 0) {
        // Student ID doesn't exist
        mysqli_close($conn);
        header("location: enroll_course.php?error=student_not_found");
        exit();
    }
    
    // Insert into enrollments table
    $sql = "INSERT INTO enrollments (student_id, course_code, course_title, semester) 
            VALUES ('$student_id', '$course_code', '$course_title', '$semester')";
    
    if(mysqli_query($conn, $sql)){
        mysqli_close($conn);
        header("location: enroll_course.php?status=success");
        exit();
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
    
    // Close connection
    mysqli_close($conn);
} else {
    // Redirect if accessed directly
    header("location: enroll_course.php");
    exit();
}
?>