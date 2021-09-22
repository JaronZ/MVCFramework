<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$settings->getTitle();?></title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<?php
		if($settings->hasHeader())
			require_once(APP_ROOT."/views/shared/header.php");
		require_once($body);
		if($settings->hasFooter())
			require_once(APP_ROOT."/views/shared/footer.php");
	?>
	<script src="js/app.js"></script>
</body>
</html>