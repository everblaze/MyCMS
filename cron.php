<?php
require_once('helpers/MysqliDb.php');

$null = null;
$data = Array ("id" => $null ,
               "firstName" => "John",
               "lastName" => 'Doe',
               "timestamp" => date('Y-m-d H:i:s')
);

$id = $db->insert ('test', $data);

if($id){
  echo "Success!";
} else {
  echo "No success!";
}
?>
