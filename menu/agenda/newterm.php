<?php

if ( isset( $_GET[ "a" ] ) ) {

	$sql = "SELECT term.tid, term.term_no, term_subject , term.term_detail, term.term_resolution , agenda.agenda_id, agenda.agenda_subject, DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,TIME_FORMAT(start_time, '%H:%i') as st,
	TIME_FORMAT(end_time, '%H:%i') as et , agenda.round
	FROM agenda 
	LEFT JOIN term ON agenda.agenda_id = term.agenda_id 
	WHERE agenda.agenda_id = " . $_GET[ 'a' ];
	if ( $result = mysqli_query( $conn, $sql ) ) {
		if ( mysqli_num_rows( $result ) > 0 ) {
			/* Fetch result row as an associative array. Since the result set
			contains only one row, we don't need to use while loop */
			$row = mysqli_fetch_array( $result, MYSQLI_ASSOC );

			// Retrieve individual field value
			$agenda_id = $row[ "agenda_id" ];
			$agenda_subject = $row[ "agenda_subject" ];
			$round = $row[ "round" ];
			$md = $row[ "md" ];
			$st = $row[ "st" ];
			$et = $row[ "et" ];
			$term_subject = $row[ "term_subject" ];
			$tid = $row[ "tid" ];
			$term_no = $row[ "term_no" ];
			$term_detail = $row[ "term_detail" ];
			$term_resolution = $row[ "term_resolution" ];

		} else {
			// URL doesn't contain valid id parameter. Redirect to error page
			//header( "location: error.php" );
			//	exit();
		}
	} else {
		echo "Oops! Something went wrong. Please try again later.";
	}
}

if ( isset( $_POST[ "submit" ] ) ) {

	$agenda_id = $_POST[ "agenda_id" ];
	$term_no = $_POST[ "term_no" ];
	$term_subject = $_POST[ "term_subject" ];
	$term_detail = $_POST[ 'editor1' ];
	$rowcount = $_POST[ "rowcount" ];

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
	$sql2 = "SELECT MAX(term_id) AS term_id FROM term where agenda_id = $agenda_id ";
	$result2 = mysqli_query( $conn, $sql2 );
	if ( $result2->num_rows > 0 ) {
		// output data of each row
		if ( $row2 = $result2->fetch_assoc() ) {
			$term_id = $row2[ "term_id" ] + 1;
		}
	} else {
		$term_id = 1;
	}
	$rowcount = $_POST[ "rowcount" ];


	$sql = "INSERT INTO term (tid, term_id, agenda_id,  term_no, term_subject, term_detail)
	VALUES ($tid, $term_id,  $agenda_id,  '$term_no' , '$term_subject', '$term_detail')";
	if ( mysqli_query( $conn, $sql ) ) {

		// อัพโหลดไฟล์ และบันทึกลง database
		for ( $i = 0;  $i < count( $_FILES[ "inputfile" ][ "name" ] ); $i++ ) {
			if ( $_FILES[ "inputfile" ][ "name" ][ $i ] != "" ) {
				if ( move_uploaded_file( $_FILES[ "inputfile" ][ "tmp_name" ][ $i ], "attachfiles/" . $_FILES[ "inputfile" ][ "name" ][ $i ] ) ) {
					//echo "อัพโหลดไฟล์แล้ว<br>";
					$sql = "SELECT MAX(atfid) AS atfid FROM attachfiles";
					$result = mysqli_query( $conn, $sql );
					if ( $result->num_rows > 0 ) {
						// output data of each row
						if ( $row = $result->fetch_assoc() ) {
							$atfid = $row[ "atfid" ] + 1;
						}
					} else {
						$atfid = 1;
					}


					$sql2 = "SELECT MAX(attach_no) AS attach_no FROM attachfiles where agenda_id = $agenda_id and tid = $tid";
					$result2 = mysqli_query( $conn, $sql2 );


					if ( $result->num_rows > 0 ) {
						// output data of each row
						if ( $row2 = $result2->fetch_assoc() ) {
							$atfno = $row2[ "attach_no" ] + 1;
						}
					} else {
						$atfno = 1;
					}

				

					$attach_name = $_FILES[ "inputfile" ][ "name" ][ $i ];
					$attach_detail = $_POST[ "attach_detail" ][ $i ];
					$attno = $_POST[ "attach_no" ][ $i ];

					$sql3 = "INSERT INTO attachfiles";
					$sql3 .= " (atfid, agenda_id, tid, attach_no, attach_name, attach_detail, updt) VALUES ($atfid, $agenda_id, $tid, $atfno, '$attach_name', '$attach_detail', NOW())  ";


					$query3 = mysqli_query( $conn, $sql3 );
					if ( mysqli_query( $conn, $sql3 ) ) {

						echo "บันทึกข้อมูลแล้ว";
						//echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=termdetail&a=$agenda_id&t=$tid';}, 1000);</script>";
					} else {
						//echo "Error: " . $sql . "<br>" . $conn->error;
						//echo "ตรวจสอบอีกครั้ง";
						//	echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=viewterm&a=$agenda_id&t=$tid';}, 1000);</script>";
					}

					$no = $no + 1;
				}
			}
		}

		//echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=termdetail&a=$agenda_id&t=$term_id&st=$subterm_id';}, 1000);</script>";


		//	echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=edittermdetail&a=$agenda_id&t=$tid';}, 1000);</script>";

	} else {

	}
}

