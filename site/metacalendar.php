<?php
// Erlaube Zugriff nur von Joomla! aus
defined('_JEXEC') or die;

// Debug or not
defined('mc_Debug') or define('mc_Debug', FALSE);

if (mc_Debug) {
  echo '<pre>';
  echo 'File: ' . __FILE__ . '<br/>';
  echo 'Line: ' . __LINE__ . '<br/>';
  echo 'Class: ' . __CLASS__ . '<br/>';
  echo 'Method: ' . __METHOD__ . '<hr/>';
  echo 'Dump of $_POST <br />';
  var_dump($_POST);
  // phpinfo();
  echo '</pre>';
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

if (mc_Debug) {
  echo '<pre>';
  echo 'Leaving File ' . __FILE__ . '<br />';
  echo '</pre>';
}

?>
