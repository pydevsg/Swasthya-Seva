
<?php require_once('check_login.php');?>
<?php include('head.php');?>
<?php include('header.php');?>
<?php include('sidebar.php');?>
<?php include('connect.php');
if(isset($_POST['submit']))
{
  if(isset($_GET['editid']))
  {
      $sql ="UPDATE prescription_records SET prescription_id='$_POST[prescriptionid]',medicine_name='$_POST[medicine]',cost='$_POST[cost]',unit='$_POST[unit]',dosage='$_POST[select2]',status=' $_POST[select]' WHERE prescription_record_id='$_GET[editid]'";
    if($qsql = mysqli_query($conn,$sql))
    {
?>
        <div class="popup popup--icon -success js_success-popup popup--visible">
          <div class="popup__background"></div>
          <div class="popup__content">
            <h3 class="popup__content__title">
              Success 
            </h3>
            <p>Prescription record updated successfully.</p>
            <p>
             <!--  <a href="index.php"><button class="button button--success" data-for="js_success-popup"></button></a> -->
             <?php echo "<script>setTimeout(\"location.href = 'prescriptionrecord.php';\",1500);</script>"; ?>
            </p>
          </div>
        </div>
<?php
      //echo "<script>alert('prescription record updated successfully...');</script>";
    }
    else
    {
      echo mysqli_error($conn);
    } 
  }
  else
  {
    $sql ="INSERT INTO prescription_records(prescription_id,medicine_name,cost,unit,dosage,status) values('$_POST[prescriptionid]','$_POST[medicineid]','$_POST[cost]','$_POST[unit]','$_POST[select2]','Active')";
    if($qsql = mysqli_query($conn,$sql))
    { 
      $presamt=$_POST[cost]*$_POST[unit];
      $billtype = "Prescription update";
      $prescriptionid= $_POST[prescriptionid];
      //include("insertbillingrecord.php");
?>  
        <div class="popup popup--icon -success js_success-popup popup--visible">
          <div class="popup__background"></div>
          <div class="popup__content">
            <h3 class="popup__content__title">
              Success 
            </h3>
            <p>Prescription record Inserteed successfully.</p>
            <p>
             <!--  <a href="index.php"><button class="button button--success" data-for="js_success-popup"></button></a> -->
             <?php echo "<script>setTimeout(\"location.href = 'prescriptionrecord.php?prescriptionid=$_GET[prescriptionid]&patientid=$_GET[patientid]&appid=$_GET[appid]';\",1500);</script>"; ?>
            </p>
          </div>
        </div>
<?php
      //echo "<script>alert('prescription record inserted successfully...');</script>";
      //echo "<script>window.location='prescriptionrecord.php?prescriptionid=$_GET[prescriptionid]&patientid=$_GET[patientid]&appid=$_GET[appid]';</script>";
    }
    else
    {
      echo mysqli_error($conn);
    }
  }
}
if(isset($_GET['editid']))
{
  $sql="SELECT * FROM prescription_records WHERE prescription_record_id='$_GET[editid]' ";
  $qsql = mysqli_query($conn,$sql);
  $rsedit = mysqli_fetch_array($qsql);
  
}
?>
<?php
if(isset($_GET['id']))
{ ?>
<div class="popup popup--icon -question js_question-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      Sure
    </h1>
    <p>Are You Sure To Delete This Record?</p>
    <p>
      <a href="view-pending-appointment.php?delid=<?php echo $_GET['id']; ?>" class="button button--success" data-for="js_success-popup">Yes</a>
      <a href="view-pending-appointment.php" class="button button--error" data-for="js_success-popup">No</a>
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
<h4>Prescription Record
</h4>

</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="dashboard.php"> <i class="feather icon-home"></i> </a>
</li>
<li class="breadcrumb-item"><a>Prescription Record</a>
</li>
<li class="breadcrumb-item"><a href="#">Prescription Record</a>
</li>
</ul>
</div>
</div>
</div>
</div>

<div class="page-body">

<div class="card">
<div class="card-header">
    <div class="col-sm-10">
    </div>
</div>
<div class="card-block">
<div class="table-responsive dt-responsive">
<table id="" class="table table-striped table-bordered nowrap">
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
    $sql ="SELECT * FROM prescription WHERE prescriptionid='$_GET[prescriptionid]'";
    $qsql = mysqli_query($conn,$sql);
    while($rs = mysqli_fetch_array($qsql))
    {
      $sqlpatient = "SELECT * FROM patient WHERE patientid='$rs[patientid]'";
      $qsqlpatient = mysqli_query($conn,$sqlpatient);
      $rspatient = mysqli_fetch_array($qsqlpatient);
      
      
    $sqldoctor = "SELECT * FROM doctor WHERE doctorid='$rs[doctorid]'";
      $qsqldoctor = mysqli_query($conn,$sqldoctor);
      $rsdoctor = mysqli_fetch_array($qsqldoctor);
      
        echo "<tr>
          <td>&nbsp;$rsdoctor[doctorname]</td>
          <td>&nbsp;$rspatient[patientname]</td>
       <td>&nbsp;$rs[prescriptiondate]</td>
    <td>&nbsp;$rs[status]</td>
    
        </tr>";
    }
    ?>
</tbody>

</table>
</div>
</div>
</div>



<div class="card">
  <?php
      if(!isset($_SESSION['patientid']))
      {
      ?>  
<form method="post" action="" name="frmpresrecord" onSubmit="return validateform()"> 
  <input type="hidden" name="prescriptionid" value="<?php echo $_GET[prescriptionid]; ?>"  />
    <div class="table-responsive dt-responsive">
    <table id="" class="table table-striped table-bordered nowrap">
      <tbody>
      
        <tr>
          <td width="34%">Medicine</td>
          <td width="66%">
      <select class="form-control show-tick" name="medicineid" id="medicineid" onchange="loadmedicine(this.value)">
      <option value="">Select Medicine</option>
      <?php
    $sqlmedicine ="SELECT * FROM medicine WHERE status='Active'";
    $qsqlmedicine = mysqli_query($conn,$sqlmedicine);
    while($rsmedicine = mysqli_fetch_array($qsqlmedicine))
    {
      echo "<option value='$rsmedicine[medicineid]'>$rsmedicine[medicinename] ( TK. $rsmedicine[medicinecost] )</option>";
    }
    ?>
      </select>
      </td>
        </tr>
        <tr>
          <td>Cost</td>
          <td><input class="form-control" type="text" name="cost" id="cost" value="<?php echo $rsmedicine['medicinecost']; ?>" readonly style="background-color:pink;" /></td>
        </tr>
        <tr>
          <td>Unit</td>
          <td><input class="form-control" type="number" min="1" name="unit" id="unit" value="<?php echo $rsedit['unit']; ?>" onkeyup="calctotalcost(cost.value,this.value)" onchange="" /></td>
        </tr>
        <tr>
          <td>Total Cost</td>
          <td><input class="form-control" type="text" name="totcost" id="totcost" value="<?php if(isset($_GET['editid'])) { echo $rsedit['cost']; } ?>" readonly style="background-color:pink;" /></td>
        </tr>
        <tr>
          <td>Dosage</td>
          <td><select class="form-control show-tick" name="select2" id="select2">
           <option value="">Select</option>
          <?php
      $arr = array("0-0-1","0-1-1","1-0-1","1-1-1","1-1-0","0-1-0","1-0-0");
      foreach($arr as $val)
      {
       if($val == $rsedit['dosage'])
        {
        echo "<option value='$val' selected>$val</option>";
        }
        else
        {
          echo "<option value='$val'>$val</option>";        
        }
      }
      ?>
          </select></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><input class="btn btn-default" type="submit" name="submit" id="submit" value="Submit" /> </td>
        </tr>
      </tbody>
    </table>
  </div>
    </form>
    <?php
      }
    ?>
</div>

<h3>View Prescription record</h3>

<div class="card">
<div class="card-header">
    <div class="col-sm-10">
    </div>
</div>
<div class="card-block">
<div class="table-responsive dt-responsive">
<table id="" class="table table-striped table-bordered nowrap">
<thead>
<tr>

          <td><strong>Medicine</strong></td>
          <td><strong>Dosage</strong></td>
          <td><strong>Cost</strong></td>
          <td><strong>Unit</strong></td>
          <td><strong>Total Cost</strong></td>
                    <?php
      if(!isset($_SESSION['patientid']))
      {
      ?>  
          <td><strong>Action</strong></td>
          <?php
      }
      ?>
</tr>
</thead>
<tbody>
  <tr>
          <td><strong>Medicine</strong></td>
          <td><strong>Dosage</strong></td>
          <td><strong>Cost</strong></td>
          <td><strong>Unit</strong></td>
          <td><strong>Total Cost</strong></td>
                    <?php
      if(!isset($_SESSION['patientid']))
      {
      ?>  
          <td><strong>Action</strong></td>
          <?php
      }
      ?>
        </tr>
         <?php
     $gtotal=0;
    $sql ="SELECT * FROM prescription_records LEFT JOIN medicine on prescription_records.medicine_name=medicine.medicineid WHERE prescription_id='$_GET[prescriptionid]'";
    $qsql = mysqli_query($conn,$sql);
    while($rs = mysqli_fetch_array($qsql))
    {
        echo "<tr>
          <td>&nbsp;$rs[medicinename]</td>
        <td>&nbsp;$rs[dosage]</td>
          <td>&nbsp;₹$rs[cost]</td>
       <td>&nbsp;$rs[unit]</td>
       <td  align='right'>TK." . $rs['cost'] * $rs['unit'] . "</td>";
      if(!isset($_SESSION['patientid']))
      {
       echo " <td>&nbsp; <a href='prescriptionrecord.php?delid=$rs[prescription_record_id]&prescriptionid=$_GET[prescriptionid]'>Delete</a> </td>"; 
      }
    echo "</tr>";
    $gtotal = $gtotal+($rs['cost'] * $rs['unit']);
    }
    ?>
        <tr>
          <th colspan="4" align="right">Grand Total </th>
      <th align="right">TK.<?php echo $gtotal; ?></th>
      <td></td>
          </tr>
        <tr>
          <td colspan="6"><div align="center">
            <input Class="btn btn-default" type="submit" name="print" id="print" value="Print" onclick="myFunction()"/>
          </div></td>
          </tr>
</tbody>

</table>
</div>
</div>
</div>



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
function myFunction() {
    window.print();
}
</script>