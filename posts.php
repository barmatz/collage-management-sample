<?php require_once 'includes/header.php'; ?>
	<link type="text/css" rel="stylesheet" href="css/jquery-checkbox/jquery.checkbox.css"/>
	<script type="text/javascript" src="js/jquery.checkbox.min.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.js"></script>
	<script type="text/javascript">
	<!--
	function onPostEnableChange(target)
	{
		var $target = $(target);
		$.ajax({
			data: {
				id: $target.parent().parent().attr('rel'),
				enable: $target.attr('checked') == 'checked' ? true : false
			},
			method: 'POST',
			url: 'postEnableHandler.php'
		});
	}

	function onPostNewChange(target)
	{
		var $target = $(target);
		$.ajax({
			data: {
				id: $target.parent().parent().attr('rel'),
				new: $target.attr('checked') == 'checked' ? true : false
			},
			method: 'POST',
			url: 'postNewHandler.php'
		});
	}

	function onPostDeleteButtonClick(target)
	{
		var $target = $(target),
			$row = $target.parent().parent();

		$('#confirm-dialog').dialog({
			autoOpen: false,
			width: 400,
			modal: true,
			title: 'Delete',
			buttons: {
				"מחק": function()
				{
					$(this).dialog("close");
					$row.hide(500);
					$.ajax({
						data: {
							id: $row.attr('rel')
						},
						method: 'POST',
						url: 'postDeleteHandler.php'
					});
				}, 
				"בטל": function() 
				{
					$(this).dialog("close");
				}
			}
		}).dialog('open');
	}

	function onAddPostCallback(jqXHR, textStatus, ajax)
	{
		if(textStatus == 'success')
			location.href = location.href;
	}
	//-->
	</script>
</head>
<body>	
	<?php include 'addPostForm.php'; ?>
	<button onclick="addPost(onAddPostCallback);">הוסף פוסט</button>
	<div style="margin: 1em;"></div>
	<table id="table" style="width: 100% !important; height: 100%;" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<td>תאריך</td>
				<td>שם פרטי</td>
				<td>שם משפחה</td>
				<td>פוסט</td>
				<td>הצג</td>
				<td>חדש</td>
				<td class="hide-sort-icon"></td>
			</tr>
		</thead>
		<tbody>
			<?php 
			require_once 'includes/db.php';
			
			$sql = 'select * from posts';
			$result = mysql_query($sql);
			while($row = mysql_fetch_object($result))
				echo '<tr rel="' . $row->id . '">
						<td>' . $row->created . '</td>
						<td>' . $row->first_name . '</td>
						<td>' . $row->last_name . '</td>
						<td>' . $row->message . '</td>
						<td><input type="checkbox" onchange="onPostEnableChange(this);" ' . ($row->enabled ? 'checked' : '') . '/></td>
						<td><input type="checkbox" onchange="onPostNewChange(this);" ' . ($row->new ? 'checked' : '') . '/></td>
						<td><div class="button ui-state-default ui-corner-all" onclick="onPostDeleteButtonClick(this);"><span class="ui-icon ui-icon-circle-close"></span><span class="text" style="display: block;">מחק</span></div></td>
					</tr>';
			?>
		</tbody>
	</table>
	<div id="confirm-dialog">
		<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>פעולה זו תמחק את הפריט הזה לצמיתות ולא ניתן לבטל, האם אתה בטוח?</p>
	</div>
	<script type="text/javascript">
	<!--  
	$('#table').dataTable({
		bJQueryUI: true, 
		oLanguage: {
			sLengthMenu: 'הצג _MENU_ פוסטים בדף',
			sZeroRecords: 'לא נמצאו פוסטים',
			sInfo: 'מציג _START_ עד _END_ מתוך _TOTAL_ פוסטים',
			sInfoEmpty: 'מציג 0 מתוך 0 תוצאות',
			sInfoFiltered: '(סינון מתוך _MAX_ פוסטים)',
			sSearch: 'חיפוש:'
		}
	}).fnSort([[0, 'desc']]);
	//$('input:checkbox').checkbox();
	$('#confirm-dialog').hide();
	//-->
	</script>
<?php require_once 'includes/footer.php'; ?>