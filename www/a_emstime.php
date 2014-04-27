<h1>
Statystyka
<hr></h1>
<form method="post">

<?php
require("/emsincludes/config.php");
include("a_emsmenu.inc");

function beginTable(){
?>
<p>
<table border=0 cellpadding=4 cellspacing=5 bgcolor=#eeeeee>
<?php
}

function showline($k, $v){
  print("<tr><td bgcolor=#cccccc><font size=-1>$k</font></td><td bgcolor=#cccccc align=right><font face='Courier,Lucida Console,fixedsys' size=-1 ><b>$v</b></font></td><tr>\n");
  flush_buffers();
}

function parseTimeStr($in,$line){
  $l2 = trim($in[$line]);
  $l2 = round($l2/60,0);  
  return $l2;
}

function getStr($in,$line){
  return trim($in[$line]);
}

function getlivedata(){
  global $livedat;
  if (!isset($livedat)) $livedat = getEmsLiveData();
  return $livedat;
}

function parseVersion($in){
  global $vdata;
  
  if (!isset($vdata)) $vdata = doEmsCommand("getversion");
  foreach ($vdata as $l){
    if (substr($l,0,strlen($in))==$in){
      $f = explode(":",$l);
      return trim($f[1]);
    }
  }
  return ("offline");
}

require("/emsincludes/emsgetinfo.inc");

$in = array("Betriebsstunden total" => parseTimeStr(getlivedata(),"operatingminutes"),
            "Betriebsstunden Kessel" => $bk=parseTimeStr(getlivedata(),"heater operatingminutes"),
            "Heizzeit" => parseTimeStr(getlivedata(),"heater heatingminutes"),
            "Warmwasserbereitungszeit" => parseTimeStr(getlivedata(),"warmwaterminutes"),
            "Warmwasserbereitungen" => getStr(getlivedata(),"warmwaterpreparations"),
            "Brennerstarts" => $bs=getStr(getlivedata(),"heater heaterstarts"),
            "Durchschnittliche Brennerlaufzeit" => round(reset(explode("h",$bk)) / $bs *60 ,1)."min",
            
            "Software version UBA" => parseVersion("UBA"),
            "Software version BC10" => parseVersion("BC10"),
            "Software version RC35" => parseVersion("RC"),
            "Version EMS-Collector" => parseVersion("collector"));
            


print("<table cellspacing=14>");
if ($in["Version EMS-Collector"] < $min_collector_version){
  print("<tr><td colspan=2 bgcolor=#ff0000 style='padding: 2em 2em 2em 2em; font-size: 14pt;'><b>ACHTUNG:</b> ".
    "Wymagany ems-collector jest zbyt stary! Wymagana jest wersja $min_collector_version lub nowsza! ".
    "Niemo�liwe jest u�ywanie wszystkich dost�pnych funkcji. ".
    "Koniecznie pobierz bnajnowsz� wersj� z <a href='https://github.com/moosy/ems-collector'>https://github.com/moosy/ems-collector</a>!</td></tr>");
}
print("<tr><td colspan=2>");

# print("<img src=img/mc10bild.jpg align=left width=90%>");
print("</td></tr><tr><td>");

beginTable();

foreach ($in as $edesc => $data){
  showline($edesc,$data);
  if ($edesc == "Warmwasserbereitungen") {
    print("</table></td><td>");
    beginTable();
  }
}
print("</td></tr></table>");
?>

</table>

<p><input type=submit value="Aktualizuj">

</form>

<!-- 
?php
print("Calculating graphs...   " . $emsscriptpath . '/calcemsgraphs.sh &' );
print("<BR>Please wait...")
exec('sudo ' . $emsscriptpath . '/calcemsgraphs.sh &');
?
-->
<p>
Gotowe!
<p>

