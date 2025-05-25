<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login | ISPSC Admission</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>

  <div class="login-box">
    <h2>Login</h2>
    <form action="login_process.php" method="POST">
      <input type="text" name="username" placeholder="Username" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Login</button>
    </form>
  </div>

  <p class="login-footer">
    Don't have an account? <a href="signup.php">Sign up here</a>
  </p>

</body>
</html>
