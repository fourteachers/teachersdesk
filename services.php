<?php

extract($_REQUEST);
$url='http://fourteachers-thedesk.herokuapp.com/';

switch($service)
{
case 'subjects':

	$url.='subjects?grade='.$grade;
break;

case 'elps':

if (isset($section) && $section !='')
{
	$url.='elps?section='.$section;
}
else
{
	$url.='elps';
}
break;

case 'teks':



$url.='teks?grade='.$grade.'&subject='.$subject;

if (isset($search) && $search !='')
{
		$url.='&search='.$search;
}
break;

}


$return_data=file_get_contents($url);

echo $return_data;

?>