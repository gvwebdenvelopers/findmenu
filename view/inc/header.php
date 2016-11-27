<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>findMenu| <?php if(isset($_SESSION['module'])){ echo $_GET['module'];}else{ echo "home";} ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="description" content="Aplicación findMenu, encuentra menús espectaculares de bares y restaurantes cerca de tí" />
  	<meta name="keywords" content="findMenu, bares, restaurantes, comidas,desayunos, almuerzos, cenas, donde comer, comer barato, buscar platos de menu" />
  	<meta name="author" content="Jordi Martínez Frias" />
    <meta name="author" content="Oscar Otero Millán" />

    <!-- Facebook and Twitter integration -->
  	<meta property="og:title" content=""/>
  	<meta property="og:image" content=""/>
  	<meta property="og:url" content=""/>
  	<meta property="og:site_name" content=""/>
  	<meta property="og:description" content=""/>
  	<meta name="twitter:title" content="" />
  	<meta name="twitter:image" content="" />
  	<meta name="twitter:url" content="" />
  	<meta name="twitter:card" content="" />

  	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
  	<link rel="shortcut icon" href="/view/img/FindMenu_favicon.ico">

  	<!-- <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'> -->

    <!-- Bootstrap -->
    <link href="<?php echo CSS_PATH ?>bootstrap.min.css" rel="stylesheet">
    <!--fontawesome-->
    <link type="text/css" href="<?php echo CSS_PATH ?>font-awesome.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link type="text/css" href='https://fonts.googleapis.com/css?family=Satisfy|Bree+Serif|Candal|PT+Sans' rel='stylesheet'>
    <!-- Custom CSS -->
    <link type="text/css" href="<?php echo CSS_PATH ?>style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--form_user-->
    <script src='//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js'></script>
    <!-- Datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  </head>
  <body>
