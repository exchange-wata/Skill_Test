<?php

  session_start();

  if (!isset($_SESSION['register'])) {
    header("Location: signup.php");
    exit();
  }

    // SESSIONを用いて受け取り
    $name = $_SESSION['register']['name'];
    $image = $_SESSION['register']['image'];
    $user_password = $_SESSION['register']['password'];
 

    if (!empty($_POST)) {

      require('../dbconnect.php');

      $sql = 'INSERT INTO `users` SET `name`=?,`image`=?,`password`=?,`created`=NOW()';
      $data = array($name, $image, password_hash($user_password, PASSWORD_DEFAULT),);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $dbh = null;

      unset($_SESSION['register']);
      header('Location: ../gallery.php');
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
        <h2 class="text-center">登録情報の確認</h2>
        <br><br><br>
        <div class="row">
          <div class="col-xs-12">

             <div class="col-xs-4">
            <img src="../user_image/<?php echo htmlspecialchars($image); ?>" class="img-responsive img-thumbnail">
          </div>
              <div class="form-group">
              <span>お名前</span>
              <p class="lead text-center"><?php echo htmlspecialchars($name); ?>&nbsp;様</p>
            </div>
            
              <!-- <div class="form-group">
              <span>メールアドレス</span>
              <p class="lead text-center"><?php echo htmlspecialchars($email); ?></p>
            </div> -->
            
              <div class="form-group">
              <span>パスワード</span>
              
              <p class="lead text-center">●●●●●●●●</p>
            </div>
            
            <form method="POST" action="">
              
              <input type="hidden" name="action" value="submit">
              <input type="submit" class="btn btn-secondary btn-lg btn-block" value="  ユーザー登録  " style="margin-top: 50px;">
              
              <a href="signup.php" class="btn btn-default btn-lg btn-block">&laquo;&nbsp;戻る</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</body>
</html>
