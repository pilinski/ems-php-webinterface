﻿<h1>Ogrzewanie wczoraj<hr></h1>
<?php
include("a_emsmenu.inc");
include 'sensor_utils.php.inc';
include 'utils.php.inc';

set_loc_settings();

$aussentemp = get_min_max_interval(SensorAussenTemp, "1 day");
$aussentemp_today = get_min_max_for_day(SensorAussenTemp, 0);
$aussentemp_yesterday = get_min_max_for_day(SensorAussenTemp, 1);
$raumtemp = get_min_max_interval(SensorRaumIstTemp, "1 day");
?>
<p>
  <table style="width:90%; text-align:left;">
    <tr><td>
      <table border=0 cellspacing=0 cellpadding=0 width="100%">
        <tr><td>
          <?php print_min_max_table("Temp. zewnętrzne w ostatnich 24h", $aussentemp); ?>
        </td></tr>
        <tr height=6></tr>
        <tr><td>
          <?php print_min_max_table("Temp. zewnętrzne dzisiaj", $aussentemp_today, TRUE); ?>
        </td></tr>
        <tr height=6></tr>
        <tr><td>
          <?php print_min_max_table("Temp. zewnętrzne wczoraj", $aussentemp_yesterday, TRUE); ?>
        </td></tr>
        <tr height=6></tr>
        <tr><td>
          <?php print_min_max_table("Temperatura pomieszczeń w ostatnich 24h", $raumtemp); ?>
        </td></tr>
      </table>
    </td></tr>
  </table>
  <h3>Graphen</h3>
  <p>
    <img src="graphs/aussentemp-day.png" width=90% alt="Temperatira zewnetrzna">
  </p>
  <p>
    <img src="graphs/raumtemp-day.png" width=90% alt="Temperatura pomiesazczen">
  </p>
  <p>
    <img src="graphs/kessel-day.png" width=90% alt="Temperatura kotla">
  </p>
  <p>
    <img src="graphs/ww-day.png" width=90% alt="Temperaratura c.w.u.">
  </p>
  <p>
    <img src="graphs/brenner-day.png" width=90% alt="Status palnika">
  </p>
  <p>
    <img src="graphs/pumpen-day.png" width=90% alt="Status pompy">
  </p>
