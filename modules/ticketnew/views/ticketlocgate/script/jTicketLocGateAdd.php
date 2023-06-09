<script type="text/javascript">
    $(document).ready(function(){
    
        if(JSbsSuppliertypeIsCreatePage()){
            //suppliertype Code
            $("#oetGteCode").attr("disabled", true);
            $('#ocbGteAutoGenCode').change(function(){
                if($('#ocbGteAutoGenCode').is(':checked')) {
                    $('#oetGteCode').val('');
                    $("#oetGteCode").attr("disabled", true);
                    $('#odvCpnCodeForm').removeClass('has-error');
                    $('#odvCpnCodeForm em').remove();
                }else{
                    $("#oetGteCode").attr("disabled", false);
                }
            });
            JSxSuppliertypeVisibleComponent('#odvGteAutoGenCode', true);
        }
        
        if(JSbSuppliertypeIsUpdatePage()){
      
            // suppliertype Code
            $("#oetGteCode").attr("readonly", true);
            $('#odvGteAutoGenCode input').attr('disabled', true);
            JSxSuppliertypeVisibleComponent('#odvGteAutoGenCode', false);    
        }
    });

    $('#oetGteCode').blur(function(){
        JSxCheckSuppliertypeCodeDupInDB();
    });

    //Functionality : Event Check suppliertype
    //Parameters : Event Blur Input suppliertype Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Updata : 30/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckSuppliertypeCodeDupInDB(){
        if(!$('#ocbGteAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TTKMLocGate",
                    tFieldName: "FTGteCode",
                    tCode: $("#oetGteCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateGteCode").val(aResult["rtCode"]);
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateGteCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddGte').validate({
                    rules: {
                        oetGteCode : {
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
                        oetGteName:     {"required" :{}},
                    },
                    messages: {
                        oetGteCode : {
                            "required"      : $('#oetGteCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetGteCode').attr('data-validate-dublicateCode')
                        },
                        oetGteName : {
                            "required"      : $('#oetGteName').attr('data-validate-required'),
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
                $('#ofmAddGte').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }







</script>