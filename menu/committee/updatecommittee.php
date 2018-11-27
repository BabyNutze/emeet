<?php
// Include config file
// Define variables and initialize with empty values
$committee_name =  "";
$committee_name_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["committee_id"]) && !empty($_POST["committee_id"])){
    // Get hidden input value
    $id = $_POST["committee_id"];
    
    // Validate name
    $input_committee_name = trim($_POST["committee_name"]);
    if(empty($input_committee_name)){
        $committee_name_err = "Please enter a name.";
    } elseif(!filter_var($input_committee_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $committee_name_err = "Please enter a valid name.";
    } else{
        $committee_name = $input_committee_name;
    }
    
    // Check input errors before inserting in database
    if(empty($committee_name_err)){
        // Prepare an update statement
        $sql = "UPDATE committee SET committee_name=? WHERE committee_id=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_committee_name, $param_committee_id);
            
            // Set parameters
            $param_committee_name = $committee_name;
            $param_committee_id = $committee_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: home.php?menu=committee");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["committee_id"]) && !empty(trim($_GET["committee_id"]))){
        // Get URL parameter
        $committee_id =  trim($_GET["committee_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM committee WHERE committee_id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_committee_id);
            
            // Set parameters
            $param_cid = $committee_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $committee_name = $row["committee_name"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: home.php?menu=errorcommittee");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($conn);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: home.php?menu=errorcommittee");
        exit();
    }
}
?>
 
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-header">
                        <h2>แก้ไข</h2>
                    </div>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($committee_name_err)) ? 'has-error' : ''; ?>">
                            <input type="text" name="name" class="form-control" value="<?php echo $committee_name; ?>">
                            <span class="help-block"><?php echo $committee_name_err;?></span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $committee_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="home.php?menu=committee" class="btn btn-default">ยกเลิก</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>