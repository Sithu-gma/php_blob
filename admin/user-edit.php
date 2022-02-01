<?php 
  session_start();
  require "../config/db.php";
  require "../config/common.php";
  if(empty($_SESSION['user_id']) and empty($_SESSION['logged_in'])) {
    header("location: login.php");
  }
  if($_SESSION['role'] != 1){
    header("location: ../index.php");
  }
  if($_POST){  
    if(empty($_POST['name'])|| empty($_POST['email'])||strlen($_POST['password'])<4){
            
      if(empty($_POST['name'])){             
        $nameErr="YOUR Name is Null.";
      }
      if(empty($_POST['email'])){
        $emailErr="YOUR Email is Null.";
      }
      
      if(strlen($_POST['password'])<4){
        $passErr="YOUR have to fill at least 4  char";
      }
      
    }else{
        $id=$_POST['id'];
        $name=$_POST['name'];
        $email=$_POST['email'];  
        $password=password_hash($_POST['password'],PASSWORD_DEFAULT);  
      
        if(empty($_POST['role'])){
          $role=2;
        }else{
          $role=1;
        };
        $stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
        
        $stmt->execute([
          ':email'=>$email,
          ':id'=>$id,
        ]);
        $user=$stmt->fetch(PDO::FETCH_ASSOC);   
      
      
          if($user) {              
            echo "<script>alert('Email is duplicated');window.location.href='user-edit.php?id=$id&dd=true';</script>";
          }else{
            $stmt=$pdo->prepare("UPDATE users SET name=:name, email=:email, role=:role, password=:password WHERE id=:id");
            $result=$stmt->execute([
              ':id'=>$id,
              ':name' => $name,
              ':email'=> $email,
              ':role' => $role,
              ':password' => $password,
            ]);
            if($result) {
              echo "<script>alert('The Blog has just Added');window.location.href='user-list.php';</script>";
            }  
          
          }  
    }            
  }
  $stmt=$pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
  $stmt->execute();
  $result=$stmt->fetchAll();
  
?>
    <!-- Main content -->

<?php include('header.php'); ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Create New Blog</h4>
                </div>
                <div class="card-title">
                  <?php if(isset($_GET['dd'])): ?>                    
                        <div class="alert alert-danger" role="alert">
                          Oh!A USER HAS ALDY USE THIS EMAIL...
                        </div>
                    <?php endif; ?>
                </div>
              <div class="card-body">
              <form action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="id" value="<?=escape($result[0]['id']);?>">
                  <input type="hidden" name="_token" value="<?=$_SESSION['_token']?>">
                  <div class="form-group">
                      <label for="title">Title</label>
                      <p class="text-danger"><?php echo empty($nameErr)? '': $nameErr;?></p>
                      <input type=" text" name="name" class="form-control" value="<?= escape($result[0]['name'])?>">
                  </div>

                  <div class="form-group">
                      <label for="desc">Email</label>
                      <p class="text-danger"><?php echo empty($emailErr)? '': $emailErr;?></p>
                      <input type="email" name="email" class="form-control" id="desc" value="<?= escape($result[0]['email'])?>" >
                        
                  </div>
                  
                  <div class="form-group">
                      <label for="desc">Password</label>
                      <p class="text-danger"><?php echo empty($passErr)? '': $passErr;?></p>
                      <input type="password" name="password" class="form-control" value="<?= escape($result[0]['password'])?>">
                  </div>

                  <div class="form-group">
                        <label for="title">Role</label><br>
                        <input type="checkbox" name="role" value="1"  >
                  </div>                

                  <div class="form-group">
                      <input type="submit" class="btn btn-success" value="Edit USER">
                      <a href="user-list.php" class="btn btn-primary">Back to Home</a>
                  </div>
              </form>
              </div>
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

  