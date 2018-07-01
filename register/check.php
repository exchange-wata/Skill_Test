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
    <title>check</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">

    <link rel="stylesheet" type="text/css" href="../assets/css/gallery_check.css">
</head>
<body style="margin: 50px;">
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
            <h2 class="text-center">登録情報の確認</h2>
            <div class="row">
                <form method="POST" action="check.php">
                    <div class="form-group">
                        <p>NAME</p>
                        <textarea placeholder="name" name="name" id="name" type="text" class="form-control input-lg">
                        <?php echo htmlspecialchars($name); ?>&nbsp;様</textarea>
                    </div>
        
                    <div class="form-group">
                        <p>PASSWORD</p>
                        <textarea placeholder="password" name="password" id="password" type="text" class="form-control input-lg">●●●●●●●●
                        </textarea>
                    </div>

                    <div class="form-group">
                        <p>IMAGE</p>
                        <img src="../user_image/<?php echo htmlspecialchars($image); ?>" alt="image" class="img-responsive1 form-control">
                    </div>
          
                    <input type="hidden" name="action" value="submit">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="  ユーザー登録  " style="margin-top: 30px;">
                    
                    <a href="signup.php" class="btn btn-default btn-lg btn-block">&laquo;&nbsp;戻る</a>
                </form>
            </div>
        </div>
    </div>
</div>
 
  
</body>
</html>
