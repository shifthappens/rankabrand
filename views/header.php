<?php
	include_once 'common.php';

	// Set language
	$language = detectLanguage();
	
	/* for testing purposes */
	//$language = array('simple' => 'de', 'full' => 'de_DE', 'complete' => 'de_DE.UTF-8');
	
	$API_language = $language['simple'];
	
	putenv('LC_ALL='.$language['complete']);
	setlocale(LC_ALL, $language['complete']);
	
	// Specify location of translation tables
	bindtextdomain("rankabrand", "./languages");
	
	// Choose domain
	textdomain("rankabrand");		
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo _('Rank a Brand | Vergelijk de duurzaamheid van merken | koop duurzaam'); ?></title>
        <meta name="description" content="<?php echo _("Rank a Brand helpt je bij het kopen van duurzame merken. Hoe maatschappelijk verantwoord zijn populaire merken als Apple, Nokia en Nike? Rank a Brand beoordeelt de duurzaamheid van merken zodat u hun prestaties kunt vergelijken."); ?>" />
        <meta name="keywords" content="<?php echo _('transparant, groen, fair, merken, MVO, bedrijven, transparantie, maatschappelijk verantwoord ondernemen, ethisch ondernemen'); ?>" />
		
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		<meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="apple-touch-icon" href="<?php echo getFullPath() ?>/apple-touch-icon.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo getFullPath() ?>/apple-touch-icon-72x72-precomposed.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo getFullPath() ?>/apple-touch-icon-114x114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo getFullPath() ?>/apple-touch-icon-114x114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo getFullPath() ?>/apple-touch-icon-72x72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="<?php echo getFullPath() ?>/apple-touch-icon-precomposed.png">
	     <link rel="stylesheet" href="css/normalize.css">
	     <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	     <link rel="stylesheet" href="css/main.css">
	     <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
	     <link rel="stylesheet" href="css/rankabrand.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <script type="text/javascript">
        API_language = "<?php echo $API_language ?>";
	    
	    var addToHomeConfig = {
/*
		returningVisitor: true,		// Show the message only to returning visitors (ie: don't show it the first time)
		expire: 720,					// Show the message only once every 12 hours
*/
		message: '<?php echo strtolower($language['full']) ?>'
		};
  
        </script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe"><?php echo _('U gebruikt een <strong>verouderde</strong> browser. Upgrade uw browser of activeer Google Chrome Frame om uw ervaring te verbeteren.') ?></p>
        <![endif]-->