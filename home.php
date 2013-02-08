<?php require_once 'includes/header.php'; ?>
	<script type="text/javascript" src="js/jquery.ba-hashchange.min.js"></script>
</head>
<body>
	<div>
		<!-- 
		<span>Hello <?php echo isset($_SESSION['user']) && isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'unknown'; ?></span> 
		<span><a href="javascript:logout();">logout</a></span>
		-->
	</div>
	<div id="menu">
		<ul>
			<li><a href="posts.php">פוסטים</a></li>
			<li><a href="config.php">הגדרות</a></li>
			<li><a href="javascript:void();" onclick="location.href='addPostForm.php?open&external&noClose&noModal&logo';">הוסף פוסט</a></li>
			<li><a href="javascript:void();" onclick="location.href='wall.php';">הקיר</a></li>
		</ul>
	</div>
	<script type="text/javascript">
	<!--
		$("#menu").tabs()
				  .on({
					  	tabsselect: function(event, ui)
						{
							var hash = ui.tab.hash;
							if(hash != '#ui-tabs-3' || hash != '#ui-tabs-4')
						 		window.location.hash = hash;  
						}
				   });
	   $(function()
		{
		   	$(window).hashchange(function()
			{
				$("#menu").tabs("select", location.hash);
			});
		});

		function onLogoutBeforeSend(jqXHR, settings) {}

		function onLogoutComplete(jqXHR, textStatus) 
		{
			location.href = location.href;
		}

		function onTabsError(xhr, status, index, anchor)
		{
			$(anchor.hash).html(xhr.responseText);
		}
	//-->
	</script>
<?php require_once 'includes/footer.php'; ?>