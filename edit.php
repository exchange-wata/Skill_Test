<?php

    session_start();
    require('dbconnect.php');

    $edit_id=$_GET['id'];

    $edited_sql='SELECT * FROM `galleries` WHERE `id`=?';
    $data=array($edit_id);
    $stmt = $dbh->prepare($edited_sql);
    $stmt->execute($data);

    $edit=$stmt->fetch(PDO::FETCH_ASSOC);

    $errors=array();

    if (!empty($_POST)) {

        $book_id=$_GET['id'];

        //画像名を取得
        $book_img = $_FILES['book_img']['name'];
            
        if (!empty($book_img)) {
            // 画像名の後ろから3文字を取得
            $file_type = substr($book_img, -4);
            // 大文字が含まれていた場合すべて小文字化
            $file_type = strtolower($file_type);

            if ($file_type != '.jpg' && $file_type != '.png' && $file_type != '.gif' && $file_type != 'jpeg') {
                $errors['book_img'] = 'type';
            }
            }
         
    

    if(empty($errors)){
        date_default_timezone_set('Asia/Tokyo');
        $date_str = date('YmdHis'); 
        $submit_file_name = $date_str.$book_img;

        move_uploaded_file($_FILES['book_img']['tmp_name'],'book_img/'.$submit_file_name);

    $book_title=$_POST['book_title'];
    $book_img=$submit_file_name;
    $reason=$_POST["reason"];

    $count = strlen($book_img);

    if ($count > 14) {
        $sql='UPDATE `galleries` SET `book_title`=?, `book_img`=?,`reason`=? WHERE `id`=?';

        $data=array($book_title,$book_img,$reason,$book_id);
    }else{
        $sql='UPDATE `galleries` SET `book_title`=?,`reason`=? WHERE `id`=?';

        $data=array($book_title,$reason,$book_id);
    }

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
}
    header("Location:mypage.php");
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
        <h2 class="text-center content_header">おすすめ書籍情報更新</h2>
        <form method="POST" action="edit.php?id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
          
          <div class="form-group">
            <label for="book_title">タイトル</label>
            <textarea type="book_title" name="book_title" class="form-control" id="book_title" placeholder="タイトル"><?php echo $edit['book_title']; ?></textarea>
            <?php if(isset($errors['book_title']) && $errors['book_title'] == 'blank') { ?>

            <p class="text-danger">本のタイトル入力してください</p>
            <?php } ?>

          </div>
          
          <div class="form-group">
            <label for="reason">理由</label>
            <textarea type="reason" name="reason" class="form-control" id="reason" placeholder="理由"><?php echo $edit['reason']; ?></textarea>
            <?php if(isset($errors['reason']) && $errors['reason'] == 'blank') { ?>
            <p class="text-danger">本を選んだ理由を記入してください</p>
            <?php } ?>

          </div>


          <input type="file" name="book_img" id="book_img" accept="iamage/*">
            <?php if(isset($errors['book_img']) && $errors['book_img'] == 'blank') { ?>
            <p class="text-danger">画像を選択してください</p>
            <?php } ?>
            <?php if(isset($errors['book_img']) && $errors['book_img'] == 'type') { ?>
            <p class="text-danger">拡張子が「jpg」「png」「gif」の画像を選択してください</p>
            <?php } ?>

                    
          <input type="submit" class="btn btn-info" value="更新">
        </form>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>