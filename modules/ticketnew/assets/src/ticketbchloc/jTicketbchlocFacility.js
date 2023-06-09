var tTCKBchLocFacAgnCode   = $('#ohdTCKBchLocFacAgnCode').val();
var tTCKBchLocFacBchCode   = $('#ohdTCKBchLocFacBchCode').val();
var tTCKBchLocFacLocCode   = $('#ohdTCKBchLocFacLocCode').val();

$("document").ready(function(){
    JSxTCKBchLocFacNavDefault();
    JSvTCKBchLocFacDataTable();

    // Event Click Title Menu Fac
    $('#odvTCKBchLocDataFac #olbTCKBchLocFacInfo').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKBchLocFacDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Call Page Add Fac
    $('#odvTCKBchLocDataFac #obtTCKBchLocFacCallPageAdd').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKBchLocCallPageBchLocAddFac();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Cancel Event Fac
    $('#odvTCKBchLocDataFac #obtTCKBchLocFacCancel').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKBchLocFacDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Add/Edit Event Fac
    $('#odvTCKBchLocDataFac #obtTCKBchLocFacSave').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmBchLocFacForm #obtBchLocFacAddEdit').trigger('click');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


});

// Functionality : Setting default Nav
// Parameters : -
// Creater : 31/05/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKBchLocFacNavDefault(){
    // Hide Title And Button Default
    $('#olbTCKBchLocFacAdd').hide();
    $('#olbTCKBchLocFacEdit').hide();
    $('#odvTCKBchLocFacBtnGrpAddEdit').hide();
    // Show Title And Button Default
    $('#olbTCKBchLocFacInfo').show();
    $('#odvTCKBchLocFacBtnGrpInfo').show();
}

// Functionality : Load data table
// Parameters : LocCode
// Creater : 30/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocFacDataTable(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKBchLocFacDataTable",
        data: {
            'ptTCKBchLocFacAgnCode' : tTCKBchLocFacAgnCode,
            'ptTCKBchLocFacBchCode' : tTCKBchLocFacBchCode,
            'ptTCKBchLocFacLocCode' : tTCKBchLocFacLocCode,
        },
        success: function(oResult) {
            let aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxTCKBchLocFacNavDefault();
                $('#odvTCKBchLocDataFac #odvTCKBchLocFacContent').html(aReturnData['oTCKBchLocViewFacDataList']);
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
// Creater : 31/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocCallPageBchLocAddFac(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKBchLocFacPageAdd",
        data: {
            'ptTCKBchLocFacAgnCode' : tTCKBchLocFacAgnCode,
            'ptTCKBchLocFacBchCode' : tTCKBchLocFacBchCode,
            'ptTCKBchLocFacLocCode' : tTCKBchLocFacLocCode,
        },
        success: function(tResult) {
            $('#odvTCKBchLocDataFac #odvTCKBchLocFacContent').html(tResult);
            // Hide Title And Button
            $('#olbTCKBchLocFacEdit').hide();
            $('#odvTCKBchLocFacBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbTCKBchLocFacAdd').show();
            $('#odvTCKBchLocFacBtnGrpAddEdit').show();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Event add/edit data
// Parameters : -
// Creater : 31/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocFacAddEdit(){
    $('#ofmBchLocFacForm').validate().destroy();
    $('#ofmBchLocFacForm').validate({
        rules: {
            oetTCKBchLocFacName: { "required": {} },
        },
        messages: {
            oetTCKBchLocFacName: {
                "required"      : $('#oetTCKBchLocFacName').attr('data-validate-required'),
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
                url: "masTCKBchLocFacEventAdd",
                data: $("#ofmBchLocFacForm").serialize(),
                timeout: 0,
                success: function(tResult) {
                    let aDataReturn = JSON.parse(tResult);
                    if(aDataReturn['nStaEvent'] == 1){
                        let tCodeReturn = aDataReturn['tDataCodeReturn'];
                        JSvTCKBchLocFacDataTable(tCodeReturn);
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
// Parameters : Facility Data
// Creater : 31/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocFacDelete(poData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKBchLocFacEventDelete",
        data: poData,
        success: function(tResult){
            let aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaEvent'] == 1){
                let tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSvTCKBchLocFacDataTable(tCodeReturn, 1);
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