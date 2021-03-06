<?php

session_start();


$username = "";
$email    = "";
$Address  = "";
$Phoneno  = "";
$errors = array();
global $db;
$db = mysqli_connect('localhost', 'root', '', 'registration');

if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $Address = mysqli_real_escape_string($db, $_POST['address']);
  $Phoneno = mysqli_real_escape_string($db, $_POST['Phoneno']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($Address)) { array_push($errors, "Address is required"); }
  if (empty($Phoneno)) { array_push($errors, "Phone No  is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }


    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) === 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username,Address,Phoneno, email, password)
  			  VALUES('$username','$Address','$Phoneno', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: login.php');
  }
}
// // ...

// LOGIN USER
if (isset($_POST['login_user'])) {

  if(isset($_SESSION['username']))
   {
     header("location:logout.php");
   }

  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);

     if (mysqli_num_rows($results) == 1) {
      $row = mysqli_fetch_assoc($results);
  	  $_SESSION['username'] = $username;
      $_SESSION['user_id'] = $_GET['id'];
  	  $_SESSION['success'] = "You are now logged in";


       if(isset($_SESSION["redirect"])){
            header('location:'.$_SESSION["redirect"]);
        }
        else{
          header('location: logout.php');
        }
  	}
    else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}




?>
