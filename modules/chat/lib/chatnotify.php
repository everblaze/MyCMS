<?php
# @Author: Oliver Bob R. Lagumen <oliverbob>
# @Date:   2017-06-21T08:32:53+08:00
# @Email:  oliverbob@facegod.us
# @Project: NameBrokers
# @Last modified by:   root
# @Last modified time: 2017-06-30T15:07:48+08:00



header('Content-Type: application/json');
require_once('helpers.php');
$id = str_rand(30, 'numeric');

// Please don't create sessions here, as it is not wise due to performance reasons.
session_start();

$user = $_SESSION['user_id'];
$ses = $_SESSION['sess_id'];

//var_dump($chatter_id);
//sleep(1);

if($_GET['action']=='pulse'){

    $unixtime = $_REQUEST['msg_id'];

    $start = date("Y-m-d h:i:s", $unixtime);

     $query = "SELECT m.*
         from
           chat m
           inner join (
                 select max(id) as maxid
                 from chat
                 where chat.sender = ?
                 OR chat.receiver = ?
                 group By (if(sender > receiver,  sender, receiver)),
                 (if(sender > receiver,  receiver, sender))
                ) t1 on m.id=t1.maxid";

    if(cleanText($_REQUEST['msg_id'])==0){ //echo "adsf $chatter_id";
        $chats = $db->rawQuery($query, array($user,$user)
        );

    }

    $body = array();

    $img1 = $basename."/domains/modules/chat/assets/default-avatar.jpg";
    $img2 = $basename."/domains/modules/chat/assets/troy.png";

    /*function sortByOrder($a, $b) {
      return $a['unixtimestamp'] - $b['unixtimestamp'];
    }

    usort($chats, 'sortByOrder');*/

    if ($db->count > 0){
        $count = 0;
        foreach ($chats as $chat) {
            // replace $id to table id from the database later.
            // dotted can also serve as separator between chat sessions

            if($chat[sender]==$user){
                $db->where ("user_id", $chat[receiver]);
                $row_id = $chat['receiver'];

                $mode = "&#10548;";
                //$img = $img2;
            } else {
                $db->where ("user_id", $chat[sender]);
                $row_id = $chat['sender'];
                $mode = "&crarr;";
                //$img = $img1;
            }

            $user = $db->getOne ("user");
            $name = $user['user_first_name'];


            if($name=="Troy"){
                $name = 'NameBrokers';
            } else {
                $name = 'Visitor';
            }

            // $db->where ("id", $chat[id]);
            // $chat_id = $db->getOne('chat'); //contains an Array 10 chats

            $body[] = '

            <li class="'.$row_id.'" onclick="createChatWindow(\''.$row_id.'\');">


              <a class="addClass '.$row_id.'">
                <span class="image"><img src="'.$img1.'" alt="Profile Image" /> '.$mode.'</span>
                <span>
                  <span>'.$name.'</span>
                  <span class="time"> '.$chat[sent].'</span>
                </span>
                <span class="message">
                  '.shorten($chat[message]).'
                </span>
              </a>
            </li>
            ';
            $count++;
        }
    }

    $body[] = '<li>
                  <div class="text-center">
                    <a>
                      <strong>See All Alerts</strong>
                      <i class="fa fa-angle-right"></i>
                    </a>
                  </div>
                </li>
                <li style="display: none;">
                </li>';

    //echo "<pre>".print_r ($chat, 1);"</pre>";

    $chat_id = $db->rawQuery($query, array($user,$user,$user,$user));
    $last_id = strtotime($chat_id[0][sent]);
    // var_dump($chat_id);

    echo json_encode(array('message' => $body, 'id' => $chats[0]['id'], 'ses' => $chats[0]['sess_id'], 'chatter'=>$row_id));
}
?>
