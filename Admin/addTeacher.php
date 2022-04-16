
<?php 
error_reporting(0);
include '../Includes/Database.php';
include '../Includes/Session.php';

//------------------------SAVE--------------------------------------------------

if(isset($_POST['save'])){
    
    $fullname=$_POST['fullname'];
  $username=$_POST['username'];
  $email=$_POST['email'];
  $password=$_POST['password'];
  $phone_No=$_POST['phone_No'];
  $programme_id=$_POST['programme_id'];
  $course_id=$_POST['course_id'];
  $dateCreated = date("Y-m-d");
   
    $query=mysqli_query($conn,"select * from tblteacher where email ='$email'");
    $ret=mysqli_fetch_array($query);

    

    if($ret > 0){ 

        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Email Address Already Exists!</div>";
    }
    else{

    $query=mysqli_query($conn,"INSERT into tblteacher(fullname,username,email,password,phone_No,programme_id,course_id,dateCreated) 
    value('$fullname','$username','$email','$password','$phone_No','$programme_id','$course_id','$dateCreated')");

    if ($query) {
        
        $qu=mysqli_query($conn,"update tblcourse set is_assign='1' where id ='$course_id'");
            if ($qu) {
                
                $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Created Successfully!</div>";
            }
            else
            {
                $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
            }
    }
    else
    {
         $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}

//---------------------------------------EDIT-------------------------------------------------------------






//--------------------EDIT------------------------------------------------------------

 if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "edit")
	{
        $id= $_GET['id'];

        $query=mysqli_query($conn,"select * from tblteacher where id ='$id'");
        $row=mysqli_fetch_array($query);

        //------------UPDATE-----------------------------

        if(isset($_POST['update'])){
    
             $fullname=$_POST['fullname'];
              $username=$_POST['username'];
              $email=$_POST['email'];
              $password=$_POST['password'];
              $phone_No=$_POST['phone_No'];
              $programme_id=$_POST['programme_id'];
              $course_id=$_POST['course_id'];
              $dateCreated = date("Y-m-d");

    $query=mysqli_query($conn,"update tblteacher set fullname='$fullname', username='$username',
    email='$email', password='$password',phone_No='$phone_No', programme_id='$programme_id',course_id='$course_id'
    where id='$id'");
            if ($query) {
                
                echo "<script type = \"text/javascript\">
                window.location = (\"addTeacher.php\")
                </script>"; 
            }
            else
            {
                $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
            }
        }
    }


//--------------------------------DELETE------------------------------------------------------------------

  if (isset($_GET['id']) && isset($_GET['course_id']) && isset($_GET['action']) && $_GET['action'] == "delete")
	{
        $id= $_GET['id'];
        $course_id= $_GET['course_id'];

        $query = mysqli_query($conn,"DELETE FROM tblteacher WHERE id='$id'");

        if ($query == TRUE) {

            $qu=mysqli_query($conn,"update tblcourse set is_assign='0' where id ='$course_id'");
            if ($qu) {
                
                 echo "<script type = \"text/javascript\">
                window.location = (\"addTeacher.php\")
                </script>"; 
            }
            else
            {
                $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
            }
        }
        else{

            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>"; 
         }
      
  }


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/attnlg.jpg" rel="icon">
<?php include 'includes/title.php';?>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">



    <script>
    function courseDropdown(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxCourse.php?cid="+str,true);
        xmlhttp.send();
    }
}
</script> 
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
      <?php include "Includes/sidebar.php";?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
       <?php include "Includes/topbar.php";?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Lecturers</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Lecturers</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Add Lecturers</h6>
                    <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                   <div class="form-group row mb-3">
                        <div class="col-xl-6">
                        <label class="form-control-label">Full Name<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" required name="fullname" value="<?php echo $row['fullname'];?>" id="exampleInputFirstName">
                        </div>
                        <div class="col-xl-6">
                        <label class="form-control-label">Username<span class="text-danger ml-2">*</span></label>
                      <input type="text" class="form-control" required name="username" value="<?php echo $row['username'];?>" id="exampleInputFirstName" >
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-xl-6">
                        <label class="form-control-label">Password<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" required name="password" value="<?php echo $row['password'];?>" id="exampleInputFirstName">
                        </div>
                    </div>

                     <div class="form-group row mb-3">
                        <div class="col-xl-6">
                        <label class="form-control-label">Email Address<span class="text-danger ml-2">*</span></label>
                        <input type="email" class="form-control" required name="email" value="<?php echo $row['email'];?>" id="exampleInputFirstName" >
                        </div>
                        <div class="col-xl-6">
                        <label class="form-control-label">Phone Number<span class="text-danger ml-2">*</span></label>
                      <input type="text" class="form-control" name="phone_No" value="<?php echo $row['phone_No'];?>" id="exampleInputFirstName" >
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <div class="col-xl-6">
                        <label class="form-control-label">Select Programme<span class="text-danger ml-2">*</span></label>
                         <?php
                        $qry= "SELECT * FROM tblprogramme ORDER BY programme_name ASC";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;		
                        if ($num > 0){
                          echo ' <select required name="programme_id" onchange="courseDropdown(this.value)" class="form-control mb-3">';
                          echo'<option value="">--Select Programme--</option>';
                          while ($rows = $result->fetch_assoc()){
                          echo'<option value="'.$rows['id'].'" >'.$rows['programme_name'].'</option>';
                              }
                                  echo '</select>';
                              }
                            ?>  
                        </div>
                        <div class="col-xl-6">
                        <label class="form-control-label">Course<span class="text-danger ml-2">*</span></label>
                            <?php
                                echo"<div id='txtHint'></div>";
                            ?>
                        </div>
                    </div>
                      <?php
                    if (isset($id))
                    {
                    ?>
                    <button type="submit" name="update" class="btn btn-warning">Update</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php
                    } else {           
                    ?>
                    <button type="submit" name="save" class="btn btn-primary">Save</button>
                    <?php
                    }         
                    ?>
                  </form>
                </div>
              </div>

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">All Lecturers</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>username</th>
                        <th>Email Address</th>
                        <th>Phone No</th>
                        <th>Programme</th>
                        <th>Course</th>
                        <th>Date Created</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                   
                    <tbody>

                  <?php
                      $query = "SELECT tblteacher.id,tblprogramme.programme_name,tblcourse.course_name,tblcourse.id AS course_id,tblteacher.fullname,
                      tblteacher.username,tblteacher.email,tblteacher.phone_No,tblteacher.dateCreated
                      FROM tblteacher
                      INNER JOIN tblprogramme ON tblprogramme.id = tblteacher.programme_id
                      INNER JOIN tblcourse ON tblcourse.id = tblteacher.course_id";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn=0;
                      $status="";
                      if($num > 0)
                      { 
                        while ($rows = $rs->fetch_assoc())
                          {
                             $sn = $sn + 1;
                            echo"
                              <tr>
                                <td>".$sn."</td>
                                <td>".$rows['fullname']."</td>
                                <td>".$rows['username']."</td>
                                <td>".$rows['email']."</td>
                                <td>".$rows['phone_No']."</td>
                                <td>".$rows['programme_name']."</td>
                                <td>".$rows['course_name']."</td>
                                 <td>".$rows['dateCreated']."</td>
                                <td><a href='?action=delete&id=".$rows['id']."&course_id=".$rows['course_id']."'><i class='fas fa-fw fa-trash'></i></a></td>
                              </tr>";
                          }
                      }
                      else
                      {
                           echo   
                           "<div class='alert alert-danger' role='alert'>
                            No Record Found!
                            </div>";
                      }
                      
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            </div>
          </div>
          <!--Row-->

          <!-- Documentation Link -->
          <!-- <div class="row">
            <div class="col-lg-12 text-center">
              <p>For more documentations you can visit<a href="https://getbootstrap.com/docs/4.3/components/forms/"
                  target="_blank">
                  bootstrap forms documentations.</a> and <a
                  href="https://getbootstrap.com/docs/4.3/components/input-group/" target="_blank">bootstrap input
                  groups documentations</a></p>
            </div>
          </div> -->

        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
       <?php include "Includes/footer.php";?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
   <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
</body>

</html>