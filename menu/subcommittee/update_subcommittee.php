<?php
// Include config file
// Define variables and initialize with empty values
$cname =  "";
$cname_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["cid"]) && !empty($_POST["cid"])){
    // Get hidden input value
    $id = $_POST["cid"];
    
    // Validate name
    $input_cname = trim($_POST["cname"]);
    if(empty($input_cname)){
        $cname_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $cname_err = "Please enter a valid name.";
    } else{
        $cname = $input_cname;
    }
    
    // Check input errors before inserting in database
    if(empty($cname_err)){
        // Prepare an update statement
        $sql = "UPDATE committee SET cname=? WHERE cid=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_cname, $param_cid);
            
            // Set parameters
            $param_name = $name;
            $param_cid = $cid;
            
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
    if(isset($_GET["cid"]) && !empty(trim($_GET["cid"]))){
        // Get URL parameter
        $cid =  trim($_GET["cid"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM committee WHERE cid = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_cid);
            
            // Set parameters
            $param_cid = $cid;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $cname = $row["cname"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: errorcommittee.php");
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
        header("location: errorcommittee.php");
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
                        <div class="form-group <?php echo (!empty($cname_err)) ? 'has-error' : ''; ?>">
                            <input type="text" name="name" class="form-control" value="<?php echo $cname; ?>">
                            <span class="help-block"><?php echo $cname_err;?></span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $cid; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="home.php?menu=committee" class="btn btn-default">ยกเลิก</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>