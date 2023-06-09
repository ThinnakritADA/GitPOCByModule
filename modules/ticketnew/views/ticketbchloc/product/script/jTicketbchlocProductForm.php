<script type="text/javascript">
    var nLangEdits  = '<?= $this->session->userdata("tLangEdit");?>';

    $(document).ready(function(){
    });
    
    // Event Browse Product
    $('#obtTCKBchLocBrowsePdt').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKBchLocPdtOption = oTCKBchLocPdt({
                'tReturnInputCode'  : 'ohdTCKBchLocPdtCode',
                'tReturnInputName'  : 'oetTCKBchLocPdtName',
            });
            JCNxBrowseData('oTCKBchLocPdtOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Browse Product
    var oTCKBchLocPdt = function(poDataFnc){
        let tInputReturnCode    = poDataFnc.tReturnInputCode;
        let tInputReturnName    = poDataFnc.tReturnInputName;

        let tWhere = "";

        let oOptionReturn       = {
            Title : ['ticketnew/ticketbchloc/ticketbchloc','tTCKBchLocBrowsePdt'],
            Table:{Master:'TCNMPdt', PK:'FTPdtCode'},
            Join :{
                Table:	['TCNMPdt_L'],
                On:['TCNMPdt_L.FTPdtCode = TCNMPdt.FTPdtCode AND TCNMPdt_L.FNLngID = '+ nLangEdits,]
            },
            Where: {
                Condition: [ tWhere ]
            },
            GrideView:{
                ColumnPathLang	    : 'ticketnew/ticketbchloc/ticketbchloc',
                ColumnKeyLang	    : ['tTCKBchLocPdtCode','tTCKBchLocPdtName'],
                ColumnsSize         : ['10%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMPdt.FTPdtCode','TCNMPdt_L.FTPdtName'],
                DataColumnsFormat   : ['',''],
                Perpage			    : 10,
                OrderBy			    : ['TCNMPdt.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMPdt.FTPdtCode"],
                Text		: [tInputReturnName,"TCNMPdt_L.FTPdtName"],
            },
            // DebugSQL: true,
        };
        return oOptionReturn;
    };

    // Event Browse Zone
    $('#obtTCKBchLocBrowsePdtZne').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKBchLocPdtZoneOption = oTCKBchLocPdtZone({
                'tReturnInputCode'  : 'ohdTCKBchLocPdtZneCode',
                'tReturnInputName'  : 'oetTCKBchLocPdtZneName',
            });
            JCNxBrowseData('oTCKBchLocPdtZoneOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Browse Zone
    var oTCKBchLocPdtZone = function(poDataFnc){
        let tInputReturnCode    = poDataFnc.tReturnInputCode;
        let tInputReturnName    = poDataFnc.tReturnInputName;

        let tWhere = " AND ISNULL(TTKMLocZne.FTLocCode, '') = '<?= $tPdtLocCode ?>' ";

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