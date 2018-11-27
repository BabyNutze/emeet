<nav class="navbar navbar-default navbar-expand-lg navbar-light">
	<div class="navbar-header d-flex col">
		<a class="navbar-brand" href="#">ระบบ<b>บริหารงานประชุม</b></a>
		<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
			<span class="navbar-toggler-icon"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	







	</div>
	<!-- Collection of nav links, forms, and other content for toggling -->
	<?php //echo 'Welcome '.($_SESSION['usn'] ? $_SESSION[''] : 'Guest').'!'; ?>
	<div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
		<ul class="nav navbar-nav">
			<li class="nav-item active"><a href="#" class="nav-link">หน้าหลัก</a>
			</li>
			<li class="nav-item dropdown">
				<a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">บริการ</a>
				<ul class="dropdown-menu">
					<li><a href="?menu=reservation" class="dropdown-item">จองห้องประชุม</a>
					</li>
					<li><a href="#" class="dropdown-item">Web Development</a>
					</li>
					<li><a href="#" class="dropdown-item">Graphic Design</a>
					</li>
					<li><a href="#" class="dropdown-item">Digital Marketing</a>
					</li>
				</ul>
			</li>
		</ul>
		<form class="navbar-form form-inline">
			<div class="input-group search-box">
				<input type="text" id="search" class="form-control" placeholder="Search here...">
				<span class="input-group-addon"><i class="material-icons">&#xE8B6;</i></span>
			</div>
		</form>
		<ul class="nav navbar-nav navbar-right ml-auto">
			<li class="nav-item">
				<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle get-started-btn mt-1 mb-1">เข้าสู่ระบบ</a>

				<ul class="dropdown-menu form-wrapper">
					<li>
						<form action="inc/check_login.php" method="post">
							<p class="hint-text">login</p>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Username" name="loginusn" id="loginusn" required="required">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" placeholder="Password" name="loginpwd" id="loginpwd" required="required">
							</div>
							<input type="submit" class="btn btn-primary btn-block" value="Login">
							<div class="form-footer">
								<a href="#">Forgot Your password?</a>
							</div>
						</form>
					</li>
				</ul>
			</li>
			<li class="nav-item">

				<a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">สมัครสมาชิก</a>
				<ul class="dropdown-menu form-wrapper">
					<li>
						<form action="../menu/register.php" method="post">
							<p class="hint-text">กรอกข้อมูลเพื่อสมัครสมาชิก</p>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Username" name="registerusn" id="registerusn">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" placeholder="Password" name="registerpwd" id="registerpwd" required="required">
							</div>
							<input type="submit" class="btn btn-primary btn-block" value="สมัครสมาชิก">
						</form>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</nav>