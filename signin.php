<!-- <body style="margin-top: 60px;"> -->
<div id="modal-content" class="container"> 
    <!-- <div id="modal-content">
    <p>「閉じる」か「背景」をクリックするとモーダルウィンドウを終了します。</p> -->
    <!-- <p><a id="modal-close" class="button-link">×</a></p> -->
    <div id="btn-close">
        <i id="modal-close" class="fa fa-2x fa-times"></i>
      </div>
<!-- </div> -->

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 thumbnail">
          <h2 class="text-center content_header">ログイン</h2>
            <form method="POST" action="signin.php" enctype="multipart/form-data">
              
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