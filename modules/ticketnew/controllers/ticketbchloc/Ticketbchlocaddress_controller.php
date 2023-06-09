<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Ticketbchlocaddress_controller extends MX_Controller {

        public function __construct() {
            parent::__construct ();
            $this->load->model('ticketnew/ticketbchloc/Ticketbchloc_model');
            $this->load->model('ticketnew/ticketbchloc/Ticketbchlocaddress_model');
            date_default_timezone_set("Asia/Bangkok");
        }

        // Functionality : Call page list data
        // Parameters : -
        // Creater : 21/04/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKBchLocAddressData(){
            $aAlwEventBchLoc = FCNaHCheckAlwFunc('ticketBchLocation/0/0');
            $tAgnCode = $this->input->post('ptAgnCode');
            $tBchCode = $this->input->post('ptBchCode');
            $tLocCode = $this->input->post('ptLocCode');
            $aGenTable = array(
                'aAlwEventBchLoc' => $aAlwEventBchLoc,
                'tAgnCode'  => $tAgnCode,
                'tBchCode'  => $tBchCode,
                'tLocCode'  => $tLocCode
            );
            $this->load->view('ticketnew/ticketbchloc/address/wTicketbchlocAddressData', $aGenTable);
        }

        // Functionality : Call data table
        // Parameters : -
        // Creater : 21/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKBchLocAddressDataTable(){
            try {
                $nLangEdit  = $this->session->userdata("tLangEdit");
                $tAgnCode   = $this->input->post('ptTCKBchLocAddrAgnCode');
                $tBchCode   = $this->input->post('ptTCKBchLocAddrBchCode');
                $tLocCode   = $this->input->post('ptTCKBchLocAddrLocCode');

                $aDataWhere = array(
                    'pnLngID'   => $nLangEdit,
                    'ptAgnCode' => $tAgnCode,
                    'ptBchCode' => $tBchCode,
                    'ptLocCode' => $tLocCode
                );
                $aDataList = $this->Ticketbchlocaddress_model->FSaMTCKBchLocAddressDataList($aDataWhere);
                $aGenTable = array(
                    'aDataList' => $aDataList
                );
                $oTCKBchLocViewAddressDataList = $this->load->view('ticketnew/ticketbchloc/address/wTicketbchlocAddressDataTable', $aGenTable, true);
                $aReturnData = array(
                    'oTCKBchLocViewAddressDataList' => $oTCKBchLocViewAddressDataList,
                    'nStaEvent'             => '1',
                    'tStaMessg'             => 'Success'
                );
            } catch (Exception $Error) {
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => $Error->getMessage()
                );
            }
            echo json_encode($aReturnData);
        }

        // Functionality : Call page add
        // Parameters : -
        // Creater : 21/04/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKBchLocAddressPageAdd(){

            $tAddrAgnCode = $this->input->post('ptTCKBchLocAddrAgnCode');
            $tAddrBchCode = $this->input->post('ptTCKBchLocAddrBchCode');
            $tAddrLocCode = $this->input->post('ptTCKBchLocAddrLocCode');

            $tSesUsrAgnCode         = $this->session->userdata("tSesUsrAgnCode");
            $aBranchAgnCode         = $this->Ticketbchloc_model->FSaMTCKBchLocGetAgn($tAddrBchCode);
            $tBranchAgnCode         = ($aBranchAgnCode['rtCode'] == 1) ? $aBranchAgnCode['raItem']['FTAgnCode'] : $tSesUsrAgnCode;
            $aDataConfigAddr        = FCNaGetConfigData('tCN_AddressType', 'CN', 'TCNMBranch', 2, $tBranchAgnCode);
            if($aDataConfigAddr['rtCode'] == 1){
                if(isset($aDataConfigAddr['raItem']['FTCfgStaUsrValue']) && !empty($aDataConfigAddr['raItem']['FTCfgStaUsrValue'])){
                    $nDataConfigAddr = $aDataConfigAddr['raItem']['FTCfgStaUsrValue'];
                }else{
                    $nDataConfigAddr = $aDataConfigAddr['raItem']['FTCfgStaUsrRef'];
                }
            }else{
                $nDataConfigAddr = 1;
            }

            $aDataViewAdd = array(
                'nStaCallView'      => 1, // 1 = Call View Add , 2 = Call View Edits
                'tAddrBchCode'      => $tAddrBchCode,
                'tAddrLocCode'      => $tAddrLocCode,
                'nDataConfigAddr'   => $nDataConfigAddr
            );

            $this->load->view('ticketnew/ticketbchloc/address/wTicketbchlocAddressViewForm', $aDataViewAdd);
        }

        // Functionality : Call page edit
        // Parameters : -
        // Creater : 21/04/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKBchLocAddressPageEdit(){

            $tAddrBchCode       = $this->input->post('ptTCKBchLocAddrBchCode');
            $tSesUsrAgnCode     = $this->session->userdata("tSesUsrAgnCode");
            $aBranchAgnCode     = $this->Ticketbchloc_model->FSaMTCKBchLocGetAgn($tAddrBchCode);
            $tBranchAgnCode     = ($aBranchAgnCode['rtCode'] == 1) ? $aBranchAgnCode['raItem']['FTAgnCode'] : $tSesUsrAgnCode;
            $aDataConfigAddr    = FCNaGetConfigData('tCN_AddressType', 'CN', 'TCNMBranch', 2, $tBranchAgnCode);
            if($aDataConfigAddr['rtCode'] == 1){
                if(isset($aDataConfigAddr['raItem']['FTCfgStaUsrValue']) && !empty($aDataConfigAddr['raItem']['FTCfgStaUsrValue'])){
                    $nDataConfigAddr = $aDataConfigAddr['raItem']['FTCfgStaUsrValue'];
                }else{
                    $nDataConfigAddr = $aDataConfigAddr['raItem']['FTCfgStaUsrRef'];
                }
            }else{
                $nDataConfigAddr = 1;
            }

            $aDataWhereAddress  = array(
                'FNLngID'       => $this->input->post('FNLngID'),
                'FTAddGrpType'  => $this->input->post('FTAddGrpType'),
                'FTAddRefCode'  => $this->input->post('FTAddRefCode'),
                'FNAddSeqNo'    => $this->input->post('FNAddSeqNo'),
            );
            $aDataAddress = $this->Ticketbchlocaddress_model->FSaMTCKBchLocAddressGetDataID($aDataWhereAddress);
            $aDataViewEdit= array(
                'nStaCallView'          => 2, // 1 = Call View Add , 2 = Call View Edits
                'tAddrLocCode'          => $this->input->post('FTAddRefCode'),
                'aDataAddress'          => $aDataAddress,
                'nDataConfigAddr'       => $nDataConfigAddr
            );
            $this->load->view('ticketnew/ticketbchloc/address/wTicketbchlocAddressViewForm', $aDataViewEdit);
        }

        // Functionality : Event add data
        // Parameters : -
        // Creater : 21/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKBchLocAddressEventAdd(){
            try{
                $this->db->trans_begin();
                $tLangEdit          = $this->session->userdata("tLangEdit");
                $tSesUsername       = $this->session->userdata('tSesUsername');
                $tBchLocAddrGrpType = $this->input->post("ohdBchLocAddrGrpType");
                $tBchLocAddrRefCode = $this->input->post("ohdBchLocAddrRefCode");
                $tBchLocAddrVersion = $this->input->post('ohdBchLocAddrVersion');
                $tBchLocAddrMapLong = $this->input->post("ohdBchLocAddrMapLong");
                $tBchLocAddrMapLat  = $this->input->post("ohdBchLocAddrMapLat");
                if(isset($tBchLocAddrVersion) && $tBchLocAddrVersion == 1){
                    $aDataAddr = array(
                        'FNLngID'           => $tLangEdit,
                        'FTAddGrpType'      => $tBchLocAddrGrpType,
                        'FTAddRefCode'      => $tBchLocAddrRefCode,
                        'FTAddName'         => $this->input->post("oetBchLocAddrName"),
                        'FTAddTaxNo'        => $this->input->post("oetBchLocAddrTaxNo"),
                        'FTAddRmk'          => $this->input->post("oetBchLocAddrRmk"),
                        'FTAddVersion'      => $tBchLocAddrVersion,
                        'FTAddV1No'         => $this->input->post("oetBchLocAddrNo"),
                        'FTAddV1Soi'        => $this->input->post("oetBchLocAddrSoi"),
                        'FTAddV1Village'    => $this->input->post("oetBchLocAddrVillage"),
                        'FTAddV1Road'       => $this->input->post("oetBchLocAddrRoad"),
                        'FTAddV1SubDist'    => $this->input->post("oetBchLocAddrSubDstCode"),
                        'FTAddV1DstCode'    => $this->input->post("oetBchLocAddrDstCode"),
                        'FTAddV1PvnCode'    => $this->input->post("oetBchLocAddrPvnCode"),
                        'FTAddV1PostCode'   => $this->input->post("oetBchLocAddrPostCode"),
                        'FTAddWebsite'      => $this->input->post("oetBchLocAddrWeb"),
                        'FTAddTel'          => $this->input->post("oetBchLocAddrTel"),
                        'FTAddFax'          => $this->input->post("oetBchLocAddrFax"),
                        'FTAddLongitude'    => $tBchLocAddrMapLong,
                        'FTAddLatitude'     => $tBchLocAddrMapLat,   
                        'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                        'FTLastUpdBy'       => $tSesUsername,
                        'FDCreateOn'        => date('Y-m-d H:i:s'),
                        'FTCreateBy'        => $tSesUsername,
                    );
                }else{
                    $aDataAddr = array(
                        'FNLngID'           => $tLangEdit,
                        'FTAddGrpType'      => $tBchLocAddrGrpType,
                        'FTAddRefCode'      => $tBchLocAddrRefCode,
                        'FTAddName'         => $this->input->post("oetBchLocAddrName2"),
                        'FTAddTaxNo'        => $this->input->post("oetBchLocAddrTaxNo2"),
                        'FTAddRmk'          => $this->input->post("oetBchLocAddrRmk2"),
                        'FTAddVersion'      => $tBchLocAddrVersion,
                        'FTAddV2Desc1'      => $this->input->post("oetBchLocAddrV2Desc1"),
                        'FTAddV2Desc2'      => $this->input->post("oetBchLocAddrV2Desc2"),
                        'FTAddWebsite'      => $this->input->post("oetBchLocAddrWeb2"),
                        'FTAddTel'          => $this->input->post("oetBchLocAddrTel2"),
                        'FTAddFax'          => $this->input->post("oetBchLocAddrFax2"),
                        'FTAddLongitude'    => $tBchLocAddrMapLong,
                        'FTAddLatitude'     => $tBchLocAddrMapLat,
                        'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                        'FTLastUpdBy'       => $tSesUsername,
                        'FDCreateOn'        => date('Y-m-d H:i:s'),
                        'FTCreateBy'        => $tSesUsername,
                    );
                }

                $this->Ticketbchlocaddress_model->FSaMTCKBchLocAddressAddData($aDataAddr);
                $this->Ticketbchlocaddress_model->FSaMTCKBchLocAddressUpdateSeq($aDataAddr);
                if($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent' => 500,
                        'tStaMessg' => "Error Unsuccess Add Address."
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturnData = array(
                        'tDataCodeReturn'   => $aDataAddr['FTAddRefCode'],
                        'nStaEvent'        => 1,
                        'tStaMessg'         => 'Success Add Address.'
                    );
                }
            }catch(Exception $Error){
                $aReturnData = array(
                    'nStaEvent' => $Error['tCodeReturn'],
                    'tStaMessg' => $Error['tTextStaMessg']
                );
            }
            echo json_encode($aReturnData);
        }

        // Functionality : Event edit data
        // Parameters : -
        // Creater : 21/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        function FSaCTCKBchLocAddressEventEdit(){
            try{
                $this->db->trans_begin();
                $tLangEdit          = $this->session->userdata("tLangEdit");
                $tSesUsername       = $this->session->userdata('tSesUsername');
                $tBchLocAddrGrpType = $this->input->post("ohdBchLocAddrGrpType");
                $tBchLocAddrRefCode = $this->input->post("ohdBchLocAddrRefCode");
                $tBchLocAddrSeqNo   = $this->input->post("ohdBchLocAddrSeqNo");
                $tBchLocAddrVersion = $this->input->post('ohdBchLocAddrVersion');
                $tBchLocAddrMapLong = $this->input->post("ohdBchLocAddrMapLong");
                $tBchLocAddrMapLat  = $this->input->post("ohdBchLocAddrMapLat");
                if(isset($tBchLocAddrVersion) && $tBchLocAddrVersion == 1){
                    $aDataAddr = array(
                        'FNLngID'           => $tLangEdit,
                        'FTAddGrpType'      => $tBchLocAddrGrpType,
                        'FTAddRefCode'      => $tBchLocAddrRefCode,
                        'FNAddSeqNo'        => $tBchLocAddrSeqNo,
                        'FTAddName'         => $this->input->post("oetBchLocAddrName"),
                        'FTAddTaxNo'        => $this->input->post("oetBchLocAddrTaxNo"),
                        'FTAddRmk'          => $this->input->post("oetBchLocAddrRmk"),
                        'FTAddVersion'      => $tBchLocAddrVersion,
                        'FTAddV1No'         => $this->input->post("oetBchLocAddrNo"),
                        'FTAddV1Soi'        => $this->input->post("oetBchLocAddrSoi"),
                        'FTAddV1Village'    => $this->input->post("oetBchLocAddrVillage"),
                        'FTAddV1Road'       => $this->input->post("oetBchLocAddrRoad"),
                        'FTAddV1SubDist'    => $this->input->post("oetBchLocAddrSubDstCode"),
                        'FTAddV1DstCode'    => $this->input->post("oetBchLocAddrDstCode"),
                        'FTAddV1PvnCode'    => $this->input->post("oetBchLocAddrPvnCode"),
                        'FTAddV1PostCode'   => $this->input->post("oetBchLocAddrPostCode"),
                        'FTAddWebsite'      => $this->input->post("oetBchLocAddrWeb"),
                        'FTAddTel'          => $this->input->post("oetBchLocAddrTel"),
                        'FTAddFax'          => $this->input->post("oetBchLocAddrFax"),
                        'FTAddLongitude'    => $tBchLocAddrMapLong,
                        'FTAddLatitude'     => $tBchLocAddrMapLat,   
                        'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                        'FTLastUpdBy'       => $tSesUsername,
                    );
                }else{
                    $aDataAddr = array(
                        'FNLngID'           => $tLangEdit,
                        'FTAddGrpType'      => $tBchLocAddrGrpType,
                        'FTAddRefCode'      => $tBchLocAddrRefCode,
                        'FNAddSeqNo'        => $tBchLocAddrSeqNo,
                        'FTAddName'         => $this->input->post("oetBchLocAddrName2"),
                        'FTAddTaxNo'        => $this->input->post("oetBchLocAddrTaxNo2"),
                        'FTAddRmk'          => $this->input->post("oetBchLocAddrRmk2"),
                        'FTAddVersion'      => $tBchLocAddrVersion,
                        'FTAddV2Desc1'      => $this->input->post("oetBchLocAddrV2Desc1"),
                        'FTAddV2Desc2'      => $this->input->post("oetBchLocAddrV2Desc2"),
                        'FTAddWebsite'      => $this->input->post("oetBchLocAddrWeb2"),
                        'FTAddTel'          => $this->input->post("oetBchLocAddrTel2"),
                        'FTAddFax'          => $this->input->post("oetBchLocAddrFax2"),
                        'FTAddLongitude'    => $tBchLocAddrMapLong,
                        'FTAddLatitude'     => $tBchLocAddrMapLat,
                        'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                        'FTLastUpdBy'       => $tSesUsername,
                    );
                }

                $this->Ticketbchlocaddress_model->FSaMTCKBchLocAddressEditData($aDataAddr);
                $this->Ticketbchlocaddress_model->FSaMTCKBchLocAddressUpdateSeq($aDataAddr);
                if($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent' => 500,
                        'tStaMessg' => "Error Unsuccess Update Address."
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturnData = array(
                        'tDataCodeReturn'   => $aDataAddr['FTAddRefCode'],
                        'nStaEvent'        => 1,
                        'tStaMessg'         => 'Success Update Address.'
                    );
                }
            }catch(Exception $Error){
                $aReturnData = array(
                    'nStaEvent' => $Error['tCodeReturn'],
                    'tStaMessg' => $Error['tTextStaMessg']
                );
            }
            echo json_encode($aReturnData);
        }

        // Functionality : Event delete data
        // Parameters : -
        // Creater : 21/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        function FSaCTCKBchLocAddressEventDelete(){
            try{
                $this->db->trans_begin();
                $aDataWhereAddress  = array(
                    'FNLngID'       => $this->input->post('FNLngID'),
                    'FTAddGrpType'  => $this->input->post('FTAddGrpType'),
                    'FTAddRefCode'  => $this->input->post('FTAddRefCode'),
                    'FNAddSeqNo'    => $this->input->post('FNAddSeqNo'),
                );

                $this->Ticketbchlocaddress_model->FSaMTCKBchLocAddressDeleteData($aDataWhereAddress);
                $this->Ticketbchlocaddress_model->FSaMTCKBchLocAddressUpdateSeq($aDataWhereAddress);
                if($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaReturn'    => 500,
                        'tStaMessg'     => "Error Unsucess Delete Address."
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturnData = array(
                        'tDataCodeReturn'   => $aDataWhereAddress['FTAddRefCode'],
                        'nStaReturn'        => 1,
                        'tStaMessg'         => 'Success Delete Address.',
                    );
                }
            }catch(Exception $Error){
                $aReturnData = array(
                    'nStaReturn'    => $Error['tCodeReturn'],
                    'tStaMessg'     => $Error['tTextStaMessg']
                );
            }
            echo json_encode($aReturnData);
        }

    }

?>
