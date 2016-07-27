<?php
// Erlaube Zugriff nur von Joomla! aus:
defined('_JEXEC') or die;

if (mc_Debug) {
  echo '<pre>';
  echo 'File: ' . __FILE__ . '<br/>';
  echo 'Line: ' . __LINE__ . '<br/>';
  echo 'Class: ' . __CLASS__ . '<br/>';
  echo 'Method: ' . __METHOD__ . '<hr/>';
  echo '</pre>';
}

// Die View-Klasse (von JViewLegacy abgeleitet):
class MetaCalendarViewMetaCalendar extends JViewLegacy
{

 protected $allEvents;   // Variable to hold all Tables with events regardless of their prefix
 protected $form;        // Variable to hold the filter form

 // Ausgabefunktion:
 
 function display($tpl = null)
 {
  if (mc_Debug) echo "<h4> ++ Begin: site/views/metacalendar/view.html.php::display() ++ </h4> <br />";

  // Form to filter events
  $this->form        = $this->get('Form');

  // Get all Events vom Model
  
  $this->allEvents   = $this->get('Events');


  // Abschließend display() der Basisklasse aufrufen:
  
  parent::display($tpl);

  if (mc_Debug) echo "<h4> ++ End: site/views/metacalendar/view.html.php::display() ++ </h4> <br />";

 }
}

if (mc_Debug) echo "<h3> + Leaving site/views/metacalendar/view.html.php + </h3> <br />";

?>
