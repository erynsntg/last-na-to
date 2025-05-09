<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_number'])) {
    $studentNumber = trim($_POST['student_number']);
    $xmlFile = 'records.xml';

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);

        $deletedCount = 0;

        // Loop 
        for ($i = count($xml->record) - 1; $i >= 0; $i--) {
            $record = $xml->record[$i];
            if (trim((string)$record->student_number) === $studentNumber) {
                unset($xml->record[$i]);
                $deletedCount++;
            }
        }

        if ($deletedCount > 0) {
            $xml->asXML($xmlFile);
            $message = "$deletedCount record(s) with Student Number $studentNumber have been deleted.";
        } else {
            $message = "No record found with Student Number $studentNumber.";
        }
    } else {
        $message = "records.xml file not found.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Delete Record</title>
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

    .btn.del{
      background-color: rgba(218, 74, 93, 1);
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
  <a href="acc.php"><span>⚙️</span> &nbsp;Account Settings</a>
  <a href="login.php"><span>🔓</span> &nbsp;Log out</a>
  </div>

  <div class="main-content">
    <div class="form-container">
      <h2>Delete a Record</h2>

      <?php if ($message): ?>
        <p style="color: <?= strpos($message, 'deleted') !== false ? 'green' : 'red' ?>;">
          <?= htmlspecialchars($message) ?>
        </p>
      <?php endif; ?>

      <form method="post" action="">
        <div class="form-group">
          <label for="student-number">Student Number</label>
          <input type="text" name="student_number" id="student-number" placeholder="Enter student number" required>
        </div>

        <div class="form-buttons">
          <button type="button" class="btn back" onclick="window.location.href='index.php'">Back</button>
          <button type="submit" class="btn del">Delete</button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
