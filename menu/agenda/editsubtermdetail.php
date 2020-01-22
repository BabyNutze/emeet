<?php


if ( isset( $_GET[ "a" ] ) && isset( $_GET[ "t" ] ) && isset( $_GET[ "st" ] ) ) {

	$sql = "SELECT agenda.agenda_id, agenda.agenda_subject,  DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,TIME_FORMAT(start_time, '%H:%i') as st,	TIME_FORMAT(end_time, '%H:%i') as et , agenda.round, term.tid, term.term_id, term.term_no, term.term_subject , subterm.stid , subterm.subterm_id , subterm.subterm_no , subterm.subterm_subject , subterm.subterm_detail , subterm.subterm_resolution
	FROM agenda 
	LEFT JOIN term ON agenda.agenda_id = term.agenda_id 
	LEFT JOIN subterm on subterm.tid = term.tid
	WHERE agenda.agenda_id = " . $_GET[ 'a' ] . " and term.tid = " . $_GET[ 't' ] . " and subterm.stid = " . $_GET[ 'st' ];
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
			$tid = $row[ "tid" ];
			$term_id = $row[ "term_id" ];
			$term_no = $row[ "term_no" ];
			$term_subject = $row[ "term_subject" ];
			$stid = $row[ "stid" ];
			$subterm_subject = $row[ "subterm_subject" ];
			$subterm_no = $row[ "subterm_no" ];
			$subterm_detail = $row[ "subterm_detail" ];
			$subterm_resolution = $row[ "subterm_resolution" ];

		} else {


		}

	} else {
		echo "Oops! Something went wrong. Please try again later.";
	}
}

if ( isset( $_POST[ "submit" ] ) ) {

	$agenda_id = $_POST[ "agenda_id" ];
	$tid = $_POST[ "tid" ];
	$stid = $_POST[ "stid" ];
	$subterm_detail = $_POST[ "editor1" ];
	$subterm_resolution = $_POST[ 'subterm_resolution' ];
	$subterm_no = $_POST[ 'subterm_no' ];
	$subterm_subject = $_POST[ 'subterm_subject' ];

	$sql = "UPDATE subterm SET subterm_detail ='$subterm_detail' , subterm_resolution = '$subterm_resolution', subterm_no = $subterm_no, subterm_subject = '$subterm_subject'
	
	WHERE agenda_id = $agenda_id and tid = $tid and stid = $stid";
	if ( mysqli_query( $conn, $sql ) ) {

		#	echo '<pre>';
		#	var_dump( $_POST );
		#	echo '</pre>';




		$rowcount = $_POST[ "rowcount" ];
		// อัพโหลดไฟล์ และบันทึกลง database
		for ( $i = 0, $no = $rowcount; $i < count( $_FILES[ "inputfile" ][ "name" ] ); $i++ ) {
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
					$sql .= " (atfid, agenda_id, tid, stid, attach_no, attach_name, attach_detail, updt) VALUES ($atfid, $agenda_id, $tid, $stid, $attno, '$attach_name', '$attach_detail', NOW())  ";

					$query = mysqli_query( $conn, $sql );
					if ( $conn->query( $sql ) === TRUE ) {

						echo "บันทึกข้อมูลแล้ว";
						echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=editsubtermdetail&a=$agenda_id&t=$tid&st=$stid';}, 1000);</script>";
					} else {
						//echo "Error: " . $sql . "<br>" . $conn->error;
						echo "ตรวจสอบอีกครั้ง";
						echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=editsubtermdetail&a=$agenda_id&t=$tid&st=$stid';}, 1000);</script>";
					}

					$no = $no + 1;
				}
			}
		}

		//echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=termdetail&a=$agenda_id&t=$term_id&st=$subterm_id';}, 1000);</script>";



		//echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=edittermdetail&a=$agenda_id&t=$tid';}, 1000);</script>";




	} else {
		echo "Error updating record: " . mysqli_error( $conn );
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
								<a href="home.php?menu=agenda&sub=read&a=<?php echo $agenda_id; ?>">
									<?php echo $agenda_subject . " ครั้งที่ " . $round; ?>
								</a>
							</li>
							<li class="breadcrumb-item" aria-current="page">
								<a href="home.php?menu=agenda&sub=termdetail&a=<?php echo $agenda_id;?>&t=<?php echo $tid;?>">
									<?php echo $term_no . " " . $term_subject ; ?>
								</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">
								<?php echo $subterm_no . " " . $subterm_subject ; ?>
							</li>
						</ol>
					</nav>
				</div>
				<?php 
				$tid = $_GET["t"];
				$stid = $_GET["st"];
				?>

				<br>
				<h3>
					<?php echo $agenda_subject . " ครั้งที่ " . $round; ?>
				</h3>
				<form action="" method="post" enctype="multipart/form-data">
					<div>
						<?php echo $term_no ; ?>
						<?php echo $term_subject ;  ?>
					</div>
					<div style="text-indent: 5%">
						วาระที่ <input type="text" name="subterm_no" value="<?php echo $subterm_no;?>" size="5">
						เรื่อง <input type="text" name="subterm_subject" value="<?php echo $subterm_subject;?>" size="80">

					</div>
					<br>
					<input type="hidden" name="agenda_id" value="<?php echo $agenda_id;?>">
					<input type="hidden" name="tid" value="<?php echo $tid;?>">
					<input type="hidden" name="stid" value="<?php echo $stid;?>">

					<label for="editor1">รายละเอียด</label>

					<textarea id="editor1" name="editor1" height="100px">
						<?php echo $subterm_detail; ?>
					</textarea>
					<br>

					<div class="row">
						<div class="col-5">เอกสารประกอบ</div>
						<div class="col">รายละเอียด</div>
						<div class="col-1"></div>
					</div>

					<br>
					<?php 
					$sql = "SELECT * FROM attachfiles where agenda_id = $_GET[a] and tid= $_GET[t] and stid = $_GET[st]";
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) > 0) {
					$rowcount = mysqli_num_rows($result);

    				while($row = mysqli_fetch_assoc($result)) {
        				echo '<div class="row">
									<div class="col">

									<label>' . $row["attach_no"] . '. </label> <a href="attachfiles/' . $row["attach_name"] .  ' " target="_blank" >' . $row["attach_name"] . '</a>
									</div>
									<div class="col">
								<input type="text" name="attach_detail[]"  value="'.$row["attach_detail"] .'" size="70">

								<input type="hidden" name="attach_no[]" value="'. $row["attach_no"] .'">
								<input type="hidden" name="attach_name[]" value="'. $row["attach_name"] .'">
									</div>
									<div class="col">
								<a href="home.php?menu=agenda&sub=deletesubattachfile&a=' . $agenda_id . '&t= ' . $tid . '&st= ' . $stid . '&atf=' . $row["atfid"] . '&atfno=' .$row["attach_no"] .  '" title="ลบเอกสารแนบ" data-toggle="tooltip" class="float-right"><span><i class="fas fa-trash"></i></span></a>									
									</div>
								</div>
								';
					}
						}
					else {
						$rowcount = 0;
    					echo "ไม่มีไฟล์แนบ";
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

					<input type="text" name="subterm_resolution" class="form-control" value="<?php echo $subterm_resolution; ?>">

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
		console.log( 'Total bytes: ' + evt.editor.getData().length );
	} );
</script>