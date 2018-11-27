<?php
// Include config file
// Define variables and initialize with empty values
$position_name =  "";
$position_name_err = "";
 var_dump($_POST);
// Processing form data when form is submitted
if(isset($_POST["position_id"]) && !empty($_POST["position_id"])){
    // Get hidden input value
    $position_id = $_POST["position_id"];
    
    // Validate name
    $input_position_name = trim($_POST["position_name"]);
    if(empty($input_position_name)){
        $position_name_err = "ใส่ตำแหน่ง";
    }  else{
        $position_name = $input_position_name;
    }
    
    // Check input errors before inserting in database
    if(empty($position_name_err)){
        // Prepare an update statement
        $sql = "UPDATE position SET position_name=? WHERE position_id=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_position_name, $param_position_id);
            
            // Set parameters
            $param_position_name = $position_name;
            $param_position_id = $position_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: home.php?menu=position");
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
    if(isset($_GET["position_id"]) && !empty(trim($_GET["position_id"]))){
        // Get URL parameter
        $position_id =  trim($_GET["position_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM position WHERE position_id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_position_id);
            
            // Set parameters
            $param_position_id = $position_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $position_name = $row["position_name"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: home.php?menu=errorposition");
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
        header("location: errorposition.php");
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
                        <div class="form-group <?php echo (!empty($position_name_err)) ? 'has-error' : ''; ?>">
                            <input type="text" name="position_name" class="form-control" value="<?php echo $position_name; ?>">
                            <span class="help-block"><?php echo $position_name_err;?></span>
                        </div>

                        <input type="hidden" name="position_id" value="<?php echo $position_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="home.php?menu=position" class="btn btn-default">ยกเลิก</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>