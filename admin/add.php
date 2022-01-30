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
        if($_POST){
        
       
          if(empty($_POST['title'])|| empty($_POST['content'])|| empty($_FILES['image']['name'])){
            
            if(empty($_POST['title'])){
             
              $titleErr="YOUR Name is Null.";
            }
            if(empty($_POST['content'])){

              $conErr="YOUR Content is Null.";
            }
            if(empty($_FILES['image']['name'])){
              $imgErr="YOUR Image is Null.";
            }
          }else{
            $file='images/'.$_FILES['image']['name'];
            $imageType=pathinfo($file,PATHINFO_EXTENSION);
              if($imageType !='png' && $imageType !='jpg' && $imageType != 'jpeg'){

                  echo "<script>alert('image must be png,jpg,jpeg')</script>";

              }else{
                  $title=$_POST['title'];
                  $content=$_POST['content'];
                  $img=$_FILES['image']['name'];
                  move_uploaded_file($_FILES['image']['tmp_name'],$file);
                  $stmt=$pdo->prepare("INSERT INTO posts (title, content,image,user_id) VALUES (:title,:content,:image, :user_id)");
                  $result=$stmt->execute([
                      ':title'=>$title,
                      ':content'=>$content,
                      ':image'=>$img,
                      ':user_id'=>$_SESSION['user_id'],
                  ]);
                if($result) {
                    echo "<script>alert('The Blog has just Added');window.location.href='index.php';</script>";
                }
              }
          }
        }

     

    ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Create New Blog</h4>
                </div>
              <div class="card-body">
              <form action="add.php" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                      <label for="title">Title</label>
                      <p class="text-danger"><?php echo empty($titleErr)? '': $titleErr;?></p>
                      <input type=" text" name="title" class="form-control">
                  </div>

                  <div class="form-group">
                      <label for="desc">Content</label>
                      <p class="text-danger"><?php echo empty($conErr)? '': $conErr;?></p>
                        <textarea name="content" class="form-control" id="desc"></textarea>
                  </div>

                  <div class="form-group">
                      <label for="title">Image</label>
                      <p class="text-danger"><?php echo empty($imgErr)? '': $imgErr;?></p>
                      <input type="file" name="image" value="">
                  </div>

                  <div class="form-group">
                      <input type="submit" class="btn btn-success" value="New Blog">
                      <a href="index.php" class="btn btn-primary">Back to Home</a>
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
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <!-- <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <!-- <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside> -->
  <!-- /.control-sidebar -->

  <?php  include('footer.php'); ?>

  