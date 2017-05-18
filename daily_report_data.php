<?php 
require_once('helpers/MysqliDb.php');

//echo $_GET['date'];

$new_date=$_GET['date'];



//$getData = dbFetchAll("SELECT u.table_id,u.broker_id,u.agent_id,u.invitation_status,u.timestamp,u.website,u.company_name,u.first_name,u.last_name,u.email,u.active_on,u.invited_on FROM user_invitation u WHERE active_on LIKE '%$new_date%' AND invitation_status = 'active' LIMIT 20 ");


$getData = $db->rawQuery("SELECT * FROM user_invitation u WHERE active_on LIKE '%$new_date%' AND invitation_status = 'active' LIMIT 20 ");

//$payload['data'] = $getData;

//echo "<pre>".print_r($getData,1)."</pre>";
//$array = $getData;
	//echo "<pre>".print_r($obj,1)."</pre>";
echo json_encode(
	$getData
	
);

