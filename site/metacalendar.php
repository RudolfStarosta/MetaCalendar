<?php
// Erlaube Zugriff nur von Joomla! aus
defined('_JEXEC') or die;

// Debug or not
defined('mc_Debug') or define('mc_Debug', FALSE);

if (mc_Debug) {
  echo '<h3> + Entering File ' . __FILE__ . ' + </h3> <br />';
  echo '<h4> + Line is ' . __LINE__ . ' + </h4> <br />';
  echo '<h4> + We are in class ' . __CLASS__ . ' + </h4> <br />';
  echo '<h4> + Method is ' . __METHOD__ . ' + </h4> <br />';
  echo 'Dump of $_POST <br />';
  var_dump($_POST);
  // phpinfo();
  echo '<br />';
}

// Controller-Objekt erstellen:
if (mc_Debug) echo '--> Create instance of controller <br />';
$controller = JControllerLegacy::getInstance('MetaCalendar');

// Die gestellte Aufgabe lösen:
if (mc_Debug) echo '--> Execute Controller <br />';
$controller->execute('');

// Weiterleiten, sofern der Controller dies verlangt:
if (mc_Debug) echo '--> Redirect Controller <br />';
$controller->redirect();

if (mc_Debug) echo '<h3> + Leaving File ' . __FILE__ . ' + </h3> <br />';

?>
