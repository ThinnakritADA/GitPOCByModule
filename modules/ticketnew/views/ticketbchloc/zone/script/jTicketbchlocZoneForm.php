<script type="text/javascript">
    var nLangEdits  = '<?= $this->session->userdata("tLangEdit");?>';

    $(document).ready(function(){
    });

    // Event Browse Zone
    $('#obtTCKBchLocBrowseZne').off().on('click', function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oTCKBchLocZoneOption = oTCKBchLocZone({
                'tReturnInputCode'  : 'ohdTCKBchLocZneCode',
                'tReturnInputName'  : 'oetTCKBchLocZneName',
                'tNextFuncName'     : 'JSvTCKBchLocZoneNextFunc',
                'aArgReturn'        : ['FTZneCode','FTZneName','FTZneChain']
            });
            JCNxBrowseData('oTCKBchLocZoneOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Browse Zone
    var oTCKBchLocZone = function(poDataFnc){
        let tInputReturnCode    = poDataFnc.tReturnInputCode;
        let tInputReturnName    = poDataFnc.tReturnInputName;
        let tNextFunc           = poDataFnc.tNextFuncName;
        let aArgReturn          = poDataFnc.aArgReturn;

        let tWhere = " AND ISNULL(TTKMLocZne.FTLocCode, '') = '' ";

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
            NextFunc : {
            FuncName  : tNextFunc,
            ArgReturn : aArgReturn
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TTKMLocZne.FTZneCode"],
                Text		: [tInputReturnName,"TTKMLocZne_L.FTZneName"],
            }
        };
        return oOptionReturn;
    };

    function JSvTCKBchLocZoneNextFunc(ptPdtData){
        let aPackData   = JSON.parse(ptPdtData);
        let tZoneChain  = aPackData[2];
        $('#ohdTCKBchLocZneChain').val(tZoneChain);
    }
</script>