<?php

ob_start();
session_start();
?>
<?php


include( "db.php" );
$strSQL1 = "UPDATE user SET";
$strSQL1 .= " status = 0";
$strSQL1 .= " WHERE id= '" . $_SESSION[ 'id' ] . "'";
$objQuery1 = mysqli_query( $conn, $strSQL1 );
echo $strSQL1;
session_destroy();
header( "location:../home.php" );

?>