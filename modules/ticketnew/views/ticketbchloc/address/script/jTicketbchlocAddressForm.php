<script type="text/javascript">

    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

    $(document).ready(function(){
        $('.selectpicker').selectpicker('refresh');

        // Map
        let oDataMap   = {
            'tMapLongitude' : <?= (isset($tFTAddLongitude)&&!empty($tFTAddLongitude))? floatval($tFTAddLongitude) : floatval('100.50182294100522')?>,
            'tMapLatitude'  : <?= (isset($tFTAddLatitude)&&!empty($tFTAddLatitude))? floatval($tFTAddLatitude):floatval('13.757309968845291')?>,
        };
        JSxTCKBchLocAddressSetMapToShow(oDataMap);

    });
    // Event Browse Province
    $('#obtBchLocAddrBrowseProvince').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKBchLocAddressProvinceOption = oTCKBchLocAddressProvince({
                'tReturnInputCode'  : 'oetBchLocAddrPvnCode',
                'tReturnInputName'  : 'oetBchLocAddrPvnName',
                'tNextFuncName'     : 'JCNxTCKBchLocAddressSetMapProvince',
                'aArgReturn'        : ['FTPvnCode','FTPvnName','FTPvnLatitude','FTPvnLongitude']
            });
            JCNxBrowseData('oTCKBchLocAddressProvinceOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse District
    $('#obtBchLocAddrBrowseDistrict').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKBchLocAddressDistrictOption = oTCKBchLocAddressDistrict({
                'tReturnInputCode'  : 'oetBchLocAddrDstCode',
                'tReturnInputName'  : 'oetBchLocAddrDstName',
                'tNextFuncName'     : 'JCNxTCKBchLocAddressSetMapDistrict',
                'aArgReturn'        : ['FTDstCode','FTDstName','FTDstLatitude','FTDstLongitude']
            })
            JCNxBrowseData('oTCKBchLocAddressDistrictOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Sub-District
    $('#obtBchLocAddrBrowseSubDistrict').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKBchLocAddressSubDistrictOption  = oTCKBchLocAddressSubDistrict({
                'tReturnInputCode'  : 'oetBchLocAddrSubDstCode',
                'tReturnInputName'  : 'oetBchLocAddrSubDstName',
                'tNextFuncName'     : 'JCNxTCKBchLocAddressSetMapSubDistrict',
                'aArgReturn'        : ['FTSudCode','FTSudName','FTSudLatitude','FTSudLongitude']
            });
            JCNxBrowseData('oTCKBchLocAddressSubDistrictOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    

    // Browse จังหวัด
    var oTCKBchLocAddressProvince = function(poDataFnc){
        let tInputReturnCode    = poDataFnc.tReturnInputCode;
        let tInputReturnName    = poDataFnc.tReturnInputName;
        let tNextFuncName       = poDataFnc.tNextFuncName;
        let aArgReturn          = poDataFnc.aArgReturn;
        let oOptionReturn       = {
            Title : ['address/province/province','tPVNTitle'],
            Table:{Master:'TCNMProvince', PK:'FTPvnCode'},
            Join :{
                Table:	['TCNMProvince_L'],
                On:['TCNMProvince_L.FTPvnCode = TCNMProvince.FTPvnCode AND TCNMProvince_L.FNLngID = '+nLangEdits,]
            },
            GrideView:{
                ColumnPathLang	    : 'address/province/province',
                ColumnKeyLang	    : ['tPVNCode','tPVNName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMProvince.FTPvnCode','TCNMProvince_L.FTPvnName','TCNMProvince.FTPvnLatitude','TCNMProvince.FTPvnLongitude'],
                DataColumnsFormat   : ['','','',''],
                DisabledColumns     : [2,3],
                Perpage			    : 10,
                OrderBy			    : ['TCNMProvince.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMProvince.FTPvnCode"],
                Text		: [tInputReturnName,"TCNMProvince_L.FTPvnName"],
            },
            NextFunc:{
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            RouteAddNew : 'province',
            BrowseLev : nTCKBchLocBrowseType
        };
        return oOptionReturn;
    };

    // Browse อำเภอ
    var oTCKBchLocAddressDistrict = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tNextFuncName       = poDataFnc.tNextFuncName;
        var aArgReturn          = poDataFnc.aArgReturn;
        var oOptionReturn       = {
            Title   : ['address/district/district','tDSTTitle'],
            Table   : {Master:'TCNMDistrict', PK:'FTDstCode'},
            Join    : {
                Table:	['TCNMDistrict_L'],
                On:['TCNMDistrict_L.FTDstCode = TCNMDistrict.FTDstCode AND TCNMDistrict_L.FNLngID = '+nLangEdits]
            },
            Filter:{
                Selector    : 'oetBchLocAddrPvnCode',
                Table       : 'TCNMDistrict',
                Key         : 'FTPvnCode'
            },
            GrideView:{
                ColumnPathLang	    : 'address/district/district',
                ColumnKeyLang	    : ['tDSTTBCode','tDSTTBName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMDistrict.FTDstCode','TCNMDistrict_L.FTDstName','TCNMDistrict.FTDstLatitude','TCNMDistrict.FTDstLongitude'],
                DataColumnsFormat   : ['','','',''],
                DisabledColumns     : [2,3],
                Perpage			    : 10,
                OrderBy			    : ['TCNMDistrict.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMDistrict.FTDstCode"],
                Text		: [tInputReturnName,"TCNMDistrict_L.FTDstName"],
            },
            NextFunc:{
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            RouteAddNew : 'district',
            BrowseLev : nTCKBchLocBrowseType
        };
        return oOptionReturn;
    };

    // Browse ตำบล
    var oTCKBchLocAddressSubDistrict = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tNextFuncName       = poDataFnc.tNextFuncName;
        var aArgReturn          = poDataFnc.aArgReturn;
        var oOptionReturn       = {
            Title   : ['address/subdistrict/subdistrict','tSDTTitle'],
            Table   : {Master:'TCNMSubDistrict', PK:'FTSudCode'},
            Join    : {
                Table:	['TCNMSubDistrict_L'],
                On:['TCNMSubDistrict_L.FTSudCode = TCNMSubDistrict.FTSudCode AND TCNMSubDistrict_L.FNLngID = '+nLangEdits]
            },
            Filter:{
                Selector    : 'oetBchLocAddrDstCode',
                Table       : 'TCNMSubDistrict',
                Key         : 'FTDstCode'
            },
            GrideView:{
                ColumnPathLang	    : 'address/subdistrict/subdistrict',
                ColumnKeyLang	    : ['tSDTTBCode','tSDTTBSubdistrict'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMSubDistrict.FTSudCode','TCNMSubDistrict_L.FTSudName','TCNMSubDistrict.FTSudLatitude','TCNMSubDistrict.FTSudLongitude'],
                DataColumnsFormat   : ['','','',''],
                DisabledColumns     : [2,3],
                Perpage			    : 10,
                OrderBy			    : ['TCNMSubDistrict.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMSubDistrict.FTSudCode"],
                Text		: [tInputReturnName,"TCNMSubDistrict_L.FTSudName"],
            },
            NextFunc:{
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            RouteAddNew : 'subdistrict',
            BrowseLev : nTCKBchLocBrowseType
        };
        return oOptionReturn;
    };

    // Functionality : Set Show Map
    // Parameters : -
    // Creater : 21/04/2023 Papitchaya
    // Last Update: -
    // Return : -
    function JSxTCKBchLocAddressSetMapToShow(poDataMap){
        let tMapLongitude   = poDataMap.tMapLongitude;
        let tMapLatitude    = poDataMap.tMapLatitude;
        let nStatusLoadMap  = 0;
        if(nStatusLoadMap == 0){
            $("#odvBchLocAddrMapView").empty();
            let oMapCompany = {
                tDivShowMap	:'odvBchLocAddrMapView',
                cLongitude	: parseFloat(tMapLongitude),
                cLatitude	: parseFloat(tMapLatitude),
                tInputLong	: 'ohdBchLocAddrMapLong',
                tInputLat	: 'ohdBchLocAddrMapLat',
                tIcon		: '<?php echo base_url().'application/modules/common/assets/images/icons/icon_mark.png';?>',
                tStatus		: '2'	
            }
            JSxMapAddEdit(oMapCompany);
			nStatusLoadMap = 1;
        }
    }

    // Functionality : Set Map Province
    // Parameters : -
    // Creater : 21/04/2023 Papitchaya
    // Last Update: -
    // Return : -
    function JCNxTCKBchLocAddressSetMapProvince(ptDataNextFunc){
        let aDataNextFunc, tPvnCode, tPvnName, tPvnLatitude, tPvnLongitude;
        if(typeof(ptDataNextFunc) != undefined && ptDataNextFunc != "NULL"){
            aDataNextFunc   = JSON.parse(ptDataNextFunc);
            tPvnCode        = aDataNextFunc[0];
            tPvnName        = aDataNextFunc[1];
            tPvnLatitude    = aDataNextFunc[2];
            tPvnLongitude   = aDataNextFunc[3];
            aDataCallMap    = {
                'tMapLatitude'  : parseFloat(tPvnLatitude),
                'tMapLongitude' : parseFloat(tPvnLongitude),
            };
            $('#ohdBchLocAddrMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdBchLocAddrMapLat').val(aDataCallMap.tMapLatitude);
            JSxTCKBchLocAddressSetMapToShow(aDataCallMap);
            // **** Clear Value ****
            $('#oetBchLocAddrDstCode').val('');
            $('#oetBchLocAddrDstName').val('');
            $('#oetBchLocAddrSubDstCode').val('');
            $('#oetBchLocAddrSubDstName').val('');
        }else{
            // **** Clear Value ****
            $('#oetBchLocAddrDstCode').val('');
            $('#oetBchLocAddrDstName').val('');
            $('#oetBchLocAddrSubDstCode').val('');
            $('#oetBchLocAddrSubDstName').val('');
            $('#ohdBchLocAddrMapLong').val('');
            $('#ohdBchLocAddrMapLat').val('');
        }
    }

    // Functionality : Set Map District
    // Parameters : -
    // Creater : 21/04/2023 Papitchaya
    // Last Update: -
    // Return : -
    function JCNxTCKBchLocAddressSetMapDistrict(ptDataNextFunc){
        let aDataNextFunc,tDstCode,tDstName,tDstLatitude,tDstLongitude;
        if(typeof(ptDataNextFunc) != undefined && ptDataNextFunc != "NULL"){
            aDataNextFunc   = JSON.parse(ptDataNextFunc);
            tDstCode        = aDataNextFunc[0];
            tDstName        = aDataNextFunc[1];
            tDstLatitude    = aDataNextFunc[2];
            tDstLongitude   = aDataNextFunc[3];
            aDataCallMap    = {
                'tMapLatitude'  : parseFloat(tDstLatitude),
                'tMapLongitude' : parseFloat(tDstLongitude),
            };
            $('#ohdBchLocAddrMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdBchLocAddrMapLat').val(aDataCallMap.tMapLatitude);
            JSxTCKBchLocAddressSetMapToShow(aDataCallMap);
            // **** Clear Value ****
            $('#oetBchLocAddrSubDstCode').val('');
            $('#oetBchLocAddrSubDstName').val('');
        }else{
            // **** Clear Value ****
            $('#oetBchLocAddrSubDstCode').val('');
            $('#oetBchLocAddrSubDstName').val('');
            $('#ohdBchLocAddrMapLong').val('');
            $('#ohdBchLocAddrMapLat').val('');
        }
    }

    // Functionality : Set Map Sub District
    // Parameters : -
    // Creater : 21/04/2023 Papitchaya
    // Last Update: -
    // Return : -
    function JCNxTCKBchLocAddressSetMapSubDistrict(ptDataNextFunc){
        let aDataNextFunc,tSubDstCode,tSubDstName,tSubDstLatitude,tSubDstLongitude;
        if(typeof(ptDataNextFunc) != undefined && ptDataNextFunc != "NULL"){
            aDataNextFunc       = JSON.parse(ptDataNextFunc);
            tSubDstCode         = aDataNextFunc[0];
            tSubDstName         = aDataNextFunc[1];
            tSubDstLatitude     = aDataNextFunc[2];
            tSubDstLongitude    = aDataNextFunc[3];
            aDataCallMap    = {
                'tMapLatitude'  : parseFloat(tSubDstLatitude),
                'tMapLongitude' : parseFloat(tSubDstLongitude),
            };
            $('#ohdBchLocAddrMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdBchLocAddrMapLat').val(aDataCallMap.tMapLatitude);
            JSxTCKBchLocAddressSetMapToShow(aDataCallMap);
        }else{
            // **** Clear Value ****
            $('#ohdBchLocAddrMapLong').val('');
            $('#ohdBchLocAddrMapLat').val('');
        }
    }
</script>