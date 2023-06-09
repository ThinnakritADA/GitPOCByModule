var tPdtCode    = $('#ohdPdtCode').val();
var nLangEdits  = $('#ohdPkgGrpLangEdits').val();

$("document").ready(function(){
    $('#odvPdtPkgContent').empty();
    JSxCheckPinMenuClose();
    JSvPdtPkgDataGroup();

    let tStaAlwDup = $('#ohdPkgGrpStaAlwDup').val();
    if (tStaAlwDup == 1){
        $('#ocbPdtPkgStaAlwDup').prop("checked",true);
    } else {
        $('#ocbPdtPkgStaAlwDup').prop("checked",false);
    }

    let tStaStaSelOrChk = $('#ohdPkgGrpStaSelOrChk').val();
    if (tStaStaSelOrChk == 1){
        $('#ocbPdtPkgStaSelOrChk').prop("checked",true);
    } else {
        $('#ocbPdtPkgStaSelOrChk').prop("checked",false);
    }
});

$('#obtPdtPkgBack').off().on('click', function(){
    $('a[data-target="#odvPdtContentInfo1"]').click();
    $('#obtCallBackProductList').removeClass('xCNHide');
});

$('#obtPdtPkgSave').off().on('click', function(){
    JSvPdtPkgAddEdit();
});

