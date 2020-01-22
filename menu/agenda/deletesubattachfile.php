<?php
// Process delete operation after confirmation
if ( isset( $_GET[ "a" ] ) && isset( $_GET[ "t" ] ) && isset( $_GET[ "st" ] ) && isset( $_GET[ "atf" ] ) && isset( $_GET[ "atfno" ] ) ) {
	// Include config file
	$agenda_id = $_GET["a"];
	$tid = $_GET["t"];
	$stid = $_GET["st"];
	$atf = $_GET["atf"];
	$atfno = $_GET["atfno"];
	// Prepare a delete statement
	$sql = "DELETE FROM attachfiles WHERE agenda_id = " . $agenda_id . " and tid = " . $tid . " and stid = " . $stid . " and atfid = "  . $atf . " and attach_no = "  . $atfno  ;
	if ( mysqli_query( $conn, $sql ) ) {

		echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=editsubtermdetail&a=$agenda_id&t=$tid&st=$stid';}, 1000);</script>";

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