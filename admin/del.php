<?php
    require "../config/db.php";
    $id=$_GET['id'];
    $sql="DELETE FROM posts WHERE id=:id";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([':id'=> $id]);
    header('location: index.php');
?>