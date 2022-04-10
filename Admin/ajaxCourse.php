<?php

include '../Includes/Database.php';

    $cid = intval($_GET['cid']);//

        $queryss=mysqli_query($conn,"select * from tblcourse where programme_id=".$cid." and is_assign = '0'");                        
        $countt = mysqli_num_rows($queryss);

        echo '
        <select required name="course_id" class="form-control mb-3">';
        echo'<option value="">--Select Course--</option>';
        while ($row = mysqli_fetch_array($queryss)) {
        echo'<option value="'.$row['id'].'" >'.$row['course_name'].'</option>';
        }
        echo '</select>';
?>

