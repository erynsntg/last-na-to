<?php
session_start();

$message = "";
$selectedAccount = null;

$xmlFile = "account.xml";
$uploadDir = "uploads/";

// pang ensure na si user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$loggedInEmail = $_SESSION['email'];

// pang ensure ng upload directory exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
        $accountFound = false;

        foreach ($xml->account as $account) {
            if ((string)$account->email === $loggedInEmail) {
                $account->first_name = htmlspecialchars($_POST["first_name"]);
                $account->last_name = htmlspecialchars($_POST["last_name"]);
                $account->password = htmlspecialchars($_POST["password"]);
                $account->contact = htmlspecialchars($_POST["contact"]);

                // ito pang image upload
                if (!empty($_FILES['profile']['name'])) {
                    $fileName = basename($_FILES["profile"]["name"]);
                    $targetPath = $uploadDir . $fileName;

                    if (move_uploaded_file($_FILES["profile"]["tmp_name"], $targetPath)) {
                        $account->profile = $targetPath;
                    }
                }

                $accountFound = true;
                $xml->asXML($xmlFile);
                $message = "Account updated successfully.";
                $selectedAccount = $account;
                break;
            }
        }

        if (!$accountFound) {
            $message = "No account found with that email.";
        }
    } else {
        $message = "account.xml not found.";
    }
} else {
    //pang load ng info ni user
    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
        foreach ($xml->account as $account) {
            if ((string)$account->email === $loggedInEmail) {
                $selectedAccount = $account;
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Account Settings</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }
    .header {
      background-color: #a10f2b;
      color: white;
      padding: 15px;
      display: flex;
      align-items: center;
    }
    .header img {
      height: 40px;
      margin-right: 10px;
    }
    .sidebar {
      width: 200px;
      background-color: #b21632;
      color: white;
      position: fixed;
      height: 100%;
      padding-top: 30px;
    }
    .sidebar a {
      padding: 15px;
      text-decoration: none;
      display: block;
      color: white;
    }
    .sidebar a.active, .sidebar a:hover {
      background-color: #e06767;
    }
    .main-content {
      margin-left: 200px;
      padding: 30px;
      background: #f6f6f6;
      min-height: 100vh;
    }
    .profile-container {
      background: white;
      padding: 30px;
      display: flex;
      border-radius: 10px;
    }
    .profile-left {
      width: 30%;
      text-align: center;
      border-right: 1px solid #ddd;
      padding-right: 30px;
    }
    .profile-left img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
    }
    .profile-right {
      width: 70%;
      padding-left: 30px;
    }
    .form-group {
      margin-bottom: 15px;
    }
    .form-group input {
      padding: 10px;
      width: 45%;
      margin-right: 5%;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .form-actions {
      text-align: right;
    }
    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      color: white;
      cursor: pointer;
    }
    .btn-save {
      background-color: #db8d4b;
    }
    .btn-cancel {
      background-color: #f2f2f2;
      color: black;
      border: 1px solid #ccc;
      margin-right: 10px;
    }
    .message {
      margin-top: 20px;
      font-weight: bold;
      color: green;
    }
    .message.error {
      color: red;
    }
  </style>
</head>
<body>

<div class="header">
  <img src="bsu.png" alt="BSU Logo">
  <span class="university-name">Bulacan State University</span>
</div>

<div class="sidebar">
  <a href="home.php">🏠 &nbsp;Home</a>
  <a href="about.html">ℹ️ &nbsp;About</a>
  <a class="active" href="acc.php">⚙️ &nbsp;Account Settings</a>
  <a href="index.html">🔓 &nbsp;Log out</a>
</div>

<div class="main-content">
  <form class="profile-container" method="POST" action="" enctype="multipart/form-data">
    <div class="profile-left">
      <img id="profileImage" src="<?php echo isset($selectedAccount) && $selectedAccount->profile ? $selectedAccount->profile : 'pfp.png'; ?>" alt="Profile Image">
      <p id="userName" style="font-size: 16px; font-weight: 600; margin-top: 10px;">
        <?php echo isset($selectedAccount) ? $selectedAccount->first_name . ' ' . $selectedAccount->last_name : ''; ?>
      </p>
      <p style="font-size: 14px; color: gray;">ADMIN</p>
      <input type="file" name="profile">
    </div>

    <div class="profile-right">
      <h3 style="font-size: 14px; font-weight: 600; margin-bottom: 20px;">BASIC INFO</h3>

      <div class="form-group">
        <input type="text" placeholder="First Name" name="first_name" value="<?php echo isset($selectedAccount) ? $selectedAccount->first_name : ''; ?>" required>
        <input type="text" placeholder="Last Name" name="last_name" value="<?php echo isset($selectedAccount) ? $selectedAccount->last_name : ''; ?>" required>
      </div>
      <div class="form-group">
        <input type="text" placeholder="Contact Number" name="contact" value="<?php echo isset($selectedAccount) ? $selectedAccount->contact : ''; ?>" required>
        <input type="password" placeholder="Password" name="password" value="<?php echo isset($selectedAccount) ? $selectedAccount->password : ''; ?>" required>
      </div>

      <div class="form-actions">
        <button type="reset" class="btn btn-cancel">Cancel</button>
        <button type="submit" class="btn btn-save">Save</button>
      </div>

      <?php if (!empty($message)): ?>
        <div class="message <?php echo strpos($message, 'No account') !== false ? 'error' : ''; ?>">
          <?php echo $message; ?>
        </div>
      <?php endif; ?>
    </div>
  </form>
</div>

</body>
</html>
