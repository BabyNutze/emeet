<div class="wrapper">
	<div class="container bg-dark">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header clearfix">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="home.php">หน้าแรก</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">กรรมการ</li>
						</ol>
					</nav>
					<h2 class="pull-left"><a href="?menu=addcommittee" class="btn btn-success float-right">เพิ่มกรรมการ</a></h2>

				</div>
				<?php
				// Include config file
				require_once "inc/db.php";

				// Attempt select query execution
				$sql = "SELECT * FROM committee";
				if ( $result = mysqli_query( $conn, $sql ) ) {
					if ( mysqli_num_rows( $result ) > 0 ) {
						echo "<table class='table table-bordered table-striped table-hover'>";
						echo "<thead>";
						echo "<tr>";
						echo "<th>#</th>";
						echo "<th>ชื่อ</th>";
						echo "<th></th>";
						echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
						$i = 1;
						while ( $row = mysqli_fetch_array( $result ) ) {
							echo "<tr>";
							$committee_id = $row[ 'committee_id' ];
							echo "<td>" . $i . "</td>";
							echo "<td>" . $row[ 'committee_name' ] . "</td>";
							echo "<td>";

							echo " <a href='home.php?menu=updatecommittee&committee_id=" . $row[ 'committee_id' ] . "' title='แก้ไข' data-toggle='tooltip'><span><i class='fas fa-pencil-alt fa-2x'></i></span></a>";
							echo " <a href=home.php?menu=deletecommittee&committee_id=$committee_id title='ลบ' data-toggle='tooltip'><span><i class='fas fa-trash-alt fa-2x'></i></span></a>";
							echo "</td>";
							echo "</tr>";
							$i++;
						}
						echo "</tbody>";
						echo "</table>";
						// Free result set
						mysqli_free_result( $result );
					} else {
						echo "<p class='lead'><em>No records were found.</em></p>";
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