var nStaFacBrowseType = $('#oetFacStaBrowse').val();
var tCallFacBackOption = $('#oetFacCallBackOption').val();
// alert(nStaFacBrowseType+'//'+tCallFacBackOption);
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxFacNavDefult();
    if (nStaFacBrowseType != 1) {
        JSvCallPageFacList();
    } else {
        JSvCallPageFacAdd();
    }
});

//function : Function Clear Defult Button SupplierType
//Parameters : Document Ready
//Creator : 17/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxFacNavDefult() {
    if (nStaFacBrowseType != 1 || nStaFacBrowseType == undefined) {
        $('.xCNFacVBrowse').hide();
        $('.xCNFacVMaster').show();
        $('.xCNChoose').hide();
        $('#oliFacTitleAdd').hide();
        $('#oliFacTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnFacInfo').show();
    } else {
        $('#odvModalBody .xCNFacVMaster').hide();
        $('#odvModalBody .xCNFacVBrowse').show();
        $('#odvModalBody #odvFacMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliFacNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvFacBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNFacBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNFacBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 17/10/2018 witsarut
//Return : Modal Status Error
//Return Type : view
function JCNxResponseError(jqXHR, textStatus, errorThrown) {
    JCNxCloseLoading();
    var tHtmlError = $(jqXHR.responseText);
    var tMsgError = "<h3 style='font-size:20px;color:red'>";
    tMsgError += "<i class='fa fa-exclamation-triangle'></i>";
    tMsgError += " Error<hr></h3>";
    switch (jqXHR.status) {
        case 404:
            tMsgError += tHtmlError.find('p:nth-child(2)').text();
            break;
        case 500:
            tMsgError += tHtmlError.find('p:nth-child(3)').text();
            break;

        default:
            tMsgError += 'something had error. please contact admin';
            break;
    }
    $("body").append(tModal);
    $('#modal-customs').attr("style", 'width: 450px; margin: 1.75rem auto;top:20%;');
    $('#myModal').modal({ show: true });
    $('#odvModalBody').html(tMsgError);
}

//function : Call SupplierType Page list  
//Parameters : Document Redy And Event Button
//Creator :	17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageFacList() {
    localStorage.tStaPageNow = 'JSvCallPageFacList';
    $('#oetSearchFac').val('');
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masTIKFacPageList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentPageFac').html(tResult);
            JSvFacDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call SupplierType Data List
//Parameters: Ajax Success Event 
//Creator:	17/10/2018 witsarut
//Return: View
//Return Type: View
function JSvFacDataTable(pnPage) {
    var tSearchAll = $('#oetSearchFac').val();
    var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "masTIKFacDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#ostDataFac').html(tResult);
            }
            JSxFacNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMSplType_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call SupplierType Page Add  
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageFacAdd() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "masTIKFacPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaFacBrowseType == 1) {
                $('.xCNFacVMaster').hide();
                $('.xCNFacVBrowse').show();
            } else {
                $('.xCNFacVBrowse').hide();
                $('.xCNFacVMaster').show();
                $('#oliFacTitleEdit').hide();
                $('#oliFacTitleAdd').show();
                $('#odvBtnFacInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPageFac').html(tResult);
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call SupplierType Page Edit  
//Parameters : Event Button Click 
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageFacEdit(ptFacCode) {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageFacEdit', ptFacCode);
    $.ajax({
        type: "POST",
        url: "masTIKFacPageEdit",
        data: { tFacCode: ptFacCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliFacTitleAdd').hide();
                $('#oliFacTitleEdit').show();
                $('#odvBtnFacInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageFac').html(tResult);
                $('#oetFacCode').addClass('xCNDisable');
                $('#oetFacCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Event Add/Edit SupplierType
//Parameters : From Submit
//Creator : 17/10/2018 witsarut
//Return : Status Event Add/Edit SupplierType
//Return Type : object
function JSoAddEditFac(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddFac').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "masTIKFacEventAdd") {
                if ($("#ohdCheckDuplicateFacCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddFac').validate({
            rules: {
                oetFacCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "masTIKFacEventAdd") {
                                if ($('#ocbFacAutoGenCode').is(':checked')) {
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
                oetFacName: { "required": {} },
            },
            messages: {
                oetFacCode: {
                    "required": $('#oetFacCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetFacCode').attr('data-validate-dublicateCode')
                },
                oetFacName: {
                    "required": $('#oetFacName').attr('data-validate-required')
                }
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
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
                    url: ptRoute,
                    data: $('#ofmAddFac').serialize(),
                    success: function(oResult) {
                        if (nStaFacBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if (aReturn['nStaEvent'] == 1) {
                                switch (aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvCallPageFacEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvCallPageFacAdd();
                                        break;
                                    case '3':
                                        JSvCallPageFacList();
                                        break;
                                    default:
                                        JSvCallPageFacEdit(aReturn['tCodeReturn']);
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                                JSvCallPageFacAdd();
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallFacBackOption);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
    }
}

//Functionality : Generate Code SupplierType
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
function JStGenerateFacCode() {
    $('#oetFacCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMSplType';
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "generateCode",
        data: { tTableName: tTableName },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var tData = $.parseJSON(tResult);
            if (tData.rtCode == '1') {
                $('#oetFacCode').val(tData.rtFacCode);
                $('#oetFacCode').addClass('xCNDisable');
                $('#oetFacCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetFacName').focus();
            } else {
                $('#oetFacCode').val(tData.rtDesc);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseErroe(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 17/10/2018 witsarut
//Return : object Status Delete
//Return Type : object
function JSoFacDel(tIDCode, tName) {
    var aData = $('#ospConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    var tConfirm = $('#ohdDeleteconfirm').val();
    var tConfirmYN = $('#ohdDeleteconfirmYN').val();

    if (aDataSplitlength == '1') {

        $('#odvModalDelFac').modal('show');
        $('#ospConfirmDelete').text(tConfirm + ' ' + tIDCode + ' (' + tName + ') ' + tConfirmYN);
        $('#osmConfirm').on('click', function(evt) {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "masTIKFacEventDelete",
                data: { 'tIDCode': tIDCode },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        $('#odvModalDelFac').modal('hide');
                        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                        $('#ospConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        setTimeout(function() {
                            JSvFacDataTable();
                        }, 500);
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                    JSxFacNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 17/10/2018 witsarut
//Return:  object Status Delete
//Return Type: object
function JSoFacDelChoose() {
    JCNxOpenLoading();
    var aData = $('#ospConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];
    for ($i = 0; $i < aDataSplitlength; $i++) {
        aNewIdDelete.push(aDataSplit[$i]);
    }
    if (aDataSplitlength > 1) {
        localStorage.StaDeleteArray = '1';
        $.ajax({
            type: "POST",
            url: "masTIKFacEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturn = JSON.parse(oResult);
                if (aReturn['nStaEvent'] == 1) {
                    setTimeout(function() {
                        $('#odvModalDelFac').modal('hide');
                        JSvCallPageFacList();
                        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                        $('#ospConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                    }, 1000);
                } else {
                    alert(aReturn['tStaMessg']);
                }
                JSxFacNavDefult();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        localStorage.StaDeleteArray = '0';
        return false;
    }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvFacClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageFac .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageFac .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvFacDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 17/10/2018 witsarut
//Return: - 
//Return Type: -
function JSxShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
        $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $('#odvMngTableList #oliBtnDeleteAll').removeClass('disabled');
        } else {
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 17/10/2018 witsarut
//Return: -
//Return Type: -
function JSxTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tText = '';
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tText += aArrayConvert[0][$i].tName + '(' + aArrayConvert[0][$i].nCode + ') ';
            tText += ' , ';

            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        var tTexts = tText.substring(0, tText.length - 2);
        var tConfirm = $('#ohdDeleteChooseconfirm').val();
        $('#ospConfirmDelete').text(tConfirm);
        $('#ospConfirmIDDelete').val(tTextCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator: 17/10/2018 witsarut
//Return: Duplicate/none
//Return Type: string
function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbsSuppliertypeIsCreatePage() {
    try {
        const tFacCode = $('#oetFacCode').data('is-created');
        var bStatus = false;
        if (tFacCode == "" || tFacCode == null) { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbsSuppliertypeIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbSuppliertypeIsUpdatePage() {
    try {
        const tFacCode = $('#oetFacCode').data('is-created');
        var bStatus = false;
        if (!tFacCode == "" || !tFacCode == null) { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbVoucherIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxSuppliertypeVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            $(ptComponent).addClass('hidden');
        }
        if (pbVisible == true) {
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    } catch (err) {
        console.log('JSxVoucherVisibleComponent Error: ', err);
    }
}