<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Tickettimetable_controller extends MX_Controller {

        public function __construct() {
            parent::__construct ();
            $this->load->model('ticketnew/tickettimetable/Tickettimetable_model');
            date_default_timezone_set("Asia/Bangkok");
        }

        public function index($nTimeTbBrowseType, $nTimeTbBrowseOption) {
            $nMsgResp   = array('title'=>"TicketTimeTable");
            $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
            if(!$isXHR){
                $this->load->view ( 'common/wHeader', $nMsgResp);
                $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
                $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
            }
            // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            $aAlwEventTimeTb    = FCNaHCheckAlwFunc('ticketTimeTable/0/0');
            $vTimeTbBtnSave	    = FCNaHBtnSaveActiveHTML('ticketTimeTable/0/0');
            $aDataConfigView    = array(
                'nMsgResp'              => $nMsgResp,
                'aAlwEventTimeTb'	    => $aAlwEventTimeTb,
                'vTimeTbBtnSave'		=> $vTimeTbBtnSave,
                'nTimeTbBrowseType'	    => $nTimeTbBrowseType,
                'nTimeTbBrowseOption'	=> $nTimeTbBrowseOption
            );
            $this->load->view ('ticketnew/tickettimetable/wTickettimetable', $aDataConfigView);
        }

        // Functionality : Call form search list
        // Parameters : -
        // Creater : 08/05/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKTimeTbFormSearchList(){
            $aAlwEventTimeTb	= FCNaHCheckAlwFunc('ticketTimeTable/0/0');
            $aDataConfigView    = array(
                'aAlwEventTimeTb' => $aAlwEventTimeTb
            );
            $this->load->view('ticketnew/tickettimetable/wTickettimetableFormSearchList', $aDataConfigView);
        }

        // Functionality : Call data table
        // Parameters : -
        // Creater : 08/05/2023 Papitchaya
        // Last Update: -
        // Return : Array  
        public function FSaCTCKTimeTbDataTable(){
            try {
                $aAlwEventTimeTb    = FCNaHCheckAlwFunc('ticketTimeTable/0/0');
                $tSearchAll         = !empty($this->input->post('tSearchAll')) ? $this->input->post('tSearchAll') : '' ;
                $nPage              = !empty($this->input->post('nPageCurrent')) ? $this->input->post('nPageCurrent') : 1 ;
                $nLangEdit          = $this->session->userdata("tLangEdit");

                $aDataCondition = array(
                    'nPage'     => $nPage,
                    'nRow'      => 10,
                    'nLngID'    => $nLangEdit,
                    'tSearchAll' => $tSearchAll
                );
                $aDataList = $this->Tickettimetable_model->FSaMTCKTimeTbGetDataTableList($aDataCondition);
                $aGenTable = array(
                    'aAlwEventTimeTb' 	=> $aAlwEventTimeTb,
                    'aDataList' 		=> $aDataList,
                    'nPage'    		    => $nPage,
                    'tSearchAll'    	=> $tSearchAll
                );
                $oTCKTimeTbViewDataTableList = $this->load->view('ticketnew/tickettimetable/wTickettimetableDataTable', $aGenTable, true);
                $aReturnData = array(
                    'oTCKTimeTbViewDataTableList' => $oTCKTimeTbViewDataTableList,
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
        // Creater : 08/05/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKTimeTbPageAdd(){
            $aAlwEventTimeTb	= FCNaHCheckAlwFunc('ticketTimeTable/0/0');
            $aDataEdit = array(
				'aResult' 			=> array('rtCode' => '99'),
				'aAlwEventTimeTb' 	=> $aAlwEventTimeTb
		    );
            $this->load->view('ticketnew/tickettimetable/wTickettimetableAdd', $aDataEdit);
        }

        // Functionality : Call page edit
        // Parameters : -
        // Creater : 08/05/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKTimeTbPageEdit(){
            $aAlwEventTimeTb = FCNaHCheckAlwFunc('ticketTimeTable/0/0');
            $nLangEdit  = $this->session->userdata("tLangEdit");
            $tTmeCode   = $this->input->post('ptTmeCode');

            $aDataCondition = array(
				'ptTmeCode' => $tTmeCode,
				'pnLangID'  => $nLangEdit,
		    );

            $aDataList = $this->Tickettimetable_model->FSaMTCKTimeTbSearchByID($aDataCondition);
            $aDataEdit = array(
				'aResult' 			=> $aDataList,
				'aAlwEventTimeTb' 	=> $aAlwEventTimeTb
		    );
            $this->load->view('ticketnew/tickettimetable/wTickettimetableAdd', $aDataEdit);
        }

        // Functionality : Event add data
        // Parameters : -
        // Creater : 08/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKTimeTbEventAdd(){
            try {
                $tIsAutoGenCode = $this->input->post('ocbTCKTimeTbAutoGenCode');
                $tTmeName = $this->input->post('oetTCKTimeTbName');
                $tStaUse  = ($this->input->post('ocbTCKTimeTbStaUse') == '1') ? '1' : '2';
                
                $tTmeCode = "";
                if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){
                    $aStoreParam = array(
                        "tTblName"   => 'TTKMTimeTableHD',                           
                        "tDocType"   => 0,                                          
                        "tBchCode"   => "",                                 
                        "tShpCode"   => "",                               
                        "tPosCode"   => "",                     
                        "dDocDate"   => date("Y-m-d")
                    );
                    $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
                    $tTmeCode = $aAutogen[0]["FTXxhDocNo"];
                } else {
                    $tTmeCode = $this->input->post('oetTCKTimeTbCode');
                }

                $aDataMaster = array(
                    'FTTmeCode'     => $tTmeCode,
                    'FTTmeName'     => $tTmeName,
                    'FTTmeStaActive'=> $tStaUse,
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'    => date('Y-m-d H:i:s'),
                    'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                    'FNLngID'       => $this->session->userdata("tLangEdit")
                );
                
                $oCountDup  = $this->Tickettimetable_model->FSaMTCKTimeTbCheckDuplicate($aDataMaster['FTTmeCode']);
                $nStaDup    = $oCountDup['rtCountData'];
                if($nStaDup == 0){
                    $this->db->trans_begin();
                    $aStaMaster = $this->Tickettimetable_model->FSaMTCKTimeTbAddUpdateMaster($aDataMaster);
                    $aStaLang   = $this->Tickettimetable_model->FSaMTCKTimeTbAddUpdateLang($aDataMaster);
                    if($this->db->trans_status() === false){
                        $this->db->trans_rollback();
                        $aReturnData = array(
                            'nStaEvent'    => '900',
                            'tStaMessg'    => "Unsuccess Add Event"
                        );
                    } else {
                        $this->db->trans_commit();
                        $aReturnData = array(
                            'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                            'tCodeReturn'	=> $aDataMaster['FTTmeCode'],
                            'nStaEvent'	    => '1',
                            'tStaMessg'		=> 'Success Add Event'
                        );
                    }
                } else {
                    $aReturnData = array(
                        'nStaEvent'    => '801',
                        'tStaMessg'    => 'Data Code Duplicate'
                    );
                }
            } catch (Exception $Error) {
                return $Error;
            }
            echo json_encode($aReturnData);
        }

        // Functionality : Event edit data
        // Parameters : -
        // Creater : 08/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKTimeTbEventEdit(){
            try {
                $tTmeCode = $this->input->post('oetTCKTimeTbCode');
                $tTmeName = $this->input->post('oetTCKTimeTbName');
                $tStaUse  = ($this->input->post('ocbTCKTimeTbStaUse') == '1') ? '1' : '2';

                $aDataMaster = array(
                    'FTTmeCode'     => $tTmeCode,
                    'FTTmeName'     => $tTmeName,
                    'FTTmeStaActive'=> $tStaUse,
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FNLngID'       => $this->session->userdata("tLangEdit")
                );
 
                $this->db->trans_begin();
                $aStaMaster = $this->Tickettimetable_model->FSaMTCKTimeTbAddUpdateMaster($aDataMaster);
                $aStaLang   = $this->Tickettimetable_model->FSaMTCKTimeTbAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsuccess Edit Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturnData = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTTmeCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Update Event'
                    );
                }
            } catch (Exception $Error) {
                return $Error;
            }
            echo json_encode($aReturnData);
        }

        // Functionality : Event delete data
        // Parameters : -
        // Creater : 08/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKTimeTbEventDelete(){
            $tTmeCode   = $this->input->post('tTmeCode');
            $aDataMaster = array(
                'FTTmeCode'     => $tTmeCode,
            );
            $aResDel   = $this->Tickettimetable_model->FSaMTCKTimeTbDel($aDataMaster);
            echo json_encode($aResDel);	
        }

    }

?>