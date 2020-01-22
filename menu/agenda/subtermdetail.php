<?php


if ( isset( $_GET[ "a" ] ) && isset( $_GET[ "t" ] )  && isset( $_GET[ "st" ] ) ) {

	$sql = "SELECT agenda.agenda_id, agenda.agenda_subject, agenda.round, DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,
TIME_FORMAT(start_time, '%H:%i') as st,	TIME_FORMAT(end_time, '%H:%i') as et, term.tid,
term.term_no, term.term_subject, subterm.stid, subterm.subterm_subject, subterm.subterm_no, term.term_detail, subterm.subterm_id, subterm.subterm_detail, subterm.subterm_resolution 
	FROM agenda 
	LEFT JOIN term ON agenda.agenda_id = term.agenda_id 
	LEFT JOIN subterm on subterm.tid = term.tid and agenda.agenda_id = subterm.agenda_id
	WHERE agenda.agenda_id = " . $_GET[ 'a' ] . " and term.tid = " . $_GET[ 't' ] . " and subterm.stid = " . $_GET[ 'st' ];
	if ( $result = mysqli_query( $conn, $sql ) ) {
		if ( mysqli_num_rows( $result ) == 1 ) {
			/* Fetch result row as an associative array. Since the result set
			contains only one row, we don't need to use while loop */
			$row = mysqli_fetch_array( $result, MYSQLI_ASSOC );

			// Retrieve individual field value
			$agenda_id = $row[ "agenda_id" ];
			$agenda_subject = $row[ "agenda_subject" ];
			$round = $row["round"];
			$md = $row[ "md" ];
			$st = $row[ "st" ];
			$et = $row[ "et" ];
			$tid = $row["tid"];
			$term_subject = $row[ "term_subject" ];
			$term_no = $row[ "term_no" ];
			$term_detail = $row[ "term_detail" ];
			$stid = $row["stid"];
			$subterm_id = $row["subterm_id"];
			$subterm_subject = $row[ "subterm_subject" ];
			$subterm_no = $row[ "subterm_no" ];
			$subterm_detail = $row[ "subterm_detail" ];
			$subterm_resolution = $row["subterm_resolution"];
			
		} else {
			
		}
	} else {
		echo "Oops! Something went wrong. Please try again later.";
	}
}

if ( isset( $_POST[ 'btnres' ] ) ) {

	if ( !empty( $_POST[ 'subterm_resolution' ] ) && !empty( $_POST[ 'agenda_id' ] ) && !empty( $_POST[ 'term_id' ] ) && !empty( $_POST[ 'subterm_id' ] ) ) {
		$agenda_id = $_POST[ 'agenda_id' ];
		$term_id = $_POST[ 'term_id' ];
		$subterm_id = $_POST[ 'subterm_id' ];
		$subterm_resolution = $_POST[ 'subterm_resolution' ];

		$sql = "UPDATE subterm SET subterm_resolution ='$subterm_resolution'  WHERE agenda_id = $agenda_id and term_id= $term_id";

		if ( mysqli_query( $conn, $sql ) ) {

		} else {
			//echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=subtermdetail&a=$agenda_id&t=$term_id&s=$subterm_id';}, 1000);</script>";
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
					<b><?php echo $agenda_subject ;  ?></b>
				</h3>
				<h5>
						<b><?php echo $term_no ." " . $term_subject ;  ?></b>

					
				</h5>
			

				<div class="float-right"><a href='home.php?menu=agenda&sub=editsubtermdetail&a=<?php echo $agenda_id;?>&t=<?php echo $tid;?>&st=<?php echo $stid ;?>' title='แก้ไข' data-toggle='tooltip'><span><i class='fas fa-edit fa-2x'></i></span></a>
				</div>
				<br>
				<?php echo $subterm_no; ?>
				<input type="hidden" name="agenda_id" value="<?php echo $agenda_id;?>">
				<input type="hidden" name="tid" value="<?php echo $tid;?>">
				<input type="hidden" name="stid" value="<?php echo $stid;?>">


				<?php echo $subterm_subject; ?>
				<?php echo $subterm_detail; ?>

				<br>
				<div class="float-right">

				</div>
				<form action="" id="addtermform" name="addtermform" method="post" >
					<h5><b><u>มติที่ประชุม</u></b></h5>
					<div class="float-right"><a href='home.php?menu=agenda&sub=edittermdetail&a=<?php echo $agenda_id;?>&t=<?php echo $tid;?>&st=<?php echo $stid;?>' title='แก้ไข' data-toggle='tooltip'><span><i class='fas fa-edit fa-2x'></i></span></a>
					</div>
					<?php

					if ( !empty( $subterm_resolution ) ) {

						echo "<input type='text' name='subterm_resolution' class='form-control' value='$subterm_resolution' ></input> ";
					} else {
						echo "<input type='text' name='subterm_resolution' class='form-control' ></input> ";

					}
					?>

					<input type="hidden" name="agenda_id" id="agenda_id" value="<?php echo $agenda_id; ?>">
					<input type="hidden" name="tid" value="<?php echo $tid; ?>">
					<input type="hidden" name="stid" value="<?php echo $stid; ?>">

					<button type="submit" name="btnres" class="btn btn-primary">บันทึก</button>

				</form>



			</div>
		</div>
	</div>
</div>