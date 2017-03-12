<?php

session_start();
$_SESSION['version'] = "1.4.3";
$root = realpath( $_SERVER["DOCUMENT_ROOT"] );

include_once $root."/comcls/Menu.php";

?>

<!DOCTYPE HTML>
    <html>
	<head>
	  <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
	  <title>Demo</title>
          <link href="/css/global.css?version=<?php echo $_SESSION['version']; ?>" media="screen" rel="stylesheet" />
	  <link rel="stylesheet" href="/jQuery1.10.1/themes/base/jquery-ui.css?version=<?php echo $_SESSION['version']; ?>" />
	  <script src="/jQuery1.10.1/jquery-1.9.1.js?version=<?php echo $_SESSION['version']; ?>"></script>
	  <script src="/jQuery1.10.1/ui/minified/jquery-ui.custom.min.js?version=<?php echo $_SESSION['version']; ?>"></script>
          <script src="/js/global.js?version=<?php echo $_SESSION['version']; ?>"></script>
	</head>
	
	<body>
	  <div class="form_container container_12" id="divheadtitle">
	    <br><br>
	    <center>
	      <span class="clspagetitle">Demo...</span>
	    </center>
	    <br>
	  </div>
	  
	  <div id="divsrchfltr">
	    <fieldset>
	      <legend>Search Filter</legend>
	      <table>
		<tr>
		  <td>User ID</td>
		  <td>Name</td>
		</tr>
		<tr>
		  <td><input type="text" id="txtuid" name="txtuid" /></td>
		  <td><input type="text" id="txtname" name="txtname" /> </td>
		</tr>
		<tr>
		  <td colspan="6" style="text-align: center;">
		    <input type="button" id="btnsearch" name="btnsearch" value="Search" />
		  </td>
		</tr>
	      </table>
	    </fieldset>
	  </div>
	  
          <div id="divgridcont"><div id="divUsers"></div></div>
	  
          <script language="Javascript">
	  $(document).ready( function() {
	    
	   
	    
	    var lv_grdUsersDataStore = new dataStore({
	      url: '/indexController/get_users',
	      root: 'items',
	      fields: ['id','loginid','name','status'],
	      exParams: { sortCol: 'loginid', sortOrder: 'desc' },
	      totalProperty: 'totalCount'
	    });
	    
	      //Grid
		var lv_grdPnlUsers = new gridPanel({
		    id: "grdPnlUsers",
		    height: 343,
		    width: 843,
		    container_id: "divUsers",
		    store: lv_grdUsersDataStore,
		    paging: true,
		    pageSize: 20,
		    headers:  [{
			headerText: 'User Id',
			width: 83,
			dataIndex: 'loginid'
		      },{
			headerText: 'Name',
			width: 83,
			dataIndex: 'name'
		      },{
			headerText: 'Status',
			width: 83,
			dataIndex: 'status'
		      }
		    ]
		});
		lv_grdPnlUsers.render();
	      
	      //Refresh Grid
	      fn_refreshUsersGrid = function() {
		
		  lv_grdPnlUsers.store.baseParams = {
			loginid: $( "#txtuid" ).val(),
			name: $( "#txtname" ).val()
		  };
		  lv_grdPnlUsers.refreshGrid();
	      }
	      
	      //Search button Click event
	      $( "#btnsearch" ).on( 'click', fn_refreshUsersGrid );;
	      
	  });
	</script>
        </body>
    </html>
