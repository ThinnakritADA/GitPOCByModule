var tTCKTimeTbDTTmeCode   = $('#ohdTCKTimeTbDTTmeCode').val();

$("document").ready(function(){
    JSxTCKTimeTbDTNavDefault();
    JSvTCKTimeTbDTDataTable();

    if(tTCKTimeTbDTTmeCode == ""){
        $('#obtTCKTimeTbDTCallPageAdd').addClass("xCNDisabled"); 
        $('#obtTCKTimeTbDTCallPageAdd').attr("disabled", true);
    }else{
        // $('#obtTCKTimeTbDTCallPageAdd').removeClass("xCNDisabled");
    }

    // Event Click Title Menu
    $('#olbTCKTimeTbDTInfo').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKTimeTbDTDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Call Page Add
    $('#obtTCKTimeTbDTCallPageAdd').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#odvTCKTimeTbBtnEditInfo').hide(); 
            JSvTCKTimeTbDTCallPageAdd();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Cancel Event
    $('#obtTCKTimeTbDTCancel').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKTimeTbDTDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Add/Edit Event
    $('#obtTCKTimeTbDTSave').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmTCKTimeTbDTForm #obtTCKTimeTbDTAddEdit').trigger('click');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
});

// Functionality : Setting default Nav
// Parameters : -
// Creater : 09/05/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKTimeTbDTNavDefault(){
    // Hide Title And Button Default
    $('#olbTCKTimeTbDTAdd').hide();
    $('#odvTCKTimeTbDTBtnGrpAddEdit').hide();
    // Show Title And Button Default
    $('#odvTCKTimeTbBtnEditInfo').show(); 
    $('#olbTCKTimeTbDTInfo').show();
    $('#odvTCKTimeTbDTBtnGrpInfo').show();
}

// Functionality : Load data table
// Parameters : TmeCode
// Creater : 09/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKTimeTbDTDataTable(ptTmeCode){
    let tTmeCode = (ptTmeCode == undefined || ptTmeCode == '') ? tTCKTimeTbDTTmeCode : ptTmeCode;
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKTimeTbDTDataTable",
        data: {
            'ptTmeCode' : tTmeCode,
        },
        success: function(oResult) {
            let aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxTCKTimeTbDTNavDefault();
                $('#odvTCKTimeTbDTContent').html(aReturnData['oTCKTimeTbDTDataList']);
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
// Creater : 09/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKTimeTbDTCallPageAdd(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKTimeTbDTPageAdd",
        data: {
            'ptTmeCode' : tTCKTimeTbDTTmeCode,
        },
        success: function(tResult) {
            $('#odvTCKTimeTbDTContent').html(tResult);
            // Hide Title And Button
            $('#odvTCKTimeTbDTBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbTCKTimeTbDTAdd').show();
            $('#odvTCKTimeTbDTBtnGrpAddEdit').show();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Event add data
// Parameters : -
// Creater : 09/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKTimeTbDTAdd(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKTimeTbDTEventAdd",
        data: $('#ofmTCKTimeTbDTForm').serialize(),
        success: function(tResult){
            let aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                let tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSvTCKTimeTbDTDataTable(tCodeReturn);
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

// Functionality : Event delete 1 item
// Parameters : TimeTbDTData
// Creater : 09/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSoTCKTimeTbDTDeleteData(poTimeTbDTData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKTimeTbDTEventDelete",
        data: poTimeTbDTData,
        success: function(tResult){
            let aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                let tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSvTCKTimeTbDTDataTable(tCodeReturn);
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