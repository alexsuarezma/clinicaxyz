<?php
 require '../../../../database.php';
    $hijoId=$_GET['id'];
    $table=$_GET['table'];
    $nameId=$_GET['nameId'];
    $ced=$_GET['ced'];

    if(isset($_GET['table'])){
        $sql = "DELETE FROM $table WHERE $nameId =:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $hijoId);
        $stmt->execute();
        header("Location:../routes/profile.php?id=$ced"); 
    }