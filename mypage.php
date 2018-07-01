<?php
	session_start();
	
	require('dbconnect.php');

	if (empty($_SESSION)) {
		header("Location:gallery.php");
	}

	$sql='SELECT * FROM `galleries` WHERE `user_id`=?';
	$data = array($_SESSION['id']);
    $stmt = $dbh->prepare($sql); 
    $stmt->execute($data);

    $my_books=array();

    while (true) {
	    $record=$stmt->fetch(PDO::FETCH_ASSOC);
	    if ($record==false) {
	    	break;
	    }
	    
	    $my_books[]=$record;
	}


	// profile表示用
	$user_sql='SELECT * FROM `users` WHERE `id`=?';
	$user_data = array($_SESSION['id']);
    $user_stmt = $dbh->prepare($user_sql); 
    $user_stmt->execute($user_data);

	$user=$user_stmt->fetch(PDO::FETCH_ASSOC);
	    
	// edit profile
	
	$errors = array();

	if (!empty($_POST)) {
		$name = $_POST['name'];

		if ($name == '') {
            $errors['name'] = 'blank';
        }
        // else{
        //     // require('dbconnect.php');

        //     $cnt_sql = 'SELECT COUNT(*) as `cnt` FROM `users` WHERE `name`=?';
        //     $cnt_data = array($name);
        //     $cnt_stmt = $dbh->prepare($cnt_sql);
        //     $cnt_stmt->execute($cnt_data);

        //     // $dbh = null;

        //     $rec = $cnt_stmt->fetch(PDO::FETCH_ASSOC);

        //     if ($rec['cnt'] > 0) {
        //         $errors['name'] = 'duplication';
        //     }
        // }

        //画像名を取得
        $user_image = $_FILES['user_image']['name'];
            
        if (!empty($user_image)) {
            // 画像名の後ろから3文字を取得
            $file_type = substr($user_image, -4);
            // 大文字が含まれていた場合すべて小文字化
            $file_type = strtolower($file_type);

            if ($file_type != '.jpg' && $file_type != '.png' && $file_type != '.gif' && $file_type != 'jpeg') {
                $errors['user_image'] = 'type';
            }
        }
         
   
    if(empty($errors)){
        date_default_timezone_set('Asia/Tokyo');
        $date_str = date('YmdHis'); 
        $submit_file_name = $date_str.$user_image;

        move_uploaded_file($_FILES['user_image']['tmp_name'],'user_image/'.$submit_file_name);

    $user_image=$submit_file_name;
    
    $count = strlen($user_image);

    // require('dbconnect.php');

    if ($count > 14) {
        $edit_sql='UPDATE `users` SET `name`=?, `image`=? WHERE `id`=?';

        $edit_data=array($name,$user_image,$_SESSION['id']);
    }else{
        $edit_sql='UPDATE `users` SET `name`=? WHERE `id`=?';

        $edit_data=array($name,$_SESSION['id']);
    }

    $edit_stmt = $dbh->prepare($edit_sql);
    $edit_stmt->execute($edit_data);

    header("Location:mypage.php");

	}
}

	var_dump($_POST);
?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Valet &mdash; Free HTML5 Bootstrap Template by FREEHTML5.co</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FREEHTML5.CO" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	<meta name="author" content="FREEHTML5.CO" />


	<!-- Google Webfont -->
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
	<?php include("partial/link_css.php"); ?>
	<link rel="stylesheet" type="text/css" href="assets/css/mypage.css">
  	
</head>
<body>

<!-- START #fh5co-header -->
<header id="fh5co-header-section" role="header" class="" >
	<div class="container">

		

		<!-- <div id="fh5co-menu-logo"> -->
			<!-- START #fh5co-logo -->
			<!-- <h1 id="fh5co-logo" class="pull-left"> -->
			<h1 class="pull-left">
				<a href="#">
					MY BOOK
				</a>
			</h1>
			
			<!-- START #fh5co-menu-wrap -->
			<nav id="fh5co-menu-wrap" role="navigation">
				
				
				<ul class="sf-menu" id="fh5co-primary-menu">
					<li class="active">
						<a href="gallery.php">GALLERY</a>
					</li>
					
					<li><a href="#fh5co-main1">PROFILE</a></li>
					
					<li><a href="signout.php">SIGN OUT</a></li>
				</ul>
			</nav>
		<!-- </div> -->

	</div>
