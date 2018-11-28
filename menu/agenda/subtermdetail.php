<?php


if ( isset( $_GET[ "a" ] ) && isset( $_GET[ "t" ] )  && isset( $_GET[ "s" ] ) ) {

	$sql = "SELECT agenda.agenda_id, agenda.agenda_subject,  DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,
TIME_FORMAT(start_time, '%H:%i') as st,	TIME_FORMAT(end_time, '%H:%i') as et , 
term.term_no, term.term_subject , subterm.subterm_subject, term.term_detail, subterm.subterm_detail
	FROM agenda 
	LEFT JOIN term ON agenda.agenda_id = term.agenda_id 
	LEFT JOIN subterm on subterm.term_id = term.term_id and agenda.agenda_id = subterm.agenda_id
	WHERE agenda.agenda_id = " . $_GET[ 'a' ] . " and term.term_id = " . $_GET[ 't' ] . " and subterm.subterm_id = " . $_GET[ 's' ];
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
			$subterm_subject = $row[ "subterm_subject" ];
			$subterm_detail = $row[ "subterm_detail" ];
			
			

		} else {
			// URL doesn't contain valid id parameter. Redirect to error page
			header( "location: error.php" );
			exit();
		}

	} else {
		echo "Oops! Something went wrong. Please try again later.";
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
								<a href="home.php?menu=agenda&sub=read&ag=<?php echo $agenda_id;?>">
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
					<b><?php echo $agenda_subject ;  ?></b>
				</h3>
			

				<h5>
						<b><?php echo $term_no ." " .$term_subject ;  ?></b>
					</h5>
			

				<div class="float-right"><a href='home.php?menu=agenda&sub=edittermdetail&ag=<?php echo $agenda_id;?>&t=<?php echo $term_id;?>' title='แก้ไข' data-toggle='tooltip'><span><i class='fas fa-edit fa-2x'></i></span></a>
				</div>
				<br>
				<input type="hidden" name="agenda_id" value="<?php echo $agenda_id;?>">
				<input type="hidden" name="term_id" value="<?php echo $term_id;?>">


				<?php echo $subterm_subject; ?>
				<?php echo $subterm_detail; ?>

				<br>
				<div class="float-right">

				</div>
				<form action="home.php?menu=agenda&sub=savetermdetail" id="addsubtermform" name="addtermform" method="post">
					<h5><b><u>มติที่ประชุม</u></b></h5>
					<div class="float-right"><a href='home.php?menu=agenda&sub=edittermdetail&ag=<?php echo $agenda_id;?>&t=<?php echo $term_id;?>' title='แก้ไข' data-toggle='tooltip'><span><i class='fas fa-edit fa-2x'></i></span></a>
					</div>
					<textarea rows="3" class="form-control"></textarea>
					<button type="submit" >บันทึกมติ</button>
				</form>


			</div>
		</div>
	</div>
</div>