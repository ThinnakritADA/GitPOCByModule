<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Ticketbchloczone_controller extends MX_Controller {

        public function __construct() {
            parent::__construct ();
            $this->load->model('ticketnew/ticketbchloc/Ticketbchloc_model');
            $this->load->model('ticketnew/ticketbchloc/Ticketbchloczone_model');
            date_default_timezone_set("Asia/Bangkok");
        }

        // Functionality : Call page list data
        // Parameters : -
        // Creater : 29/05/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKBchLocZoneData(){
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
            $this->load->view('ticketnew/ticketbchloc/zone/wTicketbchlocZoneData', $aGenTable);
        }

        // Functionality : Call data table
        // Parameters : -
        // Creater : 30/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKBchLocZoneDataTable(){
            try {
                $nLangEdit  = $this->session->userdata("tLangEdit");
                $tAgnCode   = $this->input->post('ptTCKBchLocZoneAgnCode');
                $tBchCode   = $this->input->post('ptTCKBchLocZoneBchCode');
                $tLocCode   = $this->input->post('ptTCKBchLocZoneLocCode');

                $aDataWhere = array(
                    'pnLngID'   => $nLangEdit,
                    'ptAgnCode' => $tAgnCode,
                    'ptBchCode' => $tBchCode,
                    'ptLocCode' => $tLocCode
                );
                $aDataList = $this->Ticketbchloczone_model->FSaMTCKBchLocZoneDataList($aDataWhere);
                $aGenTable = array(
                    'aDataList' => $aDataList
                );
                $oTCKBchLocViewZoneDataList = $this->load->view('ticketnew/ticketbchloc/zone/wTicketbchlocZoneDataTable', $aGenTable, true);
                $aReturnData = array(
                    'oTCKBchLocViewZoneDataList' => $oTCKBchLocViewZoneDataList,
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
        // Creater : 30/05/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKBchLocZonePageAdd(){

            $tZoneAgnCode = $this->input->post('ptTCKBchLocZoneAgnCode');
            $tZoneBchCode = $this->input->post('ptTCKBchLocZoneBchCode');
            $tZoneLocCode = $this->input->post('ptTCKBchLocZoneLocCode');

            $aDataViewAdd = array(
                'nStaCallView'  => 1, // 1 = Call View Add , 2 = Call View Edits
                'tZoneAgnCode'  => $tZoneAgnCode,
                'tZoneBchCode'  => $tZoneBchCode,
                'tZoneLocCode'  => $tZoneLocCode,
            );
            $this->load->view('ticketnew/ticketbchloc/zone/wTicketbchlocZoneViewForm', $aDataViewAdd);
        }

        // Functionality : Event add data zone
        // Parameters : -
        // Creater : 30/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKBchLocZoneEventAdd(){
            try{
                $tSesUsername   = $this->session->userdata('tSesUsername');
                $tZoneAgnCode   = !empty($this->input->post("ohdBchLocZoneAgnCode")) ? $this->input->post("ohdBchLocZoneAgnCode") : '';
                $tZoneBchCode   = !empty($this->input->post("ohdBchLocZoneBchCode")) ? $this->input->post("ohdBchLocZoneBchCode") : '';
                $tZoneLocCode   = !empty($this->input->post('ohdBchLocZoneLocCode')) ? $this->input->post("ohdBchLocZoneLocCode") : '';
                $tZoneCode      = $this->input->post("ohdTCKBchLocZneCode");
                $tZoneChainOld  = $this->input->post("ohdTCKBchLocZneChain");
                $tZoneChainNew  = $tZoneAgnCode . $tZoneBchCode . $tZoneLocCode . $tZoneCode;

                $aDataZone = array(
                    'ptZoneAgnCode'     => $tZoneAgnCode,
                    'ptZoneBchCode'     => $tZoneBchCode,
                    'ptZoneLocCode'     => $tZoneLocCode,
                    'ptZoneCode'        => $tZoneCode,
                    'ptZoneChainOld'    => $tZoneChainOld,
                    'ptZoneChainNew'    => $tZoneChainNew,
                    'ptSesUsername'     => $tSesUsername
                );
                $aZonePdt = $this->Ticketbchloczone_model->FSaMTCKBchLocZonePdtList($tZoneChainOld);

                $this->db->trans_begin();
                $this->Ticketbchloczone_model->FSaMTCKBchLocZoneUpdateZoneChain($aDataZone, $aZonePdt);
                if($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent' => 500,
                        'tStaMessg' => "Error Unsuccess Add Zone."
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturnData = array(
                        'tDataCodeReturn'   => $aDataZone['ptZoneLocCode'],
                        'nStaEvent'         => 1,
                        'tStaMessg'         => 'Success Add Zone.'
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
        // Creater : 30/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKBchLocZoneEventDelete(){
            try{
                $tSesUsername   = $this->session->userdata('tSesUsername');
                $tLocCode       = $this->input->post('ptLocCode');
                $tZneCode       = $this->input->post('ptZneCode');
                $tZneChain      = $this->input->post('ptZneChain');

                $aDataWhere = array(
                    'ptZoneCode'        => $tZneCode,
                    'ptZoneChainOld'    => $tZneChain,
                    'ptZoneChainNew'    => $tZneCode,
                    'ptSesUsername'     => $tSesUsername,
                );
                $aZonePdt = $this->Ticketbchloczone_model->FSaMTCKBchLocZonePdtList($tZneCode);

                $this->db->trans_begin();
                $this->Ticketbchloczone_model->FSaMTCKBchLocZoneUpdateZoneChain($aDataWhere, $aZonePdt);
                $this->Ticketbchloczone_model->FSaMTCKBchLocZoneDeleteZonePdt($aDataWhere);
                $this->Ticketbchloczone_model->FSaMTCKBchLocZoneDeleteZoneFac($aDataWhere);
                if($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent' => 500,
                        'tStaMessg' => "Error Unsuccess Add Zone."
                    );
                }else{
                    $this->db->trans_commit();
                    //Check Zone
                    $aCountZne = $this->Ticketbchloc_model->FSaMTCKBchLocCheckZone($tLocCode);
                    $nCountZne = $aCountZne['raItem']['nCountZne'];
                    //Check Facility
                    $aCountFac = $this->Ticketbchloc_model->FSaMTCKBchLocCheckFac($tLocCode);
                    $nCountFac = $aCountFac['raItem']['nCountFac'];
                    $aReturnData = array(
                        'tDataCodeReturn'   => $tLocCode,
                        'nCountZne'         => $nCountZne,
                        'nCountFac'         => $nCountFac,
                        'nStaEvent'         => 1,
                        'tStaMessg'         => 'Success Add Zone.'
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
        
    }

?>