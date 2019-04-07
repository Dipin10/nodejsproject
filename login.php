<?php

include('loginserver.php');

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <?php include('header.php');?>
  <div class="header">
  	<h2>Login</h2>
  </div>

  <form method="POST" action="">
  	<?php include('errors.php');
    if(isset($_SESSION['login']) && $_SESSION['login'] == 'ok'){
      // header('location:index.php');
      $destURL = $_SESSION['kickurl'] ? $_SESSION['kickurl'] : 'index.php';
      unset($_SESSION['kickurl']);
      header('Location: ' . $destURL);
    }
    ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  		Not yet a member? <a href="register.php">Sign up</a>
  	</p>
  </form>
  <?php include('footer.php'); ?>
</body>
</html>
