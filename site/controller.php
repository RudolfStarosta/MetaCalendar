<?php
// Erlaube Zugriff nur von Joomla! aus:
defined('_JEXEC') or die;

if (mc_Debug) echo "<h3> + Entering site/controller.php + </h3> <br />";

// Die View-Klasse (von JViewLegacy abgeleitet):
class MetaCalendarController extends JControllerLegacy
{
  function __construct()
  {
    parent::__construct();
    if (mc_Debug) echo "<h4> ++ New instance of MetaCalendarController ++ </h4> <br />";
  }

  function __destruct()
  {
    if (mc_Debug) echo "<h4> ++ Remove instance of MetaCalendarController ++ </h4> <br />";
  }
}

if (mc_Debug) echo "<h3> + Leaving site/controller.php + </h3> <br />";

?>
