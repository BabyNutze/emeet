<div class="wrapper">
	<div class="container bg-dark">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header clearfix">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="home.php">หน้าแรก</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">อนุกรรมการ\คณะทำงาน</li>
						</ol>
					</nav>
					<h2 class="pull-left"><a href="?menu=subcommittee&sub=add_subcommittee" class="btn btn-success float-right">เพิ่มอนุกรรมการ\คณะทำงาน</a></h2>

				</div>
				<?php

				// Attempt select query execution
				$sql = "SELECT * FROM subcommittee";
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
							$subcommittee_id = $row[ 'subcommittee_id' ];
							echo "<td>" . $i . "</td>";
							echo "<td>" . $row[ 'subcommittee_name' ] . "</td>";
							echo "<td>";

							echo " <a href='home.php?menu=subcommittee&sub=update_subcommittee&subcommittee_id=" . $row[ 'subcommittee_id' ] . "' title='แก้ไข' data-toggle='tooltip'><span><i class='fas fa-pencil-alt fa-2x'></i></span></a>";
							echo " <a href=home.php?menu=subcommittee&sub=delete_subcommittee&subcommittee_id=$subcommittee_id title='ลบ' data-toggle='tooltip'><span><i class='fas fa-trash-alt fa-2x'></i></span></a>";
							echo "</td>";
							echo "</tr>";
							$i++;
						}
						echo "</tbody>";
						echo "</table>";
						// Free result set
						mysqli_free_result( $result );
					} else {
						echo "<p class='text-center'><em>ไม่มีข้อมูล</em></p>";
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