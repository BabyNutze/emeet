<?php

require( "..\..\inc\db.php" );


if ( !empty( $_POST[ "committee_id" ] ) && !isset($_POST[ "subcommittee_id" ]) ) {
	$committee_id = $_POST[ "committee_id" ];
	$sql = "SELECT * FROM subcommittee where committee_id = $committee_id";
	$result = mysqli_query( $conn, $sql );
	$rowcount = mysqli_num_rows( $result );


	if ( mysqli_num_rows( $result ) > 0 ) {
		echo '<option value="">เลือก</option>';
		while ( $row = mysqli_fetch_assoc( $result ) ) {
			echo '<option value="' . $row[ 'subcommittee_id' ] . '">' . $row[ 'subcommittee_name' ] . '</option>';
		}
	} else {
		echo '<option value="">ไม่พบข้อมูล</option>';
	}
}

if ( !empty( $_POST[ "subcommittee_id" ] ) && !empty( $_POST[ "committee_id" ] ) ) {
	$committee_id = $_POST[ "committee_id" ];
	$subcommittee_id = $_POST[ "subcommittee_id" ];
	$sql = "SELECT * FROM subcommittee where committee_id = $committee_id and subcommittee_id = $subcommittee_id";
	$result = mysqli_query( $conn, $sql );
	$rowcount = mysqli_num_rows( $result );


	if ( mysqli_num_rows( $result ) > 0 ) {
		if ( $row = mysqli_fetch_assoc( $result ) ) {
			echo '<option value="' . $row[ 'subcommittee_id' ] . '">' . $row[ 'subcommittee_name' ] . '</option>';
		}
	} else {
		echo '<option value="">ไม่พบข้อมูล</option>';
	}
}
?>