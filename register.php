<?php
$conn = new mysqli("localhost", "root", "", "student_db");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$nic     = $_POST['nic'];
$name    = $_POST['name'];
$address = $_POST['address'];
$tel     = $_POST['tel'];
$course  = $_POST['course'];


$sql = "INSERT INTO students (nic, name, address, tel, course) 
        VALUES ('$nic', '$name', '$address', '$tel', '$course')";

if ($conn->query($sql) === TRUE) {
  echo '
  <html>
  <head>
    <title>Registration Success</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #00c9ff, #92fe9d);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
      }
      .container {
        background-color: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        text-align: center;
      }
      h2 {
        color: #28a745;
        margin-bottom: 20px;
      }
      button {
        background-color: #007bff;
        color: white;
        padding: 12px 24px;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }
      button:hover {
        background-color: #0056b3;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h2>Registration Successful!</h2>
      <button onclick="window.location.href=\'index.html\'">Go to Home Page</button>
    </div>
  </body>
  </html>';
}
else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
