var nTCKTimeTbBrowseType    = $('#ohdTCKTimeTbBrowseType').val();
var nTCKTimeTbBrowseOption  = $('#ohdTCKTimeTbBrowseOption').val();

$('document').ready(function () {
    JSxCheckPinMenuClose();     //Check เปิดปิด Menu ตาม Pin
    JSxTCKTimeTbNavDefult();    //ตั้งค่า Default Nav
    localStorage.removeItem('LocalItemData');

    if (nTCKTimeTbBrowseType != 1) {
        JSvTCKTimeTbCallPageList(1);
    } else {
        JSvTCKTimeTbCallPageAdd();
    }
});

// Functionality : Setting default Nav
// Parameters : -
// Creater : 08/05/2023 papitchaya
// Last Update: -
// Return : -
function JSxTCKTimeTbNavDefult() {
    if (nTCKTimeTbBrowseType != 1 || nTCKTimeTbBrowseOption == undefined) {
        $('#oliTCKTimeTbTitleAdd').hide();
        $('#oliTCKTimeTbTitleEdit').hide();
        $('#odvTCKTimeTbBtnEditInfo').hide();    
        $('#odvTCKTimeTbBtnInfo').show();
    } else {
        $('#odvModalBody #odvTCKTimeTbMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliTCKTimeTbNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvTCKTimeTbBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNTCKTimeTbBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNTCKTimeTbBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Functionality : Load list view
// Parameters : Page
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKTimeTbCallPageList(pnPage){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        localStorage.tStaPageNow = 'JSvTCKTimeTbCallPageList';
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masTCKTimeTbFormSearchList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageTCKTimeTb').html(tResult);
                JSvTCKTimeTbCallPageDataTable(pnPage);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : Load data table
// Parameters : Page
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKTimeTbCallPageDataTable(pnPage) {
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        let tSearchAll = $('#oetTCKTimeTbSearchAll').val();
        let nPageCurrent = (pnPage == undefined || pnPage == '') ? '1' : pnPage;
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masTCKTimeTbDataTable",
            data: {
                tSearchAll      : tSearchAll,
                nPageCurrent    : nPageCurrent,
            },
            cache: false,
            timeout: 5000,
            success: function(oResult) {
                let aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    JSxTCKTimeTbNavDefult();
                    $('#ostTCKTimeTbDataTimeTb').html(aReturnData['oTCKTimeTbViewDataTableList']);
                } else {
                    let tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                JCNxLayoutControll();
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

// Functionality : Click page button
// Parameters : Page
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKTimeTbClickPage(ptPage) {
    let nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageWah .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageWah .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvTCKTimeTbCallPageDataTable(nPageCurrent);
}

// Functionality : Call add page
// Parameters : -
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKTimeTbCallPageAdd() {
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masTCKTimeTbPageAdd",
            cache: false,
            timeout: 0,
            success: function(oResult) {
                if (nTCKTimeTbBrowseType == 1) {
                    $('#odvTCKTimeTbModalBodyBrowse').html(oResult);
                    $('#odvTCKTimeTbModalBodyBrowse .panel-body').css('padding-top', '0');
                } else {
                    $('#oliTCKTimeTbTitleAdd').show();
                    $('#oliTCKTimeTbTitleEdit').hide();
                    $('#odvTCKTimeTbBtnInfo').hide();
                    $('#odvTCKTimeTbBtnEditInfo').show();
                    $('#odvContentPageTCKTimeTb').html(oResult);
                    JSvTCKTimeTbCallContentDT();
                }
                JCNxLayoutControll();
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

// Functionality : Call edit page
// Parameters : TmeCode
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKTimeTbCallPageEdit(ptTmeCode){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masTCKTimeTbPageEdit",
            data: {
                'ptTmeCode'	: ptTmeCode,
            },
            timeout: 0,
            success: function(oResult) {
                $('#odvContentPageTCKTimeTb').html(oResult);

                $('#oetTCKTimeTbCode').addClass('xCNCursorNotAlw').attr('readonly', true);
                $('#odvTCKTimeTbAutoGenCode').addClass('xCNHide');

                $('#oliTCKTimeTbTitleAdd').hide();
                $('#oliTCKTimeTbTitleEdit').show();
                $('#odvTCKTimeTbBtnInfo').hide();
                $('#odvTCKTimeTbBtnEditInfo').show();
                JSvTCKTimeTbCallContentDT();
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

// Functionality : Event add/edit data
// Parameters : Route
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKTimeTbAddEdit(ptRoute){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        let tRoute = ptRoute;
        console.log(tRoute);
        $('#ofmTCKTimeTbAdd').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (tRoute == "masTCKTimeTbEventAdd") {
                if ($("#ohdTCKTimeTbCheckDuplicateCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmTCKTimeTbAdd').validate({
            rules: {
                oetTCKTimeTbCode: {
                    "required": {
                        depends: function(oElement) {
                            if (tRoute == "masTCKTimeTbEventAdd") {
                                if ($('#ocbTCKTimeTbAutoGenCode').is(':checked')) {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },
                oetTCKTimeTbName: { "required": {} },
            },
            messages: {
                oetTCKTimeTbCode: {
                    "required"      : $('#oetTCKTimeTbCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetTCKTimeTbCode').attr('data-validate-dublicateCode')
                },
                oetTCKTimeTbName: {
                    "required"      : $('#oetTCKTimeTbName').attr('data-validate-required'),
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
                    url: tRoute,
                    data: $("#ofmTCKTimeTbAdd").serialize(),
                    timeout: 0,
                    success: function(oResult) {
                        if (nTCKTimeTbBrowseType != 1) {
                            let aReturn = JSON.parse(oResult);
                            if (aReturn['nStaEvent'] == 1) {
                                switch (aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvTCKTimeTbCallPageEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvTCKTimeTbCallPageAdd();
                                        break;
                                    case '3':
                                        JSvTCKTimeTbCallPageList(1);
                                        break;
                                    default:
                                        JSvTCKTimeTbCallPageEdit(aReturn['tCodeReturn']);
                                }
                            } else {
                                JCNxCloseLoading();
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(nTCKTimeTbBrowseOption);
                        }
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

// Functionality : Call page time table DT
// Parameters : -
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKTimeTbCallContentDT(pbLockInput) {
    let tTmeCode    = $('#oetTCKTimeTbCode').val();
    let nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        $.ajax({
            type : "POST",
            url : "masTCKTimeTbDTData",
            data : {
                'ptTmeCode' : tTmeCode
            },
            success	: function(oResult){
                $('#odvTCKTimeTbDataDT').html(oResult);
                if(pbLockInput == true){
                    JSxTCKTimeDisabledAllInput();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : Check Is Create Page
// Parameters : -
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : Boolean
function JSbTCKTimeTbIsCreatePage() {
    try {
        const tTimeTbCode = $('#oetTCKTimeTbCode').data('is-created');
        let bStatus = false;
        if (tTimeTbCode == "") {
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbTCKTimeTbIsCreatePage Error: ', err);
    }
}

// Functionality : Check Is Update Page
// Parameters : -
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : Boolean
function JSbTCKTimeTbIsUpdatePage() {
    try {
        const tTimeTbCode = $('#oetTCKTimeTbCode').data('is-created');
        let bStatus = false;
        if (!tTimeTbCode == "") {
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbTCKTimeTbIsUpdatePage Error: ', err);
    }
}

// Functionality : Set Visible Component
// Parameters : Component, Visible, Effect
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKTimeTbVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            $(ptComponent).addClass('hidden');
        }
        if (pbVisible == true) {
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    } catch (err) {
        console.log('JSxTCKTimeTbVisibleComponent Error: ', err);
    }
}

// Functionality : Find Object By Key
// Parameters : array, key, value
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKTimeTbfindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}

// Functionality : Set text in delete modal
// Parameters : -
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKTimeTbTextinModal() {
    let aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {

    } else {
        let tText = '';
        let tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tText += aArrayConvert[0][$i].tTmename + '(' + aArrayConvert[0][$i].tTmecode + ') ';
            tText += ' , ';

            tTextCode += aArrayConvert[0][$i].tTmecode;
            tTextCode += ' , ';
        }
        let tTexts = tText.substring(0, tText.length - 2);
        let tConfirm = $('#ohdDeleteChooseconfirm').val();

        $("#odvTCKTimeTbModalDeleteMultiple #ospTCKTimeTbConfirmDelMultiple").text($("#ospTCKTimeTbConfirmDelMultiple").val() + tConfirm);
        $("#odvTCKTimeTbModalDeleteMultiple #ohdTCKTimeTbConfirmIDDelMultiple").val(tTextCode);
    }
}

// Functionality : Set disabled in delete button and icon
// Parameters : -
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKTimeTbShowButtonChoose() {
    let aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
        $('#odvTCKTimeTbMngTableList #oliTCKTimeTbBtnDeleteAll').addClass('disabled');
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $('#odvTCKTimeTbMngTableList #oliTCKTimeTbBtnDeleteAll').removeClass('disabled');
        } else {
            $('#odvTCKTimeTbMngTableList #oliTCKTimeTbBtnDeleteAll').addClass('disabled');
        }

        if (nNumOfArr > 1) {
            $('.xCNIconDelete').addClass('xCNDisabled');
            $('.xCNIconDelete').css("pointer-events", "none");
        } else {
            $('.xCNIconDelete').removeClass('xCNDisabled');
        }
    }
}

// Functionality : Event delete 1 item
// Parameters : CurrentPage, IDCode, DelName, YesOnNo
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKTimeTbDel(tCurrentPage, tIDCode, tDelName, tYesOnNo){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        let aData       = $('#ohdTCKTimeTbConfirmIDDelete').val();
        let aTexts      = aData.substring(0, aData.length - 2);
        let aDataSplit  = aTexts.split(" , ");
        let aDataSplitlength = aDataSplit.length;
        if (aDataSplitlength == '1') {
            $('#odvTCKTimeTbModalDelete').modal('show');
            $('#ospTCKTimeTbConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' (' + tDelName + ')' + tYesOnNo);
            $('#obtTCKTimeTbConfirmDelete').on('click', function(evt) {
                $.ajax({
                    type: "POST",
                    url: "masTCKTimeTbEventDelete",
                    data: {
                        'tTmeCode'   : tIDCode,
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        let tData = $.parseJSON(tResult);
                        $('#odvTCKTimeTbModalDelete').modal('hide');
                        $('#ospTCKTimeTbConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdTCKTimeTbConfirmIDDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        setTimeout(function() {
                            JSvTCKTimeTbCallPageDataTable(tCurrentPage);
                        }, 500);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : Event delete multiple
// Parameters : -
// Creater : 08/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSoTCKTimeTbDeleteMultiple(){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        let aDataDelMultiple = $("#ohdTCKTimeTbConfirmIDDelMultiple").val();
        let aTextsDelMultiple = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
        let aDataSplit = aTextsDelMultiple.split(" , ");
        let nDataSplitlength = aDataSplit.length;
        let aNewIdDelete = [];

        for ($i = 0; $i < nDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }

        if (nDataSplitlength > 1) {
            localStorage.StaDeleteArray = "1";
            $.ajax({
                type: "POST",
                url: "masTCKTimeTbEventDelete",
                data: {
                    'tTmeCode'  : aNewIdDelete ,
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $('#odvTCKTimeTbModalDeleteMultiple').modal('hide');
                    $('#ospTCKTimeTbConfirmDelMultiple').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdTCKTimeTbConfirmIDDelMultiple').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.modal-backdrop').remove();
                    setTimeout(function() {
                        JSvTCKTimeTbCallPageDataTable();
                    }, 500);        
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            localStorage.StaDeleteArray = '0';
            return false;
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : Event Disabled Input
// Parameters : -
// Creater : 23/05/2023 intouch
// Last Update: -
// Return : -
function JSxTCKTimeDisabledAllInput(){
    $('#ofmTCKTimeTbAdd input').addClass('xCNCursorNotAlw').attr('readonly', true);
    $('#ofmTCKTimeTbAdd input').addClass('xCNCursorNotAlw').attr('disabled', true);
    
    $('#odvTCKTimeTbAutoGenCode').addClass('xCNHide');
    $('#oliTCKTimeTbTitleAdd').hide();
    $('#oliTCKTimeTbTitleEdit').hide();
    $('#odvTCKTimeTbBtnInfo').hide();
    $('#odvTCKTimeTbBtnEditInfo').hide();
    
    $('#odvTCKTimeTbDTBtnGrpInfo').hide();
    $('#obtTCKTimeTbDTCallPageAdd').hide();

    JSxTCKTimeDisabledBtnDel();
}

function JSxTCKTimeDisabledBtnDel(){
    setTimeout(function() {
        $('#otbTimeTbDTTableList td:nth-child(5)').hide();
        $('#otbTimeTbDTTableList th:nth-child(5)').hide();
    }, 300);
}