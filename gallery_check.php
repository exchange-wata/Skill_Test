<?php

    session_start();

    if (!isset($_SESSION['register'])) {
      header("Location: gallery.php");
      exit();
    }

    // SESSIONを用いて受け取り
    $book_title = $_SESSION['register']['book_title'];
    $book_img = $_SESSION['register']['book_img'];
    $reason = $_SESSION['register']['reason'];
 

    if (!empty($_POST)) {

      require('dbconnect.php');

      $sql = 'INSERT INTO `galleries` SET `book_title`=?, `reason`=?,`book_img`=?,`user_id`=?,`created`=NOW()'; 
      $data = array($book_title,$reason,$book_img,$_SESSION['id']);
      $stmt = $dbh->prepare($sql); 
      $stmt->execute($data);

      unset($_SESSION['register']);
      header('Location: gallery.php');
      exit();
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>check book</title>

    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/gallery_check.css">
</head>
<body style="margin: 50px;">
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
            <h2 class="text-center">おすすめ書籍情報</h2>
            <form method="POST" action="gallery_check.php">
                <div class="form-group">
                    <p>TITLE</p>
                    <textarea placeholder="Title" name="book_title" id="title" type="text" class="form-control input-lg">
                    <?php echo htmlspecialchars($book_title); ?></textarea>
                </div>
                
                <div class="form-group">
                    <p>REASON</p>
                    <textarea placeholder="Reason" name="reason" id="reason" type="text" class="form-control input-lg">
                    <?php echo htmlspecialchars($reason); ?></textarea>            
                </div>
                
               <div class="form-group">
                    <p>IMAGE</p>
                    <img src="book_img/<?php echo htmlspecialchars($book_img); ?>" alt="image" class="img-responsive1 form-control">
              </div>
                  
              <input type="hidden" name="action" value="submit">
              <input type="submit" class="btn btn-primary btn-lg btn-block" value="おすすめへ追加 " style="margin-top: 30px;">
                  
              <a href="new_add_gallery.php" class="btn btn-default btn-lg btn-block">&laquo;&nbsp;戻る</a>    
            </form>
        </div>
    </div>
</div>
 
</body>
</html>