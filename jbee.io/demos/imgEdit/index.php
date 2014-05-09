<html>
<head>

<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
			<script src="../import/jQuery.js" type="text/javascript"></script> 
            <script src="admin.js" type="text/javascript"></script><link href="admin.css" rel="stylesheet" type="text/css"/> 
            <link rel="shortcut icon" href="http://www.oasis-ad.com/graphics/oasisIcon.ico" type="image/x-icon">
<title>EDIT HOME PAGE</title> 
<?php

function deleteTempGraphics(){$dir = 'tempGraphics';foreach (scandir($dir) as $item) {
    if ($item == '.' || $item == '..') continue;unlink($dir.DIRECTORY_SEPARATOR.$item); echo 'deleted'; }}
?>

<script>

$(document).ready(function()
{
$('#subMenu').selectMENU({'shD':false,'sD':'#A1A3A5','cD':'subMenu_0'});
});

</script>


</head><body>

<table id="mainContainerTable"><tr><td><!-- headerStart --><div id="mainMenu"> <div id="logo"><div id="goHome" onClick="(window.location = 'http://oasis-ad.com/admin')"></div></div><div id="mainNav"><table id="topButtonsSpaced"><tr><td><div class="selectedButtons" id="topButtons" style="width:129px;"><a href="index.php"><h1>Home Page</h1></a></div></td><td><div class="unselectedButtons" id="topButtons" style="width:129px;"><a href="portfolioAdmin.php"><h1>Portfolio</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="processAdmin.php"><h1>Process</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="teamAdmin.php"><h1>Team</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="contactAdmin.php"><h1>Contact</h1></a></div>
</td><td><div class="unselectedButtons" id="topButtons"><a href="mediaAdmin.php"><h1>Media</h1></a></div></td><td><div class="unselectedButtons" id="topButtons"><a href="../fullSite.php"><h1>full site</h1></a></div></td></tr></table></div></div></td></tr><!-- headerEnd -->
<tr><td valign="top"><table><tr><td width="206px" valign="top">
<!-- Sub Menu -->
<!-- Sub Menu END-->
</td><td valign="top"> 
<!-- Main Content -->
<!-- Main Content END -->
</td>
</tr>
</table>
</div>

</body>

</html>