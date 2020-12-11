<?php
ob_start();
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
 include 'htmlhead.php';
 if(!isset($_SESSION['token'])){
     header('location:index.php');
 }
    include('../model/not_captured.php');
    
    ?>
    <head>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
  
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
    </head>
    <!--<h3 class="text-center bg bg-secondary" style="margin:10px 0px 30px 0px;padding:10px;border-radius:20px"><?php// echo $app->fetchInmatesNotCaptured(); ?> Inmates Not Captured</h3>
 -->
 <div style='border:0.5px solid lightgrey; background-color:white; margin-top:40px; padding:30px'>
    <table id="tbl_not_captured" class ="table table-bordered table-hover table-stripped display nowrap" style='margin-top:8%;width:100%'>
        <thead class="thead-dark">
            <tr>
                <th>LCIS_NUMBER</th>
                <th>NAME</th>
                <th>STATUS</th>
                <th>PRISON</th>
            </tr>
        </thead> 
        <tbody>
                <?php echo $app->fetchInmatesNotCaptured(); ?>
                
     </div>           

    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script> 
    <script src=" https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script> 
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script> 
  
    

<script>
    $(document).ready(function() {
    $('#tbl_not_captured').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

<?php ob_flush(); ?>