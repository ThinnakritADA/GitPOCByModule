var tTCKBchLocAddressAgnCode   = $('#ohdTCKBchLocAddressAgnCode').val();
var tTCKBchLocAddressBchCode   = $('#ohdTCKBchLocAddressBchCode').val();
var tTCKBchLocAddressLocCode   = $('#ohdTCKBchLocAddressLocCode').val();

$("document").ready(function(){
    JSxTCKBchLocAddressNavDefault();
    JSvTCKBchLocAddressDataTable();

    // Event Click Title Menu Address
    $('#odvTCKBchLocDataAddress #olbTCKBchLocAddressInfo').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKBchLocAddressDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Call Page Add Address
    $('#odvTCKBchLocDataAddress #obtTCKBchLocAddressCallPageAdd').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKBchLocCallPageBchLocAddAddress();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Cancel Event Address
    $('#odvTCKBchLocDataAddress #obtTCKBchLocAddressCancel').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKBchLocAddressDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Add/Edit Event Address
    $('#odvTCKBchLocDataAddress #obtTCKBchLocAddressSave').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmBchLocAddrForm #obtBchLocAddrAddEdit').trigger('click');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
});

// Functionality : Setting default Nav
// Parameters : -
// Creater : 21/04/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKBchLocAddressNavDefault(){
    // Hide Title And Button Default
    $('#olbTCKBchLocAddressAdd').hide();
    $('#olbTCKBchLocAddressEdit').hide();
    $('#odvTCKBchLocAddressBtnGrpAddEdit').hide();
    // Show Title And Button Default
    $('#olbTCKBchLocAddressInfo').show();
    $('#odvTCKBchLocAddressBtnGrpInfo').show();
}

// Functionality : Load data table
// Parameters : LocCode
// Creater : 21/04/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocAddressDataTable(ptLocCode){
    let tLocCode = (ptLocCode == undefined || ptLocCode == '') ? tTCKBchLocAddressLocCode : ptLocCode;
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKBchLocAddrDataTable",
        data: {
            'ptTCKBchLocAddrAgnCode' : tTCKBchLocAddressAgnCode,
            'ptTCKBchLocAddrBchCode' : tTCKBchLocAddressBchCode,
            'ptTCKBchLocAddrLocCode' : tLocCode,
        },
        success: function(oResult) {
            let aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxTCKBchLocAddressNavDefault();
                $('#odvTCKBchLocDataAddress #odvTCKBchLocAddressContent').html(aReturnData['oTCKBchLocViewAddressDataList']);
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
function JSvTCKBchLocCallPageBchLocAddAddress(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKBchLocAddrPageAdd",
        data: {
            'ptTCKBchLocAddrAgnCode' : tTCKBchLocAddressAgnCode,
            'ptTCKBchLocAddrBchCode' : tTCKBchLocAddressBchCode,
            'ptTCKBchLocAddrLocCode' : tTCKBchLocAddressLocCode,
        },
        success: function(tResult) {
            $('#odvTCKBchLocDataAddress #odvTCKBchLocAddressContent').html(tResult);
            // Hide Title And Button
            $('#olbTCKBchLocAddressEdit').hide();
            $('#odvTCKBchLocAddressBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbTCKBchLocAddressAdd').show();
            $('#odvTCKBchLocAddressBtnGrpAddEdit').show();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Call edit page
// Parameters : BchLocAddrData
// Creater : 21/04/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocCallPageBchLocEditAddress(poBchLocAddrData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url : "masTCKBchLocAddrPageEdit",
        data : poBchLocAddrData,
        success: function(tResult){
            $('#odvTCKBchLocDataAddress #odvTCKBchLocAddressContent').html(tResult);
            // Hide Title And Button
            $('#olbTCKBchLocAddressAdd').hide();
            $('#odvTCKBchLocAddressBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbTCKBchLocAddressEdit').show();
            $('#odvTCKBchLocAddressBtnGrpAddEdit').show();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Event add/edit data
// Parameters : -
// Creater : 21/04/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocAddressAddEdit(){
    JCNxOpenLoading();
    let tBchLocAddrRoute = $('#ofmBchLocAddrForm #ohdBchLocAddrRoute').val();
    $.ajax({
        type: "POST",
        url: tBchLocAddrRoute,
        data: $('#ofmBchLocAddrForm').serialize(),
        success: function(tResult){
            let aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaEvent'] == 1){
                let tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSvTCKBchLocAddressDataTable(tCodeReturn);
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
// Parameters : BchLocAddrData
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocAddressDeleteData(poBchLocAddrData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKBchLocAddrEventDelete",
        data: poBchLocAddrData,
        success: function(tResult){
            let aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                let tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSvTCKBchLocAddressDataTable(tCodeReturn);
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