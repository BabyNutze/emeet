<?php
// Process delete operation after confirmation
if ( isset( $_GET[ "a" ] ) && !empty( $_GET[ "a" ] ) ) {
	// Include config file

	// Prepare a delete statement
	$sql = "DELETE FROM term WHERE agenda_id = " . $_GET[ 'a' ] ;
	if ( mysqli_query( $conn, $sql ) ) {

		echo "ลบวาระแล้ว\n";

		$sql = "DELETE FROM agenda WHERE agenda_id = " .$_GET['a'] ;
		if ( mysqli_query( $conn, $sql ) ) {
			echo "ลบการประชุมแล้ว\n";
					//echo "<script>window.location='home.php?menu=agenda'</script>";
			echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda';}, 1000);</script>";
		} else {
			echo "Error deleting record: " . mysqli_error( $conn );
		}

	} else {
		echo "Error deleting record: " . mysqli_error( $conn );
	}


} else {
	// Check existence of id parameter
	if ( empty( trim( $_GET[ "a" ] ) ) ) {
		// URL doesn't contain id parameter. Redirect to error page
		header( "location: home.php?menu=agenda" );
		exit();
	}
}
?>