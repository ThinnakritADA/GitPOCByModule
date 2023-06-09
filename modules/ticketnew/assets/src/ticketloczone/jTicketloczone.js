var nTCKLocZoneBrowseType   = $('#ohdTCKLocZoneBrowseType').val();
var nTCKLocZoneBrowseOption = $('#ohdTCKLocZoneBrowseOption').val();

$('document').ready(function () {
    JSxCheckPinMenuClose();     //Check เปิดปิด Menu ตาม Pin
    JSxTCKLocZoneNavDefult();   //ตั้งค่า Default Nav
    localStorage.removeItem('LocalItemData');

    if (nTCKLocZoneBrowseType != 1) {
        JSvTCKLocZoneCallPageList(1);
    } else {
        JSvTCKLocZoneCallPageAdd();
    }
});

// Functionality : Setting default Nav
// Parameters : -
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKLocZoneNavDefult() {
    if (nTCKLocZoneBrowseType != 1 || nTCKLocZoneBrowseOption == undefined) {
        $('#oliTCKLocZoneTitleAdd').hide();
        $('#oliTCKLocZoneTitleEdit').hide();
        $('#odvTCKLocZoneBtnEditInfo').hide();    
        $('#odvTCKLocZoneBtnInfo').show();
    } else {
        $('#odvModalBody #odvTCKLocZoneMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliTCKLocZoneNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvTCKLocZoneBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNTCKLocZoneBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNTCKLocZoneBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Functionality : Load list view
// Parameters : Page
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKLocZoneCallPageList(pnPage){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        localStorage.tStaPageNow = 'JSvTCKLocZoneCallPageList';
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masTCKLocZoneFormSearchList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageTCKLocZone').html(tResult);
                JSvTCKLocZoneCallPageDataTable(pnPage);
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
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKLocZoneCallPageDataTable(pnPage) {
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        let tSearchAll = $('#oetTCKLocZoneSearchAll').val();
        let nPageCurrent = (pnPage == undefined || pnPage == '') ? '1' : pnPage;
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masTCKLocZoneDataTable",
            data: {
                tSearchAll      : tSearchAll,
                nPageCurrent    : nPageCurrent,
            },
            cache: false,
            timeout: 5000,
            success: function(oResult) {
                let aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    JSxTCKLocZoneNavDefult();
                    $('#ostTCKLocZoneDataLocZone').html(aReturnData['oTCKLocZoneViewDataTableList']);
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
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKLocZoneClickPage(ptPage) {
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
    JSvTCKLocZoneCallPageDataTable(nPageCurrent);
}

// Functionality : Call add page
// Parameters : -
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKLocZoneCallPageAdd() {
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masTCKLocZonePageAdd",
            cache: false,
            timeout: 0,
            success: function(oResult) {
                if (nTCKLocZoneBrowseType == 1) {
                    $('#odvTCKLocZoneModalBodyBrowse').html(oResult);
                    $('#odvTCKLocZoneModalBodyBrowse .panel-body').css('padding-top', '0');
                } else {
                    $('#oliTCKLocZoneTitleAdd').show();
                    $('#oliTCKLocZoneTitleEdit').hide();
                    $('#odvTCKLocZoneBtnInfo').hide();
                    $('#odvTCKLocZoneBtnEditInfo').show();
                }
                $('#odvContentPageTCKLocZone').html(oResult);
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
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKLocZoneCallPageEdit(ptZneCode){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        let tZneCode = ptZneCode;
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masTCKLocZonePageEdit",
            data: {
                'ptZneCode'	: tZneCode,
            },
            timeout: 0,
            success: function(oResult) {
                $('#odvContentPageTCKLocZone').html(oResult);

                $('#oetTCKLocZoneCode').addClass('xCNCursorNotAlw').attr('readonly', true);
                $('#odvTCKLocZoneAutoGenCode').addClass('xCNHide');

                $('#oliTCKLocZoneTitleAdd').hide();
                $('#oliTCKLocZoneTitleEdit').show();
                $('#odvTCKLocZoneBtnInfo').hide();
                $('#odvTCKLocZoneBtnEditInfo').show();
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
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKLocZoneAddEdit(ptRoute){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        let tRoute = ptRoute;
        $('#ofmTCKLocZoneAdd').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (tRoute == "masTCKLocZoneEventAdd") {
                if ($("#ohdTCKLocZoneCheckDuplicateCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');   
        $('#ofmTCKLocZoneAdd').validate({
            rules: {
                oetTCKLocZoneCode: {
                    "required": {
                        depends: function(oElement) {
                            if (tRoute == "masTCKLocZoneEventAdd") {
                                if ($('#ocbTCKLocZoneAutoGenCode').is(':checked')) {
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
                oetTCKLocZoneName: { "required": {} },
                oetTCKLocZoneBchLocName: { "required": {} },
            },
            messages: {
                oetTCKLocZoneCode: {
                    "required"      : $('#oetTCKLocZoneCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetTCKLocZoneCode').attr('data-validate-dublicateCode')
                },
                oetTCKLocZoneName: {
                    "required"      : $('#oetTCKLocZoneName').attr('data-validate-required'),
                },
                oetTCKLocZoneBchLocName: {
                    "required"      : $('#oetTCKLocZoneBchLocName').attr('data-validate-required'),
                }
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
                    data: $("#ofmTCKLocZoneAdd").serialize(),
                    timeout: 0,
                    success: function(oResult) {
                        if (nTCKLocZoneBrowseType != 1) {
                            let aReturn = JSON.parse(oResult);
                            if (aReturn['nStaEvent'] == 1) {
                                switch (aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvTCKLocZoneCallPageEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvTCKLocZoneCallPageAdd();
                                        break;
                                    case '3':
                                        JSvTCKLocZoneCallPageList(1);
                                        break;
                                    default:
                                        JSvTCKLocZoneCallPageEdit(aReturn['tCodeReturn']);
                                }
                                JCNxImgWarningMessage(aReturn['aImgReturn']);
                            } else {
                                JCNxCloseLoading();
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(nTCKLocZoneBrowseOption);
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
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : Boolean
function JSbTCKLocZoneIsCreatePage() {
    try {
        const tLocZoneCode = $('#oetTCKLocZoneCode').data('is-created');
        let bStatus = false;
        if (tLocZoneCode == "") {
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbTCKLocZoneIsCreatePage Error: ', err);
    }
}

// Functionality : Check Is Update Page
// Parameters : -
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : Boolean
function JSbTCKLocZoneIsUpdatePage() {
    try {
        const tLocZoneCode = $('#oetTCKLocZoneCode').data('is-created');
        let bStatus = false;
        if (!tLocZoneCode == "") {
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbTCKLocZoneIsUpdatePage Error: ', err);
    }
}

// Functionality : Set Visible Component
// Parameters : Component, Visible, Effect
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKLocZoneVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxTCKLocZoneVisibleComponent Error: ', err);
    }
}

// Functionality : Find Object By Key
// Parameters : array, key, value
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKLocZonefindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}

// Functionality : Set text in delete modal
// Parameters : -
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKLocZoneTextinModal() {
    let aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {

    } else {
        let tText = '';
        let tTextCode = '';
        let tTextChain = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tText += aArrayConvert[0][$i].tZnename + '(' + aArrayConvert[0][$i].tZnecode + ') ';
            tText += ' , ';

            tTextCode += aArrayConvert[0][$i].tZnecode;
            tTextCode += ' , ';

            tTextChain += aArrayConvert[0][$i].tZneChain;
            tTextChain += ' , ';
        }
        let tTexts = tText.substring(0, tText.length - 2);
        let tConfirm = $('#ohdDeleteChooseconfirm').val();

        $("#odvTCKLocZoneModalDeleteMultiple #ospTCKLocZoneConfirmDelMultiple").text($("#ospTCKLocZoneConfirmDelMultiple").val() + tConfirm);
        $("#odvTCKLocZoneModalDeleteMultiple #ohdTCKLocZoneConfirmIDDelMultiple").val(tTextCode);
        $("#odvTCKLocZoneModalDeleteMultiple #ohdTCKLocZoneConfirmIDChainDelMultiple").val(tTextChain);
    }
}

// Functionality : Set disabled in delete button and icon
// Parameters : -
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : -
function JSxTCKLocZoneShowButtonChoose() {
    let aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
        $('#odvTCKLocZoneMngTableList #oliTCKLocZoneBtnDeleteAll').addClass('disabled');
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $('#odvTCKLocZoneMngTableList #oliTCKLocZoneBtnDeleteAll').removeClass('disabled');
        } else {
            $('#odvTCKLocZoneMngTableList #oliTCKLocZoneBtnDeleteAll').addClass('disabled');
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
// Parameters : CurrentPage, tIDChain, IDCode, DelName, YesOnNo
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKLocZoneDel(tCurrentPage, tIDChain, tIDCode, tDelName, tYesOnNo){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        let aData       = $('#ohdTCKLocZoneConfirmIDDelete').val();
        let aTexts      = aData.substring(0, aData.length - 2);
        let aDataSplit  = aTexts.split(" , ");
        let aDataSplitlength = aDataSplit.length;
        if (aDataSplitlength == '1') {
            $('#odvTCKLocZoneModalDelete').modal('show');
            $('#ospTCKLocZoneConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' (' + tDelName + ')' + tYesOnNo);
            $('#obtTCKLocZoneConfirmDelete').on('click', function(evt) {
                $.ajax({
                    type: "POST",
                    url: "masTCKLocZoneEventDelete",
                    data: {
                        'tZneCode'   : tIDCode,
                        'tZneChain'  : tIDChain
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        let tData = $.parseJSON(tResult);
                        $('#odvTCKLocZoneModalDelete').modal('hide');
                        $('#ospTCKLocZoneConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdTCKLocZoneConfirmIDDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        setTimeout(function() {
                            JSvTCKLocZoneCallPageDataTable(tCurrentPage);
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
// Creater : 03/05/2023 Papitchaya
// Last Update: -
// Return : View
function JSvTCKLocZoneDeleteMultiple(){
    let nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        let aDataDelMultiple = $("#ohdTCKLocZoneConfirmIDDelMultiple").val();
        let aTextsDelMultiple = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
        let aDataSplit = aTextsDelMultiple.split(" , ");
        let nDataSplitlength = aDataSplit.length;
        let aNewIdDelete = [];

        let aDataDelChainMultiple = $("#ohdTCKLocZoneConfirmIDChainDelMultiple").val();
        let aTextsDelChainMultiple = aDataDelChainMultiple.substring(0, aDataDelChainMultiple.length - 2);
        let aDataChainSplit = aTextsDelChainMultiple.split(" , ");
        let nDataChainSplitlength = aDataChainSplit.length;
        let aNewIdChainDelete = [];

        for ($i = 0; $i < nDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
            aNewIdChainDelete.push(aDataChainSplit[$i]);
        }
        if (nDataSplitlength > 1) {
            localStorage.StaDeleteArray = "1";
            $.ajax({
                type: "POST",
                url: "masTCKLocZoneEventDelete",
                data: {
                    'tZneCode'  : aNewIdDelete ,
                    'tZneChain' : aNewIdChainDelete
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $('#odvTCKLocZoneModalDeleteMultiple').modal('hide');
                    $('#ospTCKLocZoneConfirmDelMultiple').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdTCKLocZoneConfirmIDDelMultiple').val('');
                    $('#ohdTCKLocZoneConfirmIDChainDelMultiple').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.modal-backdrop').remove();
                    setTimeout(function() {
                        JSvTCKLocZoneCallPageDataTable();
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