<?php


if(!empty($_POST["committee_id"])){
    //Fetch all state data
    $query = $conn->query("SELECT * FROM subcommittee WHERE committee_id = ".$_POST['committee_id']." ");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //State option list
    if($rowCount > 0){
        echo '<option value="">เลือกอนุกรรมการ/คณะทำงาน</option>';
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['subcommittee_id'].'">'.$row['subcommittee_name'].'</option>';
        }
    }else{
        echo '<option value="">ไม่พบอนุกรรมการ/คณะทำงาน</option>';
    }
}
?>