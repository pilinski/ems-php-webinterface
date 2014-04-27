<h1>
Status ogrzewania
<hr></h1>
<form method="post">

<?php
require("/emsincludes/config.php");
include("a_emsmenu.inc");

require 'sensor_utils.php.inc';
require 'utils.php.inc';

set_loc_settings();

$sensors = get_current_sensor_values();
$changes = get_sensor_changes_for_day(0);

function print_header($name) {
#  $name=utf8_decode($name);
  print "<table border=1 cellspacing=3 cellpadding=2 width=\"100%\">\n";
  print "<tr><td colspan=2 style=\"background-color: rgb(102,153,204);\" height=21>\n";
  print "<p><b><span style=\"font-size: medium; color: rgb(255,255,255);\">" . $name . "</span></b></p>\n";
  print "</td></tr>\n";
}

function print_cell($name, $value, $color = "") {
#  $name=utf8_decode($name);
  $value=utf8_decode($value);
  print "<tr>\n";
  if ($color == "green") {
    $color = " style=\"background-color: rgb(0,200,0); color: rgb(255,255,255);\"";
  } else if ($color == "red") {
    $color = " style=\"background-color: rgb(200,0,0); color: rgb(255,255,255);\"";
  } else if ($color == "yellow") {
    $color = " style=\"background-color: rgb(200,200,0); color: rgb(255,255,255);\"";
  } else {
    $color = "";
  }

  print "<td width=147 height=18><p>" . $name . "</p></td>\n";
  print "<td width=129 align=center><p><span" . $color . ">" . $value . "</span></p></td>\n";
  print "</tr>\n";
}
?>
  
 
  <table border=0 cellspacing=0 cellpadding=0 style="width:90%; text-align:center;">
    <tr><td width="100%">
    </td></tr>
    <tr><td>
    </td></tr>
    <tr height=10></tr>
    <tr><td>
      <table>
        <tr valign="top">
          <td width=390>
            <?php
              print_header("Ogrzewanie");
              print_cell("Kocioł JEST", $sensors[SensorKesselIstTemp]);
              print_cell("Kocioł UST.", $sensors[SensorKesselSollTemp]);
              $value = $sensors[SensorKesselPumpe] && !$sensors[Sensor3WegeVentil];
              print_cell("Przepływ pompy", $value ? "- wł -" : "- wył -", $value ? "green" : "");
              $value = $sensors[SensorBrenner];
              print_cell("Palnik",
                         $value ? ($sensors[SensorWarmwasserBereitung] ? "Przygotowanie c.w.u." : "Ogrzewanie") : "- wył -",
                         $value ? "red" : "");
              $value = $sensors[SensorFlamme] ? " - wł, " . $sensors[SensorFlammenstrom] . " -" : " - wył -";
              print_cell("Płomień", $value, $sensors[SensorFlamme] ? "red" : "");
              $value = $sensors[SensorMomLeistung] . " / " . $sensors[SensorMaxLeistung];
              print_cell("Moc chwilowa", $value);
              print_cell("Tryb letni", $sensors[SensorSommerbetrieb] ? "- aktywny -" : "- nieaktywny -");
            ?>
            </table>
          </td>
          <td width=20></td>
          <td width=390>
            <?php
              print_header("Obiegi grzewcze");
              $value = $sensors[SensorVorlaufHK1SollTemp] . " / " . $sensors[SensorVorlaufHK1IstTemp];
              print_cell("Obieg grzewczy 1 Ust./Jest", $value);
              if ($sensors[SensorHK1Party]) {
                $value = "Party";
              } else if ($sensors[SensorHK1Ferien]) {
                $value = "Urlop";
              } else {
                $value = ($sensors[SensorHK1Automatik] ? "Automat" : "Ręcznie") . " (" .
                         ($sensors[SensorHK1Tagbetrieb] ? "Dzień" : "Noc") . ")";
              }
              print_cell("Tryb pracy OG1", $value);
              print_cell("Popmpa OG1",
                         $sensors[SensorHK1Pumpe] ? "- aktywna -" : "- nieaktywna -", 
                         $sensors[SensorHK1Pumpe] ? "green" : "");
              $value = $sensors[SensorVorlaufHK2SollTemp] . " / " . $sensors[SensorVorlaufHK2IstTemp];
              print_cell("Obieg grzewczy 2 Ust./Jest", $value);
              if ($sensors[SensorHK2Party]) {
                $value = "Party";
              } else if ($sensors[SensorHK2Ferien]) {
                $value = "Urlop";
              } else {
                $value = ($sensors[SensorHK2Automatik] ? "Automat" : "Ręcznie") . " (" .
                         ($sensors[SensorHK2Tagbetrieb] ? "Dzień" : "Noc") . ")";
              }
              print_cell("Tryb pracy OG2", $value);
              print_cell("Pompa OG2",
                         $sensors[SensorHK2Pumpe] ? "- aktywna -" : "- nieaktywna -", 
                         $sensors[SensorHK2Pumpe] ? "green" : "");
              print_cell("Miszacz OG2", $sensors[SensorMischersteuerung]);
              print_cell("Temp. powrotu JEST", $sensors[SensorRuecklaufTemp]);
            ?>
            </table>
          </td>
        </tr>
        <tr height=6></tr>
        <tr valign="top">
          <td width=390>
            <?php
              print_header("Ciepła Woda Użytkowa (c.w.u.)");
              print_cell("Ciepła woda JEST", $sensors[SensorWarmwasserIstTemp],
                         $sensors[SensorWarmwasserTempOK] ? "" : "yellow");
              print_cell("Ciepła woda UST.", $sensors[SensorWarmwasserSollTemp]);
              $value = $sensors[SensorWWTagbetrieb] ? "Dzień" : "Noc";
              print_cell("Tryb pracy", $value);
              $value = $sensors[SensorKesselPumpe] && $sensors[Sensor3WegeVentil];
              print_cell("Pompa c.w.u.", $value ? "- wł -" : "- wył -", $value ? "green" : "");
              $value = $sensors[SensorZirkulation];
              print_cell("Pompa cyrkulacji", $value ? "- wł -" : "- wył -", $value ? "green" : "");
              print_cell("Priorytet c.w.u.", $sensors[SensorWWVorrang] ? "- wł -" : "- wył -");
            ?>
            </table>
          </td>
          <td width=20></td>
          <td width=390>
            <?php
              print_header("Inne temperatury");
              print_cell("Temp. zewn.", $sensors[SensorAussenTemp]);
              print_cell("temp. zewn. tłumiona", $sensors[SensorGedaempfteAussenTemp]);
              print_cell("Temp. pom. JEST", $sensors[SensorRaumIstTemp]);
              print_cell("Temp. pom. UST.", $sensors[SensorRaumSollTemp]);
            ?>
            </table>
          </td>
        </tr>
        <tr height=6></tr>
        <tr valign="top">
          <td width=390>
            <?php
              print_header("Dzisiejsza aktywność");
              print_cell("Czas pracy palnika", $changes[SensorBetriebszeit]);
              print_cell("Ilość zapłonów palnika", $changes[SensorBrennerstarts]);
              print_cell("Czas pracy palnika na ogrzewaniu", $changes[SensorHeizZeit]);
              print_cell("Czas przygotowowania c.w.u.", $changes[SensorWarmwasserbereitungsZeit]);
              print_cell("Ilość przygotowań c.w.u.", $changes[SensorWarmwasserBereitungen]);
            ?>
            </table>
          </td>
          <td width=20></td>
          <td width=390>
            <?php
              print_header("Stan pracy");
              print_cell("Czas pracy palnika", $sensors[SensorBetriebszeit]);
              print_cell("Ilość zapłonów palnika", $sensors[SensorBrennerstarts]);
              print_cell("Ciśnienie w instalacji", $sensors[SensorSystemdruck]);
              print_cell("Kod serwisowy", $sensors[SensorServiceCode]);
              print_cell("Kod błędu", $sensors[SensorFehlerCode]);
              # TODO: Fehler
            ?>
            </table>
          </td>
        </tr>
      </table>
    </td></tr>
  </table>
  
<input type=submit value="Aktualizuj">

</form>