?>

<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header clearfix">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="home.php">หน้าแรก</a>
							</li>
							<li class="breadcrumb-item"><a href="home.php?menu=agenda">งานประชุม</a>
							</li>
							<li class="breadcrumb-item">
								<a href="home.php?menu=agenda&sub=read&a=<?php echo $agenda_id;?>">
									<?php echo $agenda_subject . " " . $round ; ?>
								</a>
							</li>
							<li class="breadcrumb-item">
								<a href="home.php?menu=agenda&sub=termdetail&a=<?php echo $agenda_id;?>&t=<?php echo $tid;?>">
									<?php echo $term_no . " " . $term_subject ; ?>
								</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">
								แก้ไขวาระ
							</li>
						</ol>
					</nav>
				</div>
				<?php 
				$agenda_id = $_GET["a"]
				?>

				<br>
				<h3>
					<?php echo $agenda_subject . " ครั้งที่ " . $round ;  ?>
				</h3>
				<form action="" id="addsubtermform" name="addtermform" method="post" enctype="multipart/form-data">
					<?php 
				$sql = "SELECT * FROM term where agenda_id = $agenda_id";
				$result = mysqli_query( $conn, $sql );
				if ( $result->num_rows > 0 ) {					
					$row_cnt = mysqli_num_rows($result);		
					echo "มีวาระอยู่แล้ว $row_cnt วาระ<br>";	
					while( $row = $result->fetch_assoc() ) {
						$tid = $row["tid"];
							echo "<a href='home.php?menu=agenda&sub=termdetail&a=$agenda_id&t=$tid'>". $row['term_no'] . " " . $row['term_subject'] . "</a><br>";
						}
				} else {
					echo "ยังไม่มีวาระย่อย";
				}
?>
					<br>
					<input type="hidden" name="agenda_id" value="<?php echo $agenda_id;?>">
					<input type="hidden" name="rowcount" value="<?php echo $row_cnt;?>">




					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="inputEmail4">ชื่อวาระ</label>
							<input type="text" class="form-control" name="term_no" value="ระเบียบวาระที่ ">
						</div>
						<div class="form-group col-md-9">
							<label for="inputPassword4">เรื่อง</label>
							<input type="text" class="form-control" name="term_subject">
						</div>
					</div>

					<br>
					<label for="editor1">รายละเอียด</label>

					<textarea id="editor1" name="editor1" height="100px">
						<?php echo $term_detail; ?>

					</textarea>

					<br>
					<div class="row">
						<div class="col">เอกสารประกอบ</div>
						<div class="col">รายละเอียด</div>
					</div>

					<br>
					<?php 
					
		for ( $i = 0; $i < 10 ; $i++ ) {	
			$ordinal = $i+1;
			echo '<div class="row"><div class="col">  <label>'. $ordinal .'. </label>   <input type="file" name="inputfile[]">
			</div><div class="col">
			<input type="text" name="attach_detail[]">
			<input type="hidden" name="attach_no[]" value="'. $ordinal .'"> 
			</div></div>';
			
		}
			?>

					<input type="hidden" name="agenda_id" value="<?php echo $agenda_id; ?>">
					<input type="hidden" name="tid" value="<?php echo $tid; ?>">
					<br>


					<div class="float-right">

						<input type="submit" class="btn btn-primary" value="บันทึก" name="submit">
					</div>
				</form>

			</div>
		</div>
	</div>
</div>
<script>
	var editor = CKEDITOR.replace( 'editor1', {

	} );

	editor.on( 'change', function ( evt ) {
		// getData() returns CKEditor's HTML content.
		console.log( 'Total bytes: ' + evt.editor.getData().length );
	} );
</script>