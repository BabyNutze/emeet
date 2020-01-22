<?php

if ( isset( $_GET[ "a" ] ) && !empty( trim( $_GET[ "a" ] ) ) && isset( $_GET[ "t" ] ) ) {

	$sql = "SELECT agenda.agenda_id, agenda.agenda_subject,  DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,TIME_FORMAT(start_time, '%H:%i') as st,	TIME_FORMAT(end_time, '%H:%i') as et , agenda.round, term.tid, term.term_no, term_subject , term.term_detail, term.term_resolution
	FROM agenda 
	LEFT JOIN term ON agenda.agenda_id = term.agenda_id 
	WHERE agenda.agenda_id = " . $_GET[ 'a' ] . " and term.tid = " . $_GET[ 't' ];
	if ( $result = mysqli_query( $conn, $sql ) ) {
		if ( mysqli_num_rows( $result ) == 1 ) {
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
			header( "location: error.php" );
			exit();
		}
	} else {
		echo "Oops! Something went wrong. Please try again later.";
	}
}

if ( isset( $_POST[ "submit" ] ) ) {

	$agenda_id = $_POST[ "agenda_id" ];
	$tid = $_POST[ "tid" ];
	$term_detail = $_POST[ "editor1" ];
	$term_resolution = $_POST[ 'term_resolution' ];


	$sql = "UPDATE term SET term_detail ='$term_detail' , term_resolution = '$term_resolution' WHERE tid = $tid and agenda_id = $agenda_id ";
	if ( mysqli_query( $conn, $sql ) ) {
		$rowcount = $_POST[ "rowcount" ];
		// อัพโหลดไฟล์ และบันทึกลง database
		if(isset($_FILES[ "inputfile" ])){
		for ( $i = 0 ,$no = $rowcount; $i < count( $_FILES[ "inputfile" ][ "name" ] ); $i++ ) {
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

					$attach_no = $no;
					
					$attach_name = $_FILES[ "inputfile" ][ "name" ][ $i ];
					$attach_detail = $_POST[ "attach_detail" ][ $attach_no ];
					$attno = $_POST[ "attach_no" ][ $attach_no ];

					$sql = "INSERT INTO attachfiles";
					$sql .= " (atfid, agenda_id, tid, attach_no, attach_name, attach_detail, updt) VALUES ($atfid, $agenda_id, $tid, $attno, '$attach_name', '$attach_detail', NOW())  ";
					
					$query = mysqli_query( $conn, $sql );
					if ( $conn->query( $sql ) === TRUE ) {
						
						echo "บันทึกข้อมูลแล้ว";
						//echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=termdetail&a=$agenda_id&t=$tid';}, 1000);</script>";
					} else {
						//echo "Error: " . $sql . "<br>" . $conn->error;
						//echo "ตรวจสอบอีกครั้ง";
						//	echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=viewterm&a=$agenda_id&t=$tid';}, 1000);</script>";
					}
					
				$no =  $no + 1;
				}
			}
		}

		//echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=termdetail&a=$agenda_id&t=$term_id&st=$subterm_id';}, 1000);</script>";



		//echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=edittermdetail&a=$agenda_id&t=$tid';}, 1000);</script>";
		}
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
				$tid = $_GET["t"];
				$agenda_id = $_GET["a"]
				?>

				<br>
				<h3>
					<?php echo $agenda_subject . " ครั้งที่ " . $round ;  ?>
				</h3>
				<form action="" id="addsubtermform" name="addtermform" method="post" enctype="multipart/form-data">
					<h5>
						<?php echo $term_no ." " .$term_subject ;  ?>
					</h5>
					<br>
					<input type="hidden" name="agenda_id" value="<?php echo $agenda_id;?>">
					<input type="hidden" name="tid" value="<?php echo $tid;?>">

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
					$sql = "SELECT * FROM attachfiles where agenda_id = $_GET[a] and tid= $_GET[t]";
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) > 0) {
					$rowcount = mysqli_num_rows($result);
    				while($row = mysqli_fetch_assoc($result)) {
        				echo '<div class="row">
									<div class="col"> <label>' . $row["attach_no"] . '. </label> <a href="attachfiles/' . $row["attach_name"] .  ' " target="_blank" >' . $row["attach_name"] . '</a>
									</div>
									<div class="col">
								<input type="text" name="attach_detail[]"  value="'.$row["attach_detail"] .'" >
								<input type="hidden" name="attach_no[]" value="'. $row["attach_no"] .'">
								<input type="hidden" name="attach_name[]" value="'. $row["attach_name"] .'">
								<a href="home.php?menu=agenda&sub=deleteattachfile&a=' . $agenda_id . '&t= ' . $tid . '&atf=' . $row["atfid"] . '&atfno=' .$row["attach_no"] .  '" title="ลบวาระย่อย" data-toggle="tooltip" class="float-right"><span><i class="fas fa-trash"></i></span></a>
									</div>
								</div>';
					}
						} else {
    					echo "";
					}
					$addinputfile = 10-$rowcount ;
					
		for ( $i = $rowcount; $i < 10 ; $i++ ) {	
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
					<input type="hidden" name="rowcount" value="<?php echo $rowcount; ?>">




					<br>
					<h5><b><u>มติที่ประชุม</u></b></h5>

					<input type="text" name="term_resolution" class="form-control" value="<?php echo $term_resolution; ?>">

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