/**
 * @Author: Oliver Bob Lagumen
 * @Date:   2017-05-13 09:58:30
 * @Last modified by:   root
 * @Last modified time: 2017-06-30T09:06:41+08:00
 */

window.chatbox_count = 0;
window.chatbox = [];
window.chatboxes = [];
window.last_chat_sess_id = 0;
window.chat_update_history = [];

function increment_chatWin(chatwindow){
    //window.chatbox_count ++;
    window.chatbox.push(chatwindow);
    return chatwindow_count;
};

var chatboxes = new Array();

function restructureChatBoxes() { //alert(window.chatbox.length);
    var align = 0;

    counter = 0;
    for (x in window.chatbox) {
        chatwindow = window.chatbox[x];

        if ($('#chatbox_'+chatwindow).css('display') != 'none') {

            // if(window.chatbox.includes(chatwindow)){
            //     alert(chatwindow);
            // }
            if (align == 0) {
                $('#chatbox_'+chatwindow).css('right', '20px');
            } else {
                if(window.chatbox.length !=null){
                    width = (window.chatbox.length < counter ? (align)*(300+7)+20 : (align)*(300+7)+20 );
                }

                $('#chatbox_'+chatwindow).css('right', width+'px');
            }
            align++;
        }
        //alert(counter);

        counter++;
    }
}

function getLastObj(o){
    return o[o.length -1];
};

function createChatWindow(chatwindow){

    if(!(chatwindow in window.chatboxes)){
        var obj = {
            chatbox : chatwindow,
            start_id : 0,
            time : 6000,
            delta: 1000
        };

        window.chat_update_history[chatwindow] = [];
        window.chatboxes[chatwindow] = []; // new array
        window.chatboxes[chatwindow].push(obj); // default value
        //var last_item = o[o.length -1];

        //console.log(o[o.length -1]);
        //console.log(o.indexOf(chatwindow) === -1);
        //console.log(last.chatbox);


        //console.log(window.chatboxes);

        //alert(window.chatbox.includes(chatwindow));

        window.chatWindow = chatwindow;
        if(!window.chatbox.includes(chatwindow)){
            window.chatbox.push(chatwindow);
            //alert(window.chatbox.includes(chatwindow));
            var chatWindow = "<div class=\"popup-box chat-popup "+chatwindow+"\" id=\"chatbox_"+chatwindow+"\">\r\n    <div class=\"popup-head\">\r\n        <div class=\"popup-head-left pull-left\"><img align=\"left\" hspace=\"10\" src=\"https:\/\/facegod.us\/mycms\/modules\/chat\/assets\/default-avatar.jpg\" width=\"20\" alt=\"useractive\"> <div class=\"avatname avatar-name\">...<\/div>\r\n        <\/div>\r\n        <div class=\"popup-head-right pull-right\">\r\n            <div class=\"btn-group\">\r\n                 <\/div>\r\n            <i class=\"glyphicon glyphicon-remove\" id=\"removeClass\"><\/i>\r\n        <\/div>\r\n    <\/div>\r\n    <div class=\"popup-messages\">\r\n        <div class=\"direct-chat-messages\"><\/div>\r\n    <\/div>\r\n    <div class=\"popup-messages-footer\">\r\n        <div class=\"textareadiv\">\r\n          <textarea onkeyup=\"textAreaAdjust(event,this,'"+chatwindow+"')\" style=\"overflow-x:hidden\" id=\"status_message\" placeholder=\"Type a message...\" rows=\"10\" cols=\"40\" name=\"message\"><\/textarea>\r\n        <\/div>\r\n        <div class=\"btn-footer\">\r\n            <button class=\"bg_none\"><i class=\"fa fa-film\"><\/i> <\/button>\r\n            <button class=\"bg_none\"><i class=\"fa fa-camera\"><\/i> <\/button>\r\n            <button class=\"bg_none\"><i class=\"fa fa-paperclip\"><\/i> <\/button>\r\n            <button class=\"bg_none pull-right\"><i class=\"fa fa-thumbs-up\" aria-hidden=\"true\"><\/i> <\/button>\r\n        <\/div>\r\n\r\n    <\/div>\r\n<\/div>";
            $('body').prepend(chatWindow);

            $('#chatbox_'+chatwindow).addClass('popup-box-on');

            /*chatboxeslength = 0;

        	for (x in chatbox) {
        		if ($("#chatbox_"+chatbox[x]).css('display') != 'none') {
        			chatboxeslength++;
        		}
        	}

        	if (chatboxeslength == 0) {
        		$('#chatbox_'+chatwindow).css('right', '20px');
        	} else {
        		width = (chatboxeslength)*(300+7)+20;
        		$('#chatbox_'+chatwindow).css('right', width+'px');
        	}*/

            $("."+chatwindow+" textarea").focus();

            $(".addClass "+chatwindow).click(function () {
                $('#chatbox_'+chatwindow).addClass('popup-box-on');
            });



            $('#chatbox_'+chatwindow+" #removeClass").click(function () {
                window.chatbox.pop(chatwindow);
                delete window.chatboxes[chatwindow];
                delete window.chat_update_history[chatwindow];
                $('#chatbox_'+chatwindow).remove();
                restructureChatBoxes();
                //alert(window.chatbox.includes(chatwindow));
            });

            $('.textareadiv').css("border-bottom-color", "#fff");

            var currentMargin = $('.chatbox_'+chatwindow).css('right');

            var chatWidth = $('.chatbox_'+chatwindow).width();



            restructureChatBoxes();
            updateChat(chatwindow, 0);

        }



    }
};

