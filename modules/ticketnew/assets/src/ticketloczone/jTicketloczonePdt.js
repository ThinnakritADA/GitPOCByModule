var tLocZonePdtZneChain = $('#ohdTCKLocZonePdtZneChain').val();
var tLocZonePdtZneCode  = $('#ohdTCKLocZonePdtZneCode').val();
var tLocZonePdtBchCode  = $('#ohdTCKLocZonePdtBchCode').val();

$("document").ready(function(){
    JSxTCKLocZonePdtNavDefault();
    JSvTCKLocZonePdtDataTable();

    // Event Click Title Menu Address
    $('#odvTCKLocZoneDataPdt #olbTCKLocZonePdtInfo').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvTCKLocZonePdtDataTable();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
});

// Functionality : Setting default Nav
// Parameters : -
// Creater : 04/05/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKLocZonePdtNavDefault(){
    // Hide Title And Button Default
    $('#olbTCKLocZonePdtAdd').hide();
    $('#olbTCKLocZonePdtEdit').hide();
    $('#odvTCKLocZonePdtBtnGrpAddEdit').hide();
    // Show Title And Button Default
    $('#olbTCKLocZonePdtInfo').show();
    $('#odvTCKLocZonePdtBtnGrpInfo').show();
}

// Functionality : Load data table
// Parameters : ZneChain, Page
// Creater : 04/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKLocZonePdtDataTable(ptZneChain, pnPage){
    let tZneChain = (ptZneChain == undefined || ptZneChain == '') ? tLocZonePdtZneChain : ptZneChain;
    let nPageCurrent = (pnPage == undefined || pnPage == '') ? '1' : pnPage;
    let tSearchAll = $('#oetTCKLocZoneSearchAll').val();
    
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKLocZonePdtDataTable",
        data: {
            'ptLocZonePdtZneChain'  : tZneChain,
            'ptLocZonePdtZneCode'   : tLocZonePdtZneCode,
            'ptSearchAll'           : tSearchAll,
            'pnPageCurrent'         : nPageCurrent,
        },
        success: function(oResult) {
            let aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                $('#odvTCKLocZoneDataPdt #odvTCKLocZonePdtContent').html(aReturnData['oTCKLocZoneViewPdtDataList']);
                JSxTCKLocZonePdtNavDefault();
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

// Functionality : Browse Pdt
// Parameters : -
// Creater : 04/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKLocZoneBrowsePdt(){
    let tWhereCondition = "";
    $.ajax({
        type: "POST",
        url: "BrowseDataPDT",
        data: {
            Qualitysearch: [],
            PriceType: ["Cost", "tCN_Cost", "Company", "2"],
            VatInOrEx : '',
            VatRacte : '',
            SelectTier: ["Barcode"],
            ShowCountRecord: 10,
            NextFunc: "FSvTCKLocZonePdtAddData",
            ReturnType: "M",
            SPL: ['', ''],
            BCH: [tLocZonePdtBchCode, tLocZonePdtBchCode],
            MCH: ['', ''],
            SHP: ['', ''],
            Where: [tWhereCondition]
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $("#odvModalDOCPDT").modal({ backdrop: "static", keyboard: false });
            $("#odvModalDOCPDT").modal({ show: true });
            //remove localstorage
            localStorage.removeItem("LocalItemDataPDT");
            $("#odvModalsectionBodyPDT").html(tResult);
            $("#odvModalDOCPDT #oliBrowsePDTSupply").css('display', 'none');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Event add data
// Parameters : -
// Creater : 04/05/2023 Papitchaya
// Last Update: -
// Return : View
function FSvTCKLocZonePdtAddData(ptPdtData){
    let aPackData = JSON.parse(ptPdtData);
    console.log('aPackData', aPackData.length);
    $.ajax({
        type: "POST",
        url: "masTCKLocZonePdtEventAdd",
        data: {
            'ptZneChain'  : tLocZonePdtZneChain,
            'ptZneCode'   : tLocZonePdtZneCode,
            'ptBchCode'   : tLocZonePdtBchCode,
            'paPdtData'   : aPackData
        },
        cache: false,
        timeout: 0,
        success: function(oResult){
            let aResult = JSON.parse(oResult);
            // console.log('aResult', aResult);
            if(aResult['nStaEvent'] == 1){
                JSvTCKLocZonePdtDataTable();
                $("#obtTCKLocZoneBrowseAgn").attr("disabled", true);
                $("#obtTCKLocZoneBrowseBch").attr("disabled", true);
                $("#obtTCKLocZoneBrowseBchLoc").attr("disabled", true);
                JCNxCloseLoading();
            } else {
                JCNxCloseLoading();
                FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Event delete 1 item
// Parameters : PdtData
// Creater : 04/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKLocZonePdtDeleteData(poPdtData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTCKLocZonePdtEventDelete",
        data: poPdtData,
        success: function(tResult){
            let aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                let tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSvTCKLocZonePdtDataTable(tCodeReturn, 1);
                if(aDataReturn['nCountZnePdt'] == 0){
                    $("#obtTCKLocZoneBrowseAgn").attr("disabled", false);
                    $("#obtTCKLocZoneBrowseBch").attr("disabled", false);
                    $("#obtTCKLocZoneBrowseBchLoc").attr("disabled", false);
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