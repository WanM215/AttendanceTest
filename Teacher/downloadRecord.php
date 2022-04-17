<?php 
error_reporting(0);
include '../Includes/Database.php';
include '../Includes/Session.php';

?>
        <table border="1">
        <thead>
            <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Admission No</th>
            <th>Programme</th>
            <th>Course</th>
            <th>Semester</th>
            <th>Term</th>
            <th>Status</th>
            <th>Date</th>
            </tr>
        </thead>

<?php 
$filename="Attendance list";
$dateTaken = date("Y-m-d");

$cnt=1;			
$ret = mysqli_query($conn,"SELECT tblattendance.id,tblattendance.status,tblattendance.dateTimeTaken,tblprogramme.programme_name,
        tblcourse.course_name,tblsemester.semester_name,tblsemester.term_id,tblterm.term_name,
        tblstudents.fullname,tblstudents.username,tblstudents.email,tblstudents.admissionNumber
        FROM tblattendance
        INNER JOIN tblprogramme ON tblprogramme.id = tblattendance.programme_id
        INNER JOIN tblcourse ON tblcourse.id = tblattendance.course_id
        INNER JOIN tblsemester ON tblsemester.id = tblattendance.semester_id
        INNER JOIN tblterm ON tblterm.id = tblsemester.term_id
        INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
        where tblattendance.dateTimeTaken = '$dateTaken' and tblattendance.programme_id = '$_SESSION[programme_id]' and tblattendance.course_id = '$_SESSION[course_id]'");

if(mysqli_num_rows($ret) > 0 )
{
while ($row=mysqli_fetch_array($ret)) 
{ 
    
    if($row['status'] == '1'){$status = "Present"; $colour="#00FF00";}else{$status = "Absent";$colour="#FF0000";}

echo '  
<tr>  
<td>'.$cnt.'</td> 
<td>'.$fullname= $row['fullname'].'</td> 
<td>'.$username= $row['username'].'</td> 
<td>'.$email= $row['email'].'</td> 
<td>'.$admissionNumber= $row['admissionNumber'].'</td> 
<td>'.$programme_name= $row['programme_name'].'</td> 
<td>'.$course_name=$row['course_name'].'</td>	
<td>'.$semester_name=$row['semester_name'].'</td>	 
<td>'.$term_name=$row['term_name'].'</td>	
<td>'.$status=$status.'</td>	 	
<td>'.$date=$row['dateTimeTaken'].'</td>	 					
</tr>  
';
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$filename."-report.xls");
header("Pragma: no-cache");
header("Expires: 0");
			$cnt++;
			}
	}
?>
</table>