<?php
	session_start();
	
	require('dbconnect.php');

	if (empty($_SESSION)) {
		header("Location:gallery.php");
	}

//---------- おすすめ書籍アップ機能-----------
    $errors = array();

    // ボタン押した時
    if(!empty($_POST)){
      $book_title = $_POST['book_title'];
      $reason = $_POST['reason'];
      // $book_img = $_POST['book_img'];

      if ($book_title == '') {
          $errors['book_title'] = 'blank';
       }
      
      if ($reason == '') {
          $errors['reason'] = 'blank';
       }

    // book_img
    $book_img = $_FILES['book_img']['name'];
    if (!empty($book_img)) {
        $file_type = substr($book_img, -4);
        $file_type = strtolower($file_type);

        if ($file_type != '.jpg' && $file_type != '.png' && $file_type != '.gif' && $file_type != 'jpeg') {
            $errors['book_img'] = 'type';
        }
    }else{
        $errors['book_img'] = 'blank';   
    }

    if (empty($errors)) {
        date_default_timezone_set('Asia/Tokyo'); 
        $date_str = date('YmdHis'); 
        $submit_file_name = $date_str . $book_img;
        
        move_uploaded_file($_FILES['book_img']['tmp_name'], 'book_img/' . $submit_file_name);

        $_SESSION['register']['book_title'] = $_POST['book_title'];
        $_SESSION['register']['book_img'] = $submit_file_name;
        $_SESSION['register']['reason'] = $_POST['reason'];

        header('Location: gallery_check.php');
        exit();
	}

      // else {
      //   // 投稿があった時の処理
      //   require('dbconnect.php');
      //   $sql = 'INSERT INTO `book_galleries` SET `book_title`=?, `reason`=?,`book_img`=?,`user_id`=?, `created`=NOW()'; 
      //   $data = array($book_title,$reason,$book_img,$_SESSION['id']);
      //   $stmt = $dbh->prepare($sql); 
      //   $stmt->execute($data);
          
      //   header("Location: top.php");
      //   exit();

      // }

      }


?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ADD</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body style="margin-top: 60px">
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">おすすめ書籍追加情報</h2>
        <form method="POST" action="" enctype="multipart/form-data">
          
          <div class="form-group">
            <label for="book_title">タイトル</label>
            <input type="book_title" name="book_title" class="form-control" id="book_title" placeholder="タイトル">
            <?php if(isset($errors['book_title']) && $errors['book_title'] == 'blank') { ?>
            <p class="text-danger">本のタイトル入力してください</p>
            <?php } ?>

          </div>
          
          <div class="form-group">
            <label for="reason">理由</label>
            <input type="reason" name="reason" class="form-control" id="reason" placeholder="理由">
            <?php if(isset($errors['reason']) && $errors['reason'] == 'blank') { ?>
            <p class="text-danger">本を選んだ理由を記入してください</p>
            <?php } ?>

          </div>


<div class="form-group">
          <input type="file" name="book_img" id="book_img" accept="iamage/*">
            <?php if(isset($errors['book_img']) && $errors['book_img'] == 'blank') { ?>
            <p class="text-danger">画像を選択してください</p>
            <?php } ?>
            <?php if(isset($errors['book_img']) && $errors['book_img'] == 'type') { ?>
            <p class="text-danger">拡張子が「jpg」「png」「gif」の画像を選択してください</p>
            <?php } ?>

          </div>

                    
          <input type="submit" class="btn btn-info" value="追加">
        </form>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>