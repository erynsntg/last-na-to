<?php
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = htmlspecialchars($_POST["firstName"]);
    $lastName = htmlspecialchars($_POST["lastName"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $contact = htmlspecialchars($_POST["contact"]);

    $xmlFile = 'account.xml';

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
    } else {
        $xml = new SimpleXMLElement('<accounts></accounts>');
    }

    // Check if email already exists
    $emailExists = false;
    foreach ($xml->account as $account) {
        if ((string)$account->email === $email) {
            $emailExists = true;
            break;
        }
    }

    if ($emailExists) {
        $message = "Email is already registered.";
    } else {
        $newAccount = $xml->addChild('account');
        $newAccount->addChild('first_name', $firstName);
        $newAccount->addChild('last_name', $lastName);
        $newAccount->addChild('email', $email);
        $newAccount->addChild('password', $password);
        $newAccount->addChild('contact', $contact);

        $xml->asXML($xmlFile);

        // Optional: delay message before redirect
        echo "<script>alert('Account registered successfully. Redirecting to login page...'); window.location.href='login.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <style>
  * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html, body {
      height: 100%;
      overflow: hidden; 
      font-family: 'Inter', sans-serif;
    }

    body {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background: url('BULSU.png') no-repeat center center;
      background-size: cover;
      padding: 10px;
    }

    .logo {
      width: 150px;
      height: 150px;
      background: url('bsu.png') no-repeat center center;
      background-size: contain;
      margin-bottom: 10px;
    }

    .form-container {
      width: 360px;
      background: linear-gradient(180deg, rgba(34, 33, 33, 0.42), rgba(17, 16, 16, 0.651), rgba(34, 31, 31, 0.602));
      border-radius: 10px;
      padding: 15px 20px;
      color: #fff;
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 8px;
      font-size: 18px;
    }

    .form-container p {
      text-align: center;
      margin-bottom: 15px;
      font-size: 14px;
      font-weight: 600;
    }

    .input-group {
      margin-bottom: 12px;
    }

    .input-group label {
      display: block;
      margin-bottom: 4px;
      font-size: 13px;
      font-weight: 500;
    }

    .input-group input {
      width: 100%;
      height: 30px;
      border: 1px solid #ACA6A6;
      border-radius: 6px;
      padding: 0 8px;
      font-size: 13px;
      color: #000;
    }

    .submit-btn {
      width: 100%;
      height: 32px;
      background-color: #A8132D;
      color: white;
      font-size: 14px;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      margin-top: 10px;
    }
    .error-message {
      text-align: center;
      color: yellow;
      font-size: 14px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <div class="logo"></div>

  <div class="form-container">
    <h2>Student Information Management System</h2>
    <p>Create your account</p>

    <?php if (!empty($message)): ?>
      <div class="error-message"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="input-group">
        <label for="firstName">First Name</label>
        <input type="text" id="firstName" name="firstName" placeholder="Enter first name" required>
      </div>

      <div class="input-group">
        <label for="lastName">Last Name</label>
        <input type="text" id="lastName" name="lastName" placeholder="Enter last name" required>
      </div>

      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter email" required>
      </div>

      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required>
      </div>

      <div class="input-group">
        <label for="contact">Contact Number</label>
        <input type="text" id="contact" name="contact" placeholder="Enter contact number" required>
      </div>

      <button type="submit" class="submit-btn">Register</button>
    </form>
  </div>

</body>
</html>
