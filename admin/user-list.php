<?php 
  session_start();
  require "../config/db.php";
  if(empty($_SESSION['user_id']) and empty($_SESSION['logged_in'])) {
    header("location: ../login.php");
  }
  include('header.php');
?>
    <!-- Main content -->
    <?php
      if(!empty($_GET['pageno'])){
          $pageno=$_GET['pageno'];
      }else{
        $pageno=1;
      };
      $numofrecs=3;
      $offset= ($pageno-1)*$numofrecs;
    

      // if(empty($_POST['search'])) {
        $stmt=$pdo->prepare("SELECT * FROM users ORDER BY id DESC");
        $stmt->execute();
        $rawresult=$stmt->fetchAll();
        $total_pages=ceil(count($rawresult) /$numofrecs);

        $stmt=$pdo->prepare("SELECT * FROM users ORDER BY id DESC LIMIT $offset,$numofrecs");
        $stmt->execute();
        $result=$stmt->fetchAll();
      // } else {
      //   $searchKey=$_POST['search'];
      //   $stmt=$pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
      //   $stmt->execute();
      //   $rawresult=$stmt->fetchAll();
      //   $total_pages=ceil(count($rawresult) /$numofrecs);

      //   $stmt=$pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numofrecs");
      //   $stmt->execute();
      //   $result=$stmt->fetchAll();
      // }


    ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                  <a href="user-add.php" class="btn btn-success">Create New User</a>
              </div>
              <div class="card-body">
                <div class="card-title">
                  <?php if(isset($_GET['del'])): ?>                    
                      <div class="alert alert-danger" role="alert">
                        A USER DELETED !
                      </div>
                  <?php endif; ?>
                </div>

              <table class="table stripped">
                <thead>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>ACTION</th>
                </thead>
                <tbody>
                  <?php 
                      $i=1;
                      if($result):
                      foreach($result as $val):                        
                  ?>
                  <tr>
                        <td><?=$i; ?></td>
                        <td><?=$val['name']; ?></td>
                        <td><?=$val['email']; ?></td>
                        <td>
                          <?php
                            if($val['role']=='1'){
                              echo 'Admin';
                            }else{
                              echo 'User';
                            }
                          ?>
                        </td>
                        <td>
                          <div class="btn-group">
                            <div class="container">
                              <a href="user-edit.php?id=<?= $val['id']?>" class="btn btn-primary">Edit</a>
                            </div>
                            <div class="container">
                              <a href="user-del.php?id=<?= $val['id'] ?>" class="btn btn-danger">DEL</a>
                            </div>
                          </div>
                        </td>
                    </tr>

                  <?php 
                        $i++;
                      endforeach;
                    endif;
                
                  ?>
                </tbody>
                
            </table>
            <br>
            
            <nav aria-label="Page navigation example" style="float:right">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link" href="?pageno=1">First</a>
                </li>

                <li class="page-item <?php if($pageno <= 1) {echo 'disabled'; }?> ">
                  <a class="page-link" href="<?php if($pageno <= 1) {echo '#';}else {echo "?pageno=".($pageno-1);}?>">Previous</a>
                </li>

                <li class="page-item">
                  <a class="page-link" href="#"> <?php echo "$pageno"; ?></a>
                </li>

                <li class="page-item <?php if($pageno >=$total_pages) {echo 'disabled'; }?>">
                  <a class="page-link" href="<?php if($pageno >= $total_pages) {echo '#';}else {echo "?pageno=".($pageno+1);}?>">Next</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="?pageno=<?php echo $total_pages?>">Last</a>
                </li>
              </ul>
            </nav>
                
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
