<?php
$a_Comm = ( isset( $_GET[ 'aComm' ] ) ? $_GET[ 'aComm' ] : ( isset( $_POST[ 'aComm' ] ) ? $_POST[ 'aComm' ] : 0 ) );


$sqlTxt = " ";
print "<div class='input-group mb-3'>";
print "<div class='input-group-prepend'>";
print "<label class='input-group-text' for='inputGroupSelect01'>ชุดอนุกรรมการ / คณะทำงาน</label>";
print "</div>";
print "<select class='custom-select' id='selSub' name='selSub'>";
print "<option selected>Choose...</option>";
$loop = 0;
$sql = "SELECT * FROM subcommittee";
$result = $conn->query( $sql );
while ( $row = $result->fetch_assoc() ) {
	echo "<option value='" . $row[ 'committee_id' ] . "'>" . $row[ 'committee_name' ] . "</option>";
}
print "</select>";
print "</div>";

?>