var tTCKBchLocPdtAgnCode   = $('#ohdTCKBchLocPdtAgnCode').val();
var tTCKBchLocPdtBchCode   = $('#ohdTCKBchLocPdtBchCode').val();
var tTCKBchLocPdtLocCode   = $('#ohdTCKBchLocPdtLocCode').val();

$("document").ready(function(){
    JSxTCKBchLocPdtNavDefault();
    JSvTCKBchLocPdtDataTable();

    // Event Click Title Menu Pdt
    $('#odvTCKBchLocDataPdt #olbTCKBchLocPdtInfo').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKBchLocPdtDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Call Page Add Pdt
    $('#odvTCKBchLocDataPdt #obtTCKBchLocPdtCallPageAdd').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKBchLocCallPageBchLocAddPdt();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Cancel Event Pdt
    $('#odvTCKBchLocDataPdt #obtTCKBchLocPdtCancel').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKBchLocPdtDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Add/Edit Event Pdt
    $('#odvTCKBchLocDataPdt #obtTCKBchLocPdtSave').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmBchLocPdtForm #obtBchLocPdtAddEdit').trigger('click');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
});

// Functionality : Setting default Nav
// Parameters : -
// Creater : 01/06/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKBchLocPdtNavDefault(){
    // Hide Title And Button Default
    $('#olbTCKBchLocPdtAdd').hide();
    $('#olbTCKBchLocPdtEdit').hide();
    $('#odvTCKBchLocPdtBtnGrpAddEdit').hide();
    // Show Title And Button Default
    $('#olbTCKBchLocPdtInfo').show();
    $('#odvTCKBchLocPdtBtnGrpInfo').show();
}

// Functionality : Load data table
// Parameters : LocCode
// Creater : 01/06/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocPdtDataTable(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKBchLocPdtDataTable",
        data: {
            'ptTCKBchLocPdtAgnCode' : tTCKBchLocPdtAgnCode,
            'ptTCKBchLocPdtBchCode' : tTCKBchLocPdtBchCode,
            'ptTCKBchLocPdtLocCode' : tTCKBchLocPdtLocCode,
        },
        success: function(oResult) {
            let aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxTCKBchLocPdtNavDefault();
                $('#odvTCKBchLocDataPdt #odvTCKBchLocPdtContent').html(aReturnData['oTCKBchLocViewPdtDataList']);
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
function JSvTCKBchLocCallPageBchLocAddPdt(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKBchLocPdtPageAdd",
        data: {
            'ptTCKBchLocPdtAgnCode' : tTCKBchLocPdtAgnCode,
            'ptTCKBchLocPdtBchCode' : tTCKBchLocPdtBchCode,
            'ptTCKBchLocPdtLocCode' : tTCKBchLocPdtLocCode,
        },
        success: function(tResult) {
            $('#odvTCKBchLocDataPdt #odvTCKBchLocPdtContent').html(tResult);
            // Hide Title And Button
            $('#olbTCKBchLocPdtEdit').hide();
            $('#odvTCKBchLocPdtBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbTCKBchLocPdtAdd').show();
            $('#odvTCKBchLocPdtBtnGrpAddEdit').show();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Event add/edit data
// Parameters : -
// Creater : 01/06/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocPdtAddEdit(){
    $('#ofmBchLocPdtForm').validate().destroy();
    $('#ofmBchLocPdtForm').validate({
        rules: {
            oetTCKBchLocPdtName: { "required": {} },
        },
        messages: {
            oetTCKBchLocPdtName: {
                "required"      : $('#oetTCKBchLocPdtName').attr('data-validate-required'),
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
                url: "masTCKBchLocPdtEventAdd",
                data: $("#ofmBchLocPdtForm").serialize(),
                timeout: 0,
                success: function(tResult) {
                    let aDataReturn = JSON.parse(tResult);
                    if(aDataReturn['nStaEvent'] == 1){
                        let tCodeReturn = aDataReturn['tDataCodeReturn'];
                        JSvTCKBchLocPdtDataTable(tCodeReturn);
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
// Parameters : Product Data
// Creater : 01/06/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocPdtDelete(poData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKBchLocPdtEventDelete",
        data: poData,
        success: function(tResult){
            let aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaEvent'] == 1){
                let tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSvTCKBchLocPdtDataTable(tCodeReturn, 1);
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