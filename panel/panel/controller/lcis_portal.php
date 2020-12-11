<?php
//OJIODU JOACHIM (QUICK FIX);
//delete lcis inmate_record;
class LcisPanel{
	public $con;
public function __construct($host, $user, $pass, $db){
	$conn = new mysqli($host, $user, $pass, $db);
	if ($conn->error){
	    echo 'error found';
	    exit;
	}
	$this->con = $conn;
}

public function fir(){
    /*
    $str = '';
    $q = $this->con->query("SELECT lcis_number FROM inmate_biometric");
    $arr = array();
    while($row = $q->fetch_assoc()){
       array_push($arr, $row['lcis_number']);
    }
    for ($j = 0; $j < count($arr); $j++){
        $jj = $arr[$j];
      $q2 = $this->con->query("SELECT lcis_number, first_name, last_name, othername FROM inmate_profile WHERE lcis_number != '$jj' ");
      while($r = $q2->fetch_assoc()){
          $name = $row['last_name'] . ' ' . $row['first_name'] . ' ' . $row['othername'];
          $str .= "<tr><td>" . $row['lcis_number'] . "</td><td>" . $name . "</td><td>" . $this->getPrisonLCIS($row['lcis_number']) . 
           "</td><td>" .  $this->getStatus($row['lcis_number']) . "</td></tr>";
      }
    }
    return  $q2->num_rows; */
   
}

public function fetchInmateRecord($x){
	$ql = "SELECT * FROM inmate_profile WHERE lcis_number = '$x' " ;
	$ins = $this->con->query($ql);
	if($ins->num_rows == 0){
		return "<br><center><b>no record found</b></center>";
	}
	else{
 $str = "<br><hr><center>
	            <table class='table table-bordered table-hover table-lg' style='padding:10px'>
	                <thead class='thead-dark'>
	                    <tr>
	                        <th>#</th>
	                        <th class=''>Last Name</th>
	                        <th>First Name</th>
	                        <th>Other Name</th>
	                        <th>LCIS Number</th>
	                        <th>Action</th>
	                    </tr>
	               </thead>
	               <tbody>";
	               while($row = $ins->fetch_assoc()){
	                   $x = $row['lcis_number'];
			$str .= "<tr>
            			<td>" . $row['id'] . "</td>
            			<td>" . $row['last_name'] . "</td>
            			<td>" . $row['first_name'] . "</td>
            			<td>" . $row['othername'] . "</td>
            			<td>" . $x . "</td>
            			<td><button style='margin-right:10px' onclick='deleteprof(".json_encode($x).")' class='btn btn-danger'>Delete</button>
            			<button data-target='#editModal".$row['id']."' data-toggle='modal' class='btn btn-primary'>Edit</button></td>';
			        </tr>";
			        ?>
			        <div class="modal fade" id="editModal<?php echo $row['id'];?>">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                      
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Update <?php echo $row['first_name'];?>'s Profile</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body">
                          <form action="../model/update" method="GET">
                              <div class="form-group">
                                <label for="lastname"> Last Name: <input type="text" name="lastname" class="form-control" value="<?php echo $row['last_name'];?>"  placeholder=""> </label>
                              </div>
                              <input type="hidden" name="lcis_number" value="<?php echo $row['lcis_number']; ?>">
                              <div class="form-group">
                                <label for="lastname"> First Name: <input type="text" name="firstname" class="form-control" value="<?php echo $row['first_name'];?>"  placeholder=""> </label>
                              </div>
                              
                              <div class="form-group">
                                <label for="lastname"> Other Name: <input type="text" name="othername" class="form-control" value="<?php echo $row['othername'] ;?>" placeholder=""> </label>
                              </div>
                              <input type="submit" class="btn btn-primary" value="Update">
                          </form>
                        </div>
                        
                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        
                      </div>
                    </div>
                </div>
		<?php }
		$str.= "</tbody></table></center>";
				return $str;

	 }
}
public function correctInmateName(){
    function validate($txtInput){
      $text = trim($txtInput);
      $text = stripslashes($txtInput);
      $text = htmlspecialchars($txtInput);
    
      return $text;
    }
    
    $lastname = validate($_GET['lastname']);
    $firstname = validate($_GET['firstname']);
    $othername = validate($_GET['othername']);
    $x = $_GET['lcis_number'];


	$sql = "update inmate_profile set last_name ='$lastname', first_name='$firstname', othername='$othername' where lcis_number='$x'";
	$result = $this->con->query($sql);
	if(!$result){
	    echo "failed to update record";
		exit;
	}else{
	    return "<script>alert('Profile successfully Updated'); window.location='../views/delete_views.php'</script>";
	}
	
}
public function deleteUser($x){
	$ins = $this->con->query("DELETE FROM inmate_profile WHERE lcis_number = '$x' ");
	if (!$ins){
		echo "failed to delete record";
		exit;
	}else{
		return "<script>alert('data successfully deleted'); window.location='../views/delete_views.php'</script>";
	}
}
public function checkIsAuth(){
    if (!isset($_SESSION['token'])){
        header("location:../views/auth.php");
    }
    
}
public function crossToken($input){
    $sel = $this->con->query("SELECT * FROM token WHERE token_value = '$input' ");
    if ($sel->num_rows > 0){
        while($row = $sel->fetch_assoc()){
            if (time()-$row['timestamp'] < 86400){
                $_SESSION['token'] = $input;
                header("location:../views/index.php");
            }else{
                echo " generate new token "; exit;
            }
        }
        
    }else{
            echo "access denied";
            exit;
        }
}

public function generateToken(){
    $time = time();
    $string = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $newStr = "LCIS_" . substr(str_shuffle($string), 0, 12);
    $upd = $this->con->query("UPDATE token SET token_value = '$newStr', timestamp = '$time' ");
    if($upd){
        return "<center style='margin-top:10%'> " .  $newStr . "</center>";
    }else{
        return "<center style='margin-top:10%'>failed to set new token</center>";
    }
}

public function endSession(){
    session_destroy();   
    header('location:../views/index.php');
}

public function getPrisonLCIS($lcis){
    $sq = $this->con->query("SELECT * FROM inmate_prison WHERE lcis_number = '$lcis' ");
    if ($sq->num_rows == 0){
        return "not found";
    }else{
         while($row = $sq->fetch_assoc()){
        return $this->getPrisonName($row['Prison_name']);
    }
    }
}

public function getStatus($lcis){
     $sq = $this->con->query("SELECT * FROM inmate_prison WHERE lcis_number = '$lcis' ");
    if ($sq->num_rows == 0){
        return 'no record found';
    }else{
         while($row = $sq->fetch_assoc()){
        return $row['inmate_category'];
    }
    }
}

public function getPrisonName($prison_no){
    $sq = $this->con->query("SELECT * FROM tblprison WHERE ID = '$prison_no' ");
    while($row = $sq->fetch_assoc()){
        return $row['NAME'];
    }
}

public function getInmateProfileTotal(){
    $q = $this->con->query("SELECT id FROM inmate_profile");
    return $q->num_rows;
}

public function getInmateBioTotal(){
    $q = $this->con->query("SELECT id FROM inmate_biometric");
    return $q->num_rows;
}
public function subTract(){
    return $this->getInmateProfileTotal() - $this->getInmateBioTotal();
}

public function fetchInmatesNotCaptured(){
   $arr = array(); $str = $this->subTract() . ' difference  . <br><br>';
   $sql = $this->con->query("SELECT first_name, last_name, othername, lcis_number FROM inmate_profile WHERE 
   lcis_number NOT IN (SELECT lcis_number FROM inmate_biometric) ");
   if($sql->num_rows > 0){
       while($row = $sql->fetch_assoc()){
           array_push($arr, $row['lcis_number']);
        //  $prison_name = $row['Prison_name'];
           $name = $row['last_name'] . ' ' . $row['first_name'] . ' ' . $row['othername'];
          $str .=  "<tr><td>" . $row['lcis_number'] . "</td><td>" . $name . "</td><td>" . $this->getPrisonLCIS($row['lcis_number']) . 
           "</td><td>" .  $this->getStatus($row['lcis_number']) . "</td></tr>";
          
       }
        
       $str .= "</tbody></table><br><hr> <center><button class='btn btn-info'>". $sql->num_rows .   "</button></center>";
     return $str ;
   
   }else{
       return "<center style='margin-top:10%' class='text-danger'> seems every inmate has been captured </center>";
  }
}


}


?>

