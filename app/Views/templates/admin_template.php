<!DOCTYPE html>
<html lang="en">

        <?php include 'header.php'; ?>


<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    <h1> TICKETING SYSTEM</h1>
  </div> -->

 
  <?php include 'menu.php'; ?>


  <div class="content-wrapper">
    <?= $this -> renderSection('contentarea')?>
</div>


 

    <!-- Main content -->
    <section class="content">
    
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
  <?php include 'footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

        <?php include 'scripts.php'; ?>
        <?= $this -> renderSection('pagescript')?>

</body>
</html>
