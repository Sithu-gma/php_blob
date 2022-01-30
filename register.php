<?php
  session_start();
  require "config/db.php";
 
  if($_POST){
    if(empty($_POST['name'])|| empty($_POST['email'])|| empty($_POST['password'])|| strlen($_POST['password'])<4){
            
      if(empty($_POST['name'])){             
        $nameErr="YOUR Name is Null.";
      }
      if(empty($_POST['email'])){
        $emailErr="YOUR Email is Null.";
      }
      if(empty($_POST['password'])){
        $passErr="YOUR password is Null.";
      }else if(strlen($_POST['password'])<4){
        $passErr="YOUR have to fill at least 4  char";
      }
      
    }else{
      $email=$_POST['email'];
      $password=password_hash($_POST['password'],PASSWORD_DEFAULT);  
      $name=$_POST['name'];
      $role=2;
      $stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email");
      $stmt->bindValue(":email", $email);
      $stmt->execute();
      $user=$stmt->fetch(PDO::FETCH_ASSOC);
      
    
      if($user){
      
        echo "<script>alert('Duplicated Email')</script>";
      }else {
          $stmt=$pdo->prepare("INSERT INTO users (name , email, password ,role) VALUES (:name, :email, :password ,:role) ");
          $stmt->bindValue(":email", $email);
          $stmt->bindValue(":name", $name);
          $stmt->bindValue(":password", $password);
          $stmt->bindValue(":role", $role);
          $result=$stmt->execute();
          if($result){
      
              echo "<script>alert('successfully register now');window.location.href('login.php')</script>";
          }
      }
    }
  }
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Blob</b> </a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="register.php" method="post">
      <p class="text-danger"><?php echo empty($nameErr)? '': $nameErr;?></p>
      <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" placeholder="Name">
          <div class="input-group-append">
            <div class="input-group-text">           
              <br><span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <p class="text-danger"><?php echo empty($emailErr)? '': $emailErr;?></p>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <p class="text-danger"><?php echo empty($passErr)? '': $passErr;?></p>
        <div class="input-group mb-3">
          <input type="password" class="form-control"name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
         
          <!-- /.col -->
          <div class="container">
            <button type="submit" class="btn btn-primary btn-block">New Register</button>
            <a href="login.php"class="btn btn-default btn-block">Login</a>
          </div>
          <!-- /.col -->
        </div>
      </form>

    
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
