<?php require_once 'includes/header.php'; ?>
	<script type="text/javascript" src="js/wall.js.php"></script>
</head>
<body>
	<div class="wall">
		<div class="wall-title">
			<img src="css/images/title2.png"/>
		</div>
		<div class="wall-container" id="posts-wrapper">
			<div id="posts-container"></div>
		</div>
		<div class="logo"></div>
		<table class="wall-bubble" cellpadding="0" cellspacing="0" border="0" id="bubble" style="display: none;">
			<tr>
			 	<td class="wall-bubble-slice wall-bubble-slice3"></td>
			 	<td class="wall-bubble-slice wall-bubble-slice2"></td>
				<td class="wall-bubble-slice wall-bubble-slice1"></td>
			</tr>
			<tr>
			 	<td class="wall-bubble-slice wall-bubble-slice6"></td>
			 	<td class="wall-bubble-slice wall-bubble-slice5" id="bubbleContent"></td>
			 	<td class="wall-bubble-slice wall-bubble-slice4"></td>
		 	</tr>
			<tr>
			 	<td class="wall-bubble-slice wall-bubble-slice9"></td>
			 	<td class="wall-bubble-slice wall-bubble-slice8"></td>
			 	<td class="wall-bubble-slice wall-bubble-slice7"></td>
			</tr>
		</table>
	</div>
<?php require_once 'includes/footer.php'; ?>