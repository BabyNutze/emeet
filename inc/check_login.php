<?php
session_start();
include_once( "db.php" );
$strSQL = "SELECT * FROM user WHERE username = '" . trim( $_POST[ 'loginusn' ] ) . "'
	and password = '" . trim( $_POST[ 'loginpwd' ] ) . "'";
$objQuery = mysqli_query( $conn, $strSQL );
$objResult = mysqli_fetch_array( $objQuery );

if ( !$objResult ) {
	echo "Username หรือ Password ไม่ถูกต้อง!";
} else {
	if ( $objResult[ "active" ] == '0' ) {
		echo "รอการยืนยันจากผู้ดูแลระบบ";
	} else {
		$_SESSION[ "id" ] = $objResult[ "id" ];
		$_SESSION[ "usn" ] = $objResult[ "username" ];
		$_SESSION[ "status" ] = $objResult[ "status" ];
		$_SESSION[ "active" ] = $objResult[ "active" ];
		session_write_close();
		header( "location:../home.php" );
	}
}
mysqli_close( $conn );
?>
