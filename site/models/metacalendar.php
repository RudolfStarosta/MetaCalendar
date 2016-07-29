<?php
// Sicherheitsprüfung: Wird die Klasse von Joomla! verwendet?
defined('_JEXEC') or die;

mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
              "Entering file");

// Die Model-Klasse (von JModelLegacy abgeleitet):
class MetaCalendarModelMetaCalendar extends JModelLegacy
{
 function getForm()
 {

  mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
                "Entering getForm()");
 	
  // Check if the form exists already otherwise create it and fill it
  // with default values
  if (empty($form))
  {
    // Load form
    JForm::addFormPath(JPATH_COMPONENT_SITE . '/models/forms');
    $form = JForm::getInstance('metafilter','metafilter');
    if (mc_Debug){
      echo "Dump of \$form <br /> <pre>";
      var_dump($form);
      echo "</pre> <br />";
    }

    // Test if empty
    if (empty($form))
    {
      mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
                    "Cannot create form.");
      return false;
    }
    mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
                  "Succesfully created form.");
  }
  
  // Set the dates to the entered values
  // Fill $_POST array for further processing
  // Filter evil input
  $date_up = DateTime::createFromFormat('d.m.Y', $_POST["jform_publish_up"]);
  if ($date_up)
  {
    if (mc_Debug) echo "Entered date up ", $date_up->format("d.m.Y"), "<br />";
  	$_POST["jform_publish_up"] = $date_up->format("d.m.Y");
  }
  else
  {
   	$date_up = new DateTime();
   	$_POST["jform_publish_up"] = $date_up->format("d.m.Y");
  }

  $date_down = DateTime::createFromFormat('d.m.Y', $_POST["jform_publish_down"]);
  if ($date_down)
  {
    if (mc_Debug) echo "Entered date down ", $date_down->format("d.m.Y"), "<br />";
   	$_POST["jform_publish_down"] = $date_down->format("d.m.Y");
  }
  else
  {
   	$date_down = new DateTime();
   	$date_down->modify("+7 day");
   	$_POST["jform_publish_down"] = $date_down->format("d.m.Y");
  }

  $prefix = $_POST["prefix"];
  if ($prefix)
  {
  	if (mc_Debug) echo "Entered prefix ", $prefix, "<br />";
  	$_POST["prefix"] = $prefix;
  }
  else
  {
  	$_POST["prefix"] = "all";
  }
  
   // Set the values once again
   $form->setValue("jform_publish_up","",$_POST["jform_publish_up"]);
   $form->setValue("jform_publish_down","",$_POST["jform_publish_down"]);
   $form->setValue("prefix","",$_POST["prefix"]);
    
   if (mc_Debug) echo "jform_publish_up = ", $form->getValue("jform_publish_up"), "<br />";
   if (mc_Debug) echo "jform_publish_down = ", $form->getValue("jform_publish_down"), "<br />";
   if (mc_Debug) echo "prefix = ", $form->getValue("prefix"), "<br />";

   return $form;

 } // End of getForm()

 function getEvents()
 {
  mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
                "Here we go ...");
 	
  // Get "From date"
  $date_from_utc =
  (string)DateTime::createFromFormat('d.m.Y', $_POST["jform_publish_up"])->format('U');
  	
  $date_from =
  (string)DateTime::createFromFormat('d.m.Y', $_POST["jform_publish_up"])->format('Y-m-d H:i:s');
  	 
  // Get "To date"
  $date_to_utc =
  (string)DateTime::createFromFormat('d.m.Y', $_POST["jform_publish_down"])->format('U');
    
  $date_to =
  (string)DateTime::createFromFormat('d.m.Y', $_POST["jform_publish_down"])->format('Y-m-d H:i:s');
    
  // Set the dates to the entered values
  
  if (mc_Debug) {
    echo '<pre>';
  	echo "date_from_utc = ", $date_from_utc, "<br />";
    echo "date_to_utc = ", $date_to_utc, "<br />";
  	echo "date_from = ", $date_from, "<br />";
    echo "date_to = ", $date_to, "<br />";
    echo "prefix = ", $_POST["prefix"], "<br />";
    echo '</pre>';
  }

  // Create database object:

  $db = JFactory::getDbo();

  // Compose Query to retrieve JEvents tables
  // Check which table prefix is wanted, all means all
  $query = $db->getQuery(true);
  $query->select("TABLE_NAME");
  $query->from("INFORMATION_SCHEMA.TABLES");

  if ($_POST["prefix"] == 'all') {
    $query->where("TABLE_NAME LIKE '%jevents_vevdetail'");
  }
  else {
  	$jev_tableName = "'" . $_POST["prefix"] . "_jevents_vevdetail'";
  	$query->where("TABLE_NAME LIKE " . $jev_tableName);
  }

  // Get data

  $db->setQuery((string)$query);
  $allEventTables = $db->loadObjectList();

  if (mc_Debug) echo "Number of JEvent tables found: " . count($allEventTables) . "<br />";

  if (count($allEventTables) == 0) {
    mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
                  "No tables found for this selection.");
  	return false;
  }

  // Get prefixes of tables

  $i = 0; // Count tables

  foreach ($allEventTables as $tableName)
  {    
  	$allEventPrefix[$i] = substr($tableName->TABLE_NAME, 0, strpos($tableName->TABLE_NAME, "_"));
    if (mc_Debug) echo "Prefix found: " . $allEventPrefix[$i] . "<br />";
    $i++;
  }
  
  // Loop on all tables an retrieve events
  // select and where string will not change
  // Tables involved are: #__jevents_vevent, #__jevents_vevdetail and #__jevents_repetition

  $select = $db->quoteName(array('b.startrepeat', 'b.endrepeat', 'c.summary'));
  
  $where  = $db->quoteName('a.ev_id')          . ' =  ' . $db->quoteName('b.eventid')  . ' and ' .
            $db->quoteName('b.eventdetail_id') . ' =  ' . $db->quoteName('c.evdet_id') . ' and ' .
            $db->quoteName('a.state')          . " =  " . '1'                          . ' and ' .
            '((' .
  		    $db->quoteName('b.startrepeat')    . ' >= ' . 'STR_TO_DATE(\'' . $date_from  . '\', \'%Y-%m-%d %H:%i:%S\')'  . ' and ' .
  		    $db->quoteName('b.startrepeat')    . ' <= ' . 'STR_TO_DATE(\'' . $date_to    . '\', \'%Y-%m-%d %H:%i:%S\')'  .
            ') OR (' .
            $db->quoteName('b.endrepeat')    . ' >= ' . 'STR_TO_DATE(\'' . $date_from  . '\', \'%Y-%m-%d %H:%i:%S\')'    . ' and ' .
            $db->quoteName('b.endrepeat')    . ' <= ' . 'STR_TO_DATE(\'' . $date_to    . '\', \'%Y-%m-%d %H:%i:%S\')'    .
            '))';
  		    
  $order  = $db->quoteName('b.startrepeat') . ' asc';
  
  // Compose Queries to retrieve Events from these tables
  
  foreach ($allEventPrefix as $prf)
  {
  	$query = $db->getQuery(true);
  	$query->select($select);
  	
  	$query->from($db->quoteName($prf . '_jevents_vevent')     . ' a, ' .
                 $db->quoteName($prf . '_jevents_repetition') . ' b, ' .
  			     $db->quoteName($prf . '_jevents_vevdetail')  . ' c'
  			    );

  	$query->where($where);
  	$query->order($order);
    
  	if (mc_Debug) echo "Query: " . $query . "<br />";
  	$db->setQuery((string)$query);
  
  	$allEvents[$prf] = $db->loadObjectList();
  	
  	if (mc_Debug) {
  		echo 'Dump of $allEvents[$prf]';
  		var_dump($allEvents[$prf]);
  		echo "<br />";
  	}  	 
  }
 
  if (mc_Debug) echo "<h4> ++ Final end: site/models/metacalendar.php::getEvents() + </h4> <br />";

  return $allEvents;

 } // End of getEvents()

} // End of class MetaCalendarModelMetaCalendar

mc_debug_echo(__FILE__, __LINE__, __CLASS__, __METHOD__,
              "End of file");

?>
