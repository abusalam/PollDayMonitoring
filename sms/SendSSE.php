<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);
/**
 * Generating JSON Response for Ajax Data
 */
require_once ( __DIR__ . '/../config.inc.php');
require_once ( __DIR__ . '/../lib.inc.php');

include_once(__DIR__ . '/smsgw.inc.php');

if (!isset($_SESSION)) {
  session_start();
  if (!isset($_SESSION['SL'])) {
    $_SESSION['SL'] = 0;
  }
}

$_SESSION['LifeTime'] = time();
$_SESSION['RT'] = microtime(TRUE);
$_SESSION['CheckAuth'] = 'Valid';
$DataResp['Data'] = array();
$DataResp['Msg'] = '';

$_SESSION['POST'] = $_POST;
$Query = 'Select `PerCode`, `name`, `phone_no`, `message`,`MessageSent`'
        . ' From `ppds`.`tblsms` Where `MessageSent`=0 limit 10';
$PPs = array();
doQuery($PPs, $Query);
$DataResp['Data'] = array();
$Status = array();

foreach ($PPs['Data'] as $Value) {

  $name = $Value['name'];
  $Message = $Value['message'];
  $PerCode = $Value['PerCode'];
  $DestinationAddress = $Value['phone_no'];
  $MessageSent = $Value['MessageSent'];

  $Result = SMSGW::SendSMS($Message, $DestinationAddress);

  $UpdateData = new MySQLiDBHelper();
  $UpdateFields['MessageSent'] = $MessageSent + 1;
  $UpdateData->where('PerCode', $PerCode)
          ->update('`ppds`.`tblsms`', $UpdateFields);

  $_SESSION['SL'] = $_SESSION['SL'] + 1;
  $Status['SL'] = $_SESSION['SL'];
  $Status['PerCode'] = $PerCode;
  $Status['PerName'] = $name;
  $Status['Mobile'] = $DestinationAddress;
  $Status['Msg'] = $Result;

  array_push($DataResp['Data'], $Status);
}
$DataResp['PPs'] = $PPs;


$_SESSION['LifeTime'] = time();
$DataResp['RT'] = '<b>Response Time:</b> '
        . round(microtime(TRUE) - WebLib::GetVal($_SESSION, 'RT'), 6) . ' Sec';

$AjaxResp = json_encode($DataResp); //WebLib::prettyPrint(json_encode($DataResp));
unset($DataResp);

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
echo 'data: ' . $AjaxResp . "\n\n";
ob_flush();
flush();
exit();

/**
 * Perfroms Select Query to the database
 *
 * @param ref     $DataResp
 * @param string  $Query
 * @param array   $Params
 * @example GetData(&$DataResp, "Select a,b,c from Table Where c=? Order By b LIMIT ?,?", array('1',30,10))
 */
function doQuery(&$DataResp, $Query, $Params = NULL) {
  $Data = new MySQLiDBHelper();
  $Result = $Data->rawQuery($Query, $Params);
  $DataResp['Data'] = $Result;
  $DataResp['Msg'] = 'Total Rows: ' . count($Result);
  unset($Result);
  unset($Data);
}

?>
