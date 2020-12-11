<?php
ob_start();
//session_start();

    include 'htmlhead.php';
    include('../model/authen.php');
?>
    <div class="container-fluid">
        <h1 class="text-center w-100" style="margin:10px 0px 30px 0px;padding:10px;background:black;color:white;border-radius:20px">LCIS PORTAL</h1>
        <div class="row">
            <div class="col">
                <div class="card shadow-lg" style="width:300px">
                    <p> <i class="fas fa-trash text text-danger" style=""></i></p>
                    <div class="card-body">
                        <h5 class="card-title">Delete Inmate Profile</h5>
                        <a href="delete_views.php" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-lg" style="width:300px">
                    <p> <i class="fas fa-user-edit text text-info" style=""></i></p>
                    <div class="card-body">
                        <h5 class="card-title">Update Inmate Profile</h5>
                        <a href="delete_views.php" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-lg" style="width:320px; ">
                    <p> <i class="fas fa-user-times text text-warning" style=""></i></p>
                    <div class="card-body">
                        <h5 class="card-title">View Inmates Not Captured</h5>
                        <a href="not_captured.php" class="stretched-link"></a>
                    </div>
                </div>
            </div>

        </div>
        <br><br>
        <center><a class='btn btn-danger' href='../model/endsession.php'>End Session</a></center>
    </div>

</body> 
</html>
<?php ob_end_flush(); ?>