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
					
					<!-- <li><a href="signin.php">LOG IN</a></li> -->
					
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
					


					<div class="col-lg-3 col-md-6 col-sm-6 animate-box">
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
					</div>
				</div>
			</div>
		</div>

		

		

		

	
	</div>
	<!-- END fhtco-main -->
<?php include("partial/gallery_js.php"); ?>

</body>
</html>
