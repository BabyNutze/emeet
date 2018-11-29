<div class="wrapper">
	<div class="container bg-dark">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header clearfix">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="home.php">หน้าแรก</a>
							</li>
							<li class="breadcrumb-item"><a href="home.php?menu=agenda">งานประชุม</li>
						</ol>
					</nav>
					<div class="float-right"><a href="?menu=agenda&sub=addagenda">เพิ่มการประชุม</a>
				</div>

			</div>
			<h2></h2>

			<?php
			date_default_timezone_set( "Asia/Bangkok" );
			// Attempt select query execution
			$sql = "SELECT *, TIME_FORMAT(start_time, '%H:%i') as st,TIME_FORMAT(end_time, '%H:%i') as et FROM agenda";
			if ( $result = mysqli_query( $conn, $sql ) ) {
				if ( mysqli_num_rows( $result ) > 0 ) {
					echo "<table class='table table-bordered table-striped table-hover'>";
					echo "<thead>";
					echo "<tr>";
					echo "<th>เวลา</th>";
					echo "<th>ชื่อ</th>";
					echo "<th></th>";
					echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
					$i = 1;
					while ( $row = mysqli_fetch_array( $result ) ) {
						echo "<tr>";
						$agenda_id = $row[ 'agenda_id' ];

						//echo $start_time;
						echo "<td>" . $row[ "st" ] . "-" . $row[ "et" ] . " น.</td>";
						echo "<td>" . $row[ 'agenda_subject' ] . " ครั้งที่ " . $row["round"] . "</td>";
						echo "<td>";

						echo "";
						?> 
				<a href="home.php?menu=agenda&sub=read&a=<?php echo $row[ 'agenda_id' ]; ?>" title='รายละเอียด' data-toggle='tooltip'><span><i class='fas fa-eye fa-2x'></i></span></a>
			<a href="home.php?menu=agenda&sub=editagenda&a=<?php echo $row[ 'agenda_id' ];?>" title='แก้ไข' data-toggle='tooltip'><span><i class='fas fa-edit fa-2x'></i></span></a>			<a href="home.php?menu=agenda&sub=deleteagenda&a=<?php echo $row[ 'agenda_id' ];?>" onclick="return confirm('Are you sure?')" title='ลบ' data-toggle='tooltip'><span><i class='fas fa-trash-alt fa-2x'></i></span></a>
			<?php

			echo "</td>";
			echo "</tr>";
			$i++;
			}
			echo "</tbody>";
			echo "</table>";
			// Free result set
			mysqli_free_result( $result );
			}
			else {
				echo "<p class='lead'><em>ไม่พบข้อมูลการประชุม</em></p>";
			}
			} else {
				echo "ERROR: Could not able to execute $sql. " . mysqli_error( $conn );
			}

			// Close connection
			mysqli_close( $conn );
			?>

		</div>
	</div>
</div>
</div>