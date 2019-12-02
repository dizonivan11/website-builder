<?php include_once('../../../core.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

	<!-- Custom Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Changa&display=swap" rel="stylesheet">

	<!-- Inject Builder Element Controller Style & Script -->
	<link rel="stylesheet" type="text/css" href="../../../element-controller.css">
	<script type="text/javascript" src="../../../element-controller.js"></script>
	
	<!-- Global Style -->
	<link rel="stylesheet" type="text/css" href="../global.css">
</head>
<body>
	<header>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
					<?php createDropZone(); ?>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
					<?php createDropZone(); ?>
				</div>
			</div>
		</div>
	</header>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<?php createDropZone(); ?>
			</div>
		</div>
	</div>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
					<?php createDropZone(); ?>
				</div>
				<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
					<?php createDropZone(); ?>
				</div>
				<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
					<?php createDropZone(); ?>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>