<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Sign Up | ISPSC Admission</title>

 <link rel="stylesheet" href="styles.css" />

</head>
<body>

  <div class="signup-box">
    <h2>Sign Up</h2>
    <form action="signup_process.php" method="POST">
      <input type="text" name="username" placeholder="Username" required />
      <input type="password" name="password" placeholder="Password" required />
      <input type="email" name="email" placeholder="Email" required />
      <select name="role" required>
        <option value="" disabled selected>Select role</option>
        <option value="student">Student</option>
        <option value="admin">Admin</option>
      </select>
      <button type="submit">Create Account</button>
    </form>
  </div>

  <p class="signup-footer">
    Already have an account? <a href="login.php">Login here</a>
  </p>

</body>
</html>
