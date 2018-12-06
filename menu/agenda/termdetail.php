<?php

if ( isset( $_GET[ "a" ] ) && !empty( trim( $_GET[ "a" ] ) ) ) {

	$sql = "SELECT agenda.agenda_id, agenda.agenda_subject, agenda.round, DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,TIME_FORMAT(start_time, '%H:%i') as st,	TIME_FORMAT(end_time, '%H:%i') as et ,term.tid,  term.term_id, term.term_no, term.term_subject , term.term_detail, term.term_resolution
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
			$term_no = $row[ "term_no" ];
			$term_detail = $row[ "term_detail" ];
			$term_resolution = $row[ "term_resolution" ];
		} else {
			// URL doesn't contain valid id parameter. Redirect to error page

		}

	} else {
		echo "Oops! Something went wrong. Please try again later.";
	}
}

if ( isset( $_POST[ 'btnres' ] ) ) {

	if ( !empty( $_POST[ 'term_resolution' ] ) && !empty( $_POST[ 'agenda_id' ] ) && !empty( $_POST[ 'term_id' ] ) ) {
		$agenda_id = $_POST[ 'agenda_id' ];
		$term_id = $_POST[ 'term_id' ];
		$term_resolution = $_POST[ 'term_resolution' ];

		$sql = "UPDATE term SET term_resolution ='$term_resolution' WHERE agenda_id = $agenda_id and term_id= $term_id";
		if ( mysqli_query( $conn, $sql ) ) {

		} else {

			echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=termdetail&a=$agenda_id&t=$term_id';}, 1000);</script>";
		}







	} else {
		echo "<script type='text/javascript'>alert('กรุณากรอกมติการประชุมด้วย');</script>";
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
				$term_id = $_GET["t"];
				?>

				<br>
				<h3>
					<b><?php echo $agenda_subject . " ครั้งที่ " . $round; ?></b>
				</h3>
			
				<h5>
						<b><?php echo $term_no ." " .$term_subject ;  ?></b>
					</h5>
			
				<div class="float-right"><a href='home.php?menu=agenda&sub=edittermdetail&a=<?php echo $agenda_id;?>&t=<?php echo $term_id;?>' title='แก้ไข' data-toggle='tooltip'><span><i class='fas fa-edit fa-2x'></i></span></a>
				</div>
				<br>
				<input type="hidden" name="agenda_id" value="<?php echo $agenda_id;?>">
				<input type="hidden" name="term_id" value="<?php echo $term_id;?>">


				<?php echo $term_detail; ?>

				<br>
				<div class="float-right">

				</div>
				<form action="" id="addtermform" name="addtermform" method="post" >
					<h5><b><u>มติที่ประชุม</u></b></h5>
					<div class="float-right"><a href='home.php?menu=agenda&sub=edittermdetail&ag=<?php echo $agenda_id;?>&t=<?php echo $term_id;?>' title='แก้ไข' data-toggle='tooltip'><span><i class='fas fa-edit fa-2x'></i></span></a>
					</div>
					<?php

					if ( !empty( $term_resolution ) ) {

						echo "<input type='text' name='term_resolution' class='form-control' value='$term_resolution' ></input> ";
					} else {
						echo "<input type='text' name='term_resolution' class='form-control' ></input> ";

					}
					?>

					<input type="hidden" name="agenda_id" id="agenda_id" value="<?php echo $agenda_id; ?>">
					<input type="hidden" name="term_id" value="<?php echo $term_id; ?>">

					<button type="submit" name="btnres" class="btn btn-primary">บันทึก</button>

				</form>


			</div>
		</div>
	</div>
</div>