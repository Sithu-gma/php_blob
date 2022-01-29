<?php
  session_start();
  require '../config/db.php';
  if(empty($_SESSION['user_id']) and empty($_SESSION['logged_in'])) {
    header("location: ../login.php");
  }
  $id=$_GET['id'];
  if($id){
    $stmt=$pdo->prepare("DELETE FROM users WHERE id=".$id);
    $stmt->execute();
    header("location: user-list.php?del=true");
  }
?>