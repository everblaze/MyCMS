<?php
/**
 * @Author: Oliver Bob Lagumen
 * @Date:   2017-05-13 09:58:30
 * @Last Modified by:   Oliver Bob  Lagumen
 * @Last Modified time: 2017-05-19 13:41:18
 */

require_once('helpers/MysqliDb.php');

/*$cols = Array (
    "invited_on", 
    "active_on"
    );*/

//$db->where ("active_on", "GROUP BY DATE(active_on)");
//$users = $db->get ("user_invitation", 2, $cols);

@$status = $_GET['status'];

if($status=='pending'){

	$users = $db->rawQuery('SELECT COUNT(u.invited_on) AS active, 
		DATE(u.invited_on) AS invited_on 
		FROM user_invitation u 
		WHERE invitation_status = "pending"
		GROUP BY DATE(u.invited_on)'
	);

} else {
	$users = $db->rawQuery('SELECT COUNT(u.active_on) AS active, 
		DATE(u.active_on) AS active_on 
		FROM user_invitation u 
		WHERE invitation_status = "active"
		GROUP BY DATE(u.active_on)'
	);
}

//echo "<pre>".print_r($users, 1)."</pre>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

	<!-- <link rel="stylesheet" type="text/css" href="src/js/mod/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css"> -->
	
	<link rel="stylesheet" type="text/css" href="src/js/mod/footable/css/footable.bootstrap.min.css">

	<!-- Timepicker  -->
	<link rel="stylesheet" type="text/css" media="screen" href="src/js/mod/bootstrap-4.0.0-alpha.6-dist/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="src/js/mod/bootstrap-4.0.0-alpha.6-dist/plugins/datetimepicker/css/bootstrap-datetimepicker-standalone.css">

	<!-- Chat Interface -->
	<link rel="stylesheet" type="text/css" href="assets/css/chat.css">


	<script type="text/javascript" src="src/js/require.js" data-main="src/js/main.js"></script>

</head>
    <body onload="onBodyLoaded()">
    <div class="container row content" style="margin:10px;">
        <h1>jQuery+RequireJS MyCMS</h1>
        <p>Look at source or inspect the DOM to see how it works.</p>
    </div>
<h3 style="margin-left: 20px">Set Range</h3>
<form id="clearTable">
	<div class='input-group date' id='date-pick' style="width: 200px;margin-left:20px;margin-top: 20px" >

	    <input type='date' id="datePick" class="form-control" name="date1"/>
	    <span class="input-group-addon">
	        <span class="glyphicon glyphicon-calendar"></span>
	    </span>
	</div>
	<div class='input-group date' id='date-pick2' style="width: 200px;margin-left:20px;margin-top: 20px">

	    <input type='date' id="datePick2" class="form-control" name="date2" />
	    <span class="input-group-addon">
	        <span class="glyphicon glyphicon-calendar"></span>
	    </span>
	</div>
</form><br>

<script>

