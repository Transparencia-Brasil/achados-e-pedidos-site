<html>
	<head>
		<!-- start: Meta -->
		<meta charset="utf-8">
		<title>Achados e Pedidos - Administração</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="keyword" content="">
		<!-- end: Meta -->
		<!-- start: Mobile Specific -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- end: Mobile Specific -->
		
		<!-- start: CSS -->
		
		<?php 
			echo $this->Html->css('/admin/css/bootstrap.min.css');
			echo $this->Html->css('/admin/css/bootstrap-responsive.min.css');
			echo $this->Html->css('/admin/css/style.css');
			echo $this->Html->css('/admin/css/style-responsive.css');
			echo $this->Html->meta('admin/img/favicon.ico','/favicon.ico', ['type' => 'icon']);
		?>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
		<!-- end: CSS -->
		<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<link id="ie-style" href="css/ie.css" rel="stylesheet">
		<![endif]-->
		
		<!--[if IE 9]>
			<link id="ie9style" href="css/ie9.css" rel="stylesheet">
		<![endif]-->
			
		<!-- start: Favicon -->
		<link rel="shortcut icon" href="admin/img/favicon.ico">
		<!-- end: Favicon -->
		<style type="text/css">
			html, body {
			    height: 100%;
			}

			html {
			    display: table;
			    margin: auto;
			}

			body {
			    display: table-cell;
			    vertical-align: middle;
			}
		</style>
	</head>
	<body>
		<?= $this->fetch('content') ?>
	</body>
</html>