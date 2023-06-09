<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Ticketloczonepdt_controller extends MX_Controller {
        public function __construct() {
            parent::__construct ();
            $this->load->model('ticketnew/ticketloczone/Ticketloczonepdt_model');
            date_default_timezone_set("Asia/Bangkok");
        }

        // Functionality : Call page list data
        // Parameters : -
        // Creater : 04/05/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKLocZonePdtData(){
            $aAlwEventLocZone = FCNaHCheckAlwFunc('ticketLocZone/0/0');
            $tZneChain  = $this->input->post('ptZneChain');
            $tZneCode   = $this->input->post('ptZneCode');
            $tBchCode   = $this->input->post('ptBchCode');
            $aGenTable = array(
                'aAlwEventLocZone' => $aAlwEventLocZone,
                'tZneChain' => $tZneChain,
                'tZneCode'  => $tZneCode,
                'tBchCode'  => $tBchCode
            );
            $this->load->view('ticketnew/ticketloczone/product/wTicketloczonePdtData', $aGenTable);
        }
        
        // Functionality : Call data table
        // Parameters : -
        // Creater : 04/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKLocZonePdtDataTable(){
            try {
                $nLangEdit          = $this->session->userdata("tLangEdit");
                $tSearchAll         = !empty($this->input->post('ptSearchAll')) ? $this->input->post('ptSearchAll') : '' ;
                $nPage              = !empty($this->input->post('pnPageCurrent')) ? $this->input->post('pnPageCurrent') : 1 ;
                $tZneChain          = $this->input->post('ptLocZonePdtZneChain');
                $tZneCode           = $this->input->post('ptLocZonePdtZneCode');
                
                $aDataWhere = array(
                    'nPage'     => $nPage,
                    'nRow'      => 10,
                    'nLngID'    => $nLangEdit,
                    'tSearchAll' => $tSearchAll,
                    'tZneChain' => $tZneChain,
                    'tZneCode'  => $tZneCode
                );
                $aDataList = $this->Ticketloczonepdt_model->FSaMTCKLocZonePdtDataList($aDataWhere);
                $aGenTable = array(
                    'aDataList'     => $aDataList,
                    'nPage'    	    => $nPage,
                    'tSearchAll'    => $tSearchAll,
                );
                $oTCKLocZoneViewPdtDataList = $this->load->view('ticketnew/ticketloczone/product/wTicketloczonePdtDataTable', $aGenTable, true);
                $aReturnData = array(
                    'oTCKLocZoneViewPdtDataList' => $oTCKLocZoneViewPdtDataList,
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

        // Functionality : Event add data
        // Parameters : -
        // Creater : 04/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKLocZonePdtEventAdd(){
            try {
                $tSesUsername   = $this->session->userdata('tSesUsername');
                $tZneChain      = $this->input->post('ptZneChain');
                $tZneCode       = $this->input->post('ptZneCode');
                $tBchCode       = $this->input->post('ptBchCode');
                $aPdtData       = $this->input->post('paPdtData');

                for ($nI = 0; $nI < FCNnHSizeOf($aPdtData); $nI++) {
                    $aDataPdt = array(
                        'FTZneChain'    => $tZneChain,
                        'FTLzbRefPdt'   => $aPdtData[$nI]['pnPdtCode'],
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTLastUpdBy'   => $tSesUsername,
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $tSesUsername,
                    );
                    
                    $oCountDup  = $this->Ticketloczonepdt_model->FSaMTCKLocZonePdtCheckDuplicate($aDataPdt);
                    $nStaDup    = $oCountDup['rtCountData'];
                    if($nStaDup == 0){
                        $this->db->trans_begin();
                        $aStaPdt    = $this->Ticketloczonepdt_model->FSaMTCKLocZonePdtAddData($aDataPdt);
                        if($this->db->trans_status() === FALSE) {
                            $this->db->trans_rollback();
                            $aReturnData = array(
                                'nStaEvent' => 500,
                                'tStaMessg' => "Error Unsuccess Add Product."
                            );
                        }else{
                            $this->db->trans_commit();
                            $aReturnData = array(
                                'tDataCodeReturn'   => $aDataPdt['FTZneChain'],
                                'nStaEvent'         => 1,
                                'tStaMessg'         => 'Success Add Product.'
                            );
                        }
                    }else{
                        $aReturnData = array(
                            'nStaEvent'    => '801',
                            'tStaMessg'    => language('ticketnew/ticketloczone/ticketloczone','tTCKLocZonePdtDup')
                        );
                    }
                }
            } catch (Exception $Error) {
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => $Error->getMessage()
                );
            }
            echo json_encode($aReturnData);
        }

        // Functionality : Event delete data
        // Parameters : -
        // Creater : 04/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKLocZonePdtEventDelete(){
            try{
                $this->db->trans_begin();
                $aDataPdt  = array(
                    'FTZneChain'   => $this->input->post('FTZneChain'),
                    'FTLzbRefPdt'  => $this->input->post('FTLzbRefPdt'),
                );

                $this->Ticketloczonepdt_model->FSaMTCKLocZonePdtDeleteData($aDataPdt);
                if($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaReturn'    => 500,
                        'tStaMessg'     => "Error Unsuccess Delete."
                    );
                }else{
                    $this->db->trans_commit();
                    $aCountZnePdt = $this->Ticketloczonepdt_model->FSaMTCKLocZonePdtCheckPdt($aDataPdt);
                    $nCountZnePdt = $aCountZnePdt['raItem']['nCountZnePdt'];
                    $aReturnData = array(
                        'tDataCodeReturn'   => $aDataPdt['FTZneChain'],
                        'nCountZnePdt'      => $nCountZnePdt,
                        'nStaReturn'        => 1,
                        'tStaMessg'         => 'Success Delete.',
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