<!-- Author Name: Sudipto Ghosh-->
<?php require_once('check_login.php');?>
<?php include('head.php');?>
<?php include('header.php');?>
<?php include('sidebar.php');?>
<?php include('connect.php');
if(isset($_GET['id']))
{
  $sql ="UPDATE appointment SET delete_status='1' WHERE departmentid='$_GET[id]'";
  $qsql=mysqli_query($conn,$sql);
  if(mysqli_affected_rows($conn) == 1)
  {
?>
         <div class="popup popup--icon -success js_success-popup popup--visible">
          <div class="popup__background"></div>
          <div class="popup__content">
            <h3 class="popup__content__title">
              Success 
            </h3>
            <p>Appointment record deleted successfully.</p>
            <p>
             <!--  <a href="index.php"><button class="button button--success" data-for="js_success-popup"></button></a> -->
             <?php echo "<script>setTimeout(\"location.href = 'view-prescription.php';\",1500);</script>"; ?>
            </p>
          </div>
        </div>
<?php
    //echo "<script>alert('Department record deleted successfully..');</script>";
    //echo "<script>window.location='view-appointment.php';</script>";
  }
}


if(isset($_GET['approveid']))
{
  $sql ="UPDATE appointment SET status='Approved' WHERE appointmentid='$_GET[approveid]'";
  $qsql=mysqli_query($conn,$sql);
  if(mysqli_affected_rows($conn) == 1)
  {
?>
         <div class="popup popup--icon -success js_success-popup popup--visible">
          <div class="popup__background"></div>
          <div class="popup__content">
            <h3 class="popup__content__title">
              Success 
            </h3>
            <p>Appointment record Approved successfully.</p>
            <p>
             <!--  <a href="index.php"><button class="button button--success" data-for="js_success-popup"></button></a> -->
             <?php echo "<script>setTimeout(\"location.href = 'view-prescription.php';\",1500);</script>"; ?>
            </p>
          </div>
        </div>
     <?php
    //echo "<script>alert('Appointment record Approved successfully..');</script>";
    //echo "<script>window.location='view-appointment.php';</script>";
  }
}
?>
<?php
if(isset($_GET['delid']))
{ ?>
<div class="popup popup--icon -question js_question-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      Sure
    </h1>
    <p>Are You Sure To Delete This Record?</p>
    <p>
      <a href="view-department.php?id=<?php echo $_GET['delid']; ?>" class="button button--success" data-for="js_success-popup">Yes</a>
      <a href="view-department.php" class="button button--error" data-for="js_success-popup">No</a>
    </p>
  </div>
</div>
<?php } ?>
<div class="pcoded-content">
<div class="pcoded-inner-content">

<div class="main-body">
<div class="page-wrapper">

<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4>View Prescription Record</h4>

</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="dashboard.php"> <i class="feather icon-home"></i> </a>
</li>
<li class="breadcrumb-item"><a>View Prescription Record</a>
</li>
<li class="breadcrumb-item"><a href="#">View Prescription Record</a>
</li>
</ul>
</div>
</div>
</div>
</div>

