<?php
    session_start();

    require('dbconnect.php');

    // var_dump($_POST);

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
<html class="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Skill Test</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FREEHTML5.CO" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	<meta name="author" content="FREEHTML5.CO" />

	<!-- signin.php -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/signin.css">

  	<?php include("partial/link_css.php"); ?>
  	<link rel="stylesheet" href="assets/css/top.css">

</head>
<body>

<header id="fh5co-header-section" role="header" class="" >
	<div class="container">
		<h1 class="pull-left">
			<a href="#">
				BOOK GALLERY
			</a>
		</h1>
			
		<nav id="fh5co-menu-wrap" role="navigation">
			<ul class="sf-menu" id="fh5co-primary-menu">
				<li class="active">
					<!-- <a href="gallery.php">USING</a> -->
				</li>
				
				<li>
					<!-- signin.js -->
					<!-- <a onclick="load_signin()">LOG IN</a>
					<div id="signin"></div>
 -->

					<!-- signin2.js -->
					<a id="modal-open" class="button-link">LOG IN</a>
				</li>
				
				<li>
					<a href="register/signup.php">SIGN UP</a>
				</li>
			</ul>
		</nav>
	</div>
</header>
	
<!-- signin modal -->
	<?php include("signin.php"); ?>

<div id="fh5co-hero" style="background-image: url(assets/img/tmu_lib1.JPG);">
	<div class="overlay"></div>
		<a href="#" class="smoothscroll fh5co-arrow to-animate hero-animate-4">
			<i class="ti-angle-down"></i>
		</a>

	<div class="container">
		<div class="col-md-12">
			<div class="fh5co-hero-wrap">
				<div class="fh5co-hero-intro">
					<h1 class="to-animate hero-animate-1">BOOK GALLERY</h1>
					<h2 class="to-animate hero-animate-2">Created by <a href="https://www.facebook.com/profile.php?id=100024407540535" target="_blank">MIZUKI WATANABE</a></h2>
					<p class="to-animate hero-animate-3"><a href="register/signup.php" class="btn btn-outline btn-md">Sign up</a></p>
				</div>
			</div>
		</div>
	</div>		
</div>


<footer role="contentinfo" id="fh5co-footer">
	<div class="container">
		<div class="row">
			<div class="col-md-12 footer-box text-center">
				<div class="fh5co-copyright">
				<p>&copy; MIZUKI WATANABE All Rights Reserved. <br>Designed by <a href="http://freehtml5.co" target="_blank">FREEHTML5.co</a> Images by: <a href="http://unsplash.com" target="_blank">Unsplash</a></p>
				</div>
			</div>	
		</div>
		<div class="fh5co-spacer fh5co-spacer-md"></div>
	</div>
</footer>


<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
<!-- <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script> -->

<!-- Remember to include jQuery :) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

<!-- jQuery Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" /> -->

<script type="text/javascript" src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="assets/js/signin2.js"></script>
<script src="assets/js/jquery-migrate-1.4.1.js"></script>
<script src="assets/js/bootstrap.js"></script>

		
<?php include("partial/gallery_js.php"); ?>

</body>
</html>
