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
  <title>PHILIALE</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/style_r.css">
  <link rel="shortcut icon" href="../assets/img/favicon/favicon.ico" type="image/vnd.microsoft.icon">
  <link rel="icon" href="../assets/img/favicon/favicon.ico" type="image/vnd.microsoft.icon">
</head>
<body style="margin: 60px 0;">
  <div class="container">
    <div class="row">
      
        <div class="col-xs-12 col-md-6 col-md-offset-3" style="height:500px;">
        <h2 class="text-center">おすすめ書籍追加情報</h2>
        <br><br><br>
        <div class="row">
          <div class="col-xs-12">

             <div class="form-group col-xs-4">
            <img src="book_img/<?php echo htmlspecialchars($book_img); ?>" class="img-responsive img-thumbnail">
          </div>

              <div class="form-group">
              <span>タイトル</span>
              <p class="lead text-center"><?php echo htmlspecialchars($book_title); ?></p>
            </div>
            
              <div class="form-group">
              <span>理由</span>
              <p class="lead text-center"><?php echo htmlspecialchars($reason); ?></p>
            </div>
            
            <form method="POST" action="">
              
              <input type="hidden" name="action" value="submit">
              <input type="submit" class="btn btn-secondary btn-lg btn-block" value="おすすめへ追加 " style="margin-top: 50px;">
              
              <a href="new_add_gallery.php" class="btn btn-default btn-lg btn-block">&laquo;&nbsp;戻る</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</body>
</html>
