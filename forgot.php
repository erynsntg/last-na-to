<?php
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $newPassword = htmlspecialchars($_POST["password"]);

    $xmlFile = 'account.xml';

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
        $accountFound = false;

        foreach ($xml->account as $account) {
            if ((string)$account->email === $email) {
                $account->password = $newPassword;
                $xml->asXML($xmlFile);
                $accountFound = true;
                $message = "Password updated successfully.";
                break;
            }
        }

        if (!$accountFound) {
            $message = "Updating password fails, there's no account with that email.";
        }
    } else {
        $message = "No account data found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Forgot Password</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      min-height: 100vh;
      font-family: 'Inter', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background: url('BULSU.png') no-repeat center center;
      background-size: cover;
      padding: 20px;
    }
    .logo {
      width: 150px;
      height: 150px;
      margin-bottom: 15px;
      background: url('bsu.png') no-repeat center center;
      background-size: contain;
    }
    .wrapper {
      background: rgba(34, 33, 33, 0.6);
      padding: 30px;
      border-radius: 20px;
      width: 100%;
      max-width: 400px;
      text-align: center;
      color: #fff;
    }
    .title { font-size: 20px; margin-bottom: 10px; }
    .subtitle { font-size: 14px; margin-bottom: 20px; }
    label {
      display: block;
      text-align: left;
      margin-bottom: 5px;
      font-weight: 500;
      font-size: 14px;
    }
    input {
      width: 100%;
      padding: 10px;
      border-radius: 12px;
      border: none;
      margin-bottom: 15px;
      font-size: 14px;
    }
    button {
      width: 100%;
      padding: 10px;
      background-color: #A8132D;
      border: none;
      border-radius: 12px;
      color: white;
      font-size: 15px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }
    button:hover { background-color: #8f1026; }
    .links {
      margin-top: 15px;
      font-size: 13px;
    }
    .links a {
      color: #ddd;
      text-decoration: none;
    }
    .links a:hover {
      text-decoration: underline;
    }
    .message {
      margin-bottom: 15px;
      font-size: 14px;
      color: yellow;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="logo"></div>

  <div class="wrapper">
    <div class="title">Student Information Management System</div>
    <div class="subtitle">Reset your password</div>

    <?php if (!empty($message)): ?>
      <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Enter email" required />

      <label for="password">New Password</label>
      <input type="password" id="password" name="password" placeholder="Enter new password" required />

      <button type="submit">Submit</button>
    </form>

    <div class="links">
      <p><a href="login.php">Back to Login</a></p>
    </div>
  </div>
</body>
</html>
