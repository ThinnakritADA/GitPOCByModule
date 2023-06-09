<script type="text/javascript">
    $(document).ready(function(){
    
        if(JSbsSuppliertypeIsCreatePage()){
            //suppliertype Code
            $("#oetLevCode").attr("disabled", true);
            $('#ocbLevAutoGenCode').change(function(){
                if($('#ocbLevAutoGenCode').is(':checked')) {
                    $('#oetLevCode').val('');
                    $("#oetLevCode").attr("disabled", true);
                    $('#odvCpnCodeForm').removeClass('has-error');
                    $('#odvCpnCodeForm em').remove();
                }else{
                    $("#oetLevCode").attr("disabled", false);
                }
            });
            JSxSuppliertypeVisibleComponent('#odvLevAutoGenCode', true);
        }
        
        if(JSbSuppliertypeIsUpdatePage()){
      
            // suppliertype Code
            $("#oetLevCode").attr("readonly", true);
            $('#odvLevAutoGenCode input').attr('disabled', true);
            JSxSuppliertypeVisibleComponent('#odvLevAutoGenCode', false);    
        }
    });

    $('#oetLevCode').blur(function(){
        JSxCheckSuppliertypeCodeDupInDB();
    });

    //Functionality : Event Check suppliertype
    //Parameters : Event Blur Input suppliertype Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Updata : 30/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckSuppliertypeCodeDupInDB(){
        if(!$('#ocbLevAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TTKMLocLev",
                    tFieldName: "FTLevCode",
                    tCode: $("#oetLevCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateLevCode").val(aResult["rtCode"]);
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateLevCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddLev').validate({
                    rules: {
                        oetLevCode : {
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
                        oetLevName:     {"required" :{}},
                    },
                    messages: {
                        oetLevCode : {
                            "required"      : $('#oetLevCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetLevCode').attr('data-validate-dublicateCode')
                        },
                        oetLevName : {
                            "required"      : $('#oetLevName').attr('data-validate-required'),
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
                $('#ofmAddLev').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }







</script>