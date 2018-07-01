<?php  
	session_start();
	
	require('dbconnect.php');

	if (empty($_SESSION)) {
		header("Location: top.php");
	}

	$sql='SELECT * FROM `galleries` WHERE 1 ORDER BY created DESC';
	$data = array();
    $stmt = $dbh->prepare($sql); 
    $stmt->execute($data);

    $add_books=array();

    while (true) {
	    $record=$stmt->fetch(PDO::FETCH_ASSOC);
	    if ($record==false) {
	    	break;
	    }
	    
	    $add_books[]=$record;
	}
?>

<!DOCTYPE html>
<html class="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>GALLERY</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FREEHTML5.CO" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	<meta name="author" content="FREEHTML5.CO" />

  	<?php include("partial/link_css.php"); ?>
  	<link rel="stylesheet" type="text/css" href="assets/css/gallery.css">

</head>
<body>

<header id="fh5co-header-section" role="header" class="" >
	<div class="container">
		<h1 class="pull-left">
			<a href="#">GALLERY</a>
		</h1>
		
		<nav id="fh5co-menu-wrap" role="navigation">			
			<ul class="sf-menu" id="fh5co-primary-menu">
				<li class="active">
					<a href="top.php">TOP</a>
				</li>
				
				<li>
					<a href="mypage.php?id=<?php echo $_SESSION['id']; ?>">MYPAGE</a>
				</li>
		
				<li>
					<a href="signout.php">SIGN OUT</a>
				</li>
			</ul>
		</nav>
	</div>
</header>
	
<div id="fh5co-main">
	<div class="fh5co-cards">
		<div class="container-fluid">
			<div class="row animate-box">
				<div class="col-md-12 heading text-center">
					<h2>COLLECTION</h2>
				</div>
			</div>
			
			<div class="row">
				<!-- 新規追加 -->
				<div class="col-lg-3 col-md-6 col-sm-6 animate-box">
					<a class="fh5co-card" href="new_add_gallery.php">
						<img src="assets/img/add.png" alt="Free HTML5 Bootstrap template" class="img-responsive">
						<div class="fh5co-card-body">
							<h3>ADD NEW BOOK</h3>
							<p>上記リンクをクリックし、本のタイトル、画像、その本を選んだ理由を入力して下さい。</p>
						</div>
					</a>
				</div>
				
				<!-- 追加されたものの表示 -->
				<?php foreach ($add_books as $b) {?>
					<div class="col-lg-3 col-md-6 col-sm-6 animate-box">
						<a class="fh5co-card" href="#">
							<img src="book_img/<?php echo $b['book_img']; ?>" alt="Free HTML5 Bootstrap template" class="img-responsive">
							<div class="fh5co-card-body">
								<h3><?php echo $b['book_title']; ?></h3>
								<p><?php echo $b['reason']; ?></p>
							</div>
						</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>


<?php include("partial/gallery_js.php"); ?>

</body>
</html>
