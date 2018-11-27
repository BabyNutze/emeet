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
	<div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
		<ul class="nav navbar-nav">
			<li class="nav-item active"><a href="#" class="nav-link">หน้าหลัก</a>
			</li>
			<li class="nav-item dropdown">
				<a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">บริการ</a>
				<ul class="dropdown-menu">
					<li><a href="?menu=reservation" class="dropdown-item">จองห้องประชุม</a>
					</li>
					<!--
					<li><a href="?menu=committee" class="dropdown-item">คณะกรรมการ</a>
					</li>
					<li><a href="?menu=position" class="dropdown-item">ตำแหน่งในอนุกรรมการ/คณะกรรมการ</a>
					</li>
					<li><a href="?menu=subcommittee" class="dropdown-item">คณะอนุกรรมการ/คณะทำงาน</a>
					</li>
					-->
					<li><a href="?menu=agenda" class="dropdown-item">งานประชุม</a>
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
				<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle get-started-btn mt-1 mb-1">สวัสดีคุณ <?php echo $usn; ?></a>

				<ul class="dropdown-menu form-wrapper">
					<li>
							<input type="text" class="btn btn-primary btn-block" value="ข้อมูลผู้ใช้">
							<div class="or-seperator"></div>
							<div class="form-footer">
								<a href="inc/logout.php">ออกจากระบบ</a>
							</div>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</nav>
