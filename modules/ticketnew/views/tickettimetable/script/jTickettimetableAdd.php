<script type="text/javascript">
    var nLangEdits      = <?= $this->session->userdata("tLangEdit")?>;
    var tAgnCodeSession = "<?= $this->session->userdata("tSesUsrAgnCode"); ?>";
    var tAgnNameSession = "<?= $this->session->userdata("tSesUsrAgnName"); ?>";
    var tUsrLevSession  = "<?= $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti   = "<?= $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch       = "<?= $this->session->userdata("nSesUsrBchCount"); ?>";

    $(document).ready(function(){
        if(JSbTCKTimeTbIsCreatePage()){
            $('#oetTCKTimeTbCode').attr("disabled", true);
            $('#ocbTCKTimeTbAutoGenCode').change(function(){
                if($('#ocbTCKTimeTbAutoGenCode').is(':checked')) {
                    $('#oetTCKTimeTbCode').val('');
                    $('#oetTCKTimeTbCode').attr("disabled", true);
                    $('#odvTCKTimeTbCodeForm').removeClass('has-error');
                    $('#odvTCKTimeTbCodeForm em').remove();
                } else {
                    $("#oetTCKTimeTbCode").attr("disabled", false);
                }
            });
            JSxTCKTimeTbVisibleComponent('#ocbTCKTimeTbAutoGenCode', true);
        }

        // Check box
        let tTmeStaAct = "<?= $tTmeStaAct;?>";
        if (tTmeStaAct == 1){
            $('#ocbTCKTimeTbStaUse').prop("checked",true);
        } else {
            $('#ocbTCKTimeTbStaUse').prop("checked",false);
        }
    });

    $('#oetTCKTimeTbCode').blur(function(){
        JSxTCKTimeTbCheckCodeDupInDB();
    });

    // Functionality : Check Code Duplicate
    // Parameters : -
    // Creater : 21/04/2023 Papitchaya
    // Last Update: -
    // Return : -
    function JSxTCKTimeTbCheckCodeDupInDB(){
        if(!$('#ocbTCKTimeTbAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TTKMTimeTableHD",
                    tFieldName: "FTTmeCode",
                    tCode: $("#oetTCKTimeTbCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    let aResult = JSON.parse(tResult);
                    $("#ohdTCKTimeTbCheckDuplicateCode").val(aResult["rtCode"]);
                    // Set Validate Dublicate Code
                    $.validator.addMethod('dublicateCode', function(value, element) {
                        if($("#ohdTCKTimeTbCheckDuplicateCode").val() == 1){
                            return false;
                        }else{
                            return true;
                        }
                    },'');
                    // From Summit Validate
                    $('#ofmTCKTimeTbAdd').validate({
                        rules: {
                            oetTCKTimeTbCode : {
                                "required" :{
                                    // ตรวจสอบเงื่อนไข validate
                                    depends: function(oElement) {
                                    if($('#ocbTCKTimeTbAutoGenCode').is(':checked')){
                                        return false;
                                    }else{
                                        return true;
                                    }
                                    }
                                },
                                "dublicateCode" :{}
                            },
                            oetTCKTimeTbName: { "required": {} },
                        },
                        messages: {
                            oetTCKTimeTbCode: {
                                "required"      : $('#oetTCKTimeTbCode').attr('data-validate-required'),
                                "dublicateCode" : $('#oetTCKTimeTbCode').attr('data-validate-dublicateCode')
                            },
                            oetTCKTimeTbName: {
                                "required"      : $('#oetTCKTimeTbName').attr('data-validate-required'),
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
                    $('#ofmTCKTimeTbAdd').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }
</script>