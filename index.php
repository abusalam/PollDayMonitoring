<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Poll Day Monitoring - Paschim Medinipur</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="css/MapUI.css" />
    <script src="js/Maps.js"></script>
    <script src="js/DataPS.js"></script>
    <script src="js/markerclusterer.js" type="text/javascript"></script>
  </head>
  <body>
    <div id="panel">
      <div style="float:left;">
        <label for="PC">
          <span>PC:</span>
          <select name="pc" id="PC" style="width:150px">
          </select>
        </label>
      </div>
      <div style="float:left;">
        <label for="AC">
          <span>AC:</span>
          <select name="ac" id="AC" style="width:175px">
          </select>
        </label>
      </div>
      <button id="ShowPS" >Show</button>
      <button id="RemovePS" >Remove</button>
      <hr style="clear: both;"/>
      <div id="filters">
        <input type="checkbox" id="Critical" value="1">
        <label for="Critical">Critical</label>
        <input type="checkbox" id="MSZ" value="1">
        <label for="MSZ">Mobile Shadow Zone</label>
        <input type="checkbox" id="Vulnerable" value="1">
        <label for="Vulnerable">Vulnerable</label>
        <?php
        $_SESSION['AjaxToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . time());
        ?>
        <input type="hidden" id="AjaxToken" value="<?php echo $_SESSION['AjaxToken']; ?>"/>
      </div>
      <hr style="clear: both;"/>
      <div>
        <span id="Msg"></span>
        <span id="Error" style="color:red;"></span>
        <span id="ED"></span>
      </div>
    </div>
    <div id="map-canvas"></div>
    <script>
      $("#filters").buttonset();
    </script>
  </body>
</html>