<?php


if ( isset( $_GET[ "a" ] ) && !empty( trim( $_GET[ "a" ] && isset( $_GET[ "t" ] ) && !empty( trim( $_GET[ "t" ] ) ) ) ) ) {

	// Prepare a select statement
	$sql = "SELECT agenda.agenda_id, agenda.agenda_subject,  DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,TIME_FORMAT(start_time, '%H:%i') as st,	TIME_FORMAT(end_time, '%H:%i') as et , term_no, term_subject , subterm.subterm_subject
	FROM agenda 
	LEFT JOIN term ON agenda.agenda_id = term.agenda_id 
	LEFT JOIN subterm on subterm.term_id = term.term_id
	WHERE agenda.agenda_id = " . $_GET[ 'a' ] . " and term.term_id = " . $_GET[ 't' ];

	if ( $result = mysqli_query( $conn, $sql ) ) {
		if ( mysqli_num_rows( $result ) == 1 ) {
			/* Fetch result row as an associative array. Since the result set
			contains only one row, we don't need to use while loop */
			$row = mysqli_fetch_array( $result, MYSQLI_ASSOC );

			// Retrieve individual field value
			$agenda_id = $row[ "agenda_id" ];
			$agenda_subject = $row[ "agenda_subject" ];
			$md = $row[ "md" ];
			$st = $row[ "st" ];
			$et = $row[ "et" ];
			$term_subject = $row[ "term_subject" ];
			$term_no = $row[ "term_no" ];

		} else {
			// URL doesn't contain valid id parameter. Redirect to error page
			header( "location: error.php" );
			exit();
		}

	} else {
		echo "Oops! Something went wrong. Please try again later.";
	}
}

if ( isset( $_POST[ "agenda_id" ] ) && !empty( $_POST[ 'subterm_subject' ] ) && isset( $_POST[ "term_id" ] ) ) {
	$sql = "SELECT MAX(subterm_id) AS subterm_id FROM subterm";
	$result = mysqli_query( $conn, $sql );
	if ( $result->num_rows > 0 ) {
		// output data of each row
		if ( $row = $result->fetch_assoc() ) {
			$subterm_id = $row[ "subterm_id" ] + 1;
		}
	} else {
		$subterm_id = 1;
	}
	$term_id = $_POST[ "term_id" ];
	$subterm_subject = $_POST[ 'subterm_subject' ];
	$subterm_detail = $_POST[ 'subterm_detail' ];
	$agenda_id = $_POST[ 'agenda_id' ];


	$sql = "INSERT INTO subterm (subterm_id,  agenda_id, term_id, subterm_subject, subterm_detail) 
					VALUES ($subterm_id, $agenda_id, $term_id, '$subterm_subject', '$subterm_detail' )";

	$query = mysqli_query( $conn, $sql );
	if ( $conn->query( $sql ) === TRUE ) {
		echo "บันทึกข้อมูลแล้ว";
		echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=termdetail&a=$agenda_id&t=$term_id';}, 1000);</script>";
	} else {
		//echo "Error: " . $sql . "<br>" . $conn->error;
		echo "ตรวจสอบอีกครั้ง";
				echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=termdetail&a=$agenda_id&t=$term_id';}, 1000);</script>";
	}


} else {

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
							<li class="breadcrumb-item" aria-current="page"><a href="home.php?menu=agenda">งานประชุม</a>
							</li>
							<li class="breadcrumb-item">
								<a href="home.php?menu=agenda&sub=read&a=<?php echo $agenda_id;?>">
									<?php echo $agenda_subject  ; ?>
								</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">
								<?php echo $term_subject ; ?>
							</li>
						</ol>
					</nav>
				</div>
				<?php 
				$term_id = $_GET["t"];
				?>

				<br>
				<h3>
					<?php echo $agenda_subject ;  ?>
				</h3>
				<h5>
					<?php echo $term_no ." " .$term_subject ;  ?>
				</h5>
				<?php 
				$sql = "SELECT * FROM subterm where term_id = $term_id and agenda_id = $agenda_id";
	$result = mysqli_query( $conn, $sql );
	if ( $result->num_rows > 0 ) {
		// output data of each row
		$row_cnt = mysqli_num_rows($result);
		
		if ( $row = $result->fetch_assoc() ) {
			echo "มีวาระย่อย $row_cnt วาระ" . "<br><a href='home.php?menu=agenda&sub=subtermdetail&a=$agenda_id&t=$term_id&s=$row[subterm_id]'>". $row['subterm_subject'] . "</a><br>";
		}
	} else {
			echo "ยังไม่มีวาระย่อย";
	}

				
				
				
				?>
				<form action="" id="addsubtermform" name="addtermform" method="post">

					<br>

					<div class="form-group">
						<label for="subterm_subject">เพิ่มชื่อวาระย่อย:</label>
						<input type="text" name="subterm_subject" class="form-control">
					</div>
					<div class="form-group">
						<label for="subterm_detail">รายละเอียด</label><br>
						<textarea id="subterm_detail" name="subterm_detail" class="form-control"></textarea>


					</div>
					<input type="hidden" name="agenda_id" value="<?php echo $agenda_id;?> ">
					<input type="hidden" name="term_id" value="<?php echo $term_id;?> ">


					<input type="submit" value="บันทึก">
				</form>


			</div>
		</div>
	</div>
</div>
<script>
	var editor = CKEDITOR.replace( 'subterm_detail', {

	} );

	editor.on( 'change', function ( evt ) {
		// getData() returns CKEditor's HTML content.
		console.log( 'Total bytes: ' + evt.editor.getData().length );
	} );
</script>