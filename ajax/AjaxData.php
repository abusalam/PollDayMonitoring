<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);
/**
 * Generating JSON Response for Ajax Data
 */
require_once ( __DIR__ . '/../lib.inc.php');

include_once(__DIR__ . '/../sms/smsgw.inc.php');

if (!isset($_SESSION)) {
  session_start();
  if (!isset($_SESSION['SL'])) {
    $_SESSION['SL'] = 0;
  }
}

if (WebLib::GetVal($_POST, 'AjaxToken') === WebLib::GetVal($_SESSION, 'AjaxToken')) {
  $_SESSION['LifeTime'] = time();
  $_SESSION['RT'] = microtime(TRUE);
  $_SESSION['CheckAuth'] = 'Valid';
  $DataResp['Data'] = array();
  $DataResp['Msg'] = '';


  switch (WebLib::GetVal($_POST, 'CallAPI')) {

    case 'SendSMS':
      $_SESSION['POST'] = $_POST;
      $Query = 'Select `PerCode`, `name`, `phone_no`, `message`,`MessageSent`'
              . ' From `ppds`.`tblsms` Where `MessageSent`=0 limit 2';
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
      break;

    case 'GetACPCs':
      $_SESSION['POST'] = $_POST;
      $Query = 'Select `PCNo`, `PCName`'
              . ' From `' . MySQL_Pre . 'Parliament`';
      $DataResp['PCs'] = array();
      doQuery($DataResp['PCs'], $Query);

      $Query = 'Select `ACNo`,`ACName`,`PCNo`'
              . ' FROM `' . MySQL_Pre . 'Assembly`';
      $DataResp['ACs'] = array();
      doQuery($DataResp['ACs'], $Query);
      break;

    case 'GetPSs':
      $_SESSION['POST'] = $_POST;
      $Condition = '';
      $Params = array();
      array_push($Params, WebLib::GetVal($_POST, 'PCNo'));

      if (WebLib::GetVal($_POST, 'ACNo') !== '%') {
        $Condition = $Condition . ' AND `ACNo`=?';
        array_push($Params, WebLib::GetVal($_POST, 'ACNo'));
      }

      if (WebLib::GetVal($_POST, 'Critical') === '1') {
        $Condition = $Condition . ' AND `Critical`>?';
        array_push($Params, 0);
      }
      $Query = 'Select distinct `ACNo`, `PSNo`, `PSName`, `Lat`, `Lng`, `Critical` '
              . ' From `' . MySQL_Pre . 'AllData` Where `PCNo`=? ' . $Condition;
      $DataResp['PSs'] = array();
      doQuery($DataResp['PSs'], $Query, $Params);

//            $Query = 'Select MIN(`Lat`) as `SWLat`, MIN(`Lng`) as `SWLng`,'
//              . ' MAX(`Lat`) as `NELat`, MAX(`Lng`) as `NELng` '
//              . ' From `' . MySQL_Pre . 'AllData` ';
//            $DataResp['Bounds'] = array();
//            doQuery($DataResp['Bounds'], $Query, $Params);
      break;
  }
  $_SESSION['LifeTime'] = time();
  $DataResp['RT'] = '<b>Response Time:</b> '
          . round(microtime(TRUE) - WebLib::GetVal($_SESSION, 'RT'), 6) . ' Sec';
//PHP 5.4+ is required for JSON_PRETTY_PRINT
//@todo Remove PRETTY_PRINT for Production
  if (strnatcmp(phpversion(), '5.4') >= 0) {
    $AjaxResp = json_encode($DataResp, JSON_PRETTY_PRINT);
  } else {
    $AjaxResp = json_encode($DataResp); //WebLib::prettyPrint(json_encode($DataResp));
  }
  unset($DataResp);

  header('Content-Type: application/json');
  header('Content-Length: ' . strlen($AjaxResp));
  echo $AjaxResp;
  exit();
}
header("HTTP/1.1 404 Not Found");
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
