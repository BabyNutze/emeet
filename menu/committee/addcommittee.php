<?php


// Define variables and initialize with empty values
$cname = "";
$cname_err = "";

// Processing form data when form is submitted
if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {
	// Validate name
	$input_committee_name = trim( $_POST[ "committee_name" ] );
	if ( empty( $input_committee_name ) ) {
		$committee_name_err = "กรุณากรอกชื่อกรรมการ";
	} else {
		$committee_name = $input_committee_name;
	}

	// Check input errors before inserting in database
	if ( empty( $committee_name_err ) ) {
		// Prepare an insert statement
		$sql = "SELECT MAX(committee_id) AS committee_id FROM committee";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$committee_id = $row[ "committee_id" ] + 1;
			}
		} else {
			$committee_id = 1;
		}


		$sql = "INSERT INTO committee (committee_id, committee_name) VALUES (?, ?)";

		if ( $stmt = mysqli_prepare( $conn, $sql ) ) {
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param( $stmt, "is", $param_committee_id, $param_committee_name );

			// Set parameters
			$param_committee_id = $committee_id;
			$param_committee_name = $committee_name;

			// Attempt to execute the prepared statement
			if ( mysqli_stmt_execute( $stmt ) ) {
				// Records created successfully. Redirect to landing page
				header( "location: home.php?menu=committee" );
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
							<li class="breadcrumb-item"><a href="home.php?menu=committee">กรรมการ</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">เพิ่มกรรมการ</li>
						</ol>
					</nav>
				</div>
				<form action="" method="post">
					<div class="form-group <?php echo (!empty($committee_name_err)) ? 'has-error' : ''; ?>">
						<label></label>
						<input type="text" name="cname" class="form-control" value="<?php echo $committee_name; ?>">
						<span class="help-block">
							<?php echo $committee_name_err;?>
						</span>
					</div>

					<input type="submit" class="btn btn-primary" value="Submit">
					<a href="home.php" class="btn btn-default">ยกเลิก</a>
				</form>
			</div>
		</div>
	</div>
</div>