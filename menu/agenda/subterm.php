<?php


if ( isset( $_GET[ "ag" ] ) && !empty( trim( $_GET[ "ag" ] ) ) ) {

	// Prepare a select statement
	$sql = "SELECT agenda.agenda_id, agenda.agenda_subject,  DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,TIME_FORMAT(start_time, '%H:%i') as st,	TIME_FORMAT(end_time, '%H:%i') as et , term_no, term_subject , subterm.subterm_subject
	FROM agenda 
	LEFT JOIN term ON agenda.agenda_id = term.agenda_id 
	LEFT JOIN subterm on subterm.term_id = term.term_id
	WHERE agenda.agenda_id = " . $_GET[ 'ag' ] . " and term.term_id = " . $_GET[ 't' ] ;
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
			$term_subject = $row["term_subject"];
			$term_no = $row["term_no"];



		} else {
			// URL doesn't contain valid id parameter. Redirect to error page
			header( "location: error.php" );
			exit();
		}

	} else {
		echo "Oops! Something went wrong. Please try again later.";
	}
}

if ( isset( $_POST[ "agenda_id" ] ) && !empty( $_POST[ 'hdnCount' ] ) && isset($_POST["term_id"]) ) {
	for ( $i = 1; $i <= ( int )$_POST[ "hdnCount" ]; $i++ ) {
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
		$term_id = $_POST["term_id"];


		if ( isset( $_POST[ "subterm_no$i" ] ) ) {
			if ( $_POST[ "subterm_no$i" ] != "" ) {

				$sql = "INSERT INTO subterm (subterm_id,  agenda_id, term_id, subterm_no, subterm_subject) 
					VALUES ($subterm_id, $agenda_id, $term_id, '" . $_POST[ "subterm_no$i" ] . "','" . $_POST[ "subterm_subject$i" ] . "')";
				echo $sql;
				$query = mysqli_query( $conn, $sql );
				if ( $conn->query( $sql ) === TRUE ) {
					echo "New record created successfully";
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}




			}
		}
	}

}
else{
	
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
							<li class="breadcrumb-item active" aria-current="page">ข้อมูลการประชุม</li>
						</ol>
					</nav>
					<div class="float-right"><a href="?menu=agenda&sub=addagenda">เพิ่มวาระการประชุม</a>
					</div>

				</div>
				<?php 
				$term_id = $_GET["t"];
				?>

				<br><br>
				<form action="" id="addsubtermform" name="addtermform" method="post">
					<h3>
						<?php echo "วาระที่ " . $term_no ." " .$term_subject ;  ?>
					</h3>
					<br>
					<h4></h4>
					<table class="table table-hover" id="mytable">
						<thead class="thead-light">
							<tr>
								<th style="width: 10%">วาระย่อยที่</th>
								<th style="width: 50%">เรื่อง</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$sql = "SELECT * FROM subterm where agenda_id = $agenda_id  and term_id = $term_id";
								if($result = mysqli_query($conn, $sql)){
									if(mysqli_num_rows($result) > 0){
									while ( $row = mysqli_fetch_array( $result ) ) {
							?>
							<tr>
								<td>									
									<?php echo $row[ 'subterm_no' ]; ?>
								</td>
								<td>
									<?php echo $row[ 'subterm_subject' ]; ?>
								</td>
								<td>
									<a href="home.php?menu=agenda&sub=addsubterm&ag=<?php echo $agenda_id;?>&term=<?php echo $row[ 'term_no' ];  ?>" title='เพิ่มวาระย่อย' data-toggle='tooltip'><span><i class='fas fa-plus-circle fa-2x'></i></span></a>

								</td>
							</tr>
							<?php
							}
							?>
					</table>

					<?php
					mysqli_free_result( $result );
					}
					else {
						echo "ไม่พบข้อมูล";
					
					}
					} else {
						echo "ERROR: Could not able to execute $sql. " . mysqli_error( $conn );
					}

					?>
					</tbody>
					</table>
					<input type="button" id="createRows" value="เพิ่มวาระย่อย">
					<input type="button" id="deleteRows" value="ลบวาระย่อย">


					<br>
					<input type="hidden" id="hdnCount" name="hdnCount">
					<input type="hidden" id="agenda_id" name="agenda_id" value="<?php echo $agenda_id;?>">					
					<input type="hidden" id="term_id" name="term_id" value="<?php echo $term_id;?>">
					<input type="submit" value="เพิ่ม">
					
					
					
					
					
					
					
				</form>


			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$( document ).ready( function () {

		var rows = 1;
		var countrow = $( "#mytable tr" ).length;
		console.log( countrow );
		$( "#createRows" ).click( function () {
			var tr = "<tr>";
			tr = tr + "<td><input type='text' name='subterm_no" + rows + "' id='subterm_no" + rows + "'  class='form-control'></td>";
			tr = tr + "<td><input type='text' name='subterm_subject" + rows + "' id='subterm_subject" + rows + "'  class='form-control'/></td>";

			tr = tr + "</tr>";
			$( '#mytable > tbody:last' ).append( tr );

			$( '#hdnCount' ).val( rows );
			rows = rows + 1;
			console.log( tr );
		} );


		$( "#deleteRows" ).click( function () {
			if ( $( "#mytable tr" ).length != countrow ) {
				$( "#mytable tr:last" ).remove();
			}
		} );

		$( "#clearRows" ).click( function () {
			rows = 1;
			$( '#hdnCount' ).val( rows );
			$( '#mytable > tbody:last' ).empty(); // remove all
		} );

	} );
</script>