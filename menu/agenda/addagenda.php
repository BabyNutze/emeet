<div class="wrapper">
	<div class="container bg-dark">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header clearfix">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="home.php">หน้าแรก</a>
							</li>
							<li class="breadcrumb-item " aria-current="page"><a href="home.php?menu=agenda">งานประชุม</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">เพิ่มงานประชุม</li>
						</ol>
					</nav>


				</div>
				<h2></h2>
				<form action="home.php?menu=agenda&sub=saveagenda" method="post">
					<div class="form-row">
						<div class="form-group col-md-9">
							<label for="inputEmail4">หัวข้อการประชุม</label>
							<input type="text" class="form-control" name="subject">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md">
							<label for="round">ครั้งที่</label>
							<input type="text" name="round">/
							<select name="year" id="year">
								<?php   $latest_year = date('Y');  
								for($i=0; $i<=10; $i++) {?>
								<option value="<?php echo date(" Y ")-$i. '"'  .($i === $latest_year ? ' selected="selected"' : ''); ?>">
									<?php echo date("Y")-$i+543;?>
								</option>
								<?php } ?>
							</select>
						</div>
					</div>


					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="committee_id">กรรมการ / จรรยาบรรณ</label>
							<select id="committee_id" name="committee_id" class="form-control">
								<option value="">ชุดกรรมการ</option>
								<?php
								$default_committee = '1';
								$default_val = '1';
								$sql = "SELECT * FROM committee";
								if ( $result = mysqli_query( $conn, $sql ) ) {
									if ( mysqli_num_rows( $result ) > 0 ) {
										while ( $row = mysqli_fetch_array( $result ) ) {
											?>
								<option value="<?php echo $row[ 'committee_id' ]; ?>" <?php if($row[ 'committee_id' ]==1 ) echo "SELECTED";?>>
									<?php echo $row[ 'committee_name' ]; ?>
								</option>
								<?php
								}
								}
								}
								?>
							</select>
						</div>

					</div>


					<div class="form-row">
						<div class="form-group col-md-8">
							<label for="subcommittee_id">อนุกรรมการ / คณะทำงาน</label>
							<select id="subcommittee" name="subcommittee" class="form-control">
								<option value="">อนุกรรมการ / คณะทำงาน</option>
								<?php

								$sql = "SELECT * FROM subcommittee";
								if ( $result = mysqli_query( $conn, $sql ) ) {
									if ( mysqli_num_rows( $result ) > 0 ) {
										while ( $row = mysqli_fetch_array( $result ) ) {
											?>
								<option value="<?php echo $row[ 'subcommittee_id' ]; ?>">
									<?php echo $row[ 'subcommittee_name' ]; ?>
								</option>
								<?php
								}
								}
								}
								?>
							</select>
						</div>
					</div>








					<div>
						<label for="meeting_day">วันที่</label>
						<input type="date" name="meeting_day" id="meeting_day">
						<label for="t1">เวลา</label>
						<select name="t11">
							<?php
							foreach ( range( '0', '23' ) as $num ) {
								?>
							<option value="<?php echo sprintf(" %02d ",$num); ?>">
								<?php echo sprintf("%02d",$num)?>
							</option>
							<?php } ?>
						</select>
						<select name="t12">
							<?php
							foreach ( range( '0', '59' ) as $num ) {
								?>
							<option value="<?php echo sprintf(" %02d ",$num); ?>">
								<?php echo sprintf("%02d",$num)?>
							</option>
							<?php } ?>
						</select>

						<label for="t21"> ถึง </label>
						<select name="t21">
							<?php
							foreach ( range( '0', '23' ) as $num ) {
								?>
							<option value="<?php echo sprintf(" %02d ",$num); ?>">
								<?php echo sprintf("%02d",$num)?>
							</option>
							<?php } ?>
						</select>
						<select name="t22">
							<?php
							foreach ( range( '0', '59' ) as $num ) {
								?>
							<option value="<?php echo sprintf(" %02d ",$num); ?>">
								<?php echo sprintf("%02d",$num)?>
							</option>
							<?php } ?>
						</select>
					</div>



					<br>
					<button type="submit" class="btn btn-primary">บันทึก</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	var today = moment().format( 'YYYY-MM-DD' );
	console.log( today );
	$( "#meeting_day" ).val( today );
</script>