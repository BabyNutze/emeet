<?php
// Process delete operation after confirmation
if ( isset( $_GET[ "a" ] ) && isset( $_GET[ "t" ] ) && isset( $_GET[ "st" ] ) ) {
	// Include config file
	$agenda_id = $_GET[ 'a' ];
	$tid = $_GET[ 't' ];
	$stid = $_GET[ 'st' ];
	// Prepare a delete statement
	$sql = "DELETE FROM subterm WHERE agenda_id = $agenda_id and tid = $tid and stid = $stid";
	if ( mysqli_query( $conn, $sql ) ) {

		echo "ลบข้อมูลแล้ว\n";
		echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=read&a=$agenda_id&t=$tid';}, 1000);</script>";

	} else {
		echo "Error deleting record: " . mysqli_error( $conn );
	}


} else {
	// Check existence of id parameter
	if ( empty( $_GET[ "a" ] ) && empty( $_GET[ "t" ] ) && empty( $_GET[ "st" ] ) ) {
		// URL doesn't contain id parameter. Redirect to error page
		echo 'alert("รายการไม่ถูกต้อง กรุณาลองใหม่ในภายหลัง");';
		echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=read&a=$agenda_id&t=$tid';}, 1000);</script>";
	}
}
?>