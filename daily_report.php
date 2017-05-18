<?php
/**
 * @Author: Oliver Bob  Lagumen
 * @Date:   2017-05-15 08:07:21
 * @Last Modified by:   Oliver Bob Lagumen
 * @Last Modified time: 2017-05-15 23:20:47
 */
require_once('helpers/MysqliDb.php');

$cols = Array (
    "invited_on", 
    "active_on"
    );

//$db->where ("active_on", "GROUP BY DATE(active_on)");
//$users = $db->get ("user_invitation", 2, $cols);
$users = $db->rawQuery('SELECT COUNT(u.active_on) AS active, DATE(u.active_on) AS active_on FROM user_invitation u GROUP BY DATE(u.active_on);', Array (2));

//echo "<pre>".print_r($users, 1)."</pre>";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Daily Report</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="src/js/mod/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
  <link href="src/js/mod/footable/footable.bootstrap.min.css" rel="stylsheet"><!-- 
	<link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-footable/3.1.4/footable.paging.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-footable/3.1.4/footable.core.standalone.css"> -->
	<!-- Jquiery -->
	

	<!-- Timepicker  -->
	<link rel="stylesheet" type="text/css" media="screen" href="src/js/mod/bootstrap-4.0.0-alpha.6-dist/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css"><!-- 
	<link rel="stylesheet" type="text/css" media="screen" href="src/js/mod/bootstrap-4.0.0-alpha.6-dist/plugins/datetimepicker/css/bootstrap-datetimepicker-standalone.css"> -->

	<link rel="stylesheet" type="text/css" media="screen" href="src/js/mod/footable/css/footable.bootstrap.min.css">


  <script type="text/javascript" src="src/js/mod/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="src/js/mod/moment.min.js"></script>
  <script type="text/javascript" src="src/js/mod/footable/js/footable.min.js"></script>
  <script type="text/javascript" src="src/js/mod/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="src/js/mod/bootstrap-4.0.0-alpha.6-dist/plugins/datetimepicker/bootstrap-datetimepicker.min.js"></script>

	
</head>





<body>
<h3 style="margin-left: 20px">Set Range</h3>
<form >
	<div class='input-group date' id='date-pick' style="width: 200px;margin-left:20px;margin-top: 20px" >

	    <input type='text' id="datePick" class="form-control" name="date1"/>
	    <span class="input-group-addon">
	        <span class="glyphicon glyphicon-calendar"></span>
	    </span>
	</div>
	<div class='input-group date' id='date-pick2' style="width: 200px;margin-left:20px;margin-top: 20px">

	    <input type='text' id="datePick2" class="form-control" name="date2" />
	    <span class="input-group-addon">
	        <span class="glyphicon glyphicon-calendar"></span>
	    </span>
	</div>
</form>
<button type="button" class="btn btn-primary btnSubmit">Go</button>
<script type="text/javascript">
    $(function () {
        $('#date-pick').datetimepicker({
            //daysOfWeekDisabled: [0, 0]
        });
    $(function () {
        $('#date-pick2').datetimepicker({
            //daysOfWeekDisabled: [0, 0]
        });


    });
  });

    $(function(){
    	$('.btnSubmit').click(function(){    		
    		var apiUrl = 'http://' +document.location.hostname + '/name-brokers/public_html/dts/rangesetter.php';
    
            console.log(apiUrl);
            var params = {
                date1: document.getElementById('datePick').value,
                date2: document.getElementById('datePick2').value,
            };
            console.log(params);
                $.ajax({
                        url: 'http://' +document.location.hostname + '/name-brokers/public_html/dts/rangesetter.php',
                        type: "POST",
                        dataType: 'json',
                        data: params,
                        crossDomain: true,
                        xhrFields: {
                            withCredentials: true
                        },
                        success: function (r) {
                         
                            if (r.success == true) {
                                console.log('Successfully submitted!');
                                $('#submit-an-offer')[0].reset();
                                
                            } else {
                                console.log('Opps! Broker does not exist in our database!');
                            }
                        }
                    });
    	});
    });
</script>
<?php

