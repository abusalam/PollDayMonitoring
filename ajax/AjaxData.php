<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);
/**
 * Generating JSON Response for Ajax Data
 */
require_once ( __DIR__ . '/../lib.inc.php');

if (!isset($_SESSION)) {
    session_start();
}

if (WebLib::GetVal($_POST, 'AjaxToken') === WebLib::GetVal($_SESSION, 'AjaxToken')) {
    $_SESSION['LifeTime'] = time();
    $_SESSION['RT'] = microtime(TRUE);
    $_SESSION['CheckAuth'] = 'Valid';
    $DataResp['Data'] = array();
    $DataResp['Msg'] = '';
    switch (WebLib::GetVal($_POST, 'CallAPI')) {

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
            $Query = 'Select  `ACNo`, `PSNo`, `PSName`, `Lat`, `Lng`, `Critical` '
              . ' From `' . MySQL_Pre . 'AllData` Where `PCNo`=? AND `ACNo`=?';
            $DataResp['PSs'] = array();
            doQuery($DataResp['PSs'], $Query, array(WebLib::GetVal($_POST, 'PCNo'), WebLib::GetVal($_POST, 'ACNo')));
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
