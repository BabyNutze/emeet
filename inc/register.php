<?php
include( "db.php" );
var_dump( $_POST );
if ( isset( $_POST[ 'registerusn' ], $_POST[ 'registerpwd' ] ) ) {
	// login form was submitted correctly,
	$usn = $_POST[ 'registerusn' ];
	$pwd = $_POST[ 'registerpwd' ];
	$_SESSION[ 'usn' ] = $usn;
	$_SESSION[ 'pwd' ] = $pwd;


	if ( $conn->connect_error ) {
		die( "Connection failed: " . $conn->connect_error );
	}
$sql = "SELECT id FROM user";
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
    // output data of each row
    if($row = $result->fetch_assoc()) {
      $id = $row["id"] +1;
    }
} else {
    $id = 1;
}
	echo $id;
	$sql = "INSERT INTO user (id,username, password)
VALUES ($id,'$usn', '$pwd')";


	if ( $conn->query( $sql ) === TRUE ) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
	
	
	
}



?>