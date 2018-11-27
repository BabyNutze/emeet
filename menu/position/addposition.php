<?php

$position_name = "";
$position_name_err = "";

// Processing form data when form is submitted
if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {
	// Validate name
	$position_input_name = trim( $_POST[ "position_name" ] );
	if ( empty( $position_input_name ) ) {
		$position_name_err = "กรุณาใส่ชื่อตำแหน่ง";
	} else {
		$position_name = $position_input_name;
	}


	// Check input errors before inserting in database
	if ( empty( $position_name_err ) ) {
		// Prepare an insert statement
		$sql = "SELECT MAX(position_id) AS position_id FROM position";
		$result = mysqli_query( $conn, $sql );
		if ( $result->num_rows > 0 ) {
			// output data of each row
			if ( $row = $result->fetch_assoc() ) {
				$position_id = $row[ "position_id" ] + 1;
			}
		} else {
			$position_id = 1;
		}



		$sql = "INSERT INTO position (position_id, position_name) VALUES (?, ?)";

		if ( $stmt = mysqli_prepare( $conn, $sql ) ) {
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param( $stmt, "is", $param_position_id, $param_position_name );

			// Set parameters
			$param_position_id = $position_id;
			$param_position_name = $position_name;

			// Attempt to execute the prepared statement
			if ( mysqli_stmt_execute( $stmt ) ) {
				// Records created successfully. Redirect to landing page
				header( "location: home.php?menu=position" );
				exit();
			} else {
				echo "Something went wrong. Please try again later.";
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


				</div>

				<form action="" method="post">
					<div class="form-group <?php echo (!empty($position_name_err)) ? 'has-error' : ''; ?>">
						<label>Name</label>
						<input type="text" name="position_name" class="form-control" value="<?php echo $position_name; ?>">
						<span class="help-block">
							<?php echo $position_name_err;?>
						</span>
					</div>

					<input type="submit" class="btn btn-primary" value="ยืนยัน">
					<a href="index.php" class="btn btn-default">ยกเลิก</a>
				</form>
			</div>
		</div>
	</div>
</div>
