<script>
  $( function() {
	  
	  $("#selectcommittee").change(function(){	
		  if($("#selectcommittee").val() > 0 ){
			  $.post('menu/agenda/ajaxsubcommittee.php',{
				aComm : $("#selectcommittee").val() },
				function(result){
					$("#displaysubcommittee").html(result); 
				})
		  }else{
			  $( "#selectsubcommittee" ).focus(); 
		  }
	  });
	  
	  
  } );
  </script>

<?php
date_default_timezone_set( "Asia/Bangkok" );
if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {
	var_dump($_POST);
	exit();
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

					
					<div class="input-group mb-3">
    						<div class="input-group-prepend">
      							<label class='input-group-text' for='subject'>หัวข้อการประชุม</label>
    						</div>
   							<input type="text" name="subject" class="form-control">
 					 </div>
					
					<div class="input-group mb-3">
    						<div class="input-group-prepend">
      							<label class='input-group-text' for='round'>ครั้งที่</label>
    						</div>
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

					<div class="input-group mb-3">
    						<div class="input-group-prepend">
      							<label class='input-group-text' for='meeting_day'>วันที่</label>
    						</div>
						<input type="date" name="meeting_day" id="meeting_day">

    						<div class="input-group-prepend">
      							<label class='input-group-text' for='t11'> เวลา</label>
    						</div>

						<select name="t11">
							<?php
							foreach ( range( '0', '23' ) as $num ) {
								?>
							<option value="<?php echo sprintf(" %02d ",$num); ?>" 
									<?php if(sprintf( " %02d ",$num) == 13 ) echo "SELECTED";?>>
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
		
    						<div class="input-group-prepend">
      							<label class='input-group-text' for='t21'>ถึง</label>
    						</div>						
						<select name="t21">
							<?php
							foreach ( range( '0', '23' ) as $num ) {
								?>
							<option value="<?php echo sprintf(" %02d ",$num); ?>" 
									<?php if(sprintf( " %02d ",$num) == 16 ) echo "SELECTED";?>>
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

					<div class='input-group mb-3'>
						<div class='input-group-prepend'>
							<label class='input-group-text' for='selectcommittee'>สมัยกรรมการ</label>
						</div>
						<select class='custom-select' id='selectcommittee' name='selectcommittee'>
							<option>เลือก</option>
							<?php
							$sql = "SELECT * FROM committee";
							$result = $conn->query( $sql );
							while ( $row = $result->fetch_assoc() ) {
								echo "<option value='" . $row[ 'committee_id' ] . "'>" . $row[ 'committee_name' ] . "</option>";
							}
							?>
						</select>
					</div>
					
					<div id='displaysubcommittee' name='displaysubcommittee'>
				
					


					
					
					
					<br><br>
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
