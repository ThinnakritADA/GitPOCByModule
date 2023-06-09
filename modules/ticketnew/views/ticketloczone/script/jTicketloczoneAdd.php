<script type="text/javascript">
    var nLangEdits      = <?= $this->session->userdata("tLangEdit")?>;
    var tAgnCodeSession = "<?= $this->session->userdata("tSesUsrAgnCode"); ?>";
    var tAgnNameSession = "<?= $this->session->userdata("tSesUsrAgnName"); ?>";
    var tUsrLevSession  = "<?= $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti   = "<?= $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch       = "<?= $this->session->userdata("nSesUsrBchCount"); ?>";

    $(document).ready(function(){
        // Event Click Tab
        $('#odvTCKLocZonePanelBody .xCNBCHTab').off().on('click', function(){
            let tRoutePage  = '<?= $tRoute;?>';
            if(tRoutePage == 'masTCKLocZoneEventAdd'){
                return;
            } else {
                let tTypeTab    = $(this).data('typetab');
                if(typeof(tTypeTab) !== undefined && tTypeTab == 'main'){
                    // *** Click Tab ข้อมูลทั่วไป
                    JCNxOpenLoading();
                    setTimeout(function(){
                        $('#odvTCKLocZoneBtnEditInfo').show();
                        JCNxCloseLoading();
                        return;
                    }, 500);
                } else if (typeof(tTypeTab) !== undefined && tTypeTab == 'sub'){
                    $('#odvTCKLocZoneBtnEditInfo').hide();
                    let tTabTitle   = $(this).data('tabtitle');
                    switch(tTabTitle){
                        case 'loczonepdt':
                            // *** Click Tab สินค้า
                            JSvCallTCKLocZoneContentPdt();
                        break;
                        default:
                            return;
                    }   
                } else {
                    return;
                }
            }
        });

        if(JSbTCKLocZoneIsCreatePage()){
            $('#oetTCKLocZoneCode').attr("disabled", true);
            $('#ocbTCKLocZoneAutoGenCode').change(function(){
                if($('#ocbTCKLocZoneAutoGenCode').is(':checked')) {
                    $('#oetTCKLocZoneCode').val('');
                    $('#oetTCKLocZoneCode').attr("disabled", true);
                    $('#odvTCKLocZoneCodeForm').removeClass('has-error');
                    $('#odvTCKLocZoneCodeForm em').remove();
                } else {
                    $("#oetTCKLocZoneCode").attr("disabled", false);
                }
            });
            JSxTCKLocZoneVisibleComponent('#ocbTCKLocZoneAutoGenCode', true);
        }

        if(tUsrLevSession == 'BCH' || tUsrLevSession == 'SHP'){
            $('#obtTCKLocZoneBrowseAgn').attr("disabled", true);
        }

        if(tUsrLevSession != "AGN" && tUsrLevSession != "HQ" ){
            if(nCountBch < 2 ){
                $('#obtTCKLocZoneBrowseBch').attr("disabled", true);
            }
        }

        // Count Pdt
        let nCountZnePdt = "<?= $nCountZnePdt;?>";
        if (nCountZnePdt > 0){
            $("#obtTCKLocZoneBrowseAgn").attr("disabled", true);
            $("#obtTCKLocZoneBrowseBch").attr("disabled", true);
            $("#obtTCKLocZoneBrowseBchLoc").attr("disabled", true);
        }

        // Check box
        let tZneStaUse = "<?= $tZneStaUse;?>";
        if (tZneStaUse == 1){
            $('#ocbTCKLocZoneStaUse').prop("checked",true);
        } else {
            $('#ocbTCKLocZoneStaUse').prop("checked",false);
        }
    });

    $('#oetTCKLocZoneCode').blur(function(){
        JSxTCKLocZoneCheckCodeDupInDB();
    });

    // Functionality : Check Code Duplicate
    // Parameters : -
    // Creater : 21/04/2023 Papitchaya
    // Last Update: -
    // Return : -
    function JSxTCKLocZoneCheckCodeDupInDB(){
        if(!$('#ocbTCKLocZoneAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TTKMLocZne",
                    tFieldName: "FTZneCode",
                    tCode: $("#oetTCKLocZoneCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    let aResult = JSON.parse(tResult);
                    $("#ohdTCKLocZoneCheckDuplicateCode").val(aResult["rtCode"]);
                    // Set Validate Dublicate Code
                    $.validator.addMethod('dublicateCode', function(value, element) {
                        if($("#ohdTCKLocZoneCheckDuplicateCode").val() == 1){
                            return false;
                        }else{
                            return true;
                        }
                    },'');
                    // From Summit Validate
                    $('#ofmTCKLocZoneAdd').validate({
                        rules: {
                            oetTCKLocZoneCode : {
                                "required" :{
                                    // ตรวจสอบเงื่อนไข validate
                                    depends: function(oElement) {
                                    if($('#ocbTCKLocZoneAutoGenCode').is(':checked')){
                                        return false;
                                    }else{
                                        return true;
                                    }
                                    }
                                },
                                "dublicateCode" :{}
                            },
                            oetTCKLocZoneName: { "required": {} },
                        },
                        messages: {
                            oetTCKLocZoneCode: {
                                "required"      : $('#oetTCKLocZoneCode').attr('data-validate-required'),
                                "dublicateCode" : $('#oetTCKLocZoneCode').attr('data-validate-dublicateCode')
                            },
                            oetTCKLocZoneName: {
                                "required"      : $('#oetTCKLocZoneName').attr('data-validate-required'),
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
                    $('#ofmTCKLocZoneAdd').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

    // Functionality : Call Tab Product
    // Parameters : -
    // Creater : 21/04/2023 Papitchaya
    // Last Update: -
    // Return : View
    function JSvCallTCKLocZoneContentPdt(){
        let tZneChain   = '<?= $tZneChain; ?>';
        let tZneCode    = '<?= $tZneCode; ?>';
        let tBchCode    =  $('#ohdTCKLocZoneBchCode').val();
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            $.ajax({
                type : "POST",
                url : "masTCKLocZonePdtData",
                data : {
                    'ptZneChain' : tZneChain,
                    'ptZneCode'	 : tZneCode,
                    'ptBchCode'  : tBchCode
                },
                success	: function(oResult){
                    $('#odvTCKLocZoneDataPdt').html(oResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }
    
    $('#obtTCKLocZoneBrowseAgn').off().on('click',function(){
        let nStaSession  = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKLocZoneAgnOption     = undefined;
            oTCKLocZoneAgnOption            = oTCKLocZoneBrwAgn({
                'tReturnInputCode'          : 'ohdTCKLocZoneAgnCode',
                'tReturnInputName'          : 'oetTCKLocZoneAgnName',
                'tNextFuncName'             : 'JSxTCKLocZoneNextFuncBrwAgn',
                'aArgReturn'                : ['FTAgnCode','FTAgnName']
            });
            JCNxBrowseData('oTCKLocZoneAgnOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    
    var oTCKLocZoneBrwAgn = function(poReturnInputAgency){
        let tInputReturnAgnCode   = poReturnInputAgency.tReturnInputCode;
        let tInputReturnAgnName   = poReturnInputAgency.tReturnInputName;
        let tAgencyNextFunc       = poReturnInputAgency.tNextFuncName;
        let aAgencyArgReturn      = poReturnInputAgency.aArgReturn;

        let oAgencyOptionReturn = {
            Title : ['authen/user/user','tBrowseAgnTitle'],
            Table :{Master:'TCNMAgency',PK:'FTAgnCode'},
            Join :{
                Table   : ['TCNMAgency_L'],
                On      : [' TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits] //+ tJoinBranch + tJoinShop
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

    function JSxTCKLocZoneNextFuncBrwAgn(poDataNextFunc){
        console.log('LOG >>> choose agency');
        // Clear Input Browse Branch
        $('#ohdTCKLocZoneBchCode').val('');
        $('#oetTCKLocZoneBchName').val('');
        // Clear Input Browse Location
        $('#ohdTCKLocZoneBchLocCode').val('');
        $('#oetTCKLocZoneBchLocName').val('');
    }
    
    $("#obtTCKLocZoneBrowseBch").off().on('click', function(){
        let nStaSession  = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKLocZoneBchOption =  undefined;
            oTCKLocZoneBchOption        = oTCKLocZoneBrwBch({
                'tReturnInputBranchCode'    : 'ohdTCKLocZoneBchCode',
                'tReturnInputBranchName'    : 'oetTCKLocZoneBchName',
                'tNextFuncName'             : 'JSxTCKLocZoneNextFuncBrwBch',
                'aArgReturn'                : ['FTBchCode','FTBchName']
            });
            JCNxBrowseData('oTCKLocZoneBchOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Option Browse Branch
    var oTCKLocZoneBrwBch = function(poReturnInputBranch){
        let tInputReturnBranchCode  = poReturnInputBranch.tReturnInputBranchCode;
        let tInputReturnBranchName  = poReturnInputBranch.tReturnInputBranchName;
        let tBranchNextFunc         = poReturnInputBranch.tNextFuncName;
        let aBranchArgReturn        = poReturnInputBranch.aArgReturn;

        let tWhereCondiotion        = "";

        if( tUsrLevSession != "HQ" ){
            tWhereCondiotion = " AND TCNMBranch.FTBchCode IN (" + tBchCodeMulti + ") ";
        }

        let oBranchOptionReturn      = {
            Title : ['authen/user/user','tBrowseBCHTitle'],
            Table :{Master:'TCNMBranch', PK:'FTBchCode'},
            Join :{
                Table   : ['TCNMBranch_L'],
                On      : ['TCNMBranch.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+ nLangEdits]
                },
            Where:{
                Condition: [ tWhereCondiotion ]
            },
            Filter:{
                Selector    : 'ohdTCKLocZoneAgnCode',
                Table       : 'TCNMBranch',
                Key         : 'FTAgnCode'
            },
            GrideView:{
                ColumnPathLang	: 'authen/user/user',
                ColumnKeyLang	: ['tBrowseBCHCode','tBrowseBCHName'],
                ColumnsSize     : ['10%','75%'],
                DataColumns	    : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat : ['',''],
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
            // DebugSQL:true,
        };
        return oBranchOptionReturn;
    }

    function JSxTCKLocZoneNextFuncBrwBch(poDataNextFunc){
        console.log('LOG >>> choose branch');
        // Clear Input Browse Location
        $('#ohdTCKLocZoneBchLocCode').val('');
        $('#oetTCKLocZoneBchLocName').val('');
    }

    $("#obtTCKLocZoneBrowseBchLoc").off().on('click', function(){
        let nStaSession  = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKLocZoneBchLocOption =  undefined;
            oTCKLocZoneBchLocOption        = oTCKLocZoneBrwBchLoc({
                'tReturnInputBranchLocCode' : 'ohdTCKLocZoneBchLocCode',
                'tReturnInputBranchLocName' : 'oetTCKLocZoneBchLocName'
            });
            JCNxBrowseData('oTCKLocZoneBchLocOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oTCKLocZoneBrwBchLoc = function(poReturnInputBranchLoc){
        let tInputReturnBranchLocCode   = poReturnInputBranchLoc.tReturnInputBranchLocCode;
        let tInputReturnBranchLocName   = poReturnInputBranchLoc.tReturnInputBranchLocName;

        let tWhereCondiotion = "";

        let oBranchLocOptionReturn = {
            Title: ['ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneBrwBchLoc'],
            Table: { Master: 'TTKMBchLocation', PK: 'FTLocCode' },
            Join: {
                Table: ['TTKMBchLocation_L'],
                On: ['TTKMBchLocation_L.FTLocCode = TTKMBchLocation.FTLocCode AND TTKMBchLocation_L.FNLngID = ' + nLangEdits]
            },
            Where:{
                Condition: [ tWhereCondiotion ]
            },
            Filter:{
                Selector    : 'ohdTCKLocZoneBchCode',
                Table       : 'TTKMBchLocation',
                Key         : 'FTBchCode'
            },
            GrideView:{
                ColumnPathLang	: 'ticketnew/ticketloczone/ticketloczone',
                ColumnKeyLang	: ['tTCKLocZoneBrwCode','tTCKLocZoneBrwBchLocN'],
                ColumnsSize     : ['10%','75%'],
                DataColumns	    : ['TTKMBchLocation.FTLocCode', 'TTKMBchLocation_L.FTLocName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TTKMBchLocation.FTLocCode DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnBranchLocCode,"TTKMBchLocation.FTLocCode"],
                Text		: [tInputReturnBranchLocName,"TTKMBchLocation_L.FTLocName"]
            },
            // DebugSQL:true,
        };
        return oBranchLocOptionReturn;
    }

    // Search Level
    $("#obtTCKLocZoneBrowseLev").off().on('click', function(){
        let nStaSession  = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKLocZoneBrowseLevOption =  undefined;
            oTCKLocZoneBrowseLevOption        = oTCKLocZoneBrowseLev({
                'tReturnInputLevCode' : 'ohdTCKLocZoneLevCode',
                'tReturnInputLevName' : 'oetTCKLocZoneLevName'
            });
            JCNxBrowseData('oTCKLocZoneBrowseLevOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oTCKLocZoneBrowseLev = function(poReturnInputLev){
        let tInputReturnLevCode   = poReturnInputLev.tReturnInputLevCode;
        let tInputReturnLevName   = poReturnInputLev.tReturnInputLevName;

        let tWhere = "";

        let oLevOptionReturn = {
            Title: ['ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneBrwLev'],
            Table: { Master: 'TTKMLocLev', PK: 'FTLevCode' },
            Join: {
                Table: ['TTKMLocLev_L'],
                On: ['TTKMLocLev_L.FTLevCode = TTKMLocLev.FTLevCode AND TTKMLocLev_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [ tWhere ]
            },
            GrideView: {
                ColumnPathLang: 'ticketnew/ticketloczone/ticketloczone',
                ColumnKeyLang: ['tTCKLocZoneBrwCode', 'tTCKLocZoneBrwLevN'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TTKMLocLev.FTLevCode', 'TTKMLocLev_L.FTLevName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TTKMLocLev.FTLevCode'],
                SourceOrder: "DESC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnLevCode, "TTKMLocLev.FTLevCode"],
                Text: [tInputReturnLevName, "TTKMLocLev_L.FTLevName"]
            }
        };
        return oLevOptionReturn;
    }

    // Search Gate
    $("#obtTCKLocZoneBrowseGate").off().on('click', function(){
        let nStaSession  = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKLocZoneBrowseGateOption =  undefined;
            oTCKLocZoneBrowseGateOption        = oTCKLocZoneBrowseGate({
                'tReturnInputGateCode' : 'ohdTCKLocZoneGateCode',
                'tReturnInputGateName' : 'oetTCKLocZoneGateName'
            });
            JCNxBrowseData('oTCKLocZoneBrowseGateOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oTCKLocZoneBrowseGate = function(poReturnInputGate){
        let tInputReturnGateCode   = poReturnInputGate.tReturnInputGateCode;
        let tInputReturnGateName   = poReturnInputGate.tReturnInputGateName;

        let tWhere = "";

        let oGateOptionReturn = {
            Title: ['ticketnew/ticketloczone/ticketloczone', 'tTCKLocZoneBrwGate'],
            Table: { Master: 'TTKMLocGate', PK: 'FTGteCode' },
            Join: {
                Table: ['TTKMLocGate_L'],
                On: ['TTKMLocGate_L.FTGteCode = TTKMLocGate.FTGteCode AND TTKMLocGate_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [ tWhere ]
            },
            GrideView: {
                ColumnPathLang: 'ticketnew/ticketloczone/ticketloczone',
                ColumnKeyLang: ['tTCKLocZoneBrwCode', 'tTCKLocZoneBrwGateN'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TTKMLocGate.FTGteCode', 'TTKMLocGate_L.FTGteName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TTKMLocGate.FTGteCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnGateCode, "TTKMLocGate.FTGteCode"],
                Text: [tInputReturnGateName, "TTKMLocGate_L.FTGteName"]
            }
        };
        return oGateOptionReturn;
    }
    
</script>