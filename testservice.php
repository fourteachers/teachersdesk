<?php


$service_name=$_REQUEST['service_name'];

if ($service_name=='subjects')
{
subject_service();

}

function subject_service()

{
	
$subjects=array('key_1'=>'Math','key_1'=>'Science','key_2'=>'History','key_3'=>'English','key_4'=>'Social Studies');

echo json_encode($subjects);


}


?>