// Function: Load page package
// Parameters:  -
// Creator:	07/06/2023 Papitchaya
// Return: View
// Return -
function JSvPdtPkgDataGroup(){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "pdtPackagePageDataGrp",
            data: {
                'ptPdtCode'  : tPdtCode,
            },
            success: function(oResult) {
                let aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    $('#odvPdtPkgContent').html(aReturnData['oPdtPkgViewPkgGrop']);
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
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function: Load data group package
// Parameters:  -
// Creator:	07/06/2023 Papitchaya
// Return: View
// Return -
function JSvPdtPkgLoadDataGroup(){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "pdtPackageLoadDataGrp",
            data: {
                'ptPdtCode'  : tPdtCode,
            },
            success: function(oResult) {
                let aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    $('#odvPdtPkgContent').html(aReturnData['oPdtPkgViewPkgGrop']);
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
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function: Call modal Add/Edit group package
// Parameters:  -
// Creator:	07/06/2023 Papitchaya
// Return: View
// Return -
function JSvPdtPkgCallModalAddEditGrp(ptRoute, ptTextHD, pnKey = ''){
    let tRoute  = ptRoute;
    let tTextHD = ptTextHD;
    let nKey    = pnKey;

    //Reset Modal
    $('#ofmPdtPkgAddGrp').validate().destroy();
    $('#ofmPdtPkgAddGrp .form-group').removeClass("has-success");
    $('#ofmPdtPkgAddGrp .form-group').removeClass("has-error");
    $('#odvPdtPkgModalAddEditGrp #oetPdtPkgGrpName').val('');

    $('#odvPdtPkgModalAddEditGrp .xCNTextModalHeard').text(tTextHD);
    $('#odvPdtPkgModalAddEditGrp #ohdPdtPkgRoute').val(tRoute);
    if(nKey != ''){
        let tGrpSeq     =  $('#ohdPkgGrpSeq' + nKey).val();
        let tGrpSeqNo   =  $('#ohdPkgGrpSeqNo' + nKey).val();
        let tGrpName    =  $('#ohdPkgGrpName' + nKey).val();
        $('#odvPdtPkgModalAddEditGrp #ohdPdtPkgGrpSeq').val(tGrpSeq);
        $('#odvPdtPkgModalAddEditGrp #ohdPdtPkgGrpSeqNo').val(tGrpSeqNo);
        $('#odvPdtPkgModalAddEditGrp #oetPdtPkgGrpName').val(tGrpName);
        $('#odvPdtPkgModalAddEditGrp #ohdPdtPkgGrpNameOld').val(tGrpName);
    }
    $('#odvPdtPkgModalAddEditGrp').modal('show');
}

// Function: Add/Edit group package
// Parameters:  -
// Creator:	07/06/2023 Papitchaya
// Return: View
// Return -
function JSvPdtPkgAddEditGroup(){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

        let tRoute = $('#odvPdtPkgModalAddEditGrp #ohdPdtPkgRoute').val();

        $('#ofmPdtPkgAddGrp').validate().destroy();
        $('#ofmPdtPkgAddGrp').validate({
            rules: { oetPdtPkgGrpName: { "required": {} }, },
            messages: {
                oetPdtPkgGrpName: { "required" : $('#oetPdtPkgGrpName').attr('data-validate-required'),}
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
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: tRoute,
                    data: $("#ofmPdtPkgAddGrp").serialize(),
                    timeout: 0,
                    success: function(oResult) {
                        let aResult = JSON.parse(oResult);
                        if(aResult['nStaEvent']==1){
                            JSvPdtPkgLoadDataGroup();
                        } else {
                            FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
                        }
                        $('#odvPdtPkgModalAddEditGrp').modal('hide');
                        $('#oetPdtPkgGrpName').val('');
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }    
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

function JSvPdtPkgAddList(pnKey, pnRefPdt, pnGrpSeq, ptGrpSeqNo, ptGrpName){
    let nAddListType = $('#ocmPdtPkgAddList' + pnKey).val();
    if(nAddListType == 1){
        $('#obtPdtPkgAddPdt' + pnKey).show();
        $('#obtPdtPkgAddLoc' + pnKey).hide();
    }else{
        $('#obtPdtPkgAddPdt' + pnKey).hide();
        $('#obtPdtPkgAddLoc' + pnKey).show();
    }    

    // if(pnRefPdt != 0){
    //     $("#ohdLocZnePkgDelGrpSeq").val(pnGrpSeq);
    //     $("#ohdLocZnePkgDelGrpSeqNo").val(ptGrpSeqNo);
    //     $("#ohdLocZnePkgDelGrpName").val(ptGrpName);
    //     $('#odvPdtPkgModalDeleteListInGrp').modal('show');
    //     $('#obtPdtPkgCancelDeleteListInGrp').on('click', function(evt) {
    //         if(nAddListType == 1){
    //             $('#ocmPdtPkgAddList' + pnKey).val(2);
    //             $('#obtPdtPkgAddPdt' + pnKey).hide();
    //             $('#obtPdtPkgAddLoc' + pnKey).show();
    //         }else{
    //             $('#ocmPdtPkgAddList' + pnKey).val(1);
    //             $('#obtPdtPkgAddPdt' + pnKey).show();
    //             $('#obtPdtPkgAddLoc' + pnKey).hide();
    //         } 
    //     });

    //     $('#obtPdtPkgConfirmDeleteListInGrp').on('click', function(evt) {
    //         JCNxOpenLoading();
    //         $.ajax({
    //             type: "POST",
    //             url: "pdtPackageEventDelAllPdtGrpFromTmp",
    //             data: {
    //                 'pnGrpSeq'     : pnGrpSeq,
    //                 'ptPkgPdtCode' : tPdtCode,
    //             },
    //             cache: false,
    //             timeout: 0,
    //             success: function(oResult){
    //                 let aResult = JSON.parse(oResult);
    //                 if(aResult['nStaEvent']==1){
    //                     $('#odvPdtPkgModalDeleteListInGrp').modal('hide');
    //                     $("#ohdLocZnePkgDelGrpSeq").val('');
    //                     $("#ohdLocZnePkgDelGrpSeqNo").val('');
    //                     $("#ohdLocZnePkgDelGrpName").val('');
    //                     if(nAddListType == 1){
    //                         $('#obtPdtPkgAddPdt' + pnKey).show();
    //                         $('#obtPdtPkgAddLoc' + pnKey).hide();
    //                     }else{
    //                         $('#obtPdtPkgAddPdt' + pnKey).hide();
    //                         $('#obtPdtPkgAddLoc' + pnKey).show();
    //                     } 
    //                     JSvPdtPkgLoadDataGroup();
    //                 } else {
    //                     FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
    //                 }
    //                 JCNxCloseLoading();
    //             },
    //             error: function (jqXHR, textStatus, errorThrown) {
    //                 JCNxResponseError(jqXHR, textStatus, errorThrown);
    //             }
    //         });
    //     });
    // }else{
    //     if(nAddListType == 1){
    //         $('#obtPdtPkgAddPdt' + pnKey).show();
    //         $('#obtPdtPkgAddLoc' + pnKey).hide();
    //     }else{
    //         $('#obtPdtPkgAddPdt' + pnKey).hide();
    //         $('#obtPdtPkgAddLoc' + pnKey).show();
    //     } 
    // }
}

function JSvPdtPkgNextFuncAddPdt(ptPdtData){
    let nKey      = $("#ohdPkgGrpAddKey").val();
    let nPkgType  = $("#ohdPkgTypeNew" + nKey).val();
    let nGrpSeq   = $("#ohdPkgGrpSeq" + nKey).val();
    let tGrpSeqNo = $("#ohdPkgGrpSeqNo" + nKey).val();
    let tGrpName  = $("#ohdPkgGrpName" + nKey).val();
    let aPackData = "";
    if(nPkgType == '1'){
        aPackData = JSON.parse(ptPdtData);
    }else{
        aPackData = ptPdtData;
    }

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "pdtPackageEventAddPdtGrpIntoTmp",
        data: {
            'pnGrpSeq'     : nGrpSeq,
            'ptPkgPdtCode' : tPdtCode,
            'ptGrpSeqNo'   : tGrpSeqNo,
            'ptGrpName'    : tGrpName,
            'pnPkgType'    : nPkgType,
            'paPdtData'    : aPackData
        },
        cache: false,
        timeout: 0,
        success: function(oResult){
            let aResult = JSON.parse(oResult);
            if(aResult['nStaEvent']==1){
                JSvPdtPkgLoadDataGroup();
            } else {
                FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
            }
            $("#ohdPkgGrpSeq").val('');
            $("#ohdPkgGrpSeqNo").val('');
            $("#ohdPkgGrpName").val('');
            JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

function JSvPdtPkgCallModalAddLocZne(pnKey){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        let tGrpSeq     = $('#ohdPkgGrpSeq' + pnKey).val();
        let tGrpSeqNo   = $('#ohdPkgGrpSeqNo' + pnKey).val();
        let tGrpName    = $('#ohdPkgGrpName' + pnKey).val();

        $("#ohdLocZnePkgType").val('2');
        $("#ohdLocZnePkgGrpSeq").val(tGrpSeq);
        $("#ohdLocZnePkgGrpSeqNo").val(tGrpSeqNo);
        $("#ohdLocZnePkgGrpName").val(tGrpName);


        //Reset Modal
        $('#ofmPdtPkgAddLocZne').validate().destroy();
        $('#ofmPdtPkgAddLocZne .form-group').removeClass("has-success");
        $('#ofmPdtPkgAddLocZne .form-group').removeClass("has-error");        
        $("#ohdPdtPkgLocCode").val('');
        $("#oetPdtPkgLocName").val('');
        $("#ohdPdtPkgZneCode").val('');
        $("#oetPdtPkgZneName").val('');

        $('#odvPdtPkgModalAddLocZne').modal('show');
    } else {
        JCNxShowMsgSessionExpired();
    }
}

function JSvPdtPkgAddLocZne(){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmPdtPkgAddLocZne').validate().destroy();
        $('#ofmPdtPkgAddLocZne').validate({
            rules: { oetPdtPkgLocName: { "required": {} }, },
            messages: {
                oetPdtPkgLocName: { "required" : $('#oetPdtPkgLocName').attr('data-validate-required'),}
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
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "pdtPackageEventAddLocZneGrpIntoTmp",
                    data: $("#ofmPdtPkgAddLocZne").serialize(),
                    timeout: 0,
                    success: function(oResult) {
                        let aResult = JSON.parse(oResult);
                        if(aResult['nStaEvent']==1){
                            JSvPdtPkgLoadDataGroup();
                        } else {
                            FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
                        }
                        $('#odvPdtPkgModalAddLocZne').modal('hide');
                        $("#ohdLocZnePkgType").val('');
                        $("#ohdLocZnePkgGrpSeq").val('');
                        $("#ohdLocZnePkgGrpSeqNo").val('');
                        $("#ohdLocZnePkgGrpName").val('');
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }

}

function JSvPdtPkgDelPdtGrp(pnGrpSeq, ptCodeRefPdt){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "pdtPackageEventDelPdtGrpFromTmp",
            data: {
                'pnGrpSeq'     : pnGrpSeq,
                'ptPkgPdtCode' : tPdtCode,
                'ptCodeRefPdt' : ptCodeRefPdt,
            },
            cache: false,
            timeout: 0,
            success: function(oResult){
                let aResult = JSON.parse(oResult);
                if(aResult['nStaEvent']==1){
                    JSvPdtPkgLoadDataGroup();
                } else {
                    FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
                }
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

function JSvPdtPkgDelGrp(pnGrpSeq, ptGrpSeqNo, ptGrpName, ptMessg, ptYesOnNo){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#odvPdtPkgModalDelete').modal('show');
        $('#ospPdtPkgConfirmDelete').html(ptMessg + ' ' + ptGrpName + ' ' + ptYesOnNo);
        $('#obtPdtPkgConfirmDelete').on('click', function(evt) {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "pdtPackageEventDelGrpFromTmp",
                data: {
                    'pnGrpSeq'     : pnGrpSeq,
                    'ptPkgPdtCode' : tPdtCode,
                    'ptGrpSeqNo'   : ptGrpSeqNo,
                },
                cache: false,
                timeout: 0,
                success: function(oResult){
                    let aResult = JSON.parse(oResult);
                    if(aResult['nStaEvent']==1){
                        $('#odvPdtPkgModalDelete').modal('hide');
                        $('#ospPdtPkgConfirmDelete').text('');
                        JSvPdtPkgLoadDataGroup();
                    } else {
                        FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
                    }
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

function JSvPdtPkgAddEdit(){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "pdtPackageEventAddPkgGrpMaster",
                data: {
                    'ptPkgPdtCode' : tPdtCode,
                },
                cache: false,
                timeout: 0,
                success: function(oResult){
                    let aResult = JSON.parse(oResult);
                    if(aResult['nStaEvent']==1){
                        JSvPdtPkgDataGroup();
                    } else {
                        FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
                    }
                    JCNxCloseLoading();
                },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

function JSxPdtPkgEditCondition(pnGrpSeq){
    let nPdtPkgMax  = $('#onbPdtPkgMax'+ pnGrpSeq).val();
    let tStaAlwDup  = ($('#ocbPdtPkgStaAlwDup'+ pnGrpSeq).prop('checked')) ? '1' : '2';
    let tStaSelOrChk = ($('#ocbPdtPkgStaSelOrChk'+ pnGrpSeq).prop('checked')) ? '1' : '2';
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "pdtPackageEventEditGrpCondIntoTmp",
            data: {
                'ptPdtCode'     : tPdtCode,
                'pnGrpSeq'      : pnGrpSeq,
                'pnPdtPkgMax'   : nPdtPkgMax,
                'ptStaAlwDup'   : tStaAlwDup,
                'ptStaSelOrChk' : tStaSelOrChk
            },
            cache: false,
            timeout: 0,
            success: function(oResult){
                let aResult = JSON.parse(oResult);
                if(aResult['nStaEvent']==1){
                    JSvPdtPkgLoadDataGroup();
                } else {
                    FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
                }
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

function JSxPdtPkgEditPdtQty(pnGrpSeq, pnPdtCodeRef){
    let nGrpSeq     = pnGrpSeq;
    let nPdtCodeRef = pnPdtCodeRef;
    let nPdtQty     = $('#onbPdtPkgQty'+ nPdtCodeRef).val();

    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "pdtPackageEventEditPdtQtyIntoTmp",
            data: {
                'ptPdtCode'     : tPdtCode,
                'pnGrpSeq'      : nGrpSeq,
                'pnPdtCodeRef'  : nPdtCodeRef,
                'pnPdtQty'      : nPdtQty
            },
            cache: false,
            timeout: 0,
            success: function(oResult){
                let aResult = JSON.parse(oResult);
                if(aResult['nStaEvent']==1){
                    JSvPdtPkgLoadDataGroup();
                } else {
                    FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
                }
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}
