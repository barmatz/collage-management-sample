<?php 
require_once 'includes/header.php';
require_once 'includes/ErrorCodes.php';
?>
	<script type="text/javascript">
	<!--
	function validate()
	{
		var error;
		$('.form-row').removeClass('form-row-error');
		
		$userField = $('#userField');
		if($userField.val().length == 0)
		{
			$userField.parent().addClass('form-row-error');
			error = true;
		}
		
		$passField = $('#passField');
		if($passField.val().length == 0)
		{
			$passField.parent().addClass('form-row-error');
			error = true;
		}

		return error ? false : true;
	}
	
	function submitForm()
	{
		if(validate())
			$.ajax({
				beforeSend: function(jqXHR, settings)
				{
					$('#loginFormDialog').dialog('open');
				},
				data: {
					user: $('#userField').val(),
					pass: $('#passField').val()
				},
				error: function(jqXHR, textStatus, errorThrown)
				{
					$('#loginFormDialog').html(jqXHR.responseText);
				},
				success: function(data, textStatus, jqXHR)
				{
					var data = $.parseJSON(jqXHR.responseText);
					if(textStatus != 'error')
						if(data.authorized)
						{
							$('#loginFormDialog').dialog('close');
							location.href = '<?php echo isset($_REQUEST['ref']) ? $_REQUEST['ref'] : 'home.php'; ?>';
						}
						else if(data.error)
						{
							switch(data.error.code)
							{
								default: 
								case <?php echo ErrorCodes::SQL_ERROR ?>: 
								case <?php echo ErrorCodes::INCORRECT_NUMBER_OF_PARAMETERS ?>: 
									data.error.message = 'שגיאה, נסה שנית.';
									break;
								case <?php echo ErrorCodes::USER_NOT_FOUND ?>: 
									data.error.message = 'שם משתמש וסיסמא לא תואמים';
									break;
							}
							$('#loginFormDialog').html(data.error.message + ' (' + data.error.code + ')');
						}
						else
							$('#loginFormDialog').html('You are not authorized to view this page');
				},
				type: 'POST',
				url: 'loginHandler.php'
			});
	}
	//-->
	</script>
</head>
<body>
	<fieldset id="loginForm" class="form">
		<div id="loginFormDialog"></div>
		<div class="form-row">
			<label>שם משתמש</label> 
			<input type="text" id="userField"/>
			<div class="form-error-message">יש למלא שם משתמש</div>
		</div>
		<div class="form-row">
			<label>סיסמא</label> 
			<input type="password" id="passField"/>
			<div class="form-error-message">יש למלא סיסמא</div>
		</div>
		<div class="form-row">
			<button onclick="submitForm();">כנס</button>
		</div>
	</fieldset>
	<script type="text/javascript">
	$("#loginForm").dialog({title: "כניסה", dialogClass: 'loginForm'});
	$("#loginFormDialog").dialog({autoOpen: false, closeOnEscape: false, draggable: false, modal: true});
	</script>
<?php require_once 'includes/footer.php'; ?>