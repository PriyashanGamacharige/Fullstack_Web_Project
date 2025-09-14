<?php
$conn = new mysqli("localhost", "root", "", "student_db");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student = null;
$errorMessage = "";


if (isset($_POST['search'])) {
    $nic = $_POST['nic'];
    $sql = "SELECT * FROM students WHERE nic='$nic'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        $errorMessage = "No student found with that NIC.";
    }
}


if (isset($_POST['update'])) {
    $nic     = $_POST['nic'];
    $name    = $_POST['name'];
    $address = $_POST['address'];
    $tel     = $_POST['tel'];
    $course  = $_POST['course'];
    
    $sql = "UPDATE students 
            SET name='$name', address='$address', tel='$tel', course='$course' 
            WHERE nic='$nic'";
    
    if ($conn->query($sql) === TRUE) {
        $errorMessage = "Student details updated successfully.";
    } else {
        $errorMessage = "Error: " . $conn->error;
    }
}


if (isset($_POST['delete'])) {
    $nic = $_POST['nic'];
    $sql = "DELETE FROM students WHERE nic='$nic'";
    
    if ($conn->query($sql) === TRUE) {
        $errorMessage = "Student deleted successfully.";
        $student = null;
    } else {
        $errorMessage = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Students</title>
  <style>
    
    .navbar {
      display: flex;
      align-items: center;
      background: linear-gradient(90deg, #004e92, #000428);
      padding: 15px;

    }
    .logo-container {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .logo img {
      height: 75px;
      width: 200px;
    }
    .nav-links {
      list-style: none;
      display: flex;
      gap: 15px;
      margin-left: auto;
    }
    .nav-links li {
      display: inline;
    }
    .nav-links a {
      color: white;
      text-decoration: none;
      padding: 10px 15px;
      border-radius: 5px;
      transition: all 0.3s ease-in-out;
    }
    .nav-links a:hover {
      background: #ffcc00;
      color: #000;
      box-shadow: 0 0 10px #ffcc00;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #00c9ff, #92fe9d);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }



    .container {
      background-color: #ffffffcc;
      padding: 30px 35px;
      border-radius: 15px;
      width: 70%;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      animation: fadeIn 0.6s ease-in-out;
      margin: 30px auto;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }

    label {
      font-weight: bold;
      margin-bottom: 5px;
      display: block;
      color: #444;
    }

    input[type="text"],
    input[type="tel"],
    textarea,
    select {
      width: 97%;
      padding: 10px 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
      background-color: #f9f9f9;
      transition: all 0.3s;
    }

    input:focus,
    textarea:focus,
    select:focus {
      border-color: #00c9ff;
      outline: none;
      background-color: #fff;
    }

    button {
      padding: 10px 15px;
      margin-top: 5px;
      width: 100%;
      background: linear-gradient(to right, #667eea, #764ba2);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: linear-gradient(to right, #5f2c82, #49a09d);
    }

    .btn-group {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }

    .error {
      color: #d8000c;
      background-color: #ffd2d2;
      padding: 10px;
      text-align: center;
      border-radius: 8px;
      margin-top: 20px;
      margin-bottom: 20px;
      font-size: 14px;
      font-weight: bold;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

  <div class="navbar">
    <div class="logo-container">
      <div class="logo">
        <img src="Logo.jpg" alt="Logo">
      </div>
    </div>
    <ul class="nav-links">
    <li><a href="index.html">HOME</a></li>
    <li><a href="about.html">ABOUT</a></li>
    <li><a href="lms.html">STUDENT LMS</a></li>
    <li><a href="courses.html">COURSES</a></li>
    </ul>
  </div>

  <div class="container">
    <h2>Manage Students</h2>

    <form method="POST">
      <label for="nic">Search Student by NIC:</label>
      <input type="text" id="nic" name="nic" placeholder="Enter NIC number" required>
      <button type="submit" name="search">Search</button>
    </form>

    <?php if (!empty($errorMessage)): ?>
      <div class="error"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <?php if ($student): ?>
      <form method="POST">
        <input type="hidden" name="nic" value="<?php echo $student['nic']; ?>">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $student['name']; ?>" required>

        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="3" required><?php echo $student['address']; ?></textarea>

        <label for="tel">Tel. No:</label>
        <input type="tel" id="tel" name="tel" value="<?php echo $student['tel']; ?>" required>

        <label for="course">Course:</label>
        <select id="course" name="course" required>
          <option value="ict" <?php echo ($student['course'] == 'ict') ? 'selected' : ''; ?>>ICT</option>
          <option value="engineering" <?php echo ($student['course'] == 'engineering') ? 'selected' : ''; ?>>Engineering</option>
          <option value="business" <?php echo ($student['course'] == 'business') ? 'selected' : ''; ?>>Business</option>
          <option value="arts" <?php echo ($student['course'] == 'arts') ? 'selected' : ''; ?>>Arts</option>
        </select>

        <div class="btn-group">
          <button type="submit" name="update">Update</button>
          <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this student?');" style="background: linear-gradient(to right, #ff416c, #ff4b2b);">Delete</button>
        </div>
      </form>
    <?php endif; ?>
  </div>


</body>
</html>