if(document.location.hostname == "localhost"){
    var apiUrl = '//' +document.location.hostname + '/name-brokers/public_html/domains/modules/chat/lib/';
} else {
    var apiUrl = '//' +document.location.hostname + '/domains/modules/chat/lib/';
}

function _getlastCSID(array){
    if (!isItemInArray(window.chat_update_history[array[0]], array)) {
        window.chat_update_history[array[0]].push(array);
    }
    return array;
};

function isItemInArray(array, item) {
    for (var i = 0; i < array.length; i++) {
        // This if statement depends on the format of your array
        if (array[i][0] == item[0] && array[i][1] == item[1]) {
            return true;   // Found it
        }
    }
    return false;   // Not found
}

window.onblur = function() { window.blurred = true; };
window.onfocus = function() { window.blurred = false; };


function loop(){
   time--;
   //$('.timer').text(window.time);

   if (window.time <=0 ) {
       clearInterval(window.interval);
   }

}

$(document).on('mousemove', function() {
    clearInterval(window.interval);
    window.time=60*60;
    window.interval = setInterval(loop, 1000)
});

function deltaCheck(chatbox, start_id){ // finite increment/looper

    var last_item = getLastObj(window.chatboxes[chatbox]);

    if(last_item.start_id != start_id && $('.'+chatbox).length){ // check if this chatbox exists

        var new_obj = {
            chatbox : chatbox,
            start_id : start_id,
            time : 60000 * 60,
            delta: 2000
        };

        window.chatboxes[chatbox].push(new_obj);
        window.chatboxes[chatbox][start_id] = []; // push the chatboxes array

        /*window['chatboxes'][chatbox][start_id].start_id = start_id, // include the start_id
        window['chatboxes'][chatbox][start_id].time = 60000 * 60, // one hour
        window['chatboxes'][chatbox][start_id].delta = 1000, // request every 3 seconds in given time.
        window['chatboxes'][chatbox][start_id].tid = setInterval(function() {

            if (new_obj.time > 0) { // countdown
                new_obj.time -= new_obj.delta;
            }

            if (new_obj.time <= 0) {
                new_obj.time = 0;
                clearInterval(window['chatboxes'][chatbox][start_id].tid);
                //console.log(new_obj.time);
                updateChat(chatbox, start_id);
            } else {
                //if(window.time>0){
                    updateChat(chatbox, start_id);
                //}
            }

        }, new_obj.delta);*/

        if(window.time>0){
            setInterval(function() {
                updateChat(chatbox, start_id);
            }, 2000);
        }
    }
}

