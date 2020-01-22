<?php



if ( isset( $_GET[ "a" ] ) && !empty( trim( $_GET[ "a" ] ) ) ) {

	// Prepare a select statement
	$sql = "SELECT *  , DATE_FORMAT(meeting_day,'%d/%m/%Y') as md,TIME_FORMAT(start_time, '%H:%i') as st,TIME_FORMAT(end_time, '%H:%i') as et, round FROM agenda WHERE agenda_id = " . $_GET[ 'a' ];

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



		} else {
			// URL doesn't contain valid id parameter. Redirect to error page

			exit();
		}

	} else {
		echo "Oops! Something went wrong. Please try again later.";
	}
}

if ( isset( $_POST[ "agenda_id" ] ) && !empty( $_POST[ 'hdnCount' ] ) ) {
	for ( $i = 1; $i <= ( int )$_POST[ "hdnCount" ]; $i++ ) {
		$sql = "SELECT MAX(term_id) AS term_id FROM term";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$term_id = $row[ "term_id" ] + 1;
			}
		} else {
			$term_id = 1;
		}
		echo $term_id;


		if ( isset( $_POST[ "term_no$i" ] ) ) {
			if ( $_POST[ "term_no$i" ] != "" ) {

				$sql = "INSERT INTO term (term_id,  agenda_id, term_no, term_subject) 
					VALUES ($term_id, $agenda_id, '" . $_POST[ "term_no$i" ] . "','" . $_POST[ "term_subject$i" ] . "')";
				echo $sql;
				$query = mysqli_query( $conn, $sql );
				if ( $conn->query( $sql ) === TRUE ) {
					echo "New record created successfully";
				} else {
					//echo "Error: " . $sql . "<br>" . $conn->error;
				}




			}
		}
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
							<li class="breadcrumb-item" aria-current="page"><a href="home.php?menu=agenda">งานประชุม</a>
							</li>
							<li class="breadcrumb-item">
								<a href="home.php?menu=agenda&sub=read&a=<?php echo $agenda_id;?>">
									<?php echo $agenda_subject . " ครั้งที่ " . $round; ?>
								</a>
							</li>
						</ol>
					</nav>
					<div class="float-right"><a href="?menu=agenda&sub=addagenda">เพิ่มวาระการประชุม</a>
					</div>

				</div>


				<br><br>
				<form action="" id="addtermform" name="addtermform" method="post">
					<h3>
						<?php echo $agenda_subject . " ครั้งที่ " . $round ;  ?>
						<?php echo "<br>วันที่ " . $md . " เวลา " . $st. "-" . $et . " น." ;  ?>
					</h3>
					<br>
					<table class="table table-hover" id="mytable">
						<thead class="thead-light">
							<tr>
								<th style="width: 13.33%">วาระที่</th>
								<th style="width: 50%">เรื่อง</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$sql = "SELECT * FROM term where agenda_id = $agenda_id ";
								if($result = mysqli_query($conn, $sql)){
									if(mysqli_num_rows($result) > 0){
									while ( $row = mysqli_fetch_array( $result ) ) {
							?>
							<tr>
								<td>									
									<?php echo $row[ 'term_no' ]; ?>
								</td>
								<td>
									<?php echo $row[ 'term_subject' ]; ?>
								</td>
								<td>
									<a href="home.php?menu=agenda&sub=addsubterm&ag=<?php echo $agenda_id;?>&t=<?php echo $row[ 'term_no' ];  ?>" title='เพิ่มวาระย่อย' data-toggle='tooltip'><span><i class='fas fa-plus-circle fa-2x'></i></span></a>

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
					<input type="button" id="createRows" value="เพิ่มวาระ">
					<input type="button" id="deleteRows" value="ลบวาระ">


					<br>
					<input type="hidden" id="hdnCount" name="hdnCount">
					<input type="hidden" id="agenda_id" name="agenda_id">
					<input type="submit" value="เพิ่ม">
				</form>


			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$( document ).ready( function () {

		var rows = 1;
		var countrow = $( "#mytable tr" ).length ;
		console.log(countrow);
		$( "#createRows" ).click( function () {
			var tr = "<tr>";
			tr = tr + "<td><input type='text' name='term_no" + rows + "' id='term_no" + rows + "'  class='form-control'></td>";
			tr = tr + "<td><input type='text' name='term_subject" + rows + "' id='term_subject" + rows + "'  class='form-control'/></td>";

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