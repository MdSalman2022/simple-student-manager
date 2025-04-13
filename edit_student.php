<?php
include 'includes/header.php';
require_once 'includes/db_connect.php';

// Get student ID from URL parameter
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    // Invalid ID, redirect back to student list
    header("Location: student_list.php");
    exit;
}

// Connect to database
$conn = connectDB();

// Initialize variables
$student = null;
$error_message = '';
$success_message = '';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form was submitted, update student
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $major = mysqli_real_escape_string($conn, $_POST['major']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    // Cannot change student_id as it's used as an identifier in other tables

    // Update the student record
    $sql = "UPDATE students SET 
            name = '$name',
            email = '$email',
            department = '$department',
            major = '$major',
            dob = '$dob',
            address = '$address'
            WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        $success_message = "Student information updated successfully.";
    } else {
        $error_message = "Error updating student: " . mysqli_error($conn);
    }
}

// Get student data
$sql = "SELECT * FROM students WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $student = mysqli_fetch_assoc($result);
} else {
    // Student not found, redirect back to student list
    header("Location: student_list.php");
    exit;
}

mysqli_close($conn);
?>

<?php if ($error_message): ?>
    <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>

<?php if ($success_message): ?>
    <div class="alert alert-success"><?php echo $success_message; ?></div>
<?php endif; ?>

<form action="edit_student.php?id=<?php echo $id; ?>" method="post" id="add-student-form" class="form-container">
    <h2 class="page-title">Edit Student</h2>
    
    <div class="form-group">
        <label for="name">Name <span class="required_class">*</span></label>
        <input type="text" id="name" name="name" value="<?php echo $student['name']; ?>" placeholder="Enter student name" required>
    </div>
    
    <div class="form-group">
        <label for="email">Email<span class="required_class">*</span></label>
        <input type="email" id="email" name="email" value="<?php echo $student['email']; ?>" placeholder="Enter email address" required>
    </div>
    
    <div class="form-group">
        <label for="student_id">Student ID<span class="required_class">*</span></label>
        <input type="text" id="student_id" name="student_id" value="<?php echo $student['student_id']; ?>" readonly>
        <small>Student ID cannot be changed</small>
    </div>
    
    <div class="form-group">
        <label for="department">Department<span class="required_class">*</span></label>
        <select id="department" name="department" required onchange="updateMajorOptions()">
            <option value="">Select Department</option>
            <option value="CSE" <?php echo ($student['department'] === 'CSE') ? 'selected' : ''; ?>>CSE</option>
            <option value="EEE" <?php echo ($student['department'] === 'EEE') ? 'selected' : ''; ?>>EEE</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="major">Major<span class="required_class">*</span></label>
        <select id="major" name="major" required>
            <option value="<?php echo $student['major']; ?>"><?php echo $student['major']; ?></option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="dob">Date of Birth<span class="required_class">*</span></label>
        <input type="date" id="dob" name="dob" value="<?php echo $student['dob']; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="address">Address<span class="required_class">*</span></label>
        <textarea id="address" name="address" required><?php echo $student['address']; ?></textarea>
    </div>
    
    <div class="button-group" style="display: flex; gap: 10px;">
        <button type="submit">Save Changes</button>        
        <a href="student_list.php" class="btn" style="display: flex; justify-content: center; align-items: center; padding: 8px 16px; background-color: #f44336; color: white; text-decoration: none; border: none; border-radius: 10px; cursor: pointer; text-align: center; min-width: 100px;">Cancel</a>  
    </div>
</form>

<script>
    function updateMajorOptions() {
        const department = document.getElementById('department').value;
        const majorSelect = document.getElementById('major');
        const currentValue = "<?php echo $student['major']; ?>";
        
        majorSelect.innerHTML = '';
        
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.text = 'Select Major';
        majorSelect.appendChild(defaultOption);
        
        if (department === 'CSE') {
            const cseOptions = [
                'AI', 
                'Robotics', 
                'Development', 
                'Data Science', 
                'Cybersecurity',
                'Computer Networks'
            ];
            
            cseOptions.forEach(option => {
                const newOption = document.createElement('option');
                newOption.value = option;
                newOption.text = option;
                if (option === currentValue) {
                    newOption.selected = true;
                }
                majorSelect.appendChild(newOption);
            });
        } else if (department === 'EEE') {
            const eeeOptions = [
                'Power Systems',
                'Telecommunications',
                'Electrical',
                'Electronics',
                'Control Systems',
                'Embedded Systems'
            ];
            
            eeeOptions.forEach(option => {
                const newOption = document.createElement('option');
                newOption.value = option;
                newOption.text = option;
                if (option === currentValue) {
                    newOption.selected = true;
                }
                majorSelect.appendChild(newOption);
            });
        }
    }
    
    // Initialize the major options when page loads
    document.addEventListener('DOMContentLoaded', function() {
        updateMajorOptions();
    });
</script>