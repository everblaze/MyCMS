<?php 
require_once('helpers/MysqliDb.php');

$new_date=$_GET['date'];
$status=$_GET['status'];


if($status == 'active'){

	$getData = $db->rawQuery("SELECT (@cnt := @cnt + 1) AS registration_count, 
    u.table_id,
    u.broker_id,u.agent_id,
    u.invitation_status,
    u.website,
    u.company_name,
    u.first_name,
    u.last_name,
    u.email,
    u.active_on,
    u.invited_on, 
	(COUNT(t.user_id) - SUM(case when t.track_type = 'mail-open' then 1 else 0 end)) AS mail_click,
	 SUM(case when t.track_type = 'mail-open' then 1 else 0 end) mail_open
	 FROM user_invitation u 
	 LEFT JOIN invite_tracker t on u.agent_id=t.user_id
	 CROSS JOIN (SELECT @cnt := 0) AS dummy
     WHERE t.user_id = u.agent_id 
     AND active_on LIKE '%$new_date%' AND invitation_status = '$status'  GROUP BY t.user_id DESC");


} else {

	$getData = $db->rawQuery("SELECT (@cnt := @cnt + 1) AS registration_count, 
	    u.table_id,
	    u.broker_id,
	    u.agent_id,
	    u.invitation_status,

	    u.website,
	    u.company_name,
	    u.first_name,
	    u.last_name,
	    u.email,
	    u.active_on,
	    u.invited_on,
		(COUNT(t.user_id) - SUM(case when t.track_type = 'mail-open' then 1 else 0 end)) AS mail_click,
	    SUM(case when t.track_type = 'mail-open' then 1 else 0 end) mail_open
	    FROM user_invitation u 
	    LEFT JOIN invite_tracker t on u.agent_id=t.user_id
	    CROSS JOIN (SELECT @cnt := 0) AS dummy
	    WHERE t.user_id = u.agent_id
	    AND active_on LIKE '%$new_date%' AND invitation_status = '$status' GROUP BY t.user_id  

	    UNION 

	    (SELECT (@cnt := @cnt + 1) AS registration_count,
	        u.table_id,
	        u.broker_id,
	        u.agent_id,
	        u.invitation_status,
	        u.website,
	        u.company_name,
	        u.first_name,
	        u.last_name,
	        u.email,
	        u.active_on,
	        u.invited_on,
		'0' AS mail_click,
	    '0' mail_open
	    FROM user_invitation u
	    CROSS JOIN (SELECT @cnt := 0) AS dummy
	    WHERE u.agent_id NOT IN 

	    	(SELECT t.user_id FROM invite_tracker t WHERE user_id = u.agent_id) 
	    AND invited_on LIKE '%$new_date%' AND invitation_status = '$status' ORDER BY u.invited_on DESC)");

}

echo json_encode(
	$getData
);



