<?php
  session_start();
  if(empty($_SESSION['user_id']) and empty($_SESSION['logged_in'])) {
    header("location: login.php");
  }
  require "config/db.php";

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
  
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0 !important">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 text-center">
            <h1>Widgets</h1>
          </div>
         
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
      if(!empty($_GET['pageno'])){
        $pageno=$_GET['pageno'];
      }else{
        $pageno=1;
      }
      $numRec=3;
      $offset=($pageno-1)*$numRec;
      $stmt=$pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
      $stmt->execute();
      $raw=$stmt->fetchAll();
      $totalPages=ceil(count($raw)/$numRec);

      $stmt=$pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numRec");
      $stmt->execute();
      $result=$stmt->fetchAll();


      
     ?>
    <!-- Main content -->
    <section class="content">     
        <!-- /.row -->

        <div class="row">
            <?php             
              if($result):
              foreach($result as $val):                        
            ?>
                      <div class="col-md-4">
                        <!-- Box Comment -->
                        <div class="card card-widget">
                          <div class="card-header text-center">
                            <div class="user-block ">                  
                              <span class="username "><a href="#"><?= $val['title']; ?></a></span>                  
                            </div>
                            
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body" >                        
                            <a href="blog-detail.php?id=<?= $val['id'];?>">
                            <img class="img-fluid pad" src="admin/images/<?=$val['image'];?>" alt="" style="width:100%;height:250px !important"> 
                            </a>            
                          </div>
                          
                        </div>
                      </div>

              <?php                   
                  endforeach;
                endif;            
              ?>
          
            <!-- /.card -->
           
          
         
        </div>    
        <!-- /.row -->
        <div class="row mb-3 float-right">
            <nav aria-label="Page navigation example " >
              <ul class="pagination justify-content-end ">
                <li class="page-item">
                  <a class="page-link" href="?pageno=1">First</a>
                </li>
                <li class="page-item <?php if($pageno<=1) { echo'disabled'; } ?>">
                  <a class="page-link" href="<?php if($pageno<=1 ) {echo '#';} else { echo '?pageno='.($pageno-1);}?>">Previous</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#"><?=$pageno;?></a>
                </li>
                <li class="page-item <?php if($pageno >=$totalPages) { echo'disabled'; }?>">
                  <a class="page-link" href="<?php if($pageno>=$totalPages ) {echo '#';} else { echo '?pageno='.($pageno+1);}?>">Next</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="?pageno=<?php echo $totalPages; ?>">Last</a>
                </li>
              </ul>
            </nav>
            </div>
            <br>
            <br>
        
      
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left:0 !important">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
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
