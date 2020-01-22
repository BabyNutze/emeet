<?php
$conn = new mysqli( "localhost", "root", "", "me" );
/* check connection */
if ( $conn->connect_errno ) {
	printf( "Connect failed: %s\n", $conn->connect_error );
	exit();
}
if ( !$conn->set_charset( "utf8" ) ) {
	printf( "Error loading character set utf8: %s\n", $conn->error );
	exit();
}

$a_Comm = ( isset( $_GET[ 'aComm' ] ) ? $_GET[ 'aComm' ] : ( isset( $_POST[ 'aComm' ] ) ? $_POST[ 'aComm' ] : 0 ) );
$sql = "SELECT * FROM subcommittee where committee_id = $a_Comm ";
print "<div class='input-group mb-3'>";
print "<div class='input-group-prepend'>";
print "<label class='input-group-text' for='selectsubcommittee'>ชุดอนุกรรมการ/คณะทำงาน</label>";
print "</div>";
print "<select  id='selectsubcommittee' name='selectsubcommittee' class='custom-select'>";
print "<option selected>เลือก</option>";


$result = mysqli_query( $conn, $sql );
while ( $row = mysqli_fetch_assoc( $result ) ) {
$data = array();
	$data[] = $row;
echo 	'<option value="' . $row["subcommittee_id"] . '">' . $row["subcommittee_name"]. '</option>';

}

print "</select>";
print "</div>";
//echo json_encode( $data );
?>