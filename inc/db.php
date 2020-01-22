<?php  
$conn = new mysqli("localhost", "root","","me");  
/* check connection */ 
if ($conn->connect_errno) {  
    printf("Connect failed: %s\n", $conn->connect_error);  
    exit();  
}  
if(!$conn->set_charset("utf8")) {  
    printf("Error loading character set utf8: %s\n", $conn->error);  
    exit();  
}

//	$orcconn = oci_connect("COEDB","COEDB","COE_DB","AL32UTF8"); 
//	if( $orcconn ? print "" : print  "Can not connect to Oracle Server" );
?>