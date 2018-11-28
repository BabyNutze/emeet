<?php
date_default_timezone_set( "Asia/Bangkok" );
if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {
	$detail = $_POST[ "editor1" ];
	$agenda_id = $_POST[ "agenda_id" ];
	$term_id = $_POST[ "term_id" ];


	$sql = "UPDATE term SET term_detail ='$detail' WHERE term_id='$term_id' and agenda_id = '$agenda_id' ";
	if ( mysqli_query( $conn, $sql ) ) {
		echo "ปรับปรุงข้อมูลแล้ว";
		echo "<script>setTimeout(function() {  window.location.href = 'home.php?menu=agenda&sub=termdetail&a=$agenda_id&t=$term_id';}, 1000);</script>";
	} else {
		echo "Error updating record: " . mysqli_error( $conn );
	}

}
?>