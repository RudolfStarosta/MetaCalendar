<?php
// Erlaube Zugriff nur von Joomla! aus:
defined('_JEXEC') or die;

if (mc_Debug) echo __FILE__ . ', Line:' . __LINE__ . ' ---> Entering file <br />';

// Die View-Klasse (von JViewLegacy abgeleitet):
class MetaCalendarController extends JControllerLegacy
{
  function __construct()
  {
    parent::__construct();
    if (mc_Debug) echo __FILE__ . ', Line:' . __LINE__ . ' ---> New instance of MetaCalendarController <br />';
  }

  function __destruct()
  {
    if (mc_Debug) echo __FILE__ . ', Line:' . __LINE__ . ' ---> Remove instance of MetaCalendarController ++ </h4> <br />';
  }
}

if (mc_Debug) echo __FILE__ . ', Line:' . __LINE__ . ' ---> Leaving file <br />';

?>
