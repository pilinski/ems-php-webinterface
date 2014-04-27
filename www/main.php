<script type="text/javascript">
function popup (url) {
  fenster = window.open(url, "Popupfenster", "width=1000,height=850,resizable=yes,scrollbars=yes");
  fenster.focus();
  return false;
}
function popup2 (url) {
  fenster = window.open(url, "Popupfenster2", "width=600,height=200,resizable=no,scrollbars=no");
  fenster.focus();
  return false;
}
</script>
<h1>
Sterowanie ogrzewaniem
<hr>
</h1>&nbsp;
<table cellpadding=20px>
<tr><td bgcolor=#cccccc>
<div align=right>
<a href="?seite=a_emsdet.php&menu=no"  onclick="return popup(this.href);">Dane EMS (czyste)</a>
&nbsp;&nbsp;
<a href="?seite=a_emstest.php&menu=no"  onclick="return popup2(this.href);">Test funkcjonowania</a>
</div>
</td></tr>
<tr>
<td align=center>
<img src=img/uebersicht.png width=70%><p>
<b>wersja polska</b> (c) 2014 Maciej Piliński<br>
<b>ems-php-webinterface</b> (c) 2014 Michael Moosbauer<br>
<b>ems-tools</b> (c) 2014 Michael Moosbauer<br>
<b>ems-collector</b> (c) 2014 Danny Baumann<br>
<b>ethersex</b> mit EMS-Framer (c) 2014 Danny Baumann<br>
</td>
</tr>
</table>
