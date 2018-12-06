<?php


if ( isset( $_GET[ "a" ] ) && isset( $_GET[ "t" ] )  && isset( $_GET[ "st" ] ) ) {

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
	$subterm_detail = $_POST[ "editor1" ];
	$subterm_resolution = $_POST[ 'subterm_resolution' ];

	$sql = "UPDATE subterm SET subterm_detail ='$subterm_detail' , subterm_resolution = '$subterm_resolution' WHERE tid = $tid and agenda_id = $agenda_id ";
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
									<?php echo $agenda_subject . " ครั้งที่ " . $round; ?>
								</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">
								<?php echo $term_no . " " . $term_subject ; ?>
							</li>
						</ol>
					</nav>
				</div>
				<?php 
				$tid = $_GET["t"];
				?>

				<br>
				<h3>
					<?php echo $agenda_subject . " ครั้งที่ " . $round; ?>
				</h3>
				<form action="" id="addsubtermform" name="addtermform" method="post">
					<div><?php echo $term_no; ?> <?php echo $term_subject ;  ?></div>
						<div style="text-indent: 10%"><?php echo $subterm_no . " " . $subterm_subject ; ?></div>
					<br>
					<input type="hidden" name="agenda_id" value="<?php echo $agenda_id;?>">
					<input type="hidden" name="tid" value="<?php echo $tid;?>">
					<input type="hidden" name="stid" value="<?php echo $stid;?>">

					<label for="editor1">รายละเอียด</label>

					<textarea id="editor1" name="editor1" height="100px">
						<?php echo $subterm_detail; ?>

					</textarea>

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
		// getData() returns CKEditor's HTML content.
		console.log( 'Total bytes: ' + evt.editor.getData().length );
	} );
</script>