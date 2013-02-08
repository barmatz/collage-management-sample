<?php 
require_once 'includes/header.php'; 
require_once 'getConfig.php'; 
?>
	<script type="text/javascript">
	<!--
	function onNumberOnlyFieldInput(field)
	{
		$FIELD = $(field);
		$FIELD.val($FIELD.val().replace(/\D/g, ''));
	}

	function onUpdateButtonClick()
	{
		var data = {};

		$('input[rel="field"]').each(function(i)
		{
			$FIELD = $(this);
			data[$FIELD.attr('id')] = $FIELD.val();
		});
		
		$.ajax({
			url: 'setConfig.php', 
			type: 'POST',
			data: data
		});
	}
	//-->
	</script>
</head>
<body>
	<div class="config-form">
		<?php
		$rows = array(
			array('key'=>'bubble_font_size', 'label'=>'גודל פונט בועה (פיקסלים)'),
			array('key'=>'post_font_size', 'label'=>'גודל פונט פוסט (פיקסלים)'),
			array('key'=>'bubble_hold_duration', 'label'=>'זמן הצגת בועה (שניות)'),
			array('key'=>'bubble_transition_delta', 'label'=>'זמן בין בועות (שניות)'),
			array(
				'label'=>'בועה',
				'label1'=>'כניסה (שניות)',
				'label2'=>'יציאה (שניות)',
				'key1'=>'bubble_transition_in_duration',
				'key2'=>'bubble_transition_out_duration'
			),
			array('key'=>'frame_rate', 'label'=>'קצב תנועה (פריימים לשניה)'),
			array(
				'label'=>'גודל פונט',
				'label1'=>'מינימלי (%)',
				'label2'=>'מקסימלי (%)',
				'key1'=>'post_font_size_em_min',
				'key2'=>'post_font_size_em_max'
			),
			array(
				'label'=>'שקיפות פוסט',
				'label1'=>'מינימלי (%)',
				'label2'=>'מקסימלי (%)',
				'key1'=>'post_opacity_min',
				'key2'=>'post_opacity_max'
			),
			array('key'=>'post_refresh_interval', 'label'=>'קצב ריענון פוסטים (שניות)'),
			array(
				'label'=>'פוסט',
				'label1'=>'כניסה (שניות)',
				'label2'=>'יציאה (שניות)',
				'key1'=>'post_transition_in_duration',
				'key2'=>'post_transition_out_duration'
			),
			array('key'=>'transition_speed', 'label'=>'קצב תנועה (שניות)'),
			array('key'=>'max_posts_per_wall', 'label'=>'מספר פוסטים מקסימלי')
		); 
		
		$i = 0;
		
		foreach($rows as $row)
		{
			echo '<div class="config-form-row ' . ($i % 2 < 1 ? 'odd' : 'even') . '">';
			if(isset($row['key1']))
			{
				echo '<label>' . $row['label'] . '</label>';
				echo '<input rel="field" type="text" id="' . $row['key1'] . '" style="width: 50px;" oninput="onNumberOnlyFieldInput(this);" value="' . $config[$row['key1']] . '"/><label>' . $row['label1'] . '</label>';
				echo '<input rel="field" type="text" id="' . $row['key2'] . '" style="width: 50px;" oninput="onNumberOnlyFieldInput(this);" value="' . $config[$row['key2']] . '"/><label>' . $row['label2'] . '</label>';
			}
			else
				echo '<label>' . $row['label'] . '</label><input rel="field" type="text" id="' . $row['key'] . '" style="width: 50px;" oninput="onNumberOnlyFieldInput(this);" value="' . $config[$row['key']] . '"/>';
			echo '</div>';
			++$i;
		}
		?>
		<div class="config-form-row even">
			<button onclick="onUpdateButtonClick();">עדכן</button>
		</div>
		<div class="note">יש לרענן את עמוד הקיר לאחר עידכון על מנת שההגדרות החדשות יכנסו לתוקף!</div>
	</div>
<?php require_once 'includes/footer.php'; ?>