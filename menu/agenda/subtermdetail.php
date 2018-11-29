<?php


if ( isset( $_GET[ "a" ] ) && isset( $_GET[ "t" ] )  && isset( $_GET[ "s" ] ) ) {

	$sql = "SELECT agenda.agenda_id, agenda.agenda_subject,  DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,
TIME_FORMAT(start_time, '%H:%i') as st,	TIME_FORMAT(end_time, '%H:%i') as et , 
term.term_no, term.term_subject , subterm.subterm_subject, subterm.subterm_no, term.term_detail, subterm.subterm_detail, subterm.subterm_resolution 
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
			$subterm_no = $row[ "subterm_no" ];
			$subterm_detail = $row[ "subterm_detail" ];
			$subterm_resolution = $row["subterm_resolution"];
			
			
			

		} else {


			exit();
		}

	} else {
		echo "Oops! Something went wrong. Please try again later.";
	}
}

if ( isset( $_POST[ 'btnres' ] ) ) {

	if ( !empty( $_POST[ 'term_resolution' ] ) && !empty( $_POST[ 'agenda_id' ] ) && !empty( $_POST[ 'term_id' ] ) && !empty( $_POST[ 'subterm_id' ] ) ) {
		$agenda_id = $_POST[ 'agenda_id' ];
		$term_id = $_POST[ 'term_id' ];
		$subterm_id = $_POST[ 'subterm_id' ];
		$subterm_resolution = $_POST[ 'term_resolution' ];

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
									<?php echo $agenda_subject ; ?>
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
			

				<div class="float-right"><a href='home.php?menu=agenda&sub=edittermdetail&a=<?php echo $agenda_id;?>&t=<?php echo $term_id;?>' title='แก้ไข' data-toggle='tooltip'><span><i class='fas fa-edit fa-2x'></i></span></a>
				</div>
				<br>
				<input type="hidden" name="agenda_id" value="<?php echo $agenda_id;?>">
				<input type="hidden" name="term_id" value="<?php echo $term_id;?>">


				<?php echo $subterm_subject; ?>
				<?php echo $subterm_detail; ?>

				<br>
				<div class="float-right">

				</div>
				<form action="" id="addtermform" name="addtermform" method="post" >
					<h5><b><u>มติที่ประชุม</u></b></h5>
					<div class="float-right"><a href='home.php?menu=agenda&sub=edittermdetail&a=<?php echo $agenda_id;?>&t=<?php echo $term_id;?>' title='แก้ไข' data-toggle='tooltip'><span><i class='fas fa-edit fa-2x'></i></span></a>
					</div>
					<?php

					if ( !empty( $subterm_resolution ) ) {

						echo "<input type='text' name=subterm_resolution' class='form-control' value='$subterm_resolution' ></input> ";
					} else {
						echo "<input type='text' name='subterm_resolution' class='form-control' ></input> ";

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