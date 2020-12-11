<?php
ob_start();
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    include "htmlhead.php";
    include('../model/authen.php');

?>

<div class="form-group" style="margin:100px 30px 30px 30px;  ">
    <center><input class="form-control" style="height:50px; width:50%; border-radius:12px; padding:5px 10px 5px 10px;" id="lcisno" name="lcisno" onkeyup="fetchRecord()" placeholder='Enter LCIS Number e.g "lcis/0000/111111"'></center>
</div>

<h3 class="text-center">SEARCH RESULT</h3>

<div id="tableholder" >
    
</div>


<br>
<center><a href='index' class='btn btn-info'>Back</a></center>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



<script>
function fetchRecord(){
var obj = new XMLHttpRequest();
var inp = document.getElementById('lcisno');
obj.onreadystatechange = function(){
if (obj.readyState == 4){
    console.log('ready to receive response')
document.getElementById('tableholder').innerHTML = this.responseText;
console.log(obj.responseText);
}
}
obj.open('GET', '../model/ajax_fetch.php?lcis_number=' + inp.value, true);
obj.send(null);
}
</script>

<script>
    function deleteprof(x){
	swal({
		text: "ARE YOU SURE YOU WANT TO DELETE THIS PROFILE",
// 		text: "Create an account to Access this page!",
		icon: "warning",
		buttons: ["NO", "YES"],
		//dangerMode: true,
		
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			window.location = "../model/delete.php?lcis_number="+ x;
		} else {
// 			window.location = "../model/delete.php?lcis_number="+ x;
		}
	});
}
</script>
</body>
<?php ob_end_flush(); ?>