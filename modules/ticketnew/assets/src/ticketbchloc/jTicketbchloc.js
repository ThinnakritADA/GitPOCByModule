var nTCKBchLocBrowseType   = $('#ohdTCKBchLocBrowseType').val();
var tTCKBchLocBrowseOption = $('#ohdTCKBchLocBrowseOption').val();

$('document').ready(function () {
    JSxCheckPinMenuClose();     //Check เปิดปิด Menu ตาม Pin
    JSxTCKBchLocNavDefult();    //ตั้งค่า Default Nav
    localStorage.removeItem('LocalItemData');

    if (nTCKBchLocBrowseType != 1) {
        JSvTCKBchLocCallPageBchLocList(1);
    } else {
        JSvTCKBchLocCallPageBchLocAdd();
    }
});

// Functionality : Setting default Nav
// Parameters : -
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKBchLocNavDefult() {
    if (nTCKBchLocBrowseType != 1 || tTCKBchLocBrowseOption == undefined) {
        $('#oliTCKBchLocTitleAdd').hide();
        $('#oliTCKBchLocTitleEdit').hide();
        $('#odvTCKBchLocBtnEditInfo').hide();    
        $('#odvTCKBchLocBtnInfo').show();
    } else {
        $('#odvModalBody #odvTCKBchLocMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliTCKBchLocNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvTCKBchLocBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNTCKBchLocBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNTCKBchLocBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Functionality : Load list view
// Parameters : Page
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocCallPageBchLocList(pnPage){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        localStorage.tStaPageNow = 'JSvTCKBchLocCallPageBchLocList';
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masTCKBchLocFormSearchList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageTCKBchLoc').html(tResult);
                JSvTCKBchLocCallPageBchLocDataTable(pnPage);
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
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocCallPageBchLocDataTable(pnPage) {
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        let tSearchAll = $('#oetTCKBchLocSearchAll').val();
        let nPageCurrent = (pnPage == undefined || pnPage == '') ? '1' : pnPage;
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masTCKBchLocDataTable",
            data: {
                tSearchAll      : tSearchAll,
                nPageCurrent    : nPageCurrent,
            },
            cache: false,
            timeout: 5000,
            success: function(oResult) {
                let aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    JSxTCKBchLocNavDefult();
                    $('#ostTCKBchLocDataBchLoc').html(aReturnData['oTCKBchLocViewDataTableList']);
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
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocClickPage(ptPage) {

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
    JSvTCKBchLocCallPageBchLocDataTable(nPageCurrent);
}

// Functionality : Call add page
// Parameters : -
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocCallPageBchLocAdd() {
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masTCKBchLocPageAdd",
            cache: false,
            timeout: 0,
            success: function(oResult) {
                if (nTCKBchLocBrowseType == 1) {
                    $('#odvTCKBchLocModalBodyBrowse').html(oResult);
                    $('#odvTCKBchLocModalBodyBrowse .panel-body').css('padding-top', '0');
                } else {
                    $('#oliTCKBchLocTitleAdd').show();
                    $('#oliTCKBchLocTitleEdit').hide();
                    $('#odvTCKBchLocBtnInfo').hide();
                    $('#odvTCKBchLocBtnEditInfo').show();
                }
                $('#odvContentPageTCKBchLoc').html(oResult);
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
// Parameters : LocCode
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocCallPageBchLocEdit(ptLocCode) {
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        let tLocCode = ptLocCode;
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masTCKBchLocPageEdit",
            data: {
                'ptLocCode'	: tLocCode,
            },
            timeout: 0,
            success: function(oResult) {
                $('#odvContentPageTCKBchLoc').html(oResult);
                
                $('#oetTCKBchLocCode').addClass('xCNCursorNotAlw').attr('readonly', true);
                $('#odvTCKBchLocAutoGenCode').addClass('xCNHide');

                $('#oliTCKBchLocTitleAdd').hide();
                $('#oliTCKBchLocTitleEdit').show();
                $('#odvTCKBchLocBtnInfo').hide();
                $('#odvTCKBchLocBtnEditInfo').show();
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
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocAddEdit(ptRoute){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        let tRoute = ptRoute;
        $('#ofmTCKBchLocAddLoc').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (tRoute == "masTCKBchLocEventAdd") {
                if ($("#ohdTCKBchLocCheckDuplicateCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmTCKBchLocAddLoc').validate({
            rules: {
                oetTCKBchLocCode: {
                    "required": {
                        depends: function(oElement) {
                            if (tRoute == "masTCKBchLocEventAdd") {
                                if ($('#ocbTCKBchLocAutoGenCode').is(':checked')) {
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
                oetTCKBchLocName: { "required": {} },
                // oetTCKBchLocBchName: { "required": {} },
            },
            messages: {
                oetTCKBchLocCode: {
                    "required"      : $('#oetTCKBchLocCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetTCKBchLocCode').attr('data-validate-dublicateCode')
                },
                oetTCKBchLocName: {
                    "required"      : $('#oetTCKBchLocName').attr('data-validate-required'),
                },
                // oetTCKBchLocBchName: {
                //     "required"      : $('#oetTCKBchLocBchName').attr('data-validate-required'),
                // },
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
                    data: $("#ofmTCKBchLocAddLoc").serialize(),
                    timeout: 0,
                    success: function(oResult) {
                        if (nTCKBchLocBrowseType != 1) {
                            let aReturn = JSON.parse(oResult);
                            if (aReturn['nStaEvent'] == 1) {
                                switch (aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvTCKBchLocCallPageBchLocEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvTCKBchLocCallPageBchLocAdd();
                                        break;
                                    case '3':
                                        JSvTCKBchLocCallPageBchLocList(1);
                                        break;
                                    default:
                                        JSvTCKBchLocCallPageBchLocEdit(aReturn['tCodeReturn']);
                                }
                                JCNxImgWarningMessage(aReturn['aImgReturn']);
                            } else {
                                JCNxCloseLoading();
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(tTCKBchLocBrowseOption);
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

// Functionality : Check Is Create Page
// Parameters : -
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : Boolean
function JSbTCKBchLocIsCreatePage() {
    try {
        const tBchLocCode = $('#oetTCKBchLocCode').data('is-created');
        let bStatus = false;
        if (tBchLocCode == "") {
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbTCKBchLocIsCreatePage Error: ', err);
    }
}

// Functionality : Check Is Update Page
// Parameters : -
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : Boolean
function JSbTCKBchLocIsUpdatePage() {
    try {
        const tBchLocCode = $('#oetTCKBchLocCode').data('is-created');
        let bStatus = false;
        if (!tBchLocCode == "") {
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbTCKBchLocIsUpdatePage Error: ', err);
    }
}

// Functionality : Set Visible Component
// Parameters : Component, Visible, Effect
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKBchLocVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxTCKBchLocVisibleComponent Error: ', err);
    }
}

// Functionality : Find Object By Key
// Parameters : array, key, value
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKBchLocfindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}

// Functionality : Set text in delete modal
// Parameters : -
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKBchLocTextinModal() {
    let aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {

    } else {

        let tText = '';
        let tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tText += aArrayConvert[0][$i].tLocName + '(' + aArrayConvert[0][$i].tLocCode + ') ';
            tText += ' , ';

            tTextCode += aArrayConvert[0][$i].tLocCode;
            tTextCode += ' , ';

        }

        let tTexts = tText.substring(0, tText.length - 2);
        let tConfirm = $('#ohdDeleteChooseconfirm').val();

        $("#odvTCKBchLocModalDeleteMultiple #ospTCKBchLocConfirmDelMultiple").text($("#ospTCKBchLocConfirmDelMultiple").val() + tConfirm);
        $("#odvTCKBchLocModalDeleteMultiple #ohdTCKBchLocConfirmIDDelMultiple").val(tTextCode);
    }
}

// Functionality : Set disabled in delete button and icon
// Parameters : -
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKBchLocShowButtonChoose() {
    let aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
        $('#odvTCKBchLocMngTableList #oliTCKBchLocBtnDeleteAll').addClass('disabled');
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $('#odvTCKBchLocMngTableList #oliTCKBchLocBtnDeleteAll').removeClass('disabled');
        } else {
            $('#odvTCKBchLocMngTableList #oliTCKBchLocBtnDeleteAll').addClass('disabled');
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
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocDel(tCurrentPage, tIDCode, tDelName, tYesOnNo) {
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        let aData       = $('#ohdTCKBchLocConfirmIDDelete').val();
        let aTexts      = aData.substring(0, aData.length - 2);
        let aDataSplit  = aTexts.split(" , ");
        let aDataSplitlength = aDataSplit.length;
        if (aDataSplitlength == '1') {
            $('#odvTCKBchLocModalDelete').modal('show');
            $('#ospTCKBchLocConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' (' + tDelName + ')' + tYesOnNo);
            $('#obtTCKBchLocConfirmDelete').on('click', function(evt) {
                $.ajax({
                    type: "POST",
                    url: "masTCKBchLocEventDelete",
                    data: {
                        'tIDCode': tIDCode
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        let tData = $.parseJSON(tResult);
                        $('#odvTCKBchLocModalDelete').modal('hide');
                        $('#ospTCKBchLocConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdTCKBchLocConfirmIDDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        setTimeout(function() {
                            JSvTCKBchLocCallPageBchLocDataTable(tCurrentPage);
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
// Creater : 20/04/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKBchLocDeleteMultiple(){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        let aDataDelMultiple = $("#ohdTCKBchLocConfirmIDDelMultiple").val();
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
                url: "masTCKBchLocEventDelete",
                data: { 'tIDCode' : aNewIdDelete },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $('#odvTCKBchLocModalDeleteMultiple').modal('hide');
                    $('#ospTCKBchLocConfirmDelMultiple').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdTCKBchLocConfirmIDDelMultiple').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.modal-backdrop').remove();
                    setTimeout(function() {
                        JSvTCKBchLocCallPageBchLocDataTable();
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

