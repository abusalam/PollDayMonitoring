$(function() {
    $.ajax({
        type: 'POST',
        url: 'ajax/AjaxData.php',
        dataType: 'json',
        data: {
            'AjaxToken': $('#AjaxToken').val(),
            'CallAPI': 'GetACPCs'
        }
    }).done(function(DataResp) {
        try {
            $('#Error').html(DataResp);
            $('#Msg').html(DataResp.Msg);
            $('#ED').html(DataResp.RT);
            var Options = '<option value="%">Select PC</option>';
            $.each(DataResp.PCs.Data,
                    function(index, value) {
                        Options += '<option value="' + value.PCNo + '">'
                                + value.PCNo + ' - ' + value.PCName
                                + '</option>';
                    });
            $('#PC').html(Options);
            $('#AC').data('ACs', DataResp.ACs);
            $('ShowPS').data('PSs', DataResp.PSs)
            delete DataResp;
            $("#Msg").hide();
        }
        catch (e) {
            $('#Msg').html('Server Error:' + e);
            $('#Error').html(DataResp);
        }
    }).fail(function(msg) {
        $('#Msg').html(msg);
    });

    $('#PC').change(function() {
        $("#Msg").hide();
        $("#example_wrapper").hide();
        var Options = '<option value="%">All ACs</option>';
        var ACs = $('#AC').data('ACs');
        var PCNo = parseInt($(this).val());
        $.each(ACs.Data,
                function(index, value) {
                    if (value.PCNo === PCNo) {
                        Options += '<option value="' + value.ACNo + '">'
                                + value.ACNo + ' - ' + value.ACName
                                + '</option>';
                    }
                });
        $('#AC').html(Options);
    });
    $('#ShowPS').click(function() {
        $.ajax({
            type: 'POST',
            url: 'ajax/AjaxData.php',
            dataType: 'json',
            data: {
                'AjaxToken': $('#AjaxToken').val(),
                'CallAPI': 'GetPSs',
                'PCNo': $('#PC').val(),
                'ACNo': $('#AC').val()
            }
        }).done(function(DataResp) {
            try {
                $('#Error').html(DataResp);
                $('#Msg').html(DataResp.Msg);
                $('#ED').html(DataResp.RT);
                $.each(DataResp.PSs.Data,
                        function(index, value) {
                            neighborhoods.push(
                                    new google.maps.LatLng(value.Lat, value.Lng)
                                    );
                            DataPS.push(value);
                        });
                $('#ShowPS').data('PSs', DataResp.PSs);
                delete DataResp;
                drop();
                $("#Msg").hide();
            }
            catch (e) {
                $('#Msg').html('Server Error:' + e);
                $('#Error').html(DataResp);
            }
        }).fail(function(msg) {
            $('#Msg').html(msg);
        });
    });
});


