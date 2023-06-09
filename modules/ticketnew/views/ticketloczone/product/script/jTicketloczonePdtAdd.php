<script type="text/javascript">
    
    var nLangEdits  = '<?= $this->session->userdata("tLangEdit");?>';
    $(document).ready(function(){

    });

    $("#obtTCKLocZoneBrowsePdt").off().on('click', function(){
        let nStaSession = 1;
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            JSvTCKLocZoneBrowsePdt();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
</script>