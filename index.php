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
		.f-right {
			float: right;
		}
		.v-full {
			height: 100%;
		}
		.v-center {
			position: relative;
			top: 50%;
			transform: translateY(-50%);
		}
		#menu {
			background-color: var(--secondary-color);
			color: white;
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
		#message-box {
			padding: 4px;
			border: 1px solid #ccc;
			width: 100%;
			text-align: center;
			background-color: #efefef;
			color: black;
			box-shadow: 0px 0px 8px #aaa inset;
		}
	</style>
</head>
<body>
	<div id="menu" class="container-fluid">
		<div class="row v-full">
			<div class="col-1">
				<h3 class="v-center">WB</h3>
			</div>
			<div class="col-6">
				<div id="message-box" class="v-center">Feedbacks here....</div>
			</div>
			<div class="col-5">
				<button class="f-right v-center">Publish</button>
				<button class="f-right v-center">Preview</button>
				<button class="f-right v-center">Load Custom Widgets</button>
			</div>
		</div>
	</div>
	<div id="toolbox"></div>
	<div id="workspace-container">
		<iframe id="workspace" src="templates/blank"></iframe>
	</div>
	<script type="text/javascript">
		window.onload = function() {
			// document.getElementById('workspace').src = window.location;
		}
	</script>
</body>
</html>