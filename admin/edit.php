<?php 
  session_start();
  require "../config/db.php";
  require "../config/common.php";
  if(empty($_SESSION['user_id']) and empty($_SESSION['logged_in'])) {
    header("location: login.php");
  }

  if($_POST){
    if(empty($_POST['title'])|| empty($_POST['content'])){
      if(empty($_POST['title'])){
        $titleErr="YOUR Name is Null.";
      }
      if(empty($_POST['Content'])){
        $conErr="YOUR Content is Null.";
      }
     
    }else{
      $id=$_POST['id'];
      $title=$_POST['title'];
      $content=$_POST['content'];
    
      if($_FILES['image']['name'] != null){
        $file='images/'.$_FILES['image']['name'];
        $imageType=pathinfo($file,PATHINFO_EXTENSION);
          if($imageType!='png' && $imageType!='jpg' && $imageType!= 'jpeg'){

              echo "<script>alert('image must be png,jpg,jpeg')</script>";

          }else{
              $image=$_FILES['image']['name'];
              move_uploaded_file($_FILES['image']['tmp_name'],$file);
              $stmt=$pdo->prepare("UPDATE posts SET title='$title', content='$content',image='$image' WHERE id='$id'");
              $result=$stmt->execute();            
            if($result) {
              echo "<script>alert('The Blog has just Added');window.location.href='index.php';</script>";
            }
          }
      }else {
        
        $stmt=$pdo->prepare("UPDATE posts SET title='$title', content='$content' WHERE id='$id'");
        $result=$stmt->execute();            
        if($result) {
            echo "<script>alert('The Blog has just Added');window.location.href='index.php';</script>";
      }
    }
   }
    
  }

  $stmt=$pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
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
              <div class="card-body">
              <form action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                  <input type="hidden" name="id" value="<?=$result[0]['id']?>">
                  <div class="form-group">
                      <label for="title">Title</label>
                      <p class="text-danger"><?php echo empty($conErr)? '': $conErr;?></p>
                      <input type=" text" name="title" class="form-control" value="<?= escape($result[0]['title'])?>">
                  </div>

                  <div class="form-group">
                      <label for="desc">Content</label>
                      <p class="text-danger"><?php echo empty($conErr)? '': $conErr;?></p>
                        <textarea name="content" class="form-control" id="desc" ><?=escape($result[0]['content'])?>
                        </textarea>
                  </div>

                  <div class="form-group">
                    <label for="title">Image</label><br>
                    
                    <img src="images/<?=$result[0]['image']?>" alt="" width="150px" height="150px"><br>
                      <input type="file" name="image" value="<?=escape($result[0]['image'])?>">
                  </div>

                  <div class="form-group">
                      <input type="submit" class="btn btn-success" value="Edit Blog">
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

  