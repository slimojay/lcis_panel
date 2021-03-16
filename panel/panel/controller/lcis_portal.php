<?php
//OJIODU JOACHIM (QUICK FIX);
//delete lcis inmate_record;
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
include('BaseClass.php');

class LcisPanel extends BaseClass{
	public $con;
    public function __construct($host, $user, $pass, $db){
    	$conn = new mysqli($host, $user, $pass, $db);
    	if ($conn->error){
    	    echo 'error found';
    	    exit;
    	}
    	$this->con = $conn;
    }
    
    public function validate($txtInput){
        $text = trim($txtInput);
		$text = stripslashes($txtInput);
		$text = htmlspecialchars($txtInput);
	  
		return $text;
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
       // session_start();
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
    	                   if ($_SESSION['center'] == 'judge'){
    	                       $nm = $row['lcis_number'];
    	                       $btn = "<a href='update_status?inmate=$nm' class='btn btn-sucess'> update </a>";
    
    	                   }
    	                   if (isset($_SESSION['token']) ){
    	                       
    	                       
    	  
    	                   $x = $row['lcis_number'];
    			$str .= "<tr>
                			<td>" . $row['id'] . "</td> 
                			<td>" .  $row['last_name'] . "</td>
                			<td>" . $row['first_name'] . "</td>
                			<td>" . $row['othername'] . "</td>
                			<td>" . $x . "</td>
                			<td><button style='margin-right:10px' onclick='deleteprof(".json_encode($x).")' class='btn btn-danger'>Delete</button> 
                			<button data-target='#editModal".$row['id']."' data-toggle='modal' class='btn btn-primary'>Edit</button> $btn </td>';
    			        </tr>";
    	                   }else{
    	                          $x = $row['lcis_number'];
    			$str .= "<tr>
                			<td>" . $row['id'] .  "</td>
                			<td>" . $row['last_name'] . "</td>
                			<td>" . $row['first_name'] . "</td>
                			<td>" . $row['othername'] . "</td>
                			<td>" . $x . "</td>
                			<td>
                			<button data-target='#editModal".$row['id']."' data-toggle='modal' class='btn btn-primary'>Edit</button> $btn </td>
    			        </tr>";
    	                   }
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
    
    public function createLCISUser(){
                            $query = "insert into lcis_users (username, password, first_name, last_name, email, company, phone) values ('$username', '$hashedPassword','$firstname','$lastname','$email', '$company', $phone') ";
    
                            $result = $this->con->query($query);
                            if($result){
                                echo "<script> alert('Account created'); </script>";
                                header('refresh:2;loginform.php');
                            }else{
                                echo json_encode($this->con->error);
                                // header('refresh:2;loginform.php');
                                exit("<h1> something went wrong</h1>");
                            }
                        
    }
    
    public function fetcher(){
        $opt = '';
        $sql = "SELECT * FROM lcis_groups";
        $q = $this->con->query($sql);
        while($r = $q->fetch_assoc()){
            $x = $r['ID']; $y = $r['Name'];
            $opt .= "<option value='$x'>$y</option>"; 
        }
        return $opt;
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
        if (!isset($_SESSION['token']) && !isset($_SESSION['username'])){
            //header("location:../views/login");
            echo "<script>window.location='../views/login'</script>";
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
        $emails = array("ojiodujoachim@gmail.com", "stephenkc3@gmail.com", "olamydas@gmail.com");
        $string = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $newStr = "LCIS_" . substr(str_shuffle($string), 0, 12);
        $upd = $this->con->query("UPDATE token SET token_value = '$newStr', timestamp = '$time' ");
        if($upd){
            //return "<center style='margin-top:10%'> " .  $newStr . "</center>";
             $this->sendMail($emails, $newStr);
             return "<center style='margin-top:10%'> Token Generated </center>";
        }else{
            return "<center style='margin-top:10%'>failed to set new token</center>";
        }
    }
    
    public function sendMail($emails, $msg){
        $subject = 'Generated Token';
        $headers = 'From: noreply@lcis.com.ng';
        for ($i = 0; $i < count($emails); $i++){
            mail($emails[$i], $subject, $msg,$headers);
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
    
    public function getInmateOffence($x){
        $sql = "SELECT * FROM inmate_police WHERE lcis_number = '$x' ";
        $p = $this->con->query($sql);
        if ($p->num_rows > 0){
            $r = $p->fetch_assoc();
            return $r['Offence'];
        }else{
            return "-";
        }
    }
    
    public function getInmateCharge($x){
        $sql = "SELECT * FROM inmate_police WHERE lcis_number = '$x' ";
        $p = $this->con->query($sql);
        if ($p->num_rows > 0){
            $r = $p->fetch_assoc();
            return $r['Charge_no'];
        }else{
            return "-";
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
    
    public function filterSearch($srch_inp){
        $str = ''; 
        $srch_inp = trim(strtolower($srch_inp));
        // $ln = trim(strtolower($ln));
    
        $sql = "select * from inmate_profile where first_name = '$srch_inp' or last_name = '$srch_inp' or lcis_number='$srch_inp'";
        //$sql = "SELECT ip.*,  ifu.warrant, ifu.id AS ifuid FROM inmate_profile AS ip INNER JOIN inmate_file_uploads  AS ifu ON ip.lcis_number = ifu.lcis_number 
        //WHERE ip.first_name = '$srch_inp' or ip.last_name = '$srch_inp' or lcis_number='$srch_inp'";
        $q = $this->con->query($sql) or die($this->con->error);
        if ($q->num_rows > 0){
            echo $q->num_rows ;// $_SERVER['PHP_SELF'];
            
            while($r = $q->fetch_assoc()){
                $x = $r['lcis_number'];
            $str .= "<tr><td>" . $r['lcis_number'] . "</td><td>" . $r['last_name'] . "</td><td>" . $r['first_name'] . "</td><td>" . $r['othername'] . "</td><td>" . $this->getInmateOffence($x)
            . "</td><td>". $this->getInmateCharge($x) . "</td><td> 
            <a href='upload_docs.php?lcis=$x' class='btn btn-warning'>upload</a> </td></tr>";
            }
            
                
        
           
            return $str;
            
        }else{
            echo "<center style='margin-top:7%'> no matching records found </center>";
            exit;
        }
    }
    
     public function viewWarrant($srch_inp){
          $str = ''; 
        $srch_inp = trim(strtolower($srch_inp));
         $sql = "SELECT ip.*,  ifu.warrant, ifu.id AS ifuid FROM inmate_profile AS ip INNER JOIN inmate_file_uploads AS ifu ON ip.lcis_number = ifu.lcis_number 
        WHERE ip.first_name = '$srch_inp' or ip.last_name = '$srch_inp' or ip.lcis_number='$srch_inp'";
        $q = $this->con->query($sql) or die($this->con->error);
        if ($q->num_rows > 0){
            echo $q->num_rows ;// $_SERVER['PHP_SELF'];
            
            while($r = $q->fetch_assoc()){
                $x = $r['lcis_number'];
            $str .= "<tr><td>" . $r['lcis_number'] . "</td><td>" . $r['last_name'] . "</td><td>" . $r['first_name'] . "</td><td>" . $r['othername'] . "</td><td>" . $this->getInmateOffence($x)
            . "</td><td>". $this->getInmateCharge($x) . "</td><td> 
            " . $this->explodeFiles($r['warrant'], 'warrants', $r['ifuid']) ." </td></tr>";
            }
            
                
        
           
            return $str;
            
        }else{
            echo "<center style='margin-top:7%'> no matching records found </center>";
            exit;
        }
         
     }
    
    public function explodeFiles($x, $doc, $id){
	    
	    $str = explode(";", $x);
	    $len = strlen($doc) - 1;
	    $substr = substr($doc, 0, $len);
	    $blank = "_blank";
	    $select = "<select style='background-color:black; padding:10px; color:white; border-radius:10px' onchange='window.open(this.value)'><option>All $doc</option>";
	    for ($i = 0; $i < (count($str) - 1); $i++){
	        $select .= "<option value='http://magistrate.lcis.com.ng/dashboard/readfile?type=$substr&file_id=$id&offset=$i' class='text-primary'>" . $substr .  "_" . ($i + 1) . "</option>";
	        
	    }
	    $select .= "</select>";
	    return $select;
	}
    
    public function uploadDocs($doctype, $document, $lcis_number){
        $pdf = array('pdf', '');
        $path = '../../../public_html/portal/uploads';
         $keys = array('lcis_number', 'arraignment', 'advise', 'warrant');
        $vals = array($lcis_number, '', '', '');
        $chk = "SELECT * FROM inmate_file_uploads WHERE lcis_number = '$lcis_number'";
        $s = $this->con->query($chk);
        if ($s->num_rows == 0){
        $ins = $this->insert('inmate_file_uploads', $keys, $vals);
        }else{
         echo '<br>data has been updated<br>';
         //$warrant_in =
        /* while($rr = $s->fetch_assoc()){
          $warrant_in = $rr['warrant'];
          $arraignment = $rr['arraignment'];
          $advise = $rr['advise'];
         }*/
        } 
        if ($doctype == 'Remand_Warrant'){
            $str = 'warrant';
            $upd = $this->upload($document, $path, true, $pdf, 0);
        }else if($doctype == 'DPP_Legal_Advice'){
            $str = 'advise';
            $upd = $this->upload($document, $path, true, $pdf, 0);
        }else if($doctype == 'Notification_of_Arraignment'){
            $str = 'arraignment';
            $upd = $this->upload($document, $path, true, $pdf, 0);
        }
        while($rr = $s->fetch_assoc()){
            $prev = $rr[$str];
        }
        $f = $upd['filenamE']; echo $f;
        /*
        $upd1 = $this->upload($arraignment, $path, false, $pdf, 0);
        $upd2 = $this->upload($advise, $path, false, $pdf, 0);
        $f1 = $upd1['filenamE'];
        $f2 = $upd2['filenamE'];
        if($f){
            $ins =  $this->con->query("UPDATE inmate_file_uploads SET arraignment = '$f1' WHERE lcis_number = '$lcis_number'");
        }*/
        if ($f){
            $append = $prev . $f;
           $upp =  $this->con->query("UPDATE inmate_file_uploads SET $str = '$append' WHERE lcis_number = '$lcis_number' "); 
        }
        //if
        if ($upp){
            return "<hr>operation successful <br> <a href='../views/filtersearch.php'>Back To Filter</a>";
        }else{
            return "<hr>opertaion failed";
        }
    }
    
    public function userlogin($username, $password){
        /*if(isset($_POST['loginbtn'])){
            if(isset($_POST['userName']) && isset($_POST['password']) ){
                if(!ctype_space($_POST['userName']) && !ctype_space($_POST['password'])){
                   $username = $this->validate($_POST['userName']);*/
        
                   //$password = $this->validate($_POST['password']);
                
                   $query = "select * from portal_users where username='$username'";
                   $result = $this->con->query($query);      
                    if($result->num_rows==1){
                        $details = $result->fetch_assoc();
                        if(password_verify($password, $details['password'])){
                            // echo "<script>swal('','LOGIN SUCCESSFULL ! ! !','success'); </script>";
                            //session_start();
                             $_SESSION['username'] = $details['username'];
                            $_SESSION['logged'] = true;
                            // echo "<script>alert('login successful');</script>";
               
                            echo "<script>setTimeout(function(){window.location.href = '../views/index';}, 1000);</script>"; 


                            // header('refresh:3; index.php');
                        }else{
                            echo "<script>setTimeout(function(){window.location.href = '../views/login';alert('incorrect password');}, 1000);</script>"; 
                            // header("location:loginform.php");
                        }
                    }else{
                        echo "<script>
                        setTimeout(function(){window.location.href = '../views/login'}, 2500);
                        alert('INCORRECT USERNAME'); 
                        </script>";
                        // header("location:loginform.php");
        
                    }
                }
    //         }
    //     }
    // }
    
    
    public function uploadedDocsCount($lcis_no){
        $sql = "SELECT * FROM inmate_file_uploads WHERE lcis_number = '$lcis_no'";
        $res=$this->con->query($sql);
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            $war = explode(";",$row['warrant']);
            $arr = explode(";",$row['arraignment']);
            $adv = explode(";",$row['advise']);
            
            $warrant = $row['warrant'] ? count($war)-1 : 0;
            $arraign = $row['arraignment'] ? count($arr)-1 : 0;
            $advise = $row['advise'] ? count($adv)-1 : 0;
            echo "
                    <p>Remand Warrant: ".$warrant." </p>
                    <p>DPP Legal Advice: ".$advise." </p>
                    <p>Notification of Arraignment: ".$arraign." </p> ";
        }
    }
    
    public function fetchPrisons(){
        $str = "<option value='judge'>JUDGE</option>
        <option value='magistrate'>MAGISTRATE</option>
        ";
        $sql = "SELECT * FROM tblprison";
        $sel = $this->con->query($sql);
        while($r = $sel->fetch_assoc()){
            $str .= "<option value='" . strtolower($r['NAME']) . "'>" . strtoupper($r['NAME']) . "</option>"; 
        }
        return $str;
    }
    
    public function createPortalUser($username, $email, $center, $password){
        $keys = array('username', 'email', 'center', 'password');
        $vals = array($username, $email, $center, $password);
        $this->insert('portal_users', $keys, $vals);
        if($this->output['outcome'] == 'data inserted'){
            echo "<script>alert('operation successful'); window.location='user_form'</script>";
        }else{
            echo "<center> operation failed .. <br> user not created </center>";
            exit;
        }
    }
    
    public function fetchMonth(){
        parent::fetchMonths();
    }
    
   /* public function fetchYear(){
        parent::fetchYear();
    }*/
    
    public function generateReport($month, $year){
        $day = date('d');
        $month_ = date('m');
        $year_ = date('Y');
        $str = '';
        $one = 1; $two = 2;
        $sql  =  "SELECT ip.first_name, ip.last_name, ip.othername, ip.lcis_number AS ip_ln, ip.date_of_birth AS ipdob, ip.gender, ip.state_of_origin, ipo.Offence, ipo.Location_offence_committed
        , ipo.Date_Defendant_Arrested, ipn.Prison_name, ipn.IsDPPAdviceReady AS ISDPP, ipn.Date_Admission, ij.Last_adjourned_date, ij.next_hearing_date, ij.Trial_Court, 
        
        CASE 'ISDPP'
        WHEN 1 THEN 'Ready'
        WHEN 2 THEN 'unknown' 
        ELSE 'Not Ready'
        END AS DPPStatus,
        CASE 'ipdob'
        WHEN DAY(ip.date_of_birth) >= '$day' AND MONTH(ip.date_of_birth) >= '$month_'
        THEN YEAR(curdate()) - YEAR(ip.date_of_birth)
        ELSE YEAR(curdate() - 1) - YEAR(ip.date_of_birth) 
        END AS inmate_age
        
        FROM inmate_profile AS ip LEFT JOIN 
        inmate_police AS ipo ON ip.lcis_number = ipo.lcis_number LEFT JOIN inmate_prison AS ipn ON ip.lcis_number = ipn.lcis_number LEFT JOIN inmate_judiciary  
        AS ij ON ip.lcis_number = ij.lcis_number  ";
        if ($month != null && $year != null){
            $sql .= " WHERE MONTH(ipo.Date_Defendant_Arrested) = '$month' AND YEAR(ipo.Date_Defendant_Arrested) = '$year' ";
        }
        
       
        $sel = $this->con->query($sql) or die($this->con->error);
        if ($sel->num_rows > 0){
            while($r = $sel->fetch_assoc()){
                $arr = explode("," , $r['state_of_origin']);
                $offence = $this->getInmateOffence($r['ip_ln']);
            $str .= "<tr><td>Ministry OF Justice</td><td>" . $r['ip_ln'] . "</td><td>" . $r['first_name'] . "</td><td>" . $r['last_name'] . "</td><td>" . $r['othername'] .
            "</td><td>" . $r['inmate_age'] . "</td><td>" . $r['gender']  . "</td><td>" . $arr[0] . "</td><td>" . $arr[1] . "</td><td>" . $this->getInmateOffence($r['ip_ln']) . "</td><td>" . 
            $r['Location_offence_committed'] . "</td><td>" . $r['Date_Defendant_Arrested'] . "</td><td> </td><td>" . $r['Trial_Court'] . "</td><td>" . $r['DPPStatus'] . 
            "</td><td> </td><td>" . $r['Last_adjourned_date'] . "</td><td>" . $r['next_hearing_date'] . "</td><td>" . $r['Location_offence_committed'] . "</td></tr>"
            ;
            }
            
        }else{
            $str .= 'no data retrieved';
        }
        return $str;
        
    }
    
    public function updateInmateJudiciaryDetails($lcis_number){
        
    }
    
    public function fetchInmateJudiciaryDetails($lcis_number){
        
    }

}


?>
