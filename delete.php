<?php 

	session_start();
    require("dbconnect.php");

    $book_id=$_GET['id'];

    $sql='DELETE FROM `galleries` WHERE id=?';
    $data=array($book_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    header("Location:mypage.php");

?>