</header>
	
	
	

	<div id="fh5co-main">
		
		<div class="fh5co-cards">
			<div class="container-fluid">
				<div class="row animate-box">
					<div class="col-md-12 heading text-center"><h2>Outstanding Products</h2></div>
				</div>
				<div class="row">


					<?php foreach ($my_books as $m) {?>
					<div class="col-lg-3 col-md-6 col-sm-6 animate-box">
						<a class="fh5co-card" href="#">
							<img src="book_img/<?php echo $m['book_img']; ?>" alt="Free HTML5 Bootstrap template" class="img-responsive">
							<div class="fh5co-card-body">
								<h3><?php echo $m['book_title']; ?></h3>
								<p><?php echo $m['reason']; ?></p>
							</div>
						</a>
						<a href="edit.php?id=<?php echo $m['id']; ?>">
							<button>edit</button>
						</a>
						<a href="delete.php?id=<?php echo $m['id']; ?>">
							<button>delete</button>
						</a>
					</div>
				<?php } ?>
					


					<!-- <div class="col-lg-3 col-md-6 col-sm-6 animate-box">
						<a class="fh5co-card" href="#">
							<img src="assets/img/img_large_2.jpg" alt="Free HTML5 Bootstrap template" class="img-responsive">
							<div class="fh5co-card-body">
								<h3>User Experience</h3>
								<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste sunt porro delectus cum officia magnam.</p>
							</div>
						</a>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 animate-box">
						<a class="fh5co-card" href="#">
							<img src="assets/img/img_large_2.jpg" alt="Free HTML5 Bootstrap template" class="img-responsive">
							<div class="fh5co-card-body">
								<h3>Web Designer</h3>
								<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste sunt porro delectus cum officia magnam.</p>
							</div>
						</a>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 animate-box">
						<a class="fh5co-card" href="#">
							<img src="assets/img/img_large_3.jpg" alt="Free HTML5 Bootstrap template" class="img-responsive">
							<div class="fh5co-card-body">
								<h3>Web Analyst</h3>
								<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste sunt porro delectus cum officia magnam.</p>
							</div>
						</a>
					</div> -->
				</div>
			</div>
		</div>



<div id="fh5co-main1">
			<div id="fh5co-contact">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<form action="mypage.php" method="post" enctype="multipart/form-data">
							<div class="col-md-12">
								<div class="form-group">
									<label for="name" class="sr-only"></label>
									<textarea placeholder="Name" name="name" id="name" type="text" class="form-control input-lg"><?php echo $user['name']; ?></textarea>
<?php if(isset($errors['name']) && $errors['name'] == 'blank') { ?>
                        <span class="text-danger">お名前を入力してください</span>
                        <?php } ?>
                        

								</div>	
							</div>
							
							<!-- <div class="col-md-12">
								<div class="form-group">
									<label for="message" class="sr-only">Message</label>
									<textarea placeholder="Message" id="message" class="form-control input-lg" rows="3"></textarea>
								</div>	
							</div> -->
							<div class="col-md-12">
								<div class="form-group">
									<img src="user_image/<?php echo $user['image']; ?>" alt="Free HTML5 Bootstrap template" class="img-responsive">
									<!-- <label for="message" class="sr-only">プロフィール画像</label> -->
									<input type="file" name="user_image" accept="image/*" placeholder="image" id="image" class="form-control input-lg" rows="3">
								</div>	
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<input type="submit" class="btn btn-primary btn-lg " value="edit profile">

								</div>	
							</div>
							
							
						</form>	
						
					</div>
					<div class="col-md-4">
						<h3>Need Help?</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non, harum autem quaerat vitae cupiditate, aspernatur est fugit, commodi optio itaque voluptatum! Beatae quae delectus deserunt est ab in sequi blanditiis!</p>
						<p>
							<a href="#">info@freehtml5.co</a>
						</p>
					</div>


				</div>
			</div>

			</div>
			<!-- fh5co-contact -->

		
		</div>		

		

		

	
	</div>
	<!-- END fhtco-main -->
<?php include("partial/gallery_js.php"); ?>

</body>
</html>