function onBodyLoaded() {
    require(["app"], function (app) {

	/*require('bootstrap');
    require('require-jquery');
	require('moment');
	require('footable');
    require('datetimepicker');*/

    require('moment');
    //require('datetimepicker');



        $('#date-pick, #date-pick2').datetimepicker({
            //daysOfWeekDisabled: [0, 0]
        });

        app.init();



		<?php

		if ($db->count > 0){
			$count = 0;
		    foreach ($users as $user) { $date = $status =='pending' ? $user['invited_on'] : $user['active_on'];



				echo "


				$('body').append(\"<a href='#' style='margin-left:20px; font-size;' class='export_$count btn btn-success'>Export Table data into Excel</a> <b>{$user['active']} $status on $date</b>\"+
				\"<div id='dvData_$count'>\"+
					\"<table class='footable_$count table table-striped footable-filtering footable-filtering-right  breakpoint-lg' style='display: table;' data-page-size='10'>\"+
					\"</table>\"+
				\"</div>\");
				jQuery(function($){
					var apiUrl = 'daily_report_data.php?date=$date&status=$status';
					$('.footable_$count').footable({
						'toggleColumn': 'first',
						'expandFirst': true,
						'columns': 
						[
							{ 'name': 'registration_count','title':'Registration Count','style':{'maxWidth':200,'overflow':'hidden','textOverflow':'ellipsis','wordBreak':'keep-all','whiteSpace':'nowrap'}}, // 5					
							//{ 'name': 'table_id','title': 'ID' ,'breakpoints':'xs sm','type':'text','style':{'width':250,'maxWidth':250}}, // 0
				            //{ 'name': 'broker_id','title':'BrokerID','breakpoints':'xs sm'}, // 1
				            //{ 'name': 'agent_id','title':'AgentID','breakpoints':'xs sm'}, // 2
				            //{ 'name': 'website' ,'title':'Website','breakpoints':'xs sm','style':{'maxWidth':250,'overflow':'hidden','textOverflow':'ellipsis','wordBreak':'keep-all','whiteSpace':'nowrap'}}, // 3
				            //{ 'name': 'company_name','title':'Company Name','breakpoints':'xs sm','style':{'maxWidth':200,'overflow':'hidden','textOverflow':'ellipsis','wordBreak':'keep-all','whiteSpace':'nowrap'}}, // 4
				            { 'name': 'first_name','title':'First Name','style':{'maxWidth':200,'overflow':'hidden','textOverflow':'ellipsis','wordBreak':'keep-all','whiteSpace':'nowrap'}}, // 5
				            { 'name': 'last_name','title': 'last Name','style':{'maxWidth':200,'overflow':'hidden','textOverflow':'ellipsis','wordBreak':'keep-all','whiteSpace':'nowrap'}}, // 6
				            { 'name': 'email','title':'Email','breakpoints':'xs sm','style':{'maxWidth':200,'overflow':'hidden','textOverflow':'ellipsis','wordBreak':'keep-all','whiteSpace':'nowrap'}}, // 7
				            { 'name': 'invitation_status','title':'Status','breakpoints':'xs sm','style':{'maxWidth':200,'overflow':'hidden','textOverflow':'ellipsis','wordBreak':'keep-all','whiteSpace':'nowrap'}}, // 9
				            { 'name': 'invited_on','title': 'Invited on','type':'date','breakpoints':'xs sm','formatString':'DD MMM YYYY'}, // 10
				            { 'name': 'active_on','title': 'Activated on','type':'date','breakpoints':'xs sm','formatString':'DD MMM YYYY'},
				            { 'name': 'mail_open','title': 'Mail Opened','type':'date','breakpoints':'xs sm','formatString':'DD MMM YYYY'}, // 11 // 11
				            { 'name': 'mail_click','title': 'Mail Clicked','type':'date','breakpoints':'xs sm','formatString':'DD MMM YYYY'} // 11
						],
						'paging': {
							'enabled' : true,
							'size': 20
						},
						'filtering' : {
							'enabled' : true
						},
						'sorting': {
							'enabled': true
						},
						'rows': $.ajax({
							url: apiUrl,
							dataType: 'json',
							size: 20
						})
					});




					// This must be a hyperlink
					  $('.export_$count').on('click', function(event) {
					    // CSV
					    var args = [$('#dvData_$count>table'), 'export.csv'];

					    exportTableToCSV.apply(this, args);

					    // If CSV, don't do event.preventDefault() or return false
					    // We actually need this to be a typical hyperlink
					  });
				});




					/*var ftbl = FooTable.get('.footable_$count');
					ftbl.use(FooTable.Paging).size = '20';
					ftbl.draw();*/



				";
				$count++;
		    }
		}



		?>

		$(function(){
			$("#addClass").click(function () {
				$('#qnimate').addClass('popup-box-on');
			});

			$("#removeClass").click(function () {
				$('#qnimate').removeClass('popup-box-on');
			});
		});

	});




} // onBodyLoaded()

function exportTableToCSV($table, filename) {

    var $rows = $table.find('tr:has(td)'),

      // Temporary delimiter characters unlikely to be typed by keyboard
      // This is to avoid accidentally splitting the actual contents
      tmpColDelim = String.fromCharCode(11), // vertical tab character
      tmpRowDelim = String.fromCharCode(0), // null character

      // actual delimiter characters for CSV format
      colDelim = '","',
      rowDelim = '"\r\n"',

      // Grab text from table into CSV formatted string
      csv = '"' + $rows.map(function(i, row) {
        var $row = $(row),
          $cols = $row.find('td');

        return $cols.map(function(j, col) {
          var $col = $(col),
            text = $col.text();

          return text.replace(/"/g, '""'); // escape double quotes

        }).get().join(tmpColDelim);

      }).get().join(tmpRowDelim)
      .split(tmpRowDelim).join(rowDelim)
      .split(tmpColDelim).join(colDelim) + '"';

    // Deliberate 'false', see comment below
    if (false && window.navigator.msSaveBlob) {

      var blob = new Blob([decodeURIComponent(csv)], {
        type: 'text/csv;charset=utf8'
      });

      // Crashes in IE 10, IE 11 and Microsoft Edge
      // See MS Edge Issue #10396033
      // Hence, the deliberate 'false'
      // This is here just for completeness
      // Remove the 'false' at your own risk
      window.navigator.msSaveBlob(blob, filename);

    } else if (window.Blob && window.URL) {
      // HTML5 Blob        
      var blob = new Blob([csv], {
        type: 'text/csv;charset=utf-8'
      });
      var csvUrl = URL.createObjectURL(blob);

      $(this)
        .attr({
          'download': filename,
          'href': csvUrl
        });
    } else {
      // Data URI
      var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

      $(this)
        .attr({
          'download': filename,
          'href': csvData,
          'target': '_blank'
        });
    }
 }


</script>
<div class="container text-center">
	<div class="row">
		<h2>Open Bob's Chat</h2>
		<div class="round hollow text-center">
			<a href="#" id="addClass"><span class="glyphicon glyphicon-comment"></span> Open in chat </a>
		</div>
		
		<hr>
		
		MORE :
		<a target="_blank" href="https://github.com/oliverbob">Oliver Bob Lagumen</a>,
		<a target="_blank" href="http://facegod.us"> FaceGod :D  </a>
		
	</div>
</div>


<div class="popup-box chat-popup" id="qnimate">
	<div class="popup-head">
        <div class="popup-head-left pull-left"><img align="left" hspace="10" src="https://avatars1.githubusercontent.com/u/23272429?v=3&s=460" alt="useractive"> <div class="avatar-name">Oliver Bob Lagumen</div>
        </div>
		<div class="popup-head-right pull-right">
			<div class="btn-group">
				<button class="chat-header-button" data-toggle="dropdown" type="button" aria-expanded="false">
				<i class="glyphicon glyphicon-cog"></i> </button>
				<ul role="menu" class="dropdown-menu pull-right">
					<li><a href="#">Media</a></li>
					<li><a href="#">Block</a></li>
					<li><a href="#">Clear Chat</a></li>
					<li><a href="#">Email Chat</a></li>
				</ul>
			</div>
			
			<button data-widget="remove" id="removeClass" class="chat-header-button pull-right" type="button"><i class="glyphicon glyphicon-off"></i></button>
		</div>
	</div>

	<div class="popup-messages">
		
		<div class="direct-chat-messages">
			
			
			<div class="chat-box-single-line">
				<abbr class="timestamp">2017-05-13 09:58:30</abbr>
			</div>
			
			
			<!-- Message. Default to the left -->
			<div class="direct-chat-msg doted-border">
				<div class="direct-chat-info clearfix">
					<span class="direct-chat-name pull-left">Lagumen</span>
				</div>
				<!-- /.direct-chat-info -->
				<img alt="message user image" src="https://avatars1.githubusercontent.com/u/28243205?v=3&s=96" class="direct-chat-img"><!-- /.direct-chat-img -->
				<div class="direct-chat-text">
					Hey bro, how’s everything going ?
				</div>
				<div class="direct-chat-info clearfix">
					<span class="direct-chat-timestamp pull-right">09:58 AM</span>
				</div>
				<div class="direct-chat-info clearfix">
					<span class="direct-chat-img-reply-small pull-left">
						
					</span>
					<span class="direct-chat-reply-name">Singh</span>
				</div>
				<!-- /.direct-chat-text -->
			</div>
			<!-- /.direct-chat-msg -->
		
		
			<div class="chat-box-single-line">
				<abbr class="timestamp">2017-05-13 10:00:30</abbr>
			</div>
	
			<!-- Message. Default to the left -->
			<div class="direct-chat-msg doted-border">
				<div class="direct-chat-info clearfix">
					<span class="direct-chat-name pull-left">Lagumen</span>
				</div>
				<!-- /.direct-chat-info -->
				<img alt="iamgurdeeposahan" src="https://avatars3.githubusercontent.com/u/11970809?v=3&s=96" class="direct-chat-img"><!-- /.direct-chat-img -->
				<div class="direct-chat-text">
					I'm fine...
				</div>
				<div class="direct-chat-info clearfix">
					<span class="direct-chat-timestamp pull-right">3.36 PM</span>
				</div>
				<div class="direct-chat-info clearfix">
					<img alt="iamgurdeeposahan" src="https://avatars3.githubusercontent.com/u/11970809?v=3&s=96" class="direct-chat-img big-round">
					<span class="direct-chat-reply-name">Singh</span>
				</div>
				<!-- /.direct-chat-text -->
			</div>
			<!-- /.direct-chat-msg -->
	
	
	
	
		</div>

	</div>
	<div class="popup-messages-footer">
		<textarea id="status_message" placeholder="Type a message..." rows="10" cols="40" name="message"></textarea>
		<div class="btn-footer">
			<button class="bg_none"><i class="glyphicon glyphicon-film"></i> </button>
			<button class="bg_none"><i class="glyphicon glyphicon-camera"></i> </button>
			<button class="bg_none"><i class="glyphicon glyphicon-paperclip"></i> </button>
			<button class="bg_none pull-right"><i class="glyphicon glyphicon-thumbs-up"></i> </button>
		</div>
	</div>
</div>
    </body>
</html>