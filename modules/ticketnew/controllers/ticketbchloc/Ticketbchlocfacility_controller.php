<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Ticketbchlocfacility_controller extends MX_Controller {

        public function __construct() {
            parent::__construct ();
            $this->load->model('ticketnew/ticketbchloc/Ticketbchloc_model');
            $this->load->model('ticketnew/ticketbchloc/Ticketbchlocfacility_model');
            date_default_timezone_set("Asia/Bangkok");
        }

        // Functionality : Call page list data
        // Parameters : -
        // Creater : 31/05/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKBchLocFacData(){
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
            $this->load->view('ticketnew/ticketbchloc/facility/wTicketbchlocFacData', $aGenTable);
        }
        
        // Functionality : Call data table
        // Parameters : -
        // Creater : 31/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKBchLocFacDataTable(){
            try {
                $nLangEdit  = $this->session->userdata("tLangEdit");
                $tAgnCode   = $this->input->post('ptTCKBchLocFacAgnCode');
                $tBchCode   = $this->input->post('ptTCKBchLocFacBchCode');
                $tLocCode   = $this->input->post('ptTCKBchLocFacLocCode');

                $aDataWhere = array(
                    'pnLngID'   => $nLangEdit,
                    'ptAgnCode' => $tAgnCode,
                    'ptBchCode' => $tBchCode,
                    'ptLocCode' => $tLocCode
                );
                $aDataList = $this->Ticketbchlocfacility_model->FSaMTCKBchLocFacDataList($aDataWhere);
                $aGenTable = array(
                    'aDataList' => $aDataList
                );
                $oTCKBchLocViewFacDataList = $this->load->view('ticketnew/ticketbchloc/facility/wTicketbchlocFacDataTable', $aGenTable, true);
                $aReturnData = array(
                    'oTCKBchLocViewFacDataList' => $oTCKBchLocViewFacDataList,
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
        // Creater : 31/05/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKBchLocFacPageAdd(){

            $tFacAgnCode = $this->input->post('ptTCKBchLocFacAgnCode');
            $tFacBchCode = $this->input->post('ptTCKBchLocFacBchCode');
            $tFacLocCode = $this->input->post('ptTCKBchLocFacLocCode');

            $aDataViewAdd = array(
                'nStaCallView'  => 1, // 1 = Call View Add , 2 = Call View Edits
                'tFacAgnCode'   => $tFacAgnCode,
                'tFacBchCode'   => $tFacBchCode,
                'tFacLocCode'   => $tFacLocCode,
            );
            $this->load->view('ticketnew/ticketbchloc/facility/wTicketbchlocFacViewForm', $aDataViewAdd);
        }
        
        // Functionality : Event add data facility
        // Parameters : -
        // Creater : 31/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKBchLocFacEventAdd(){
            try{
                $tSesUsername   = $this->session->userdata('tSesUsername');
                $tFacAgnCode    = !empty($this->input->post("ohdBchLocFacAgnCode")) ? $this->input->post("ohdBchLocFacAgnCode") : '';
                $tFacBchCode    = !empty($this->input->post("ohdBchLocFacBchCode")) ? $this->input->post("ohdBchLocFacBchCode") : '';
                $tFacLocCode    = !empty($this->input->post('ohdBchLocFacLocCode')) ? $this->input->post("ohdBchLocFacLocCode") : '';
                $tFacZneCode    = $this->input->post("ohdTCKBchLocFacZneCode");
                $tFacCode       = $this->input->post("ohdTCKBchLocFacCode");
                
                $aDataFac = array(
                    'ptFacAgnCode'  => $tFacAgnCode,
                    'ptFacBchCode'  => $tFacBchCode,
                    'ptFacLocCode'  => $tFacLocCode,
                    'ptFacZneCode'  => $tFacZneCode,
                    'ptFacCode'     => $tFacCode,
                    'ptSesUsername' => $tSesUsername
                );

                $this->db->trans_begin();
                $this->Ticketbchlocfacility_model->FSaMTCKBchLocFacUpdateLocZne($aDataFac);
                if($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent' => 500,
                        'tStaMessg' => "Error Unsuccess Add Facility."
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturnData = array(
                        'tDataCodeReturn'   => $aDataFac['ptFacLocCode'],
                        'nStaEvent'         => 1,
                        'tStaMessg'         => 'Success Add Facility.'
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
        // Creater : 31/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKBchLocFacEventDelete(){
            try{
                $tSesUsername   = $this->session->userdata('tSesUsername');
                $tLocCode       = $this->input->post('ptLocCode');
                $tZneCode       = $this->input->post('ptZneCode');
                $tFacCode       = $this->input->post('ptFacCode');

                $aDataWhere = array(
                    'ptFacCode'         => $tFacCode,
                    'ptSesUsername'     => $tSesUsername,
                );

                $this->db->trans_begin();
                $this->Ticketbchlocfacility_model->FSaMTCKBchLocFacUpdateLocZne($aDataWhere);
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