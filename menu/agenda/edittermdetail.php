<?php


if ( isset( $_GET[ "a" ] ) && !empty( trim( $_GET[ "a" ] ) ) ) {

	$sql = "SELECT agenda.agenda_id, agenda.agenda_subject,  DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,TIME_FORMAT(start_time, '%H:%i') as st,	TIME_FORMAT(end_time, '%H:%i') as et , term_no, term_subject , subterm.subterm_subject, term.term_detail, term.term_resolution
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
	$term_id = $_POST[ "term_id" ];
	$term_detail = $_POST[ "editor1" ];
	$term_resolution = $_POST[ 'term_resolution' ];

	$sql = "UPDATE term SET term_detail ='$term_detail' , term_resolution = '$term_resolution' WHERE term_id = $term_id and agenda_id = $agenda_id ";
	if ( mysqli_query( $conn, $sql ) ) {


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
									<?php echo $agenda_subject . " วันที่ " . $md. " เวลา " . $st . "-" . $et ; ?>
								</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">
								<?php echo $term_no . " " . $term_subject ; ?>
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
				<form action="" id="addsubtermform" name="addtermform" method="post">
					<h5>
						<?php echo $term_no ." " .$term_subject ;  ?>
					</h5>
					<br>
					<input type="hidden" name="agenda_id" value="<?php echo $agenda_id;?>">
					<input type="hidden" name="term_id" value="<?php echo $term_id;?>">

					<label for="editor1">รายละเอียด</label>

					<textarea id="editor1" name="editor1" height="100px">
						<?php echo $term_detail; ?>

					</textarea>

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