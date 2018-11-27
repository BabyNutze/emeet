<?php
// Process delete operation after confirmation
if(isset($_GET["committee_id"]) && !empty($_GET["committee_id"])){
    // Include config file

    // Prepare a delete statement
    $sql = "DELETE FROM committee WHERE committee_id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_committee_id);
        
        // Set parameters
        $param_committee_id = trim($_GET["committee_id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: home.php?menu=committee");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["committee_id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: home.php?menu=commitee&submenu=committeeerror");
        exit();
    }
}
?>