if ($db->count > 0){
	$count = 0;
    foreach ($users as $user) { $date = $user['active_on'];



		echo "
		<a href='#' class='export_$count'>Export Table data into Excel</a>
		<div id='dvData_$count'>
			<table class='footable_$count table table-striped footable footable-1 footable-filtering footable-filtering-right footable-paging footable-paging-center breakpoint-lg' style='display: table;' data-page-size='10'>
				<tfoot class='hide-if-no-paging'>
					<td colspan='5'>
						<div class='pagination'></div>
					</td>
				</tfoot>
			</table>
		</div>

		<script>
		jQuery(function($){
			var apiUrl = 'http://' +document.location.hostname + '/name-brokers/public_html/dts/daily_report2.php?date=$date';
			$('.footable_$count').footable({
				'toggleColumn': 'last',
				'expandFirst': false,
				'columns': 
				[
					//{ 'name': 'table_id','title': 'ID' ,'breakpoints':'xs sm','type':'text','style':{'width':250,'maxWidth':250}}, // 0
		            //{ 'name': 'broker_id','title':'BrokerID','breakpoints':'xs sm'}, // 1
		            //{ 'name': 'agent_id','title':'AgentID','breakpoints':'xs sm'}, // 2
		            //{ 'name': 'website' ,'title':'Website','breakpoints':'xs sm','style':{'maxWidth':250,'overflow':'hidden','textOverflow':'ellipsis','wordBreak':'keep-all','whiteSpace':'nowrap'}}, // 3
		            //{ 'name': 'company_name','title':'Company Name','breakpoints':'xs sm','style':{'maxWidth':200,'overflow':'hidden','textOverflow':'ellipsis','wordBreak':'keep-all','whiteSpace':'nowrap'}}, // 4
		            { 'name': 'first_name','title':'First Name','style':{'maxWidth':200,'overflow':'hidden','textOverflow':'ellipsis','wordBreak':'keep-all','whiteSpace':'nowrap'}}, // 5
		            { 'name': 'last_name','title': 'last Name','style':{'maxWidth':200,'overflow':'hidden','textOverflow':'ellipsis','wordBreak':'keep-all','whiteSpace':'nowrap'}}, // 6
		            { 'name': 'email','title':'Email','breakpoints':'xs sm','style':{'maxWidth':200,'overflow':'hidden','textOverflow':'ellipsis','wordBreak':'keep-all','whiteSpace':'nowrap'}}, // 7
		            { 'name': 'timestamp','title':'Date','type':'date','breakpoints':'xs sm md','formatString':'DD MMM YYYY'}, // 8
		            { 'name': 'invitation_status','title':'Status','breakpoints':'xs sm','style':{'maxWidth':200,'overflow':'hidden','textOverflow':'ellipsis','wordBreak':'keep-all','whiteSpace':'nowrap'}}, // 9
		            { 'name': 'invited_on','title': 'Invited on','type':'date','breakpoints':'xs sm','formatString':'DD MMM YYYY'}, // 10
		            { 'name': 'active_on','title': 'Activated on','type':'date','breakpoints':'xs sm','formatString':'DD MMM YYYY'} // 11
				],
				'paging': {
					'enabled' : true
				},
				'filtering' : {
					'enabled' : true
				},
				'sorting': {
					'enabled': true
				},
				'rows': $.ajax({
					url: apiUrl,
					dataType: 'json'
				})
			});
		});

		$(function(){
		  // This must be a hyperlink
		  $('.export_$count').on('click', function(event) {
		    // CSV
		    var args = [$('#dvData_$count>table'), 'export.csv'];

		    exportTableToCSV.apply(this, args);

		    // If CSV, don't do event.preventDefault() or return false
		    // We actually need this to be a typical hyperlink
		  });

		 });
		</script>









		";
		$count++;
    }
}



?>
<script>


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

</body>
</html>
<!-- { "name": "id", "title": "ID", "breakpoints": "xs" },
			{ "name": "firstName", "title": "First Name" },
			{ "name": "lastName", "title": "Last Name" },
			{ "name": "jobTitle", "title": "Job Title", "breakpoints": "xs" },
			{ "name": "started", "title": "Started On", "breakpoints": "xs sm" },
			{ "name": "dob", "title": "DOB", "breakpoints": "xs sm md" } -->
