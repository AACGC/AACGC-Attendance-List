<?php

/*
#######################################
#     AACGC Event Listing             #                
#     by M@CH!N3                      #
#     http://www.AACGC.com            #
#######################################
*/

require_once("../../class2.php");

if(!getperms("P")) {
echo "";
exit;
}

require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."form_handler.php"); 
require_once(e_HANDLER."file_class.php");
require_once(e_HANDLER."calendar/calendar_class.php");
$rs = new form;
$fl = new e_file;
$cal = new DHTML_Calendar(true);
function headerjs()
{
	global $cal;
	require_once(e_HANDLER."calendar/calendar_class.php");
	$cal = new DHTML_Calendar(true);
	return $cal->load_files();
}
$offset = +0;
$time = time()  + ($offset * 60 * 60);
//-----------------------------------------------------------------------------------------------------------+
if ($_POST['add_event'] == '1') {
$neweventname = $tp->toDB($_POST['event_name']);
$neweventhost = $tp->toDB($_POST['event_host']);
$neweventloc = $tp->toDB($_POST['event_location']);
$neweventcost = $tp->toDB($_POST['event_cost']);
$neweventdate = $tp->toDB($_POST['event_date']);
$neweventdetail = $tp->toDB($_POST['event_details']);
$neweventlink = $tp->toDB($_POST['event_link']);
$neweventlinktext = $tp->toDB($_POST['event_linktext']);
$neweventopen = $tp->toDB($_POST['event_open']);
$newmaxmembers = $tp->toDB($_POST['event_maxmembers']);
$reason = "";
$newok = "";

if (($neweventname == "")){
	$newok = "0";
	$reason = "No Name For Event";
} else {
	$newok = "1";
}

If ($newok == "0"){
 	$newtext = "
 	<center>
	<b><br><br> ".$reason."
	</center>
 	</b>
	";
	$ns->tablerender("", $newtext);}

If ($newok == "1"){
$sql->db_Insert("aacgc_event_listing", "NULL, '".$neweventname."', '".$neweventhost."', '".$neweventloc."', '".$neweventcost."', '".$neweventdate."', '".$neweventdetail."', '".$neweventlink."', '".$neweventlinktext."', '".$neweventopen."', '".$newmaxmembers."'") or die(mysql_error());
$ns->tablerender("", "<center><b>Event Added</b></center>");
}}

//-----------------------------------------------------------------------------------------------------------+
$text = "
<form method='POST' action='admin_new.php'>
<table style='width:100%' class='fborder' cellspacing='0' cellpadding='0'>";

$text .= "
        <tr>
        <td style='width:40%; text-align:right' class='forumheader3'>Name:</td>
        <td style='width:60%' class='forumheader3'>
        <input class='tbox' type='text' name='event_name' size='50'>
        </td>
        </tr>
        <tr>
        <td style='width:40%; text-align:right' class='forumheader3'>Host:</td>
        <td style='width:60%' class='forumheader3'>
        <input class='tbox' type='text' name='event_host' size='50'>
        </td>
        </tr>
        <tr>
        <td style='width:40%; text-align:right' class='forumheader3'>Location:</td>
        <td style='width:60%' class='forumheader3'>
        <input class='tbox' type='text' name='event_location' size='50'>
        </td>
        </tr>
        <tr>
        <td style='width:40%; text-align:right' class='forumheader3'>Cost:</td>
        <td style='width:60%' class='forumheader3'>
        <input class='tbox' type='text' name='event_cost' size='50'>
        </td>
        </tr>
        <tr>
        <td style='width:40%; text-align:right' class='forumheader3'>Date:</td><td style='width:60%' class='forumheader3'>";

	$text .= $cal->make_input_field(
           array('firstDay'       => 1, // show Monday first
                 'showsTime'      => true,
                 'showOthers'     => true,
                 'ifFormat'       => '%Y/%m/%d %I:%M %P',
                 'weekNumbers'    => false,
                 'timeFormat'     => '12'),
           array('style'       => 'color: #840; background-color: #ff8; border: 1px solid #000; text-align: center',
                 'name'        => 'event_date',
                 'value'       => date("Y/m/d h:i a", $time)));
					
	$text .="</td>";
/*
$text .="<td style='width:60%' class='forumheader3'>
        <input class='tbox' type='text' name='event_date' size='50'>
        </td>";
*/
$text .="</tr>
        <tr>
        <td style='width:40%; text-align:right' class='forumheader3'>Details:</td>
        <td style='width:60%' class='forumheader3'>
        <textarea class='tbox' rows='5' cols='50' name='event_details'></textarea>
        </td>
        </tr>
        <tr>
        <td style='width:40%; text-align:right' class='forumheader3'>Link:</td>
        <td style='width:60%' class='forumheader3'>
        <input class='tbox' type='text' name='event_link' size='50'>
        </td>
        </tr>
        <tr>
        <td style='width:40%; text-align:right' class='forumheader3'>Link Text:</td>
        <td style='width:60%' class='forumheader3'>
        <input class='tbox' type='text' name='event_linktext' size='50'>
        </td>
        </tr>
	<tr>
		<td style='width:30%; text-align:right' class='forumheader3'>Allow User Join Submissions:</td>
                <td style='width:' class=''>
                <select name='event_open' size='1' class='tbox' style='width:50%'>
                <option name='event_open' value='".$row['event_open']."'>".$row['event_open']."</option>
                <option name='event_open' value='Yes'>Yes</option>
                <option name='event_open' value='No'>No</option>
                </td>
	<tr>
        <tr>
        <td style='width:40%; text-align:right' class='forumheader3'>Maximum Participants:</td>
        <td style='width:60%' class='forumheader3'>
        <input class='tbox' type='text' name='event_maxmembers' size='50'>
        </td>
    </tr>	
";

$text .= "</div>
        </td>
	</tr>
		
        <tr style='vertical-align:top'>
        <td colspan='2' style='text-align:center' class='forumheader'>
		<input type='hidden' name='add_event' value='1'>
		<input class='button' type='submit' value='Add Event'>
		</td>
        </tr>
</table>
</form>";
	      $ns -> tablerender("AACGC Event Listing (Add Event)", $text);
	      require_once(e_ADMIN."footer.php");
?>

