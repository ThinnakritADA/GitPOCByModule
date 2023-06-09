<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Ticketbchloc_controller extends MX_Controller {

        public function __construct() {
            parent::__construct ();
            $this->load->model('ticketnew/ticketbchloc/Ticketbchloc_model');
            date_default_timezone_set("Asia/Bangkok");
        }

        public function index($nBchLocBrowseType, $tBchLocBrowseOption) {
            $nMsgResp   = array('title'=>"TicketBranchLocation");
            $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
            if(!$isXHR){
                $this->load->view ( 'common/wHeader', $nMsgResp);
                $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
                $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
            }
            // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            $aAlwEventBchLoc	= FCNaHCheckAlwFunc('ticketBchLocation/0/0');
            $vBtnSave			= FCNaHBtnSaveActiveHTML('ticketBchLocation/0/0');
            $aDataConfigView    = array(
                'nMsgResp'              => $nMsgResp,
                'aAlwEventBchLoc'	    => $aAlwEventBchLoc,
                'vBtnSave'			    => $vBtnSave,
                'nBchLocBrowseType'	    => $nBchLocBrowseType,
                'tBchLocBrowseOption'	=> $tBchLocBrowseOption
            );
            $this->load->view ('ticketnew/ticketbchloc/wTicketbchloc', $aDataConfigView);
        }

        // Functionality : Call form search list
        // Parameters : -
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKBchLocFormSearchList() {
            $aAlwEventBchLoc	= FCNaHCheckAlwFunc('ticketBchLocation/0/0');
            $aDataConfigView    = array(
                'aAlwEventBchLoc' => $aAlwEventBchLoc
            );
            $this->load->view('ticketnew/ticketbchloc/wTicketbchlocFormSearchList', $aDataConfigView);
        }

        // Functionality : Call data table
        // Parameters : -
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKBchLocDataTable(){
            try {
                $aAlwEventBchLoc	= FCNaHCheckAlwFunc('ticketBchLocation/0/0');
                $tSearchAll         = !empty($this->input->post('tSearchAll')) ? $this->input->post('tSearchAll') : '' ;
                $nPage              = !empty($this->input->post('nPageCurrent')) ? $this->input->post('nPageCurrent') : 1 ;
                $nLangEdit          = $this->session->userdata("tLangEdit");

                $aDataCondition = array(
                    'nPage'     => $nPage,
                    'nRow'      => 10,
                    'nLngID'    => $nLangEdit,
                    'tSearchAll' => $tSearchAll
                );

                $aDataList = $this->Ticketbchloc_model->FSaMTCKBchLocGetDataTableList($aDataCondition);
                $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 
                $aGenTable = array(
                    'aAlwEventBchLoc' 	=> $aAlwEventBchLoc,
                    'aDataList' 		=> $aDataList,
                    'nPage'    		    => $nPage,
                    'tSearchAll'    	=> $tSearchAll,
                    'nOptDecimalShow'   => $nOptDecimalShow
                );
                $oTCKBchLocViewDataTableList = $this->load->view('ticketnew/ticketbchloc/wTicketbchlocDataTable', $aGenTable, true);
                $aReturnData = array(
                    'oTCKBchLocViewDataTableList' => $oTCKBchLocViewDataTableList,
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
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKBchLocPageAdd(){
            $aAlwEventBchLoc = FCNaHCheckAlwFunc('ticketBchLocation/0/0');
            $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 
            $aDataEdit = array(
				'aResult' 			=> array('rtCode' => '99'),
				'aAlwEventBchLoc' 	=> $aAlwEventBchLoc,
                'nOptDecimalShow'   => $nOptDecimalShow
		    );
            $this->load->view('ticketnew/ticketbchloc/wTicketbchlocAdd', $aDataEdit);
        }

        // Functionality : Call page edit
        // Parameters : -
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKBchLocPageEdit(){
            $aAlwEventBchLoc = FCNaHCheckAlwFunc('ticketBchLocation/0/0');
            $tBchLocCode    = $this->input->post('ptLocCode');
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $aDataCondition = array(
				'ptLocCode' => $tBchLocCode,
				'pnLangID'  => $nLangEdit,
		    );
            $aDataList = $this->Ticketbchloc_model->FSaMTCKBchLocSearchByID($aDataCondition);
            $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 
            $aDataEdit = array(
				'aResult' 			=> $aDataList,
				'aAlwEventBchLoc' 	=> $aAlwEventBchLoc,
                'nOptDecimalShow'   => $nOptDecimalShow
		    );
            $this->load->view('ticketnew/ticketbchloc/wTicketbchlocAdd', $aDataEdit);
        }

        // Functionality : Event add data
        // Parameters : -
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKBchLocEventAdd(){
            try {
                $tIsAutoGenCode = $this->input->post('ocbTCKBchLocAutoGenCode');
                $tBchLocName    = $this->input->post('oetTCKBchLocName');
                $tAgnCode       = $this->input->post('ohdTCKBchLocAgnCode');
                $tBchCode       = $this->input->post('ohdTCKBchLocBchCode');
                $nCapacity      = !empty($this->input->post('onbTCKBchLocCapacity')) ? $this->input->post('onbTCKBchLocCapacity') : 0;
                $tStaAlwPet     = ($this->input->post('ocbTCKBchLocStaAlwPet') == '1') ? '1' : '2';
                $tStaAlwBook    = ($this->input->post('ocbTCKBchLocStaAlwBook')== '1') ? '1' : '2';
                $tStaUse        = ($this->input->post('ocbTCKBchLocStaUse') == '1') ? '1' : '2';

                $tBchLocCode = "";
                if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){
                    $aStoreParam = array(
                        "tTblName"   => 'TTKMBchLocation',                           
                        "tDocType"   => 0,                                          
                        "tBchCode"   => "",                                 
                        "tShpCode"   => "",                               
                        "tPosCode"   => "",                     
                        "dDocDate"   => date("Y-m-d")
                    );
                    $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
                    $tBchLocCode = $aAutogen[0]["FTXxhDocNo"];
                }else{
                    $tBchLocCode = $this->input->post('oetTCKBchLocCode');
                }

                if(isset($tBchCode) && !empty($tBchCode)){
                    if($this->session->userdata("tSesUsrLevel") != 'HQ'){
                        $tAgnCode = $this->session->userdata('tSesUsrAgnCode');
                    }else{
                        $aAgnCode = $this->Ticketbchloc_model->FSaMTCKBchLocGetAgn($tBchCode);
                        $tAgnCode = $aAgnCode['raItem']['FTAgnCode'];
                    }
                }
                
                $aDataMaster = array(
                    'FTAgnCode'         => $tAgnCode,
                    'FTBchCode'         => $tBchCode,
                    'FTLocCode'         => $tBchLocCode,
                    'FTLocName'         => $tBchLocName,
                    'FTLocStaAlwPet'    => $tStaAlwPet,
                    'FTLocStaAlwBook'   => $tStaAlwBook,
                    'FCLocCapacity'     => $nCapacity,
                    'FTLocStaUse'       => $tStaUse,
                    'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'        => date('Y-m-d H:i:s'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                    'FNLngID'           => $this->session->userdata("tLangEdit")
                );

                $oCountDup  = $this->Ticketbchloc_model->FSaMTCKBchLocCheckDuplicate($aDataMaster['FTLocCode']);
                $nStaDup    = $oCountDup['rtCountData'];
                if($nStaDup == 0){
                    $this->db->trans_begin();
                    $aStaMaster = $this->Ticketbchloc_model->FSaMTCKBchLocAddUpdateMaster($aDataMaster);
                    $aStaLang   = $this->Ticketbchloc_model->FSaMTCKBchLocAddUpdateLang($aDataMaster);
                    if($this->db->trans_status() === false){
                        $this->db->trans_rollback();
                        $aReturnData = array(
                            'nStaEvent'    => '900',
                            'tStaMessg'    => "Unsuccess Add Event"
                        );
                    } else {
                        $this->db->trans_commit();
                        // Input Image 
                        $tBchLocImageOld	= trim($this->input->post('oetImgInputbranchlocationOld'));
                        $tBchLocImage		= trim($this->input->post('oetImgInputbranchlocation'));
                        if($tBchLocImage != $tBchLocImageOld){
                            $aImageUplode = array(
                                'tModuleName'       => 'ticket',
                                'tImgFolder'        => 'branchlocation',
                                'tImgRefID'         => $aDataMaster['FTLocCode'],
                                'tImgObj'           => $tBchLocImage,
                                'tImgTable'         => 'TTKMBchLocation',
                                'tTableInsert'      => 'TCNMImgObj',
                                'tImgKey'           => 'master',
                                'dDateTimeOn'       => date('Y-m-d H:i:s'),
                                'tWhoBy'            => $this->session->userdata('tSesUsername'),
                                'nStaDelBeforeEdit' => 1
                            );
                            $aImgReturn = FCNnHAddImgObj($aImageUplode);
                        }
                        $aReturnData = array(
                            'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                            'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                            'tCodeReturn'	=> $aDataMaster['FTLocCode'],
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
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKBchLocEventEdit(){
            try {
                $tBchLocCode    = $this->input->post('oetTCKBchLocCode');
                $tBchLocName    = $this->input->post('oetTCKBchLocName');
                $tBchCode       = $this->input->post('ohdTCKBchLocBchCode');
                $nCapacity      = !empty($this->input->post('onbTCKBchLocCapacity')) ? $this->input->post('onbTCKBchLocCapacity') : 0;
                $tStaAlwPet     = ($this->input->post('ocbTCKBchLocStaAlwPet') == '1') ? '1' : '2';
                $tStaAlwBook    = ($this->input->post('ocbTCKBchLocStaAlwBook')== '1') ? '1' : '2';
                $tStaUse        = ($this->input->post('ocbTCKBchLocStaUse') == '1') ? '1' : '2';
                
                $tAgnCode ="";
                if($this->session->userdata("tSesUsrLevel") != 'HQ'){
                    $tAgnCode = $this->session->userdata('tSesUsrAgnCode');
                }else{
                    $aAgnCode = $this->Ticketbchloc_model->FSaMTCKBchLocGetAgn($tBchCode);
                    $tAgnCode = $aAgnCode['raItem']['FTAgnCode'];
                }

                $aDataMaster = array(
                    'FTAgnCode'         => $tAgnCode,
                    'FTBchCode'         => $tBchCode,
                    'FTLocCode'         => $tBchLocCode,
                    'FTLocName'         => $tBchLocName,
                    'FTLocStaAlwPet'    => $tStaAlwPet,
                    'FTLocStaAlwBook'   => $tStaAlwBook,
                    'FCLocCapacity'     => $nCapacity,
                    'FTLocStaUse'       => $tStaUse,
                    'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FNLngID'           => $this->session->userdata("tLangEdit")
                );

                $this->db->trans_begin();
                $aStaMaster = $this->Ticketbchloc_model->FSaMTCKBchLocAddUpdateMaster($aDataMaster);
                $aStaLang   = $this->Ticketbchloc_model->FSaMTCKBchLocAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsuccess Edit Event"
                    );
                }else{
                    $this->db->trans_commit();
                    // Input Image 
                    $tBchLocImageOld	= trim($this->input->post('oetImgInputbranchlocationOld'));
                    $tBchLocImage		= trim($this->input->post('oetImgInputbranchlocation'));
                    if($tBchLocImage != $tBchLocImageOld){
                        $aImageUplode = array(
                            'tModuleName'       => 'ticket',
                            'tImgFolder'        => 'branchlocation',
                            'tImgRefID'         => $aDataMaster['FTLocCode'],
                            'tImgObj'           => $tBchLocImage,
                            'tImgTable'         => 'TTKMBchLocation',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'master',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        );
                        $aImgReturn = FCNnHAddImgObj($aImageUplode);
                    }
                    $aReturnData = array(
                        'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTLocCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Update Event'
                    );
                }
            }catch (Exception $Error) {
                return $Error;
            }
            echo json_encode($aReturnData);
        }

        // Functionality : Event delete data
        // Parameters : -
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKBchLocEventDelete(){
            $tIDCode = $this->input->post('tIDCode');
            $aDataMaster = array(
                'FTLocCode' => $tIDCode
            );
            $aResDel   = $this->Ticketbchloc_model->FSaMTCKBchLocDel($aDataMaster);
            $aDeleteImage = array(
                'tModuleName'  => 'ticket',
                'tImgFolder'   => 'branchlocation',
                'tImgRefID'    => $tIDCode,
                'tTableDel'    => 'TCNMImgObj',
                'tImgTable'    => 'TTKMBchLocation',
            );
            $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
            if($nStaDelImgInDB == 1){
                FSnHDeleteImageFiles($aDeleteImage);
            }
            echo json_encode($aResDel);	
        }
    }

?>