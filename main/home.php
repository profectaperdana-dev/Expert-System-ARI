<?php 
include "../config/koneksi.php";//koneksi ke database
?>
<!doctype html>
<html lang="en">
  <head>
  	<title>Sidebar 03</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
  </head>
<body>


<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar" class="active">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only">Toggle Menu</span>
	        </button>
        </div>
				<div class="p-4">
		  		<h1><a href="home.html" class="logo">Menu</a></h1>
	        <ul class="list-unstyled components mb-5">
	          <li class="active">
              <li><a href="home.html">Beranda</a></li>
                <li><a href='penyakit.html'>Informasi</a></li>
                <li><a href='solusi.html'>Konsultasi</a></li>   
                <li><a href='admin/hal_admin/index.php?main=home'>Masuk</a></li>
            </div>
	          
	        </ul>
    	</nav>
		   
	<!-- media -->
<div id='media'>
		<div class='cl'>&nbsp;</div>
		<!-- Content -->
        <div id="content" class="p-4 p-md-5 pt-5">
        <div class=content> 
 		      <?php include "main_menu.php"; ?>
              </div>
       
      </div>
		</div>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

	

</body>
</html>