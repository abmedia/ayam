<?php 
include "conf.inc.php";
include_once 'lib.php';

$logo = "none";
if ( !empty ($conference_logo) ) 
    $logo = "url('$rootpath/images/$conference_logo')";
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo "$conference_name";?></title>
        <link rel="SHORTCUT ICON" href="<?php echo $rootpath.'/images/favicon.ico'; ?>">
        <link rel="icon" href="<?php echo $rootpath.'/images/favicon.ico'; ?>">
        <link rel="stylesheet" href="<?php echo $rootpath.'/css/ystyle.css'; ?>" type="text/css">
    </head>
<body>
<div id="pagina">
    <!--<div id="wrap">-->
        <div id="header">
            <div id="conference-title" style="background-image: <?php print $logo?>">
                <a href="<?php print $conference_link; ?>">
                    <p><?php print "$conference_name" ?></p>
                </a>
            </div>
        </div>
<?php
abrirSeccionContenido();
?>