<?php 
	session_start();
	
	require('dbconnect.php');
	
	$user_sql='SELECT * FROM `users` WHERE `id`=?';
	$user_data = array($_SESSION['id']);
    $user_stmt = $dbh->prepare($user_sql); 
    $user_stmt->execute($user_data);

	$user=$user_stmt->fetch(PDO::FETCH_ASSOC);
	    

	$errors = array();

	if (!empty($_POST)) {
		$name = $_POST['name'];

		if ($name == '') {
            $errors['name'] = 'blank';
        }

        //画像名を取得
        $user_image = $_FILES['user_image']['name'];
            
        if (!empty($user_image)) {
            $file_type = substr($user_image, -4);
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

	    if ($count > 14) {
	        $edit_sql='UPDATE `users` SET `name`=?, `image`=? WHERE `id`=?';

	        $edit_data=array($name,$user_image,$_SESSION['id']);
	    }else{
	        $edit_sql='UPDATE `users` SET `name`=? WHERE `id`=?';

	        $edit_data=array($name,$_SESSION['id']);
	    }

	    $edit_stmt = $dbh->prepare($edit_sql);
	    $edit_stmt->execute($edit_data);

	    header("Location:profile.php");

		}
	}
?>


<!DOCTYPE html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>MY GALLERY</title>
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
<header id="fh5co-header-section" role="header" class="" >
	<div class="container">
		<h1 class="pull-left">
			<a href="#">MY GALLERY</a>
		</h1>

		<nav id="fh5co-menu-wrap" role="navigation">
			<ul class="sf-menu" id="fh5co-primary-menu">
				<li class="active">
					<a href="mypage.php">MY GALLERY</a>
				</li>
				
				<!-- <li><a href="#fh5co-contact">PROFILE</a></li> -->
				
				<li><a href="signout.php">SIGN OUT</a></li>
			</ul>
		</nav>
	</div>
</header>
	

<div id="fh5co-main">
	<div id="fh5co-contact">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<h3>Edit Profile</h3>
					<p>You can rewrite your name and choose your profile image!</p>
				</div>
				
				<div class="col-md-8">
					<form action="profile.php" method="post" enctype="multipart/form-data">
						<div class="col-md-12">
							<div class="form-group">
								<p>NAME</p>
								<!-- <label for="name" class="sr-only"></label> -->
								<textarea placeholder="Name" name="name" id="name" type="text" class="form-control input-lg"><?php echo $user['name']; ?></textarea>
								<?php if(isset($errors['name']) && $errors['name'] == 'blank') { ?>
								<span class="text-danger">お名前を入力してください</span>
								<?php } ?>
							</div>	
						</div>
					
						<div class="col-md-12">
							<div class="form-group">
								<p>NOW IMAGE</p>
								<img src="user_image/<?php echo $user['image']; ?>" alt="Free HTML5 Bootstrap template" class="img-responsive1 form-control">
								<p>CHOOSE FILE</p>
								<input type="file" name="user_image" accept="image/*" placeholder="image" id="image" class="form-control input-lg" rows="3">
							</div>	
						</div>
						
						<div class="col-md-12">
							<div class="form-group">
								<input type="submit" class="btn btn-primary btn-lg col-xs-12" value="edit profile">
							</div>	
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
</div>		

<?php include("partial/gallery_js.php"); ?>

</body>
</html>
