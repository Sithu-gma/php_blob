<?php
  session_start();
  require 'config/db.php';
  if(empty($_SESSION['user_id']) and empty($_SESSION['logged_in'])) {
    header("location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Widgets</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="margin-left:0 !important">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

     
     
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0 !important">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12 text-center">
            <h1>BLOG DETAIL</h1>
          </div>
         
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
     
        <!-- /.row -->
      <?php
    
        $stmt=$pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
        $stmt->execute();
        $result=$stmt->fetchAll();
        
     ?>

        <div class="row">
          <div class="col-md-12">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header text-center">
                <a href="#"><?=$result[0]['title']; ?></a>         
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <img class="img-fluid pad" src="admin/images/<?=$result[0]['image'];?>" alt="Photo" style="width:90%;  !important">
                
              </div>
              <!-- /.card-body -->
              <div class="card-footer card-comments">
                <div class="card-comment">                  
                </div>
              
                <div class="card-comment">          
                <?php
                  if($_POST) {
                    if(empty($_POST['content'])){
                      $contentErr="Pls Write Down Something";
                    }else{
                      $content=$_POST['content'];
                      $user_id=$_SESSION['user_id'];
                      $post_id=$_GET['id'];
                      $stmt=$pdo->prepare("INSERT INTO comments (content, user_id, post_id) VALUES (:content, :user_id, :post_id)");
                      $stmt->execute([
                        ':content'=>$content,
                        ':user_id'=> $user_id,
                        ':post_id'=> $post_id
                        ]);           
                    }
                  }
                   
                      $stmtcm=$pdo->prepare("SELECT comments.*,users.name,users.id FROM comments LEFT JOIN users ON comments.user_id=users.id 
                      WHERE comments.post_id=".$_GET['id']);
                      $stmtcm->execute();
                      $resultcm=$stmtcm->fetchAll();

                ?>
                
                  <h3>Comments  </h3>
                  

              
                  <?php foreach($resultcm as $com): ?>
                  
                    <div class="comment-text">
                      <span class="username">
                        <?=$com['name'];?>   
                        <span class="text-muted float-right"><?=$com['created_at'];?> </span>                 
                      </span>
                      <?=$com['content'];?>  
                    </div>
                  <?php endforeach; ?>
                  <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->
              </div>
              <!-- /.card-footer -->
              
              <div class="card-footer">
                <form action="" method="post">                
                  <div class="img-push" >
                   <div class="mb-3">
                   <p class="text-danger"><?php echo empty($contentErr)? '': $contentErr;?></p>
                   <input type="text" name="content" class="form-control form-control-sm" placeholder="Press enter to post comment" >
                   </div>
                    <input type="submit" class="btn btn-success"name="submit" value="New Comment">
                    <a href="index.php" class="btn btn-success">Back</a>
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
         
        </div>
        <!-- /.row -->

      
        <!-- /.row -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left:0 !important">
    <div class="float-right d-none d-sm-block">
      <b><a href="admin/logout.php" class="btn btn-danger">Logout</a></b> 
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">Blog Details</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