<div class="page-body">


    <?php
      $sql ="SELECT * FROM prescription where patientid='$_SESSION[patientid]'";
      $qsql = mysqli_query($conn,$sql);
      while($rs = mysqli_fetch_array($qsql))
      {
        $sqlpatient = "SELECT * FROM patient WHERE patientid='$rs[patientid]'";
        $qsqlpatient = mysqli_query($conn,$sqlpatient);
        $rspatient = mysqli_fetch_array($qsqlpatient);

        $sqldoctor = "SELECT * FROM doctor WHERE doctorid='$rs[doctorid]'";
        $qsqldoctor = mysqli_query($conn,$sqldoctor);
        $rsdoctor = mysqli_fetch_array($qsqldoctor);
      ?>
<div class="card">
<div class="card-header">
<!-- <h5>DOM/Jquery</h5>
<span>Events assigned to the table can be exceptionally useful for user interaction, however you must be aware that DataTables will add and remove rows from the DOM as they are needed (i.e. when paging only the visible elements are actually available in the DOM). As such, this can lead to the odd hiccup when working with events.</span> -->
</div>

<div class="card-block">
<div class="table-responsive dt-responsive">
<table id="dom-jqry" class="table table-striped table-bordered nowrap">
<thead>
  <tr>
    <th>Doctor</th>
    <th>Patient</th>
    <th>Prescription Date</th>
    <th>Status</th>
  </tr>

</thead>
<tbody>  
  <?php
    echo "<tr>
    <td>&nbsp;$rsdoctor[doctorname]</td>
    <td>&nbsp;$rspatient[patientname]</td>
    <td>&nbsp;$rs[prescriptiondate]</td>
    <td>&nbsp;$rs[status]</td>
    
    </tr>";
  ?>
</tbody>
<tfoot>
  <tr>
    <th>Doctor</th>
    <th>Patient</th>
    <th>Prescription Date</th>
    <th>Status</th>
  </tr>
</tfoot>
</table>
</div>

<div class="table-responsive dt-responsive">
<table id="dom-jqry" class="table table-striped table-bordered nowrap">
<thead>
  <tr>
    <th>Medicine</th>
    <th>Cost</th>
    <th>Unit</th>
    <th>Dosage</th>
  </tr>

</thead>
<tbody>  
  <?php
    $sqlprescription_records ="SELECT * FROM prescription_records LEFT JOIN medicine ON prescription_records.medicine_name=medicine.medicineid WHERE prescription_records.prescription_id='$rs[0]'";
    $qsqlprescription_records = mysqli_query($conn,$sqlprescription_records);
    while($rsprescription_records = mysqli_fetch_array($qsqlprescription_records))
    {
      echo "<tr>
      <td>&nbsp;$rsprescription_records[medicinename]</td>
      <td>&nbsp;$rsprescription_records[cost]</td>
      <td>&nbsp;$rsprescription_records[unit]</td>
      <td>&nbsp;$rsprescription_records[dosage]</td>

      </tr>";
    }
  ?>           
</tbody>
<tfoot>
  <tr>
    <th>Medicine</th>
    <th>Cost</th>
    <th>Unit</th>
    <th>Dosage</th>
  </tr>
</tfoot>
</table>
</div>
<input type="submit" class="btn btn-lg" name="print" id="print" value="Print" onclick="myFunction()"/>
</div>
</div>
<?php } ?>


</div>

</div>
</div>

<div id="#">
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php include('footer.php');?>
<?php if(!empty($_SESSION['success'])) {  ?>
<div class="popup popup--icon -success js_success-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      Success 
    </h1>
    <p><?php echo $_SESSION['success']; ?></p>
    <p>
     <?php echo "<script>setTimeout(\"location.href = 'view_user.php';\",1500);</script>"; ?>
      <!-- <button class="button button--success" data-for="js_success-popup">Close</button> -->
    </p>
  </div>
</div>
<?php unset($_SESSION["success"]);  
} ?>
<?php if(!empty($_SESSION['error'])) {  ?>
<div class="popup popup--icon -error js_error-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      Error 
    </h1>
    <p><?php echo $_SESSION['error']; ?></p>
    <p>
     <?php echo "<script>setTimeout(\"location.href = 'view_user.php';\",1500);</script>"; ?>
     <!--  <button class="button button--error" data-for="js_error-popup">Close</button> -->
    </p>
  </div>
</div>
<?php unset($_SESSION["error"]);  } ?>
    <script>
      var addButtonTrigger = function addButtonTrigger(el) {
  el.addEventListener('click', function () {
    var popupEl = document.querySelector('.' + el.dataset.for);
    popupEl.classList.toggle('popup--visible');
  });
};

Array.from(document.querySelectorAll('button[data-for]')).
forEach(addButtonTrigger);
    </script>


<script>
  function myFunction()
  {
   window.print();
 }
</script>