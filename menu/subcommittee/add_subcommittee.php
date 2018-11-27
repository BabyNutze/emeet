<?php


// Define variables and initialize with empty values
$subcommittee_name = "";
$subcommittee_name_err = "";

// Processing form data when form is submitted
if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {
	// Validate name
	$input_subcommittee_name = trim( $_POST[ "subcommittee_name" ] );
	$committee_id = $_POST["committee_id"] ;
	if ( empty( $input_subcommittee_name ) ) {
		$subcommittee_name_err = "กรุณากรอกชื่อกรรมการ";
	} else {
		$subcommittee_name = $input_subcommittee_name;
	}

	// Check input errors before inserting in database
	if ( empty( $subcommittee_name_err ) ) {
		// Prepare an insert statement
		$sql = "SELECT MAX(subcommittee_id) AS subcommittee_id FROM subcommittee";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$subcommittee_id = $row[ "subcommittee_id" ] + 1;
			}
		} else {
			$cid = 1;
		}


		$sql = "INSERT INTO subcommittee (subcommittee_id, subcommittee_name, committee_id) VALUES (?, ?, ?)";

		if ( $stmt = mysqli_prepare( $conn, $sql ) ) {
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param( $stmt, "isi", $param_subcommittee_id, $param_subcommittee_name,  $param_committee_id);

			// Set parameters
			$param_subcommittee_id = $subcommittee_id;
			$param_subcommittee_name = $subcommittee_name;
			$param_committee_id = $committee_id;

			// Attempt to execute the prepared statement
			if ( mysqli_stmt_execute( $stmt ) ) {
				// Records created successfully. Redirect to landing page
				header( "location: home.php?menu=subcommittee" );
				exit();
			} else {
				echo "ลองใหม่อีกครั้ง";
			}
		}

		// Close statement
		mysqli_stmt_close( $stmt );
	}

	// Close connection
	mysqli_close( $conn );
}
?>

<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="page-header">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="home.php">หน้าแรก</a>
							</li>
							<li class="breadcrumb-item"><a href="home.php?menu=subcommittee">อนุกรรมการ\คณะทำงาน</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">เพิ่มอนุกรรมการ\คณะทำงาน</li>
						</ol>
					</nav>
				</div>
				<form action="" method="post">
			
					<div class="form-group col-6">
						<label>กรรมการ / จรรยาบรรณ</label>
							<select name="committee_id" class="form-control" required>
								<?php

								$sql = "SELECT * FROM committee";
								if ( $result = mysqli_query( $conn, $sql ) ) {
									if ( mysqli_num_rows( $result ) > 0 ) {
										while ( $row = mysqli_fetch_array( $result ) ) {

											?>
								<option value="<?php echo $row[ 'committee_id' ]; ?>">
									<?php echo $row[ 'committee_name' ]; ?>
								</option>
								<?php
								}
								}
								}
								?>
							</select>
					</div>
					<div class="form-group col-6">
						<label>ชื่ออนุกรรมการ / คณะทำงาน</label>
						<input type="text" name="subcommittee_name" class="form-control" value="<?php echo $subcommittee_name; ?>">
						<span class="help-block">
							<?php echo $subcommittee_name_err;?>
						</span>
					</div>		
					<input type="submit" class="btn btn-primary" value="ยืนยัน">
					<a href="home.php?menu=subcommittee" class="btn btn-default">ยกเลิก</a>
				</form>
			</div>
		</div>
	</div>
</div>