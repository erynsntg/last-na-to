<?php
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailInput = htmlspecialchars($_POST['email']);
    $passwordInput = htmlspecialchars($_POST['password']);
    $xmlFile = 'account.xml';

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
        $found = false;

        foreach ($xml->account as $account) {
            if ((string)$account->email === $emailInput && (string)$account->password === $passwordInput) {
                // Match found
                $found = true;
                session_start();
                $_SESSION['email'] = (string)$account->email;
                header("Location: home.php");
                exit;
            }
        }

        if (!$found) {
            $message = "There's no account yet";
        }
    } else {
        $message = "There's no account yet";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <style>
 * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      overflow-x: hidden;
      background: #F8F8F8;
      font-family: 'Inter', sans-serif;
    }

    .background-img {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: url('BULSU.png') no-repeat center center;
      background-size: cover;
      z-index: -1;
    }

    .logo {
      margin: 40px auto 0;
      width: 150px;
      height: 150px;
      background: url('bsu.png') no-repeat center center;
      background-size: contain;
    }

    .login-box {
      margin: 20px auto;
      width: 90%;
      max-width: 400px;
      background: rgba(34, 33, 33, 0.6);
      padding: 20px;
      border-radius: 15px;
    }

    .title, .subtitle {
      text-align: center;
      color: white;
    }

    .title {
      font-size: 20px;
      margin-bottom: 10px;
    }

    .subtitle {
      font-size: 14px;
      margin-bottom: 20px;
    }

    label, input, button {
      display: block;
      width: 100%;
      margin: 10px 0;
    }

    label {
      color: white;
      font-size: 14px;
    }

    input[type="text"], input[type="password"] {
      padding: 10px;
      border-radius: 10px;
      border: 1px solid #ccc;
    }

    .remember {
      display: flex;
      align-items: center;
      font-size: 13px;
      color: white;
    }

    .remember input {
      width: auto;
      margin-right: 10px;
    }

    .login-button {
      background: #A8132D;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 10px;
      cursor: pointer;
      font-size: 14px;
    }

    .forgot-link {
      text-align: center;
      margin-top: 10px;
      font-size: 12px;
    }

    .forgot-link a {
      color: #00f;
      text-decoration: none;
    }

    .forgot-link a:hover {
      text-decoration: underline;
    }

    .signup-text {
      text-align: center;
      font-size: 12px;
      color: white;
      margin-top: 10px;
    }

    .signup-text a {
      color: #00f;
      text-decoration: none;
    }

    .signup-text a:hover {
      text-decoration: underline;
    }
    .error-message {
      text-align: center;
      color: yellow;
      font-size: 14px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="background-img"></div>
  <div class="logo"></div>

  <div class="login-box">
    <div class="title">Student Information Management System</div>
    <div class="subtitle">Login to your account</div>

    <?php if ($message): ?>
      <div class="error-message"><?= $message ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" placeholder="Enter email" required />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required />

        <div class="remember">
          <input type="checkbox" id="remember" name="remember" />
          <label for="remember">Remember Me</label>
        </div>

        <button type="submit" class="login-button">Login</button>
    </form>

    <div class="forgot-link">
      <a href="forgot.php">Forgot password?</a>
    </div>

    <div class="signup-text">
      Don’t have an account yet? <a href="signup.php">Sign up</a>
    </div>
  </div>
</body>
</html>
