<?php 
  session_start();
  require "../config/db.php";
  if(empty($_SESSION['user_id']) and empty($_SESSION['logged_in'])) {
    header("location: login.php");
  }
  include('header.php');
?>
    <!-- Main content -->
    <?php
        if($_POST){           
          $name=$_POST['name'];
          $email=$_POST['email'];  
          $password=$_POST['password'];  
         
          if(empty($_POST['role'])){
            $role=2;
          }else{
            $role=1;
          };
          $stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email");
          $stmt->bindValue(':email',$email);
          $stmt->execute();
          $user=$stmt->fetch(PDO::FETCH_ASSOC);   
        
        
            if($user) {              
              echo "<script>alert('Email is duplicated');window.location.href='user-add.php?duplicated=true';</script>";
            }else{
              $stmt=$pdo->prepare("INSERT INTO users (name, email, role, password) VALUES (:name, :email, :role, :password)");
              $result=$stmt->execute([
                ':name' => $name,
                ':email'=> $email,
                ':role' => $role,
                ':password' => $password,
              ]);
             
            }  
            if($result) {
              echo "<script>alert('The Blog has just Added');window.location.href='user-list.php';</script>";
            }         
         
                  
      }

     

    ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Create New User</h4>
                </div>
                <div class="card-title">
                  <?php if(isset($_GET['duplicated'])): ?>                    
                        <div class="alert alert-danger" role="alert">
                          Oh!A USER HAS ALDY USE THIS EMAIL...
                        </div>
                    <?php endif; ?>
                </div>
              <div class="card-body">
                
                <br>
              
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type=" text" name="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="desc">Email</label>
                          <textarea name="email" class="form-control" id="desc">

                          </textarea>
                    </div>

                    <div class="form-group">
                        <label for="title">password</label><br>
                        <input type="password" name="password" id="title" >
                    </div>

                    <div class="form-group">
                        <label for="title">Role</label><br>
                        <input type="checkbox" name="role" value="1">
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="New User">
                        <a href="user-list.php" class="btn btn-primary">Back to User</a>
                    </div>
                </form>
              
            </div>
            
            
          </div>
          <!-- /.col-md-6 -->
         
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  

  <?php  include('footer.php'); ?>

  