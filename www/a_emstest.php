<html>
<head>
<META http-equiv="Expires" CONTENT="0">
<link href="/moosy.css" rel="stylesheet" type="text/css">
</head>
<body style="background-color:#eeeeee" text="#000000" leftmargin="0" topmargin="1em"
rightmargin="1em" marginwidth="1em" marginheight="1em">
<h3>Test funkcji<hr></h3>
<form method=post>
<table border=0 cellspacing=5 cellpadding=3>
<tr bgcolor=#cccccc>
<td colspan=4>
Proszę regularnie klikać na przycisk "Aktywuj", w przeciwnym wypadku 
test zostanie automatycznie anulowany!</td></tr><tr bgcolor=#cccccc>
<?php

require("/emsincludes/emsqry.inc");
require("/emsincludes/emschoosers.inc");

$kessel = $pumpe = 0;
$dwv = $zirk = $active = "off";

if (isset($_POST["active"])){

  if ($_POST["active"] == "Aktywuj"){
    $active = "on";
    $kessel = $_POST["kocioł"];
    $pumpe = $_POST["pompa"];
    $dwv = $_POST["zawór 3.dr"];
    $zirk = $_POST["cyrk"];
  }

  $dwvv = ($dwv=="on"?1:0);
  $zirkv = ($zirk=="on"?1:0);
  doEmsCommand("uba testmode $active $kessel $pumpe $dwvv $zirkv");
}


print("<td><b>Wydajnośc palnika</b><br>");
tempchooser("kessel",0,100,5,"%","wybierz",$kessel);
print("</td>");

print("<td><b>Wydajność pompy</b><br>");
tempchooser("pumpe",0,100,5,"%","wybierz",$pumpe);
print("</td>");

print("<td><b>Zawór 3-drożny</b><br>");
onoffchooser("dwv",$dwv);
print("</td>");

print("<td><b>Pompa cysrkulacyjna</b><br>");
onoffchooser("zirk",$zirk);
print("</td>");

?>
</tr><tr bgcolor=#cccccc>
<td colspan=4 align=center>
<input type=submit name=active value=Aktywuj>
<input type=submit name=active value=Przerwij></td>
</tr>
</table>

</form>
</body>
</html>