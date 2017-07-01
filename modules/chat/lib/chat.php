<?php
# @Author: Oliver Bob R. Lagumen <oliverbob>
# @Date:   2017-06-21T09:41:14+08:00
# @Email:  oliverbob@facegod.us
# @Project: NameBrokers
# @Last modified by:   root
# @Last modified time: 2017-06-30T12:59:11+08:00



session_start();
header('Content-Type: application/json');
require_once('helpers.php');
//$id = str_rand(30, 'numeric');

// Please don't create sessions here, as it is not wise due to performance reasons.

$_SESSION['user_id']=6;

$user = $_SESSION['user_id'];
$rem = $_REQUEST['chatter_id']; // should be present in each request
$ses = $_SESSION['sess_id'];
$agentID = $_REQUEST['agentID'];
$brokerID = $_REQUEST['brokerID'];
$chatDomain = $_REQUEST['chatDomain'];
$email = $_REQUEST['email'];
$country = $_REQUEST['country'];
// Server variables
@$ip = $_SERVER['REMOTE_ADDR'];

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    @$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    @$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    @$ip = $_SERVER['REMOTE_ADDR'];
}

//var_dump($chatter_id);
//sleep(1);

$chat_id = $db->rawQuery(
    "
    SELECT  *
    FROM    chat
    WHERE	(
                receiver = ?
                AND sender=?
            )

    OR

            (
                receiver =?
                AND sender =?
            )

    ORDER BY sent DESC LIMIT 1
    ", array($user, $rem, $rem, $user)
);

if($_GET['action']=='pulse'){

    $unixtime = $_REQUEST['msg_id'];

    $start = date("Y-m-d h:i:s", $unixtime);

    if(cleanText($_REQUEST['msg_id'])==0){ //echo "adsf $chatter_id";
        $chats = $db->rawQuery(
            "
            SELECT  *
            FROM    chat
            WHERE	(
                        receiver = ?
                        AND sender=?
                    )

            OR

                    (
                        receiver =?
                        AND sender =?
                    )

            ORDER BY sent DESC
            ", array($user, $rem, $rem, $user)
        );

        $status = 0;

    } else {
        $chats = $db->rawQuery(
            "
            SELECT  *
            FROM    chat
            WHERE	(
                        receiver =?
                        AND sender =?
                        AND sent >?
                    )

            OR

                    (
                        receiver =?
                        AND sender =?
                        AND sent >?
                    )

            ORDER BY sent DESC
            ", array($user, $rem, $start, $rem, $user, $start)
        );

        $status = 1;
    }

    $body = array();

    $img1 = $basename."/domains/modules/chat/assets/troy.png";
    $img2 = $basename."/domains/modules/chat/assets/default-avatar.jpg";
    if ($db->count > 0){
        $count = 0;
        foreach ($chats as $chat) {
            // replace $id to table id from the database later.
            // dotted can also serve as separator between chat sessions

            //if($chat[sender]==$user){
                //$db->where ("user_id", $chat[receiver]);
            //} else {
                $db->where ("user_id", $chat[sender]);
            //}

            $user = $db->getOne ("user");
            $name = $user['user_first_name'];





            if($name=="Troy"){
                $name = 'NameBrokers';
            } else {
                $name = 'Visitor';
            }

            /*if ($user->count > 0){
                $name = "test";
            }*/

            if($_SESSION['agentusername'] && $chat[sender]==6){
                //$img1 = $basename."/domains/modules/chat/assets/".$_SESSION['agentusername'].".jpg";
            } /*else {
                $img1 = $basename."/domains/modules/chat/assets/".$chat['agentusername'].".jpg";
            }*/

            $body[] = '
            <div class="chat_message '.$chat[id].'">
                <div class="chat-box-single-line">
                    <abbr class="timestamp">'.$chat[sent].'</abbr>
                </div>

                <div class="direct-chat-msg '.($count==0 ? '' : 'doted-border').'">

                    <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">'.$name.'</span>
                    </div>

                    <img alt="avatar" src="'.($chat[sender]==6 ? $img1 : $img2).'" width="50" class="direct-chat-img big-round">
                    <div class="direct-chat-text">
                        '.decodeClean($chat[message]).'
                    </div>
                    <div class="direct-chat-info clearfix">
                        <span class="direct-chat-timestamp pull-right">'.date('D h:i A', strtotime($chat[sent])). " Country : " . $chat[country] .'</span>
                        <br /><br />
                    </div>

                </div>
            </div>
            ';
            $count++;
        }
    }

    $last_id = strtotime($chat_id[0][sent]);

    if($last_id==false){
        $last_id = 0;
    }
    // var_dump($chat_id);

    echo json_encode(array('message' => array_reverse($body), 'id' => $last_id, 'avatname'=>$chat[domain], 'ip'=>$chat[ip], 'status'=>$status));
}

