<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Ticketbchlocproduct_controller extends MX_Controller {

        public function __construct() {
            parent::__construct ();
            // $this->load->model('ticketnew/ticketbchloc/Ticketbchloc_model');
            $this->load->model('ticketnew/ticketbchloc/Ticketbchlocproduct_model');
            date_default_timezone_set("Asia/Bangkok");
        }

        // Functionality : Call page list data
        // Parameters : -
        // Creater : 01/06/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKBchLocPdtData(){
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
            $this->load->view('ticketnew/ticketbchloc/product/wTicketbchlocPdtData', $aGenTable);
        }

        // Functionality : Call data table
        // Parameters : -
        // Creater : 31/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKBchLocPdtDataTable(){
            try {
                $nLangEdit  = $this->session->userdata("tLangEdit");
                $tAgnCode   = $this->input->post('ptTCKBchLocPdtAgnCode');
                $tBchCode   = $this->input->post('ptTCKBchLocPdtBchCode');
                $tLocCode   = $this->input->post('ptTCKBchLocPdtLocCode');

                $aDataWhere = array(
                    'pnLngID'   => $nLangEdit,
                    'ptAgnCode' => $tAgnCode,
                    'ptBchCode' => $tBchCode,
                    'ptLocCode' => $tLocCode
                );
                $aDataList = $this->Ticketbchlocproduct_model->FSaMTCKBchLocPdtDataList($aDataWhere);
                $aGenTable = array(
                    'aDataList' => $aDataList
                );
                $oTCKBchLocViewPdtDataList = $this->load->view('ticketnew/ticketbchloc/product/wTicketbchlocPdtDataTable', $aGenTable, true);
                $aReturnData = array(
                    'oTCKBchLocViewPdtDataList' => $oTCKBchLocViewPdtDataList,
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
        // Creater : 01/06/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKBchLocPdtPageAdd(){

            $tPdtAgnCode = $this->input->post('ptTCKBchLocPdtAgnCode');
            $tPdtBchCode = $this->input->post('ptTCKBchLocPdtBchCode');
            $tPdtLocCode = $this->input->post('ptTCKBchLocPdtLocCode');

            $aDataViewAdd = array(
                'nStaCallView'  => 1, // 1 = Call View Add , 2 = Call View Edits
                'tPdtAgnCode'   => $tPdtAgnCode,
                'tPdtBchCode'   => $tPdtBchCode,
                'tPdtLocCode'   => $tPdtLocCode,
            );
            $this->load->view('ticketnew/ticketbchloc/product/wTicketbchlocPdtViewForm', $aDataViewAdd);
        }

        // Functionality : Event add data facility
        // Parameters : -
        // Creater : 01/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKBchLocPdtEventAdd(){
            try{
                $tSesUsername   = $this->session->userdata('tSesUsername');
                $tPdtAgnCode    = !empty($this->input->post("ohdBchLocPdtAgnCode")) ? $this->input->post("ohdBchLocPdtAgnCode") : '';
                $tPdtBchCode    = !empty($this->input->post("ohdBchLocPdtBchCode")) ? $this->input->post("ohdBchLocPdtBchCode") : '';
                $tPdtLocCode    = !empty($this->input->post('ohdBchLocPdtLocCode')) ? $this->input->post("ohdBchLocPdtLocCode") : '';
                $tPdtZneCode    = $this->input->post("ohdTCKBchLocPdtZneCode");
                $tPdtCode       = $this->input->post("ohdTCKBchLocPdtCode");
                
                $aDataPdt = array(
                    'ptPdtAgnCode'  => $tPdtAgnCode,
                    'ptPdtBchCode'  => $tPdtBchCode,
                    'ptPdtLocCode'  => $tPdtLocCode,
                    'ptPdtZneCode'  => $tPdtZneCode,
                    'ptPdtCode'     => $tPdtCode,
                    'ptSesUsername' => $tSesUsername
                );

                $this->db->trans_begin();
                $this->Ticketbchlocproduct_model->FSaMTCKBchLocPdtAddData($aDataPdt);
                if($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent' => 500,
                        'tStaMessg' => "Error Unsuccess Add Product."
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturnData = array(
                        'tDataCodeReturn'   => $aDataPdt['ptPdtLocCode'],
                        'nStaEvent'         => 1,
                        'tStaMessg'         => 'Success Add Product.'
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
        public function FSaCTCKBchLocPdtEventDelete(){
            try{
                $tSesUsername   = $this->session->userdata('tSesUsername');
                $tLocCode       = $this->input->post('ptLocCode');
                $tZneCode       = $this->input->post('ptZneCode');
                $tPdtCode       = $this->input->post('ptPdtCode');

                $aDataWhere = array(
                    'ptLocCode'         => $tLocCode,
                    'ptZneCode'         => $tZneCode,
                    'ptPdtCode'         => $tPdtCode,
                    'ptSesUsername'     => $tSesUsername,
                );

                $this->db->trans_begin();
                $this->Ticketbchlocproduct_model->FSaMTCKBchLocPdtDeleteData($aDataWhere);
                if($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent' => 500,
                        'tStaMessg' => "Error Unsuccess Delete."
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturnData = array(
                        'tDataCodeReturn'   => $tLocCode,
                        'nStaEvent'         => 1,
                        'tStaMessg'         => 'Success Delete Data.'
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