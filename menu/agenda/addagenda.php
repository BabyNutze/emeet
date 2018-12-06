<?php
date_default_timezone_set( "Asia/Bangkok" );
if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {
	$sql = "SELECT MAX(agenda_id) AS agenda_id FROM agenda";
	$result = mysqli_query( $conn, $sql );
	if ( $result->num_rows > 0 ) {
		// output data of each row
		if ( $row = $result->fetch_assoc() ) {
			$agenda_id = $row[ "agenda_id" ] + 1;
		}
	} else {
		$agenda_id = 1;
	}
	$agenda_subject = $_POST[ 'subject' ];
	$committee_id = $_POST[ 'committee_id' ];
	$subcommittee_id = $_POST[ 'subcommittee' ];
	$meeting_day = $_POST[ 'meeting_day' ];
	$round = $_POST[ "round" ];

	$st1 = trim( $_POST[ "t11" ] . ":" . $_POST[ "t12" ] . ":00" );
	$st2 = str_replace( ' ', '', $st1 );
	$et1 = $_POST[ "t21" ] . ":" . $_POST[ "t22" ] . ":00";
	$et2 = str_replace( ' ', '', $et1 );

	$start_time = $meeting_day . " " . $st2;
	$end_time = $meeting_day . " " . $et2;



	$sql = "INSERT agenda (agenda_id, agenda_subject,  committee_id, subcommittee_id, meeting_day, start_time, end_time,round ) 
		VALUES ($agenda_id," . "'$agenda_subject'" . ", $committee_id, $subcommittee_id," . "'$meeting_day'" . ",'$start_time'" . ",'$end_time'" . " , '$round')";

	if ( mysqli_query( $conn, $sql ) ) {
		//echo "เพิ่มข้อมูลแล้ว<br>";

		$sql = "SELECT MAX(tid) AS tid FROM term";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$tid = $row[ "tid" ] + 1;
			}
		} else {
			$tid = 1;
		}
		$sql = "INSERT term (tid, term_id, agenda_id, term_no, term_subject) 
		VALUES ( $tid , 1 , $agenda_id, 'ระเบียบวาระที่ 1', 'เรื่องประธานและคณะอนุกรรมการแจ้งให้ที่ประชุมทราบ')";
		$query = mysqli_query( $conn, $sql );
		if ( $conn->query( $sql ) === TRUE ) {
			echo "เพิ่มวาระที่ 1 แล้ว" . "<br>";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}



		$sql = "SELECT MAX(tid) AS tid FROM term";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$tid = $row[ "tid" ] + 1;
			}
		} else {
			$tid = 1;
		}
		$sql = "INSERT term (tid, term_id, agenda_id, term_no, term_subject) 
		VALUES ( $tid , 2 , $agenda_id, 'ระเบียบวาระที่ 2', 'เรื่องรับรองรายงานการประชุม')";

		$query = mysqli_query( $conn, $sql );
		if ( $conn->query( $sql ) === TRUE ) {
			echo "เพิ่มวาระที่ 2 แล้ว" . "<br>";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}



		$sql = "SELECT MAX(tid) AS tid FROM term";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$tid = $row[ "tid" ] + 1;
			}
		} else {
			$tid = 1;
		}
		$sql = "INSERT term (tid, term_id, agenda_id, term_no, term_subject) 
		VALUES ( $tid , 3 , $agenda_id, 'ระเบียบวาระที่ 3', 'เรื่องสืบเนื่อง')";

		$query = mysqli_query( $conn, $sql );
		if ( $conn->query( $sql ) === TRUE ) {
			echo "เพิ่มวาระที่ 3 แล้ว" . "<br>";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}



		$sql = "SELECT MAX(tid) AS tid FROM term";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$tid = $row[ "tid" ] + 1;
			}
		} else {
			$tid = 1;
		}
		$sql = "INSERT term (tid, term_id, agenda_id, term_no, term_subject) 
		VALUES ( $tid , 4 , $agenda_id, 'ระเบียบวาระที่ 4', 'เรื่องเพื่อพิจารณา')";

		$query = mysqli_query( $conn, $sql );
		if ( $conn->query( $sql ) === TRUE ) {
			echo "เพิ่มวาระที่ 4 แล้ว" . "<br>";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}



		$sql = "SELECT MAX(tid) AS tid FROM term";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$tid = $row[ "tid" ] + 1;
			}
		} else {
			$tid = 1;
		}
		$sql = "INSERT term (tid, term_id, agenda_id, term_no, term_subject) 
		VALUES ( $tid , 5 , $agenda_id, 'ระเบียบวาระที่ 5', 'เรื่องเพื่อทราบ')";

		$query = mysqli_query( $conn, $sql );
		if ( $conn->query( $sql ) === TRUE ) {
			echo "เพิ่มวาระที่ 5 แล้ว" . "<br>";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}



		$sql = "SELECT MAX(tid) AS tid FROM term";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$tid = $row[ "tid" ] + 1;
			}
		} else {
			$tid = 1;
		}
		$sql = "INSERT term (tid, term_id, agenda_id, term_no, term_subject) 
		VALUES ( $tid , 6 , $agenda_id, 'ระเบียบวาระที่ 6', 'เรื่องอื่น ๆ (ถ้ามี)')";

		$query = mysqli_query( $conn, $sql );
		if ( $conn->query( $sql ) === TRUE ) {
			echo "เพิ่มวาระที่ 6 แล้ว" . "<br>";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}
		echo "บันทึกการประชุมแล้ว";
		echo "<script>window.location='home.php?menu=agenda'</script>";
				echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda';}, 1000);</script>";

	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error( $conn );
		//header( "location: home.php?menu=agenda" );
	}
	mysqli_close( $conn );

}
?>
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
				<form action="" method="post">
					<div class="form-row">
						<div class="form-group col-md-9">
							<label for="inputEmail4">หัวข้อการประชุม</label>
							<input type="text" class="form-control" name="subject" value="คณะอนุกรรมการระบบเทคโนโลยีสารสนเทศ">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md">
							<label for="round">ครั้งที่</label>
							<input type="text" name="round" value="33-9/2561">
							<!--
							<select name="year" id="year">
								<?php //  $latest_year = date('Y');  
								//for($i=0; $i<=10; $i++) {?>
								<option value="<?php //echo date(" Y ")-$i. '"'  .($i === $latest_year ? ' selected="selected"' : ''); ?>">
									<?php// echo date("Y")-$i+543;?>
								</option>
								<?php// } ?>
							</select>
							-->
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
								<option value="<?php echo $row[ 'subcommittee_id' ]; ?>" <?php if($row[ 'subcommittee_id' ]== 34 ) echo "SELECTED";?>>
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
							<option value="<?php echo sprintf(" %02d ",$num); ?>" <?php if(sprintf(" %02d ",$num) == 13 ) echo "SELECTED";?>>
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
							<option value="<?php echo sprintf(" %02d ",$num); ?>" <?php if(sprintf(" %02d ",$num) == 16 ) echo "SELECTED";?>>
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