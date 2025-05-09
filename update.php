<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentNumber = $_POST['student_number'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $program = $_POST['program'];
    $yearLevel = $_POST['year_level'];

    $xmlFile = 'records.xml';

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);

        $recordFound = false;

        foreach ($xml->record as $record) {
            if ((string)$record->student_number === $studentNumber) {
                $record->first_name = htmlspecialchars($firstName);
                $record->last_name = htmlspecialchars($lastName);
                $record->program = htmlspecialchars($program);
                $record->year_level = htmlspecialchars($yearLevel);
                $recordFound = true;
                break;
            }
        }

        if ($recordFound) {
            $xml->asXML($xmlFile);
            $message = "Record has been updated.";
        } else {
            $message = "Student number not found.";
        }
    } else {
        $message = "No records found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Record</title>
  <style>
    body {
      margin: 0;
      background: #F8F8F8;
      font-family: 'Inter', sans-serif;
    }

    .header {
      position: fixed;
      top: 0;
      width: 100%;
      height: 96px;
      background-color: #A8132D;
      display: flex;
      align-items: center;
      padding-left: 46px;
      color: white;
      z-index: 1000;
    }

    .header img {
      width: 62px;
      height: 64px;
      margin-right: 20px;
    }

    .university-name {
      font-family: 'Montserrat', sans-serif;
      font-size: 28px;
      font-weight: 600;
    }

    .sidebar {
      position: fixed;
      top: 96px;
      left: 0;
      width: 252px;
      height: calc(100% - 96px);
      background-color: rgba(168, 19, 45, 1);
      padding-top: 30px;
      display: flex;
      flex-direction: column;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      padding: 15px 20px;
      color: #FFF;
      text-decoration: none;
      font-family: 'Montserrat', sans-serif;
      font-size: 16px;
      font-weight: 600;
      transition: background 0.3s;
    }

    .sidebar a.active,
    .sidebar a:hover {
      background-color: #c53249;
    }

    .main-content {
      margin-left: 252px;
      padding-top: 120px;
      display: flex;
      justify-content: center;
    }

    .form-container {
      background-color: white;
      padding: 40px 50px;
      border-radius: 10px;
      width: 500px;
      box-shadow: 0px 0px 10px #ccc;
    }

    .form-container h2 {
      font-family: 'Montserrat', sans-serif;
      font-size: 24px;
      font-weight: 600;
      text-align: center;
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 5px;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px 12px;
      border-radius: 15px;
      border: 1px solid #ACA6A6;
      font-size: 14px;
      outline: none;
    }

    .form-buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }

    .btn {
      border: none;
      border-radius: 8px;
      padding: 10px 24px;
      font-size: 14px;
      font-weight: 600;
      color: white;
      cursor: pointer;
    }

    .btn.back {
      background-color: #4B79D7;
    }

    .btn.upd{
      background-color: rgba(249, 214, 77, 1);
    }
  </style>
</head>
<body>

  <div class="header">
    <img src="bsu.png" alt="BSU Logo">
    <span class="university-name">Bulacan State University</span>
  </div>

  <div class="sidebar">
    <a class="active" href="index.php"><span>🏠</span> &nbsp;Home</a>
    <a href="about.html"><span>ℹ️</span> &nbsp;About</a>
    <a href="acc.html"><span>⚙️</span> &nbsp;Account Settings</a>
    <a href="login.html"><span>🔓</span> &nbsp;Log out</a>
  </div>

  <div class="main-content">
    <div class="form-container">
      <h2>Update Record</h2>

      <?php if ($message): ?>
        <p style="color: <?= strpos($message, 'updated') !== false ? 'green' : 'red' ?>; text-align: center;">
          <?= htmlspecialchars($message) ?>
        </p>
      <?php endif; ?>

      <form method="post" action="">
        <div class="form-group">
          <label for="student-number">Student Number</label>
          <input type="text" id="student-number" name="student_number" placeholder="Enter student number" required>
        </div>

        <div class="form-group">
          <label for="first-name">First Name</label>
          <input type="text" id="first-name" name="first_name" placeholder="Enter first name" required>
        </div>

        <div class="form-group">
          <label for="last-name">Last Name</label>
          <input type="text" id="last-name" name="last_name" placeholder="Enter last name" required>
        </div>

        <div class="form-group">
          <label for="program">Program</label>
          <input type="text" id="program" name="program" placeholder="Enter program" required>
        </div>

        <div class="form-group">
          <label for="year-level">Year Level</label>
          <select id="year-level" name="year_level" required>
            <option value="" disabled selected>Enter year level</option>
            <option>1st Year</option>
            <option>2nd Year</option>
            <option>3rd Year</option>
            <option>4th Year</option>
          </select>
        </div>

        <div class="form-buttons">
          <button type="button" class="btn back" onclick="window.location.href='index.php'">Back</button>
          <button type="submit" class="btn upd">Update</button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
