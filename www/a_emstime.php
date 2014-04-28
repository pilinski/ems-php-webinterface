<h1>
Statystyka
<hr></h1>
<script type="text/javascript">
function progress(perc){

  if (perc<100)
	document.getElementById("prc").innerHTML="Przygotowuję wykresy... Proszę czekać...("+perc+"%)";
  else 
	document.getElementById("prc").innerHTML="<b>Gotowe!</b>";
  
  for (i=0; i<=perc/20; i++){
    if (i<6) document.getElementById("p"+i).style.backgroundColor="#8888ff";
  }
}
progress(0);
</script>

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
    "Niemożliwe jest używanie wszystkich dostępnych funkcji. ".
    "Koniecznie pobierz bnajnowszą wersję z <a href='https://github.com/moosy/ems-collector'>https://github.com/moosy/ems-collector</a>!</td></tr>");
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


<?php
print("<table id=prog width=350px bgcolor=#cccccc cellspacing=0 cellpadding=5>");
# print("<tr><td colspan=6>Przygotowuję wykresy...   (" . $emsscriptpath . '/calcemsgraphs.sh' . ")</td></tr>" );
print("<tr height=30px><td colspan=6 bgcolor=#cccccc><div id=prc align=center></div></td></tr>");
print("<tr height=3px>");
print("<td id=p0 bgcolor=#eeeeee></td>");
print("<td id=p1 bgcolor=#dddddd></td>");
print("<td id=p2 bgcolor=#cccccc></td>");
print("<td id=p3 bgcolor=#bbbbbb></td>");
print("<td id=p4 bgcolor=#aaaaaa></td>");
print("<td id=p5 bgcolor=#999999></td>");
print("</tr></table>");
print('<script type="text/javascript">progress(10);</script>');
flush_buffers();
# exec('sudo ' . $emsscriptpath . '/calcemsgraphs.sh &');
exec( $emsscriptpath . '/calcemsgraphs_h.sh &');
print('<script type="text/javascript">progress(20);</script>');
flush_buffers();
exec( $emsscriptpath . '/calcemsgraphs_d.sh &');
print('<script type="text/javascript">progress(40);</script>');
flush_buffers();
exec( $emsscriptpath . '/calcemsgraphs_3.sh &');
print('<script type="text/javascript">progress(60);</script>');
flush_buffers();
exec( $emsscriptpath . '/calcemsgraphs_w.sh &');
print('<script type="text/javascript">progress(80);</script>');
flush_buffers();
exec( $emsscriptpath . '/calcemsgraphs_m.sh &');
print('<script type="text/javascript">progress(100);</script>');
flush_buffers();
?>
<p>
<p><input type=submit value="Aktualizuj">

</form>