function updateChat(chatbox, start_time){

    if ($('#chatbox_'+chatbox).length) {
        $.ajax({
            type: "POST",
            url: apiUrl+"chat.php?action=pulse&req="+new Date(),
            data: {chatter_id : chatbox, msg_id : start_time},
            cache: false,
            dataType: 'json',
            //timeout: 1000,
            beforeSend: function(){
                //$('.'+chatbox).find('.direct-chat-messages').append('<span class="ajax-loader"><span class="direct-chat-img-reply-small pull-left" style="margin:10px;"></span>');
            },
            success: function (data) {
                //$('.ajax-loader').hide();

                if(window.chat_update_history[chatbox]!=undefined){
                    if (!isItemInArray(window.chat_update_history[chatbox], [chatbox, data.id])) {

                        if(data.avatname!=null){
                            $('.'+chatbox+' .avatname').html(data.avatname);
                        }

                        $('.'+chatbox+' .direct-chat-messages').append(data.message); //updates the output to a div
                        //$('.'+chatbox+' .'+data.id).append(data.id);
                        var chatbody = $('.'+chatbox+' .popup-messages');
                        var height = chatbody[0].scrollHeight;
                        chatbody.scrollTop(height);

                        deltaCheck(chatbox, data.id);
                        _getlastCSID([chatbox, data.id]);
                    }
                }
            },
            error: function(){
              $('.'+chatbox+' .direct-chat-messages').append('<br />error!');
              //$('.ajax-loader').hide();
            }
        });
    }
}

function sendMsg(receiver, msg){ //console.log(receiver);
    var start_id = getLastObj(window.chatboxes[receiver]).start_id;
    $.ajax({
        type: "POST",
        url: apiUrl+"chat.php?action=sendchat&req="+new Date(),
        jsonpCallback: 'MyJSONPCallback',  // specify the callback name if you're hard-coding it
        crossDomain: true,
        data: {chatter_id : receiver, msg : msg},
        cache: false,
        dataType: 'json',
        //timeout: 1000,
        beforeSend: function(){
            //$('.direct-chat-messages').append('<span class="ajax-loader">Loading... <img src="../assets/ajax-loader.gif" /></span>');
        },
        success: function (data) {
            var chatbody = $('.'+receiver+' .popup-messages');
            var height = chatbody[0].scrollHeight;
            chatbody.scrollTop(height);

            var obj = {
                chatbox : receiver,
                start_id : data.id,
                time : 6000,
                delta: 1000
            };

            window.chatboxes[receiver].push(obj);
        },
        error: function(){
            //$('.ajax-loader').hide();
            $('.'+receiver+' .direct-chat-messages').append('<p color="red">NETWORK ERROR!</p> <p>Please <a href="javascript:void(0);" id="resend">click hereto retry</a> </p>');
            $('.'+receiver+' #resend').click(function(e){
                e.preventDefault();
                sendMsg(receiver, msg);
            });

        }
    });
}

function textAreaAdjust(e, o, s) {

    var current = 270;
    //o.style.height = "50px";
    //o.style.height = (10+o.scrollHeight)+"px";
    var textarea = o;
    $(textarea).focus();
    //$(textarea).css('height','25px');
    var adjustedHeight = textarea.clientHeight;
    var maxHeight = 90;

    if(e.keyCode == 13 && e.shiftKey == 0)  {

		var message = $(textarea).val();
		//message = message.replace(/^\s+|\s+$/g,""); // Original
		//intentional breaks must be replaced:
		//message = message.replace(/<br[^>]*>/gi, ""); // sanitize breaks so that it convert breaks to empty spaces
		message = message.replace(/\n/g, '<br />'); // replace newlines to break

		if (message != '') {
			//message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
            //message = nl2br(str, is_xhtml);
			sendMsg(s, message);
		}

        $(textarea).val('');
        $(textarea).focus();
        $(textarea).css('overflow','auto');
        $(textarea).css('height','50px');

	}

    if (maxHeight > adjustedHeight) {

        adjustedHeight = Math.max(textarea.scrollHeight, adjustedHeight);

        if (maxHeight){
            adjustedHeight = Math.min(maxHeight, adjustedHeight);
        }

        if (adjustedHeight > textarea.clientHeight){
            $(textarea).css('height', (o.scrollHeight)+"px");
            $(textarea).css('overflow','auto');
            $(textarea).css('margin-right','0px');
        }

        $('.'+s+' popup-messages').css('height',(current-(adjustedHeight)+50)+'px');
        $(textarea).css('margin-top', '-'+(adjustedHeight-50)+"px");

    } else {
        $(textarea).css('overflow','auto');
    }

    if($(textarea).val()==''){
        $(textarea).css('margin-top','0px');
        $(textarea).css('height','50px');
    }
}

$(function(){
	createChatWindow(7);
});