/*if($user !=6){ // if visitor
    $sql = "select * from chat WHERE receiver = ? AND sender = ? AND sess_id=? ORDER by sent DESC LIMIT 1";
    $chatses = $db->rawQuery($sql, array($user,$rem, $ses)); // get last session from last message by sender
}*/

if($_GET['action']=='sendchat'){
    $data = Array ("id" => str_rand(30, 'numeric'),
                   "sender" => $user,
                   "receiver" => $rem,
                   "message" => cleanText($_REQUEST['msg']),
                   "with_attachment" => '',
                   "with_link" => '',
                   "sent" => gmdate('Y-m-d H:i:s'),
                   "seen" => 0,
                   "checked" => 0,
                   "sess_id" => ($user== 6 ? $rem : $ses),
                   "domain" => $chatDomain,
                   "broker_id" => $brokerID,
                   "agent_id" => $agentID,
                   "email" => $email,
                   "country" => $country,
                   "ip" => $ip/*,
                   "agentusername" => $_SESSION['agentusername'] ? $chat[agentusername] : 0*/
                   // if sender is user
    );

    $id = $db->insert ('chat', $data);
    if($id){

        $db->orderBy("sent","DESC");
        $db->where ("user_id", $rem);


        /*$chat_id = $db->rawQuery(
            "select * from chat WHERE receiver = ? AND sender = ? ORDER by sent DESC LIMIT 1",
            array($user, $rem));


        $chat_id = $db->get('chat', 1);*/
        $last_id = strtotime($chat_id[0][sent]);

        if($last_id==false){
            $last_id = 0;
        }

        if ($db->count > 0){
            echo json_encode(array('message' => '', 'id' => $last_id, 'data'=>$data));
        } else {
            echo 0;
        }

    } else {
        echo 0;
    }

}

if($_GET['action']=='latest'){

    $body = array();

    // Make the date become what is required by the client

    $unixtime = cleanText($_REQUEST['msg_id']);
    $date = $time = date("Y-m-d h:i:s", $unixtime);

    $sql = "
    SELECT  *
    FROM    chat
    WHERE	(
                receiver IN (SELECT user_id FROM user where user_id=1)
                AND sender IN (SELECT user_id FROM user where user_id=6)
                AND sent>=(SELECT sent FROM chat WHERE sent = '2017-06-08 00:02:00')
            )

    OR

            (
                receiver IN (SELECT user_id FROM user where user_id=6)
                AND sender IN (SELECT user_id FROM user where user_id=1)
                AND sent >= (SELECT id FROM chat WHERE sent = '2017-06-08 00:02:00')
            )

    ORDER   BY sent DESC

    -- No limit should be good because 1000 new messages though possible is illogical :D
    -- Appending these results to the bottom of conversation is logical
    -- Called after insert, and sent to client for a fresh message starting from and with this salt ID
    ";

    // This is the chat template body in action
    $db->orderBy("sent","DESC");
    $chats = $db->get('chat', 1); //contains an Array 10 chats




    if ($db->count > 0){
        $count = 0;
        foreach ($chats as $chat) {
            // replace $id to table id from the database later.
            // dotted can also serve as separator between chat sessions

            $db->where ("user_id", $chat[sender]);
            $user = $db->getOne ("user");
            $sender = $user['user_first_name'];

            $body[] = '
            <div class="chat_message '.$chat[id].'">
                <div class="chat-box-single-line">
                    <abbr class="timestamp">'.$chat[sent].'</abbr>
                </div>
                <div class="direct-chat-msg '.($count==0 ? '' : 'doted-border').'">
                <div class="chat_message">
                    <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left">'.$sender.'</span>
                </div>
                <!-- /.direct-chat-info -->
                <img alt="avatar" src="'.$basename.'/domains/modules/chat/assets/troy.png" width="50" class="direct-chat-img big-round"><!-- /.direct-chat-img -->

                <div class="direct-chat-text">
                    '.decodeClean($chat[message]).'
                </div>

                <div class="direct-chat-info clearfix">
                    <span class="direct-chat-timestamp pull-right">09:58 AM</span>
                </div>

                <div class="direct-chat-info clearfix">
                    <img alt="avatar" src="../assets/caren.jpg" width="50" class="direct-chat-img big-round">
                    <span class="direct-chat-reply-name">...</span>
                </div>
                <!-- /.direct-chat-text -->

                </div>
            </div>
            ';
            $count++;
        }
    }

    $last_id = strtotime($chat_id[0][sent]);

    echo json_encode(array('message' => $body, 'id' => $last_id));


}

?>
