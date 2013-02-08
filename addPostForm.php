<?php if(isset($_REQUEST['external'])) require_once 'includes/header.php'; ?>
<script type="text/javascript">
<!--
var addPostCallback;

function addPost(callback)
{
	addPostCallback = callback;
	$('#addPostForm').dialog('open');
}

function validate()
{
	var error;
	
	$('.form-row').removeClass('form-row-error');
	
	$messageField = $('#messageField');
	if($messageField.val().length == 0)
	{
		$messageField.parent().addClass('form-row-error');
		error = true;
	}

	return error ? false : true;
}

function onAddPostFormSubmit()
{
	if(validate())
		$.ajax({
			beforeSend: function(jqXHR, settings)
			{
				$('#addPostFormDialog').dialog('open');
			},
			data: {
				firstName: $('#firstNameField').val(),
				lastName: $('#lastNameField').val(),
				title: $('#titleField').val(),
				message: $('#messageField').val()
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				var data = $.parseJSON(jqXHR.responseText);
				$('#addPostFormDialog').html(data.message + ' (' + data.code + ')');
			},
			success: function(data, textStatus, jqXHR)
			{
				var data = $.parseJSON(jqXHR.responseText);
				if(textStatus != 'error' && data.success)
				{
					<?php if(isset($_REQUEST['noClose'])) echo '//'; ?>$('#addPostForm').dialog('close');
					$('#addPostFormDialog').dialog('close');
					$('#addPostForm input, #addPostForm textarea').val('');
					onAddPostFormMessageFieldInput($("#messageField")[0]);
				}
				else
					$('#addPostFormDialog').html('An error has occured, please try again.');
			},
			complete: function(jqXHR, textStatus) 
			{
				if(typeof addPostCallback != 'undefined')
					addPostCallback(jqXHR, textStatus, this);
			},
			type: 'POST',
			url: 'addPostHandler.php'
		});
}

function onAddPostFormDialogClose(event, ui)
{
	$('.form-row').removeClass('form-row-error');
}

function onAddPostFormMessageFieldInput(target)
{
	var $target = $(target);
	$target.parent().find("#messageIndicator").html(140 - $target.val().length);
}
//-->
</script>
<?php 
if(isset($_REQUEST['external'])) 
	echo '</head><body>';
if(isset($_REQUEST['noClose'])) 
	echo '<style>.ui-dialog .ui-dialog-titlebar-close span { display: none; }</style>'; 
?>
<?php if(isset($_REQUEST['logo'])) echo '<div class="logo" style="position: absolute; left: 40px; top: 20px;"></div>'; ?>
<div id="addPostForm">
	<div id="addPostFormDialog"></div>
	<fieldset class="form">
		<div class="form-row">
			<label>שם פרטי</label>
			<input type="text" id="firstNameField"/>
		</div>
		<div class="form-row">
			<label>שם משפחה</label>
			<input type="text" id="lastNameField"/>
		</div>
		<div class="form-row">
			<label>הודעה (<span id="messageIndicator">140</span>)</label>
			<textarea id="messageField" maxLength="140" oninput="onAddPostFormMessageFieldInput(this);"></textarea>
			<div class="form-error-message">שדה חובה</div>
		</div>
		<div class="form-row">
			<button onclick="onAddPostFormSubmit()">שלח</button>
		</div>
	</fieldset>
</div>
<script type="text/javascript">
<!--  
$('#addPostForm').dialog({title: 'הוסף פוסט', width: 'auto', height: 'auto', <?php if(isset($_REQUEST['noClose'])) echo 'closeOnEscape: false, '; ?>autoOpen: <?php echo isset($_REQUEST['open']) ? 'true' : 'false' ?>, modal: <?php echo isset($_REQUEST['noModal']) ? 'false' : 'true'; ?>, close: onAddPostFormDialogClose});
$('#addPostFormDialog').dialog({autoOpen: false, closeOnEscape: false, draggable: false, modal: true});
//-->
</script>
<?php if(isset($_REQUEST['external'])) require_once 'includes/footer.php'; ?>