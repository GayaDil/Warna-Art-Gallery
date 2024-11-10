<header class="main-header">
	<!-- Logo -->
	<a href="./" class="logo">
		<dir>
			<h1>Admin</h1>
		</dir>
	  <!-- mini logo -->
	 <!--  <div class="logo-mini">
		  <span class="light-logo"><img src="../assets/backend/images/logo-light.png" alt="logo"></span>
		  <span class="dark-logo"><img src="../assets/backend/images/logo-dark.png" alt="logo"></span>
	  </div>
	   logo
	  <div class="logo-lg">
		  <span class="light-logo"><img src="../assets/backend/images/logo-light-text.png" alt="logo"></span>
	  	  <span class="dark-logo"><img src="../assets/backend/images/logo-dark-text.png" alt="logo"></span>
	  </div> -->
	</a>
	<!-- <a href="./../"><i class="fa fa-home"></i> HOME</a> -->
	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top">
	  	<!-- Sidebar toggle button-->
	  	<div>
		  	<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
				<span class="sr-only">Toggle navigation</span>
		  	</a>
	  	</div>
	  	<div class="navbar-custom-menu">
	    	<ul class="nav navbar-nav">
		  	<!-- User Account-->
	      		<li class="dropdown user user-menu">
	        		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
	          			<img src="../assets/backend/images/avatar/7.jpg" class="user-image rounded-circle" alt="User Image">
	       	 		</a>
	        		<ul class="dropdown-menu animated flipInY">

	          			<!-- User image -->
	          			<li class="user-header bg-img" style="background-image: url(../../images/user-info.jpg)" data-overlay="3">
				  			<div class="flexbox align-self-center">					  
				  				<img src="../assets/backend/images/avatar/7.jpg" class="float-left rounded-circle" alt="User Image">					  
								<h4 class="user-name align-self-center">
					  				<span><?php echo $this_user_fullname; ?></span>
					  				<small><?php echo $this_user_email; ?></small>
								</h4>
				  			</div>
	          			</li>

	          			<!-- Menu Body -->
	          			<li class="user-body">
				    		<a class="dropdown-item" href="../profile"><i class="ion ion-person"></i> My Profile</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="../index"><i class="ion ion-home"></i> Warna</a>
							<div class="dropdown-divider"></div>
							<div class="p-10"><a href="../logout" class="btn btn-sm btn-rounded btn-danger"><i class="ion-log-out"></i> Logout</a></div>
	          			</li>

	        		</ul>
	      		</li>		

	    	</ul>
	  	</div>
	</nav>
</header>