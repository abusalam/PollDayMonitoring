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
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="js/jquery-ui.css" />
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/DataPS.js"></script>
  </head>
  <body>
    <button id="SendSMS" >Send SMS</button>
    <button id="ClearData" >Clear List</button>
    <hr style="clear: both;"/>
    <?php
    $_SESSION['AjaxToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . time());
    ?>
    <input type="hidden" id="AjaxToken" value="<?php echo $_SESSION['AjaxToken']; ?>"/>
    <ol id="SentList">
    </ol>
    <hr style="clear: both;"/>
    <div>
      <span id="Msg"></span>
      <span id="Error" style="color:red;"></span>
      <span id="ED"></span>
    </div>
  </div>
  <div id="map-canvas"></div>
</body>
</html>