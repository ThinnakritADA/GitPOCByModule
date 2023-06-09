<script type="text/javascript">
    var nLangEdits      = <?= $this->session->userdata("tLangEdit")?>;
    var tAgnCodeSession = "<?= $this->session->userdata("tSesUsrAgnCode"); ?>";
    var tAgnNameSession = "<?= $this->session->userdata("tSesUsrAgnName"); ?>";
    var tUsrLevSession  = "<?= $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti   = "<?= $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var tSesUserCode    = "<?= $this->session->userdata("tSesUserCode"); ?>";
    var nCountBch       = "<?= $this->session->userdata("nSesUsrBchCount"); ?>";

    $(document).ready(function(){

        // Event Click Tab
        $('#odvTCKBchLocPanelBody .xCNBCHTab').off().on('click', function(){
            let tRoutePage  = '<?= $tRoute;?>';
            if(tRoutePage == 'masTCKBchLocEventAdd'){
                return;
            } else {
                let tTypeTab    = $(this).data('typetab');
                if(typeof(tTypeTab) !== undefined && tTypeTab == 'main'){
                    // *** Click Tab ข้อมูลทั่วไป
                    JCNxOpenLoading();
                    setTimeout(function(){
                        $('#odvTCKBchLocBtnEditInfo').show();
                        JCNxCloseLoading();
                        return;
                    }, 500);
                } else if (typeof(tTypeTab) !== undefined && tTypeTab == 'sub'){
                    // *** Click Tab อื่น ๆ
                    $('#odvTCKBchLocBtnEditInfo').hide();
                    let tTabTitle   = $(this).data('tabtitle');
                    if(tTabTitle != 'bchlocinfo'){
                        JSvCallTCKBchLocContentTab(tTabTitle);
                    } else {
                        return;
                    }
                }else{
                    return;
                }
            }
        });

        if(JSbTCKBchLocIsCreatePage()){
            $('#oetTCKBchLocCode').attr("disabled", true);
            $('#ocbTCKBchLocAutoGenCode').change(function(){
                if($('#ocbTCKBchLocAutoGenCode').is(':checked')) {
                    $('#oetTCKBchLocCode').val('');
                    $('#oetTCKBchLocCode').attr("disabled", true);
                    $('#odvTCKBchLocCodeForm').removeClass('has-error');
                    $('#odvTCKBchLocCodeForm em').remove();
                }else{
                    $("#oetTCKBchLocCode").attr("disabled", false);
                }
            });
            JSxTCKBchLocVisibleComponent('#ocbTCKBchLocAutoGenCode', true);
        }

        if(tUsrLevSession == 'BCH' || tUsrLevSession == 'SHP'){
            $('#obtTCKBchLocBrowseAgn').attr("disabled", true);
        }

        if(tUsrLevSession != "AGN" && tUsrLevSession != "HQ" ){
            if(nCountBch < 2 ){
                $('#obtTCKBchLocBrowseBch').attr("disabled", true);
            }
        }

        // Count Ref Location
        let nCountZne = "<?= $nCountZne;?>";
        let nCountFac = "<?= $nCountFac;?>";
        if (nCountZne > 0 || nCountFac > 0){
            $("#obtTCKBchLocBrowseAgn").attr("disabled", true);
            $("#obtTCKBchLocBrowseBch").attr("disabled", true);
        }

        // Check box
        let tLocStaAlwPet = "<?= $tLocStaAlwPet;?>"
        if (tLocStaAlwPet == 1){
            $('#ocbTCKBchLocStaAlwPet').prop("checked",true);
        } else {
            $('#ocbTCKBchLocStaAlwPet').prop("checked",false);
        }

        let tLocStaAlwBook = "<?= $tLocStaAlwBook;?>"
        if (tLocStaAlwBook == 1){
            $('#ocbTCKBchLocStaAlwBook').prop("checked",true);
        } else {
            $('#ocbTCKBchLocStaAlwBook').prop("checked",false);
        }

        let tLocStaUse = "<?= $tLocStaUse;?>"
        if (tLocStaUse == 1){
            $('#ocbTCKBchLocStaUse').prop("checked",true);
        } else {
            $('#ocbTCKBchLocStaUse').prop("checked",false);
        }

    });

    $('#oetTCKBchLocCode').blur(function(){
        JSxTCKBchLocCheckCodeDupInDB();
    });

    // Functionality : Check Code Duplicate
    // Parameters : -
    // Creater : 21/04/2023 Papitchaya
    // Last Update: -
    // Return : -
    function JSxTCKBchLocCheckCodeDupInDB(){
        if(!$('#ocbTCKBchLocAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TTKMBchLocation",
                    tFieldName: "FTLocCode",
                    tCode: $("#oetTCKBchLocCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    let aResult = JSON.parse(tResult);
                    $("#ohdTCKBchLocCheckDuplicateCode").val(aResult["rtCode"]);
                    // Set Validate Dublicate Code
                    $.validator.addMethod('dublicateCode', function(value, element) {
                        if($("#ohdTCKBchLocCheckDuplicateCode").val() == 1){
                            return false;
                        }else{
                            return true;
                        }
                    },'');
                    // From Summit Validate
                    $('#ofmTCKBchLocAddLoc').validate({
                        rules: {
                            oetTCKBchLocCode : {
                                "required" :{
                                    // ตรวจสอบเงื่อนไข validate
                                    depends: function(oElement) {
                                    if($('#ocbTCKBchLocAutoGenCode').is(':checked')){
                                        return false;
                                    }else{
                                        return true;
                                    }
                                    }
                                },
                                "dublicateCode" :{}
                            },
                            oetTCKBchLocName: { "required": {} },
                        },
                        messages: {
                            oetTCKBchLocCode: {
                                "required"      : $('#oetTCKBchLocCode').attr('data-validate-required'),
                                "dublicateCode" : $('#oetTCKBchLocCode').attr('data-validate-dublicateCode')
                            },
                            oetTCKBchLocName: {
                                "required"      : $('#oetTCKBchLocName').attr('data-validate-required'),
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
                    $('#ofmTCKBchLocAddLoc').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

    // Functionality : Call Tab Sub
    // Parameters : -
    // Creater : 21/04/2023 Papitchaya
    // Last Update: 29/05/2023 Papitchaya
    // Return : View
    function JSvCallTCKBchLocContentTab(ptTabtitle){
        let tAgnCode = '<?= $tAgnCode; ?>';
        let tBchCode = '<?= $tBchCode; ?>';
        let tLocCode = '<?= $tLocCode; ?>';
        let tRoute   = '';
        let tDivData = '';
        
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            if(ptTabtitle == 'bchloczone'){
                tRoute   = 'masTCKBchLocZoneData';
                tDivData = '#odvTCKBchLocDataZone';
            } else if (ptTabtitle == 'bchlocpdt'){
                tRoute   = 'masTCKBchLocPdtData';
                tDivData = '#odvTCKBchLocDataPdt';
            } else if (ptTabtitle == 'bchlocfac'){
                tRoute   = 'masTCKBchLocFacData';
                tDivData = '#odvTCKBchLocDataFac';
            } else if (ptTabtitle == 'bchlocaddress'){
                tRoute   = 'masTCKBchLocAddrData';
                tDivData = '#odvTCKBchLocDataAddress';
            }

            JCNxOpenLoading();
            $.ajax({
                type : "POST",
                url : tRoute,
                data : {
                    'ptAgnCode'	: tAgnCode,
                    'ptBchCode'	: tBchCode,
                    'ptLocCode'	: tLocCode,
                },
                success	: function(oResult){
                    $(tDivData).html(oResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    $('#obtTCKBchLocBrowseAgn').off().on('click',function(){
        let nStaSession  = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKBchLocAgnOption       = undefined;
            oTCKBchLocAgnOption              = oTCKBchLocBrwAgn({
                'tReturnInputCode'          : 'ohdTCKBchLocAgnCode',
                'tReturnInputName'          : 'oetTCKBchLocAgnName',
                'tNextFuncName'             : 'JSxTCKBchLocNextFuncBrwAgn',
                'aArgReturn'                : ['FTAgnCode','FTAgnName']
            });
            JCNxBrowseData('oTCKBchLocAgnOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oTCKBchLocBrwAgn = function(poReturnInputAgency){
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

    function JSxTCKBchLocNextFuncBrwAgn(poDataNextFunc){
        console.log('LOG >>> choose agency');
        // Clear Input Browse Branch
        $('#ohdTCKBchLocBchCode').val('');
        $('#oetTCKBchLocBchName').val('');
    }

    $('#obtTCKBchLocBrowseBch').off().on('click', function(){
        let nStaSession  = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKBchLocBchOption       =  undefined;
            oTCKBchLocBchOption              = oTCKBchLocBrwBch({
                'tReturnInputBranchCode'    : 'ohdTCKBchLocBchCode',
                'tReturnInputBranchName'    : 'oetTCKBchLocBchName',
            });
            JCNxBrowseData('oTCKBchLocBchOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    
    // Option Browse Branch
    var oTCKBchLocBrwBch = function(poReturnInputBranch){
        let tInputReturnBranchCode   = poReturnInputBranch.tReturnInputBranchCode;
        let tInputReturnBranchName   = poReturnInputBranch.tReturnInputBranchName;

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
                Selector    : 'ohdTCKBchLocAgnCode',
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
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnBranchCode,"TCNMBranch.FTBchCode"],
                Text		: [tInputReturnBranchName,"TCNMBranch_L.FTBchName"]
            },
            // DebugSQL:true,
        };
        return oBranchOptionReturn;
    }
</script>