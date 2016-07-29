<?php
// Erlaube Zugriff nur von Joomla! aus:
defined('_JEXEC') or die;

mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
              "Entering file");

// Die View-Klasse (von JViewLegacy abgeleitet):
class MetaCalendarViewMetaCalendar extends JViewLegacy
{

 protected $form;        // Variable to hold the selection filter form
 protected $allEvents;   // Variable to hold all tables according to selection
 
 // Ausgabefunktion:
 
 function display($tpl = null)
 {
  mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
                "-");

  // Form to filter events
  // Build default form on first call or if no valid values given
  
  mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
               "Before get(\'Form\')");
  $this->form        = $this->get('Form');
  mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
               "After get(\'Form\')");
   
  // Get Events vom Model as required by filter form
  
  $this->allEvents   = $this->get('Events');


  // Abschließend display() der Basisklasse aufrufen:
  
  parent::display($tpl);

  mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
               "End of function");
  
 }
}

mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
             "End of file");

?>
