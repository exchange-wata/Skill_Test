<?php
    session_start();

    $errors = array();

    // post送信があった時
    if (!empty($_POST)) { 
        $name = $_POST['name'];
        // $image=$_POST['image'];
        $password = $_POST['password'];
        // $check = $_POST['input_chk_password'];
       
        $count = strlen($password);
        // $chk_count = strlen($check);

        // 名前の空チェック
        if ($name == '') {
            $errors['name'] = 'blank';
          
        }else{
            require('../dbconnect.php');

            $sql = 'SELECT COUNT(*) as `cnt` FROM `users` WHERE `name`=?';
            $data = array($name);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            $dbh = null;

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rec['cnt'] > 0) {
                $errors['name'] = 'duplication';
            }
        }

        // パスワード
        if ($password == '') {
            $errors['password'] = 'blank';
        }

        elseif ($count < 4 || $count > 16) {
            $errors['password'] = 'length';
        }


        // image
        $image = $_FILES['image']['name'];
        if (!empty($image)) {
            $file_type = substr($image, -4);
            $file_type = strtolower($file_type);

            if ($file_type != '.jpg' && $file_type != '.png' && $file_type != '.gif' && $file_type != 'jpeg') {
                $errors['image'] = 'type';
            }
        }else{
              //ファiイルがないときの処理
            $errors['image'] = 'blank';

        }

        if (empty($errors)) {
            date_default_timezone_set('Asia/Tokyo'); 
            $date_str = date('YmdHis'); 
            $submit_file_name = $date_str . $image;
            
            move_uploaded_file($_FILES['image']['tmp_name'], '../user_image/' . $submit_file_name);

            $_SESSION['register']['name'] = $_POST['name'];
            $_SESSION['register']['image'] = $submit_file_name;
            $_SESSION['register']['password'] = $_POST['password'];

            header('Location: check.php');
            exit();
        }
    }

    // echo $date_str;
    //         echo "<br>";
            // echo $submit_file_name;

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>signup</title>

    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/signin.css">
</head>
<body style="margin-top: 60px;">

<div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">新規登録</h2>
            <form action="signup.php" method="post"  enctype="multipart/form-data">
                <div class="form-group">
                    <p>NAME</p>
                    <textarea name="name" type="text" class="form-control input-lg" id="name" placeholder="your name"></textarea>
                    <?php if(isset($errors['name']) && $errors['name'] == 'blank') { ?>
                    <p class="text-danger">お名前を入力してください</p>
                    <?php } ?>
                    <?php if(isset($errors['name']) && $errors['name'] == 'duplication') { ?>
                    <p class="text-danger">すでに存在するお名前です</p>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <p>PASSWORD</p>
                    <textarea type="password" class="form-control input-lg" id="password" placeholder="password" name="password"></textarea>
                    <?php if(isset($errors['password']) && $errors['password'] == 'blank') { ?>
                    <span class="text-danger">パスワードを入力してください</span>
                    <?php } ?>
                    <?php if(isset($errors['password']) && $errors['password'] == 'length') { ?>
                    <span class="text-danger">パスワードは4〜16文字で入力してください</span>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <p>IMAGE</p>
                    <input type="file" name="image" id="image" class="form-control input-lg" accept="iamage/*">
                    <?php if(isset($errors['image']) && $errors['image'] == 'blank') { ?>
                    <p class="text-danger">画像を選択してください</p>
                    <?php } ?>
                    <?php if(isset($errors['image']) && $errors['image'] == 'type') { ?>
                    <p class="text-danger">拡張子が「jpg」「png」「gif」の画像を選択してください</p>
                    <?php } ?>
                </div>
                
                <button class="btn btn-info col-xs-8 col-xs-offset-2" type="submit">SIGN UP</button>
            </form>
        </div>
    </div>    
</div>

<script src="../assets/js/signup.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</body>
</html>