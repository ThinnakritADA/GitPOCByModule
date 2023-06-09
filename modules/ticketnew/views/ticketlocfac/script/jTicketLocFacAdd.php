<script type="text/javascript">

    var nLangEdits = <?= $this->session->userdata("tLangEdit");?>;

    $(document).ready(function(){
    
        if(JSbsSuppliertypeIsCreatePage()){
            //suppliertype Code
            $("#oetFacCode").attr("disabled", true);
            $('#ocbFacAutoGenCode').change(function(){
                if($('#ocbFacAutoGenCode').is(':checked')) {
                    $('#oetFacCode').val('');
                    $("#oetFacCode").attr("disabled", true);
                    $('#odvCpnCodeForm').removeClass('has-error');
                    $('#odvCpnCodeForm em').remove();
                }else{
                    $("#oetFacCode").attr("disabled", false);
                }
            });
            JSxSuppliertypeVisibleComponent('#odvFacAutoGenCode', true);
        }
        
        if(JSbSuppliertypeIsUpdatePage()){
      
            // suppliertype Code
            $("#oetFacCode").attr("readonly", true);
            $('#odvFacAutoGenCode input').attr('disabled', true);
            JSxSuppliertypeVisibleComponent('#odvFacAutoGenCode', false);    
        }
    });

    $('#oetFacCode').blur(function(){
        JSxCheckSuppliertypeCodeDupInDB();
    });

    //Functionality : Event Check suppliertype
    //Parameters : Event Blur Input suppliertype Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Updata : 30/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckSuppliertypeCodeDupInDB(){
        if(!$('#ocbFacAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TTKMLocFacility",
                    tFieldName: "FTFacCode",
                    tCode: $("#oetFacCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateFacCode").val(aResult["rtCode"]);
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateFacCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddFac').validate({
                    rules: {
                        oetFacCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbCouponAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetFacName:     {"required" :{}},
                    },
                    messages: {
                        oetFacCode : {
                            "required"      : $('#oetFacCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetFacCode').attr('data-validate-dublicateCode')
                        },
                        oetFacName : {
                            "required"      : $('#oetFacName').attr('data-validate-required'),
                        },
                    },
                    errorElement: "em",
                    errorPlacement: function (error, element ) {
                        error.addClass( "help-block" );
                        if ( element.prop( "type" ) === "checkbox" ) {
                            error.appendTo( element.parent( "label" ) );
                        } else {
                            var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                            if(tCheck == 0){
                                error.appendTo(element.closest('.form-group')).trigger('change');
                            }
                        }
                    },
                    highlight: function ( element, errorClass, validClass ) {
                        $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                    },
                    submitHandler: function(form){}
                });

                // Submit From
                $('#ofmAddFac').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }


        // Create By Napat 19/05/2020
        $('#obtFacBrowseAgency').off('click');
        $('#obtFacBrowseAgency').on('click',function(){
            var nStaSession  = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oUsrAgnOption       = undefined;
                oUsrAgnOption              = oUsrBrowseAgency({
                    'tReturnInputCode'          : 'oetFacAgnCode',
                    'tReturnInputName'          : 'oetFacAgnName',
                    'tNextFuncName'             : 'JSxFACNextFuncBrowseAgency',
                    'aArgReturn'                : ['FTAgnCode','FTAgnName']
                });
                JCNxBrowseData('oUsrAgnOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Option Browse Merchant
        var oUsrBrowseAgency = function(poReturnInputAgency){
            let tInputReturnAgnCode   = poReturnInputAgency.tReturnInputCode;
            let tInputReturnAgnName   = poReturnInputAgency.tReturnInputName;
            let tAgencyNextFunc       = poReturnInputAgency.tNextFuncName;
            let aAgencyArgReturn      = poReturnInputAgency.aArgReturn;

            let oAgencyOptionReturn = {
                Title : ['authen/user/user','tBrowseAgnTitle'],
                Table :{Master:'TCNMAgency',PK:'FTAgnCode'},
                Join :{
                    Table:	['TCNMAgency_L'],
                    On:[' TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits] //+ tJoinBranch + tJoinShop
                },
                GrideView:{
                    ColumnPathLang	: 'authen/user/user',
                    ColumnKeyLang	: ['tBrowseAgnCode','tBrowseAgnName'],
                    ColumnsSize     : ['10%','75%'],
                    DataColumns	    : ['TCNMAgency.FTAgnCode','TCNMAgency_L.FTAgnName'],
                    DataColumnsFormat : ['',''],
                    WidthModal      : 50,
                    Perpage			: 10,
                    OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
                },
                NextFunc : {
                    FuncName  : tAgencyNextFunc,
                    ArgReturn : aAgencyArgReturn
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: [tInputReturnAgnCode,"TCNMAgency.FTAgnCode"],
                    Text		: [tInputReturnAgnName,"TCNMAgency_L.FTAgnName"]
                },
                //DebugSQL: true,
            };
            return oAgencyOptionReturn;
        }

        function JSxFACNextFuncBrowseAgency(poDataNextFunc){
            if(poDataNextFunc != 'NULL'){
                // Clear Input Browse
                $('#oetFacBchCode').val('');
                $('#oetFacBchName').val('');
                
                $('#oetFacLocCode').val('');
                $('#oetFacLocName').val('');
                
                $('#oetFacZneCode').val('');
                $('#oetFacZneName').val('');

                $('#oetFacRefCode').val('');
                $('#oetFacRefName').val('');
            }
        }

        // Create By Napat 19/05/2020
        $('#obtFacBrowseBranch').off('click');
        $('#obtFacBrowseBranch').on('click',function(){
            var nStaSession  = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oFacBchOption       = undefined;
                oFacBchOption              = oFacBrowseBranch({
                    'tReturnInputCode'          : 'oetFacBchCode',
                    'tReturnInputName'          : 'oetFacBchName',
                    'tNextFuncName'             : 'JSxFACNextFuncBrowseBranch',
                    'aArgReturn'                : ['FTBchCode','FTBchName'] 
                });
                JCNxBrowseData('oFacBchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        // Option Browse Branch
        var oFacBrowseBranch = function(poReturnInputBranch){
            let tInputReturnBranchCode   = poReturnInputBranch.tReturnInputCode;
            let tInputReturnBranchName   = poReturnInputBranch.tReturnInputName;
            let tBranchNextFunc          = poReturnInputBranch.tNextFuncName;
            let aBranchArgReturn         = poReturnInputBranch.aArgReturn;

            let tSesUsrBchCodeMulti     =  "<?=$this->session->userdata('tSesUsrBchCodeMulti')?>";
            let tSesUsrLevel            =  "<?=$this->session->userdata('tSesUsrLevel')?>";
            let tWhereCondiotion        = "";

            if( tSesUsrLevel != "HQ" ){
                tWhereCondiotion = " AND TCNMBranch.FTBchCode IN ("+tSesUsrBchCodeMulti+") ";
            }

            let oBranchOptionReturn      = {
                Title : ['authen/user/user','tBrowseBCHTitle'],
                Table :{Master:'TCNMBranch',PK:'FTBchCode'},
                Join :{
                    Table       : ['TCNMBranch_L'], //,'TCNMMerchant_L'
                    On          : [
                        'TCNMBranch.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits
                        // 'TCNMBranch.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits
                    ]
                },
                Where:{
                    Condition: [ tWhereCondiotion ]
                },
                Filter:{
                    Selector    : 'oetFacAgnCode',
                    Table       : 'TCNMBranch',
                    Key         : 'FTAgnCode'
                },
                GrideView:{
                    ColumnPathLang	: 'authen/user/user',
                    ColumnKeyLang	: ['tBrowseBCHCode','tBrowseBCHName'],
                    ColumnsSize     : ['10%','75%'],
                    DataColumns	    : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'], //,'TCNMBranch.FTMerCode','TCNMMerchant_L.FTMerName'
                    DataColumnsFormat : ['',''],
                    // DisabledColumns	: [2,3],
                    WidthModal      : 50,
                    Perpage			: 10,
                    OrderBy			: ['TCNMBranch.FTBchCode DESC'],
                },
                NextFunc : {
                    FuncName  : tBranchNextFunc,
                    ArgReturn : aBranchArgReturn
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: [tInputReturnBranchCode,"TCNMBranch.FTBchCode"],
                    Text		: [tInputReturnBranchName,"TCNMBranch_L.FTBchName"]
                },
            };
            return oBranchOptionReturn;
        }

        function JSxFACNextFuncBrowseBranch(poDataNextFunc){
            if(poDataNextFunc != 'NULL'){
                // Clear Input Browse
                $('#oetFacLocCode').val('');
                $('#oetFacLocName').val('');
                
                $('#oetFacZneCode').val('');
                $('#oetFacZneName').val('');

                $('#oetFacRefCode').val('');
                $('#oetFacRefName').val('');
            }
        }

        // Create By Napat 19/05/2020
        $('#obtFacBrowseLoc').off('click');
        $('#obtFacBrowseLoc').on('click',function(){
            var nStaSession  = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oFacLocOption       = undefined;
                oFacLocOption              = oFacBrowseLocation({
                    'tReturnInputCode'          : 'oetFacLocCode',
                    'tReturnInputName'          : 'oetFacLocName',
                    'tNextFuncName'             : '',
                    'aArgReturn'                : ['FTLocCode','FTLocName'] 
                });
                JCNxBrowseData('oFacLocOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        var oFacBrowseLocation = function(poReturnInput){
            let tInputReturnCode    = poReturnInput.tReturnInputCode;
            let tInputReturnhName   = poReturnInput.tReturnInputName;
            let tNextFunc           = poReturnInput.tNextFuncName;
            let aArgReturn          = poReturnInput.aArgReturn;

            let tWhereCondiotion    = "";

            let tBchCode = $('#oetFacBchCode').val();
            let tAgnCode = $('#oetFacAgnCode').val();

            if(tBchCode){
                tWhereCondiotion += " AND TTKMBchLocation.FTBchCode = '"+tBchCode+"' OR ISNULL(TTKMBchLocation.FTBchCode,'') = ''";
            }
            if(tAgnCode){
                tWhereCondiotion += " AND TTKMBchLocation.FTAgnCode = '"+tAgnCode+"' OR ISNULL(TTKMBchLocation.FTAgnCode,'') = '' ";
            }

            let oLocationOptionReturn = {
                Title : ['ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocTitle'],
                Table :{Master:'TTKMBchLocation',PK:'FTLocCode'},
                Join :{
                    Table       : ['TTKMBchLocation_L'], //,'TCNMMerchant_L'
                    On          : [
                        'TTKMBchLocation.FTLocCode = TTKMBchLocation_L.FTLocCode AND TTKMBchLocation_L.FNLngID = ' + nLangEdits
                    ]
                },
                Where:{
                    Condition: [ tWhereCondiotion ]
                },
                GrideView:{
                    ColumnPathLang	: 'ticketnew/ticketbchloc/ticketbchloc',
                    ColumnKeyLang	: ['tTCKBchLocCode','tTCKBchLocName'],
                    ColumnsSize     : ['10%','75%'],
                    DataColumns	    : ['TTKMBchLocation.FTLocCode','TTKMBchLocation_L.FTLocName'], //,'TCNMBranch.FTMerCode','TCNMMerchant_L.FTMerName'
                    DataColumnsFormat : ['',''],
                    WidthModal      : 50,
                    Perpage			: 10,
                    OrderBy			: ['TTKMBchLocation.FTLocCode DESC'],
                },
                NextFunc : {
                    FuncName  : tNextFunc,
                    ArgReturn : aArgReturn
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: [tInputReturnCode,"TTKMBchLocation.FTLocCode"],
                    Text		: [tInputReturnhName,"TTKMBchLocation_L.FTLocName"]
                },
            };
            return oLocationOptionReturn;
        }


        // Create By Napat 19/05/2020
        $('#obtFacBrowseZne').off('click');
        $('#obtFacBrowseZne').on('click',function(){
            var nStaSession  = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oFacZneOption       = undefined;
                oFacZneOption              = oFacBrowseLocZne({
                    'tReturnInputCode'          : 'oetFacZneCode',
                    'tReturnInputName'          : 'oetFacZneName',
                    'tNextFuncName'             : '',
                    'aArgReturn'                : ['FTZneCode','FTZneName'] 
                });
                JCNxBrowseData('oFacZneOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        var oFacBrowseLocZne = function(poReturnInput){
            let tInputReturnCode    = poReturnInput.tReturnInputCode;
            let tInputReturnhName   = poReturnInput.tReturnInputName;
            let tNextFunc           = poReturnInput.tNextFuncName;
            let aArgReturn          = poReturnInput.aArgReturn;

            let tWhereCondiotion    = "";

            let tBchCode = $('#oetFacBchCode').val();
            let tAgnCode = $('#oetFacAgnCode').val();

            if(tBchCode){
                tWhereCondiotion += " AND TTKMLocZne.FTBchCode = '"+tBchCode+"' OR ISNULL(TTKMLocZne.FTBchCode,'') = ''";
            }
            if(tAgnCode){
                tWhereCondiotion += " AND TTKMLocZne.FTAgnCode = '"+tAgnCode+"' OR ISNULL(TTKMLocZne.FTAgnCode,'') = '' ";
            }
            let oZneOptionReturn = {
                Title : ['ticketnew/ticketloczone/ticketloczone','tTCKLocZoneTitle'],
                Table :{
                    Master:'TTKMLocZne',
                    PK:'FTZneCode'
                },
                Join :{
                    Table       : ['TTKMLocZne_L'], //,'TCNMMerchant_L'
                    On          : [
                        'TTKMLocZne.FTZneCode = TTKMLocZne_L.FTZneCode AND TTKMLocZne_L.FNLngID = ' + nLangEdits
                    ]
                },
                Where:{
                    Condition: [ tWhereCondiotion ]
                },
                GrideView:{
                    ColumnPathLang	: 'ticketnew/ticketloczone/ticketloczone',
                    ColumnKeyLang	: ['tTCKLocZoneCode','tTCKLocZoneName'],
                    ColumnsSize     : ['10%','75%'],
                    DataColumns	    : ['TTKMLocZne.FTZneCode','TTKMLocZne_L.FTZneName'], //,'TCNMBranch.FTMerCode','TCNMMerchant_L.FTMerName'
                    DataColumnsFormat : ['',''],
                    WidthModal      : 50,
                    Perpage			: 10,
                    OrderBy			: ['TTKMLocZne.FTZneCode DESC'],
                },
                NextFunc : {
                    FuncName  : tNextFunc,
                    ArgReturn : aArgReturn
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: [tInputReturnCode,"TTKMLocZne.FTZneCode"],
                    Text		: [tInputReturnhName,"TTKMLocZne_L.FTZneName"]
                },
            };
            return oZneOptionReturn;
        }

        // Create By Napat 19/05/2020
        $('#obtFacBrowseRef').off('click');
        $('#obtFacBrowseRef').on('click',function(){
            var nStaSession  = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oFacRefOption       = undefined;
                oFacRefOption              = oFacBrowseFacRef({
                    'tReturnInputCode'          : 'oetFacRefCode',
                    'tReturnInputName'          : 'oetFacRefName',
                    'tNextFuncName'             : '',
                    'aArgReturn'                : ['FTFacCode','FTFacName'] 
                });
                JCNxBrowseData('oFacRefOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        var oFacBrowseFacRef = function(poReturnInput){
            let tInputReturnCode    = poReturnInput.tReturnInputCode;
            let tInputReturnhName   = poReturnInput.tReturnInputName;
            let tNextFunc           = poReturnInput.tNextFuncName;
            let aArgReturn          = poReturnInput.aArgReturn;
            let tWhereCondiotion    = "";
            let tFacCode = $('#oetFacCode').val();
            let tBchCode = $('#oetFacBchCode').val();
            let tAgnCode = $('#oetFacAgnCode').val();

            if(tFacCode){
                tWhereCondiotion += " AND TTKMLocFacility.FTFacCode <> '"+tFacCode+"'";
            }
            if(tBchCode){
                tWhereCondiotion += " AND TTKMLocFacility.FTBchCode = '"+tBchCode+"' OR ISNULL(TTKMLocFacility.FTBchCode,'') = ''";
            }
            if(tAgnCode){
                tWhereCondiotion += " AND TTKMLocFacility.FTAgnCode = '"+tAgnCode+"' OR ISNULL(TTKMLocFacility.FTAgnCode,'') = '' ";
            }
            let oFacRefOptionReturn = {
                Title : ['ticketnew/ticketlocfac/ticketlocfac','tFACTitle'],
                Table :{
                    Master:'TTKMLocFacility',
                    PK:'FTFacCode'
                },
                Join :{
                    Table       : ['TTKMLocFacility_L'], //,'TCNMMerchant_L'
                    On          : [
                        'TTKMLocFacility.FTFacCode = TTKMLocFacility_L.FTFacCode AND TTKMLocFacility_L.FNLngID = ' + nLangEdits
                    ]
                },
                Where:{
                    Condition: [ tWhereCondiotion ]
                },
                GrideView:{
                    ColumnPathLang	: 'ticketnew/ticketlocfac/ticketlocfac',
                    ColumnKeyLang	: ['tFACCode','tFACName'],
                    ColumnsSize     : ['10%','75%'],
                    DataColumns	    : ['TTKMLocFacility.FTFacCode','TTKMLocFacility_L.FTFacName'], //,'TCNMBranch.FTMerCode','TCNMMerchant_L.FTMerName'
                    DataColumnsFormat : ['',''],
                    WidthModal      : 50,
                    Perpage			: 10,
                    OrderBy			: ['TTKMLocFacility.FTFacCode DESC'],
                },
                NextFunc : {
                    FuncName  : tNextFunc,
                    ArgReturn : aArgReturn
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: [tInputReturnCode,"TTKMLocFacility.FTFacCode"],
                    Text		: [tInputReturnhName,"TTKMLocFacility_L.FTFacName"]
                },
            };
            return oFacRefOptionReturn;
        }
</script>