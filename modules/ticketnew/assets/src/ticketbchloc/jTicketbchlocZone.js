var tTCKBchLocZoneAgnCode   = $('#ohdTCKBchLocZoneAgnCode').val();
var tTCKBchLocZoneBchCode   = $('#ohdTCKBchLocZoneBchCode').val();
var tTCKBchLocZoneLocCode   = $('#ohdTCKBchLocZoneLocCode').val();

$("document").ready(function(){
    JSxTCKBchLocZoneNavDefault();
    JSvTCKBchLocZoneDataTable();

    // Event Click Title Menu Zone
    $('#odvTCKBchLocDataZone #olbTCKBchLocZoneInfo').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKBchLocZoneDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Call Page Add Zone
    $('#odvTCKBchLocDataZone #obtTCKBchLocZoneCallPageAdd').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKBchLocCallPageBchLocAddZone();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Cancel Event Zone
    $('#odvTCKBchLocDataZone #obtTCKBchLocZoneCancel').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKBchLocZoneDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Add/Edit Event Zone
    $('#odvTCKBchLocDataZone #obtTCKBchLocZoneSave').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmBchLocZoneForm #obtBchLocZoneAddEdit').trigger('click');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

});

// Functionality : Setting default Nav
// Parameters : -
// Creater : 30/05/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKBchLocZoneNavDefault(){
    // Hide Title And Button Default
    $('#olbTCKBchLocZoneAdd').hide();
    $('#olbTCKBchLocZoneEdit').hide();
    $('#odvTCKBchLocZoneBtnGrpAddEdit').hide();
    // Show Title And Button Default
    $('#olbTCKBchLocZoneInfo').show();
    $('#odvTCKBchLocZoneBtnGrpInfo').show();
}

// Functionality : Load data table
// Parameters : LocCode
// Creater : 30/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocZoneDataTable(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKBchLocZoneDataTable",
        data: {
            'ptTCKBchLocZoneAgnCode' : tTCKBchLocZoneAgnCode,
            'ptTCKBchLocZoneBchCode' : tTCKBchLocZoneBchCode,
            'ptTCKBchLocZoneLocCode' : tTCKBchLocZoneLocCode,
        },
        success: function(oResult) {
            let aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxTCKBchLocZoneNavDefault();
                $('#odvTCKBchLocDataZone #odvTCKBchLocZoneContent').html(aReturnData['oTCKBchLocViewZoneDataList']);
            } else {
                let tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Call add page
// Parameters : -
// Creater : 21/04/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocCallPageBchLocAddZone(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKBchLocZonePageAdd",
        data: {
            'ptTCKBchLocZoneAgnCode' : tTCKBchLocZoneAgnCode,
            'ptTCKBchLocZoneBchCode' : tTCKBchLocZoneBchCode,
            'ptTCKBchLocZoneLocCode' : tTCKBchLocZoneLocCode,
        },
        success: function(tResult) {
            $('#odvTCKBchLocDataZone #odvTCKBchLocZoneContent').html(tResult);
            // Hide Title And Button
            $('#olbTCKBchLocZoneEdit').hide();
            $('#odvTCKBchLocZoneBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbTCKBchLocZoneAdd').show();
            $('#odvTCKBchLocZoneBtnGrpAddEdit').show();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Event add/edit data
// Parameters : -
// Creater : 30/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocZoneAddEdit(){
    $('#ofmBchLocZoneForm').validate().destroy();
    $('#ofmBchLocZoneForm').validate({
        rules: {
            oetTCKBchLocZneName: { "required": {} },
        },
        messages: {
            oetTCKBchLocZneName: {
                "required"      : $('#oetTCKBchLocZneName').attr('data-validate-required'),
            },
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
            error.addClass("help-block");
            if (element.prop("type") === "checkbox") {
                error.appendTo(element.parent("label"));
            } else {
                let tCheck = $(element.closest('.form-group')).find('.help-block').length;
                if (tCheck == 0) {
                    error.appendTo(element.closest('.form-group')).trigger('change');
                }
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
        },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: "masTCKBchLocZoneEventAdd",
                data: $("#ofmBchLocZoneForm").serialize(),
                timeout: 0,
                success: function(tResult) {
                    let aDataReturn = JSON.parse(tResult);
                    if(aDataReturn['nStaEvent'] == 1){
                        let tCodeReturn = aDataReturn['tDataCodeReturn'];
                        JSvTCKBchLocZoneDataTable(tCodeReturn);
                        $("#obtTCKBchLocBrowseAgn").attr("disabled", true);
                        $("#obtTCKBchLocBrowseBch").attr("disabled", true);
                    }else{
                        let tMsgErrorFunction   = aDataReturn['tStaMessg'];
                        FSvCMNSetMsgErrorDialog('<p class="text-left">'+ tMsgErrorFunction +'</p>');
                    }
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    });
}

// Functionality : Event delete 1 item
// Parameters : Zone Data
// Creater : 30/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocZoneDelete(poData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKBchLocZoneEventDelete",
        data: poData,
        success: function(tResult){
            let aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaEvent'] == 1){
                let tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSvTCKBchLocZoneDataTable(tCodeReturn, 1);
                if(aDataReturn['nCountZne'] == 0 && aDataReturn['nCountFac'] == 0){
                    $("#obtTCKBchLocBrowseAgn").attr("disabled", false);
                    $("#obtTCKBchLocBrowseBch").attr("disabled", false);
                }
            }else{
                let tMsgErrorFunction   = aDataReturn['tStaMessg'];
                FSvCMNSetMsgErrorDialog('<p class="text-left">'+ tMsgErrorFunction +'</p>');
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}