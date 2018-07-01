<?php
    session_start();

    require('dbconnect.php');

    $errors = array();

    if (!empty($_POST)) { 
        $name= $_POST['name'];
        $password = $_POST['password'];
        $count = strlen($password);

        if($name == ''){
          $errors['name'] = 'blank';
        }

        if($password == ''){
          $errors['password'] = 'blank';
        }

        elseif ($count < 4 || $count > 16) {
            $errors['password'] = 'length';
        }

        if ($name != '' && $password != '' ) {
            $sql = 'SELECT * FROM `users` WHERE `name`=?';
            $data = array($name);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($record == false) {
                $errors['signin'] = 'failed';
            }else {
                if (password_verify($password,$record['password'])) {
                    $_SESSION['id'] = $record['id'];
                    $_SESSION['name'] = $record['name'];
                    $_SESSION['image'] = $record['image'];
                
                header("Location: gallery.php");
                exit();

                }else{
                  $errors['signin'] = 'failed';
                }

            }


        }

    }

// var_dump($errors);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>signin</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/signin.css">
</head>
<body style="margin-top: 60px;">
<div class="container">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 thumbnail">
          <h2 class="text-center content_header">ログイン</h2>
            <form method="POST" action="" enctype="multipart/form-data">
              
                <div class="form-group">
                    <p>NAME</p>
                    <textarea type="name" name="name" class="form-control" id="name" placeholder="your name"></textarea>
                    <?php if(isset($errors['name']) && $errors['name'] == 'blank') { ?>
                    <p class="text-danger">お名前を正しく入力してください</p>
                    <?php } ?>
                </div>
              
                <div class="form-group">
                    <p>PASSWORD</p>
                    <textarea type="password" name="password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード"></textarea>
                    <?php if(isset($errors['password'])&& $errors['password'] == 'blank') { ?>
                      <p class="text-danger">パスワードを正しく入力してください</p>
                    <?php } ?>
                    <?php if(isset($errors['password']) && $errors['password'] == 'length') { ?>
                                <span class="text-danger">パスワードは4〜16文字で入力してください</span>
                                <?php } ?>
                    <?php if(isset($errors['signin']) && $errors['signin'] == 'failed') { ?>
                      <p class="text-danger">ログインに失敗しました</p>
                    <?php } ?>
                </div>
              <input type="submit" class="btn btn-info col-xs-8 col-xs-offset-2" value="ログイン">
            </form>
        </div>
    </div>
</div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>