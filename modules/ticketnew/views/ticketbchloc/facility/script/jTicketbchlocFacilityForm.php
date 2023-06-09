<script type="text/javascript">
    var nLangEdits  = '<?= $this->session->userdata("tLangEdit");?>';

    $(document).ready(function(){
    });

    // Event Browse Facility
    $('#obtTCKBchLocBrowseFac').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKBchLocFacOption = oTCKBchLocFac({
                'tReturnInputCode'  : 'ohdTCKBchLocFacCode',
                'tReturnInputName'  : 'oetTCKBchLocFacName',
            });
            JCNxBrowseData('oTCKBchLocFacOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Browse Facility
    var oTCKBchLocFac = function(poDataFnc){
        let tInputReturnCode    = poDataFnc.tReturnInputCode;
        let tInputReturnName    = poDataFnc.tReturnInputName;

        let tWhere = " AND ISNULL(TTKMLocFacility.FTLocCode, '') = '' ";

        let oOptionReturn       = {
            Title : ['ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocBrowseFac'],
            Table:{Master:'TTKMLocFacility', PK:'FTFacCode'},
            Join :{
                Table:	['TTKMLocFacility_L'],
                On:['TTKMLocFacility_L.FTFacCode = TTKMLocFacility.FTFacCode AND TTKMLocFacility_L.FNLngID = '+ nLangEdits,]
            },
            Where: {
                Condition: [ tWhere ]
            },
            GrideView:{
                ColumnPathLang	    : 'ticketnew/ticketbchloc/ticketbchloc',
                ColumnKeyLang	    : ['tTCKBchLocFacCode','tTCKBchLocFacName'],
                ColumnsSize         : ['10%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TTKMLocFacility.FTFacCode','TTKMLocFacility_L.FTFacName'],
                DataColumnsFormat   : ['',''],
                Perpage			    : 10,
                OrderBy			    : ['TTKMLocFacility.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TTKMLocFacility.FTFacCode"],
                Text		: [tInputReturnName,"TTKMLocFacility_L.FTFacName"],
            },
            // DebugSQL: true,
        };
        return oOptionReturn;
    };
    // Event Browse Zone
    $('#obtTCKBchLocBrowseFacZne').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKBchLocFacZoneOption = oTCKBchLocFacZone({
                'tReturnInputCode'  : 'ohdTCKBchLocFacZneCode',
                'tReturnInputName'  : 'oetTCKBchLocFacZneName',
            });
            JCNxBrowseData('oTCKBchLocFacZoneOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Browse Zone
    var oTCKBchLocFacZone = function(poDataFnc){
        let tInputReturnCode    = poDataFnc.tReturnInputCode;
        let tInputReturnName    = poDataFnc.tReturnInputName;

        let tWhere = " AND ISNULL(TTKMLocZne.FTLocCode, '') = '<?= $tFacLocCode ?>' ";

        let oOptionReturn       = {
            Title : ['ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocBrowseZne'],
            Table:{Master:'TTKMLocZne', PK:'FTZneCode'},
            Join :{
                Table:	['TTKMLocZne_L'],
                On:['TTKMLocZne_L.FTZneCode = TTKMLocZne.FTZneCode AND TTKMLocZne_L.FNLngID = '+ nLangEdits,]
            },
            Where: {
                Condition: [ tWhere ]
            },
            GrideView:{
                ColumnPathLang	    : 'ticketnew/ticketbchloc/ticketbchloc',
                ColumnKeyLang	    : ['tTCKBchLocZoneCode','tTCKBchLocZoneName'],
                ColumnsSize         : ['10%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TTKMLocZne.FTZneCode','TTKMLocZne_L.FTZneName','TTKMLocZne.FTZneChain'],
                DisabledColumns     : [2],
                DataColumnsFormat   : ['',''],
                Perpage			    : 10,
                OrderBy			    : ['TTKMLocZne.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TTKMLocZne.FTZneCode"],
                Text		: [tInputReturnName,"TTKMLocZne_L.FTZneName"],
            },
            // DebugSQL: true,
        };
        return oOptionReturn;
    };

</script>