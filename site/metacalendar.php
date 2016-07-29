<?php
// Erlaube Zugriff nur von Joomla! aus
defined('_JEXEC') or die;

// Debug or not
defined('mc_Debug') or define('mc_Debug', TRUE);

mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
		      "Debugging on!");

if (mc_Debug) {
  echo '<pre>';
  echo 'Dump of $_POST <br />';
  var_dump($_POST);
  // phpinfo();
  echo '</pre>';
}

// Controller-Objekt erstellen:
mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
              "Create instance of controller");

$controller = JControllerLegacy::getInstance('MetaCalendar');

// Die gestellte Aufgabe lösen:
mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
              "Create instance of controller");

$controller->execute('');

// Weiterleiten, sofern der Controller dies verlangt:
mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
              "Redirect Controller");

$controller->redirect();

function mc_debug_echo($file, $line, $class, $method, $text)
{
  if (mc_Debug) {
	echo '<pre>';
    echo 'File: ' . $file . '<br/>';
    echo 'Line: ' . $line . '<br/>';
    echo 'Class: ' . $class . '<br/>';
    echo 'Method: ' . $method . '<br/>';
	echo 'Text: ' . $text . '<br />';
	echo '</pre>';
  }
}

mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
              "Leaving File");

?>
