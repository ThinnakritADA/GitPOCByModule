<script type="text/javascript">
    $(document).ready(function(){
        $('.selectpicker').selectpicker();
    });

    // Function: Browse produce
    // Parameters:  -
    // Creator:	07/06/2023 Papitchaya
    // Return: View
    // Return -
    function JSvPdtPkgBrowsePdt(pnKey){
        let nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            let tWhereCondition = "";
            $.ajax({
                type: "POST",
                url: "BrowseDataPDT",
                data: {
                    Qualitysearch: [],
                    PriceType: ["Cost", "tCN_Cost", "Company", "2"],
                    VatInOrEx : '',
                    VatRacte : '',
                    SelectTier: ["Barcode"],
                    ShowCountRecord: 10,
                    NextFunc: "JSvPdtPkgNextFuncAddPdt",
                    ReturnType: "M",
                    SPL: ['', ''],
                    BCH: ['', ''],
                    MCH: ['', ''],
                    SHP: ['', ''],
                    Where: [tWhereCondition]
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $("#odvModalDOCPDT").modal({ backdrop: "static", keyboard: false });
                    $("#odvModalDOCPDT").modal({ show: true });
                    //remove localstorage
                    localStorage.removeItem("LocalItemDataPDT");
                    $("#odvModalsectionBodyPDT").html(tResult);
                    $("#odvModalDOCPDT #oliBrowsePDTSupply").css('display', 'none');

                    $("#ohdPkgGrpAddKey").val(pnKey);
                    $("#ohdPkgTypeNew"+ pnKey).val('1');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    // Function: Browse BchLocation
    // Parameters:  -
    // Creator:	07/06/2023 Papitchaya
    // Return: View
    // Return -
    $("#obtPdtPkgBrowseLoc").off().on('click', function(){
        JSxCheckPinMenuClose();
        window.oPdtPkgLocOption = undefined;
        oPdtPkgLocOption        = oPdtPkgBrwLoc({
            'tReturnInputCode'  : 'ohdPdtPkgLocCode',
            'tReturnInputName'  : 'oetPdtPkgLocName',
            'tNextFuncName'     : 'JSvPdtPkgNextFuncLocZne',
            'aArgReturn'        : ['FTLocCode','FTLocName']
        });
        JCNxBrowseData('oPdtPkgLocOption');
    });

    var oPdtPkgBrwLoc = function(poReturnInputLoc){
        let tInputReturnLocCode = poReturnInputLoc.tReturnInputCode;
        let tInputReturnAgnName = poReturnInputLoc.tReturnInputName;
        let tPdtPkgLocNextFunc  = poReturnInputLoc.tNextFuncName;
        let aPdtPkgLocArgReturn = poReturnInputLoc.aArgReturn;

        let oLocOptionReturn = {
            Title : ['product/product/product','tPDTPkdBrwLocTitle'],
            Table :{Master:'TTKMBchLocation', PK:'FTLocCode'},
            Join :{
                Table   : ['TTKMBchLocation_L'],
                On      : [' TTKMBchLocation.FTLocCode = TTKMBchLocation_L.FTLocCode AND TTKMBchLocation_L.FNLngID = ' + nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'ticketnew/ticketbchloc/ticketbchloc',
                ColumnKeyLang	: ['tTCKBchLocCode','tTCKBchLocName'],
                ColumnsSize     : ['10%','75%'],
                DataColumns	    : ['TTKMBchLocation.FTLocCode','TTKMBchLocation_L.FTLocName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TTKMBchLocation.FTLocCode DESC'],
            },
            NextFunc : {
                FuncName  : tPdtPkgLocNextFunc,
                ArgReturn : aPdtPkgLocArgReturn
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnLocCode,"TTKMBchLocation.FTLocCode"],
                Text		: [tInputReturnAgnName,"TTKMBchLocation_L.FTLocName"]
            },
            // DebugSQL: true,
        };

        return oLocOptionReturn;
    }

    // Function: Browse Zone
    // Parameters:  -
    // Creator:	07/06/2023 Papitchaya
    // Return: View
    // Return -
    $("#obtPdtPkgBrowseZne").off().on('click', function(){
        JSxCheckPinMenuClose();
        window.oPdtPkgZneOption = undefined;
        oPdtPkgZneOption        = oPdtPkgBrwZne({
            'tReturnInputCode'  : 'ohdPdtPkgZneCode',
            'tReturnInputName'  : 'oetPdtPkgZneName',
        });
        JCNxBrowseData('oPdtPkgZneOption');
    });

    var oPdtPkgBrwZne = function(poReturnInputZne){
        let tInputReturnZneCode = poReturnInputZne.tReturnInputCode;
        let tInputReturnAgnName = poReturnInputZne.tReturnInputName;

        let oZneOptionReturn = {
            Title : ['product/product/product','tPDTPkdBrwZneTitle'],
            Table :{Master:'TTKMLocZne', PK:'FTZneCode'},
            Join :{
                Table   : ['TTKMLocZne_L'],
                On      : [' TTKMLocZne.FTZneCode = TTKMLocZne_L.FTZneCode AND TTKMLocZne_L.FNLngID = ' + nLangEdits]
            },
            Filter:{
                Selector    : 'ohdPdtPkgLocCode',
                Table       : 'TTKMLocZne',
                Key         : 'FTLocCode'
            },
            GrideView:{
                ColumnPathLang	: 'ticketnew/ticketloczone/ticketloczone',
                ColumnKeyLang	: ['tTCKLocZoneCode','tTCKLocZoneName',''],
                ColumnsSize     : ['10%','75%'],
                DataColumns	    : ['TTKMLocZne.FTZneCode','TTKMLocZne_L.FTZneName','TTKMLocZne.FTZneChain'],
                DisabledColumns : [2],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TTKMLocZne.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnZneCode,"TTKMLocZne.FTZneCode"],
                Text		: [tInputReturnAgnName,"TTKMLocZne_L.FTZneName"]
            },
        };

        return oZneOptionReturn;
    }

    function JSvPdtPkgNextFuncLocZne(){
        // Clear Input Browse Zone
        $("#ohdPdtPkgZneCode").val('');
        $("#oetPdtPkgZneName").val('');
    }
</script>