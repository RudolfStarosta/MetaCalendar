<?php
// Layout of Metacalendar default view
defined('_JEXEC') or die;

if (mc_Debug) {
  echo '<pre>';
  echo 'File: ' . __FILE__ . '<br/>';
  echo 'Line: ' . __LINE__ . '<br/>';
  echo 'Class: ' . __CLASS__ . '<br/>';
  echo 'Method: ' . __METHOD__ . '<hr/>';
  echo '</pre>';
}

?>

<h2> Wanderprogramm (JEvents) </h2> <br /> <br />

<!-- Search dialog -->

<?php if (mc_Debug) echo "Route: ", JRoute::_('index.php?option=com_metacalendar'),"<br />"; ?>

<form action="<?php echo JRoute::_('index.php?option=com_metacalendar')?>" method="post">
  
  <table>
  <tr>
    <td style="padding:20px; vertical-align: bottom;"> <?php echo $this->form->renderField('jform_publish_up'); ?> </td>
    <td style="padding:20px; vertical-align: bottom;"> <?php echo $this->form->renderField('jform_publish_down'); ?> </td>
    <td style="padding:20px; vertical-align: bottom;"> <?php echo $this->form->renderField('og'); ?> </td>
    <td style="padding:20px; vertical-align: bottom;"> <br /> <input type=submit value="Suchen"> </td>
  </tr>
  </table>
</form>

<?php

  // Loop on tables if there are any

  if ($this->allEvents == false)
  {
    if (mc_Debug){
      echo "No events found, returning to caller. <br />";
      echo "<h3> + Returning from site/views/metacalendar/tmpl/default.php + </h3> <br />";
    }
  	echo "<h2> Keine Termine für diese Auswahl gefunden</h2>";
    return;
  }

  if (mc_Debug) echo "# of tables found: " . count($this->allEvents) . "<br />";  
  foreach($this->allEvents as $name=>$entry)
  {
    $og = ucfirst($name);
  	echo "<h2> Termine der Ortgruppe $og </h2>";
?>
<!-- @@@ Datum, Uhrzeit, Ereignis, Ort -->
<table>
 <tr>
  <td style="padding: 15px;"> <b> Start        </b> </td>
  <td style="padding: 15px;"> <b> Beschreibung </b> </td>
 </tr>

<?php
  // Loop on events

  foreach($entry as $event)
  {
    echo "<tr>";
    echo '<td style="padding: 15px;">' . $event->startrepeat . "</td>";
    echo '<td style="padding: 15px;">' . $event->summary     . "</td>";
    echo "</tr>";
  } // End of loop on events
?>

</table> <br />

<?php
 } // End of loop on tables

if (mc_Debug) echo " + <h3> Leaving site/views/metacalendar/tmpl/default.php + </h3> <br />";

?>

