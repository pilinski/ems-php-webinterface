<h1>Ogrzewanie w ostatniej godzinie<hr></h1>
<?php
include("a_emsmenu.inc");
include 'sensor_utils.php.inc';
include 'utils.php.inc';

set_loc_settings();

$aussentemp = get_min_max_interval(SensorAussenTemp, "1 hour");
$aussentemp_today = get_min_max_for_day(SensorAussenTemp, 0);
$aussentemp_yesterday = get_min_max_for_day(SensorAussenTemp, 1);
$raumtemp = get_min_max_interval(SensorRaumIstTemp, "1 hour");
?>
<p>
  <table style="width:90%; text-align:left;">
    <tr><td>
      <table border=0 cellspacing=0 cellpadding=0 width="100%">
        <tr><td>
          <?php print_min_max_table("Zewnetrzne temperatury w ostatniej godzinie", $aussentemp); ?>
        </td></tr>
        <tr height=6></tr>
        <tr><td>
          <?php print_min_max_table("Zewnetrzne temperatiry dzisiaj", $aussentemp_today, TRUE); ?>
        </td></tr>
        <tr height=6></tr>
        <tr><td>
          <?php print_min_max_table("Zewnetrzne temperatiry wczoraj", $aussentemp_yesterday, TRUE); ?>
        </td></tr>
        <tr height=6></tr>
        <tr><td>
          <?php print_min_max_table("Temperatury pomieszczen w ostaniej godznie", $raumtemp); ?>
        </td></tr>
      </table>
    </td></tr>
  </table>
  <h3>Graphen</h3>
  <p>
    <img src="graphs/aussentemp-hour.png" width=90% alt="temperatura zewnetrzna">
  </p>
  <p>
    <img src="graphs/raumtemp-hour.png" width=90% alt="Temperatura pomieszczen">
  </p>
  <p>
    <img src="graphs/kessel-hour.png" width=90% alt="Temperatura kotla">
  </p>
  <p>
    <img src="graphs/ww-hour.png" width=90% alt="Temperatura c.w.u.">
  </p>
  <p>
    <img src="graphs/brenner-hour.png" width=90% alt="Status palnika">
  </p>
  <p>
    <img src="graphs/pumpen-hour.png" width=90% alt="Status pomp">
  </p>
