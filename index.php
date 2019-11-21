<!DOCTYPE html>
<html>
<head>
	<title>Website Builder</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<style type="text/css">
		* {
			--primary-color: #8dca23;
			--secondary-color: #282828;
			--menu-height: 50px;
			--toolbox-width: 100px;
		}
		.v-center {
			position: relative;
			top: 50%;
			transform: translateY(-50%);
		}
		#menu {
			background-color: var(--secondary-color);
			color: white;
			padding: 8px;
			height: var(--menu-height);
		}
		#toolbox {
			background-color: var(--primary-color);
			float: left;
			width: var(--toolbox-width);
			height: calc(100vh - var(--menu-height));
		}
		#workspace-container {
			margin-left: var(--toolbox-width);
			width: calc(100vw - var(--toolbox-width));
			height: calc(100vh - var(--menu-height));
		}
		#workspace {
			width: 100%;
			height: 100%;
			border: none;
		}
	</style>
</head>
<body>
	<div id="menu">
		<h3 class="v-center">WB</h3>
	</div>
	<div id="toolbox"></div>
	<div id="workspace-container">
		<iframe id="workspace" src="templates/blank/blank.php"></iframe>
	</div>
	<script type="text/javascript">
		window.onload = function() {
			// document.getElementById('workspace').src = window.location;
		}
	</script>
</body>
</html>