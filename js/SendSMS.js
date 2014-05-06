if (typeof (EventSource) !== "undefined")
{
  var source = new EventSource("sms/SendSSE.php");
  source.onmessage = function(event)
  {
    console.log(event.data);
    var DataResp = $.parseJSON(event.data);
    $('#Error').html(DataResp);
    $('#Msg').html(DataResp.Data);
    $('#ED').html(DataResp.RT);
    if ($('#SentList li').size() > 15) {
      $('#SentList li').slice(0, 5).remove();
    }
    var d = new Date();
    $.each(DataResp.Data,
            function(index, value) {

              $('#SentList').append('<li>'
                      + '[' + value.SL + '] '
                      + d.toTimeString()
                      + ' -' + value.PerCode
                      + '-' + value.PerName
                      + '-' + value.Mobile
                      + '-' + value.Msg
                      + '</li>');
            });
    $("#Msg").show();
  };
}
else
{
  $('#Error').html("Sorry, your browser does not support server-sent events...");
  $('#Error').show();
}


