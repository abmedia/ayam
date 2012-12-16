<?php 
include "conf.inc.php";
include_once 'lib.php';

$logo = "none";
if ( !empty ($conference_logo) ) 
    $logo = "url('$conference_link/images/$conference_logo')";
?>
<!DOCTYPE HTML>
<html lang="es-MX">
    <head>
		<meta charset="ISO-8859-1">
        <title><?php echo "$conference_name";?></title>
        <link rel="SHORTCUT ICON" href="<?php echo $rootpath.'/images/favicon.ico'; ?>">
        <link rel="icon" href="<?php echo $rootpath.'/images/favicon.ico'; ?>">
        <link rel="stylesheet" href="<?php echo $conference_link; ?>/css/ystyle.css" type="text/css">
    </head>
<body>
<div id="pagina">
    <!--<div id="wrap">-->
        <div id="header">
            <div id="conference-title" style="background-image: <?php print $logo?>">
                <h1>
					<a href="<?php print $conference_link; ?>">
                    <?php print "$conference_name" ?>
					</a>
				</h1>
            </div>
        </div>
<?php
abrirSeccionContenido();
?>