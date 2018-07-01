<?php
    session_start();

    //SESSION変数の破棄(ローカル) ＝　空の配列を代入
    $_SESSION = array();


    //サーバー内の$_SESSION変数のクリア　＝　サーバー側のセッションを破棄
    session_destroy();


    // signin.phpへ移動
    header("Location: top.php");
    exit();

?>
