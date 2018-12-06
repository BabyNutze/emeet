<?php
date_default_timezone_set( "Asia/Bangkok" );

if ( isset( $_GET[ "a" ] ) && isset( $_GET[ "t" ] )  && isset( $_GET[ "st" ] ) ) {

	// Prepare a select statement
	$sql = "SELECT agenda.agenda_id, agenda.agenda_subject,  DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,TIME_FORMAT(start_time, '%H:%i') as st,	TIME_FORMAT(end_time, '%H:%i') as et , agenda.round, term.tid, term.term_no, term_subject , term.term_detail, subterm.stid, subterm.subterm_no, subterm.subterm_subject, subterm.subterm_detail, subterm.subterm_resolution
	FROM agenda 
	LEFT JOIN term ON agenda.agenda_id = term.agenda_id 
	LEFT JOIN subterm on subterm.tid = term.tid
	WHERE agenda.agenda_id = " . $_GET[ 'a' ] . " and term.tid = " . $_GET[ 't' ] . " and subterm.stid = " . $_GET[ 'st' ] ;
	if ( $result = mysqli_query( $conn, $sql ) ) {
		if ( mysqli_num_rows( $result ) == 1 ) {
			$row = mysqli_fetch_array( $result, MYSQLI_ASSOC );
			$agenda_id = $row[ "agenda_id" ];
			$agenda_subject = $row[ "agenda_subject" ];
			$round = $row["round"];
			$md = $row[ "md" ];
			$st = $row[ "st" ];
			$et = $row[ "et" ];
			$term_subject = $row[ "term_subject" ];
			$term_no = $row[ "term_no" ];
			$term_detail = $row[ "term_detail" ];
			$stid = $row["stid"];
			$subterm_no = $row["subterm_no"];
			$subterm_subject = $row["subterm_subject"];
			$subterm_detail = $row["subterm_detail"];
			$subterm_resolution = $row["subterm_resolution"];
			

		} else {
			
			exit();
		}

	} else {
		echo "Oops! Something went wrong. Please try again later.";
	}
}


if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {
	$detail = $_POST[ "editor1" ];
	$agenda_id = $_POST[ "agenda_id" ];
	$tid = $_POST[ "tid" ];
	$stid = $_POST[ "stid" ];


	$sql = "UPDATE subterm SET subterm_detail = '$detail' WHERE tid= $tid and agenda_id = $agenda_id and stid = $stid ";
	if ( mysqli_query( $conn, $sql ) ) {
		echo "ปรับปรุงข้อมูลแล้ว";
		echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=termdetail&a=$agenda_id&t=$term_id';}, 1000);</script>";
	} else {
		echo "Error updating record: " . mysqli_error( $conn );
	}

}
?>



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
									<?php echo $agenda_subject . " ครั้งที่ " . $round ; ?>
								</a>
							</li>
							<li class="breadcrumb-item" aria-current="page">
								<?php echo $term_no . " " . $term_subject ; ?>
							</li>
							<li class="breadcrumb-item active" aria-current="page">
								<?php echo $subterm_no . " " . $subterm_subject ; ?>
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
				<form action="home.php?menu=agenda&sub=savetermdetail" method="post">
					<div><?php echo $term_no; ?> <?php echo $term_subject ;  ?></div>
						<div style="text-indent: 10%"><?php echo $subterm_no . " " . $subterm_subject ; ?></div>
					
					<br>
					<input type="hidden" name="agenda_id" value="<?php echo $agenda_id;?>">
					<input type="hidden" name="term_id" value="<?php echo $term_id;?>">

					<label for="editor1">รายละเอียด</label>
					<?php if(isset($_POST['edit']))
					{
	
					}else{
	
					}
					?>
					<textarea id="editor1" name="editor1" height="100px">
						<?php echo $subterm_detail; ?>
					</textarea>

					<br>
					<h5><b><u>มติที่ประชุม</u></b></h5>				

					<textarea rows="3" class="form-control"></textarea>
					<?php echo $subterm_resolution; ?>
					<br>
					<div class="float-right">

						<button type="submit" class="btn btn-primary">บันทึก</button>
					</div>
				</form>


			</div>
		</div>
	</div>
</div>
<script>
	var editor = CKEDITOR.replace( 'editor1', {
	
	} );

editor.on( 'change', function( evt ) {
    // getData() returns CKEditor's HTML content.
    console.log( 'Total bytes: ' + evt.editor.getData().length );
});
</script>
