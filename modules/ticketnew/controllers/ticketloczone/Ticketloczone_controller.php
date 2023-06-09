<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Ticketloczone_controller extends MX_Controller {

        public function __construct() {
            parent::__construct ();
            $this->load->model('ticketnew/ticketloczone/Ticketloczone_model');
            date_default_timezone_set("Asia/Bangkok");
        }

        public function index($nLocZoneBrowseType, $nLocZoneBrowseOption) {
            $nMsgResp   = array('title'=>"TicketLocationZone");
            $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
            if(!$isXHR){
                $this->load->view ( 'common/wHeader', $nMsgResp);
                $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
                $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
            }
            // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            $aAlwEventLocZone	= FCNaHCheckAlwFunc('ticketLocZone/0/0');
            $vLocZoneBtnSave	= FCNaHBtnSaveActiveHTML('ticketLocZone/0/0');
            $aDataConfigView    = array(
                'nMsgResp'              => $nMsgResp,
                'aAlwEventLocZone'	    => $aAlwEventLocZone,
                'vLocZoneBtnSave'		=> $vLocZoneBtnSave,
                'nLocZoneBrowseType'	=> $nLocZoneBrowseType,
                'nLocZoneBrowseOption'	=> $nLocZoneBrowseOption
            );
            $this->load->view ('ticketnew/ticketloczone/wTicketloczone', $aDataConfigView);
        }

        // Functionality : Call form search list
        // Parameters : -
        // Creater : 03/05/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKLocZoneFormSearchList(){
            $aAlwEventLocZone	= FCNaHCheckAlwFunc('ticketLocZone/0/0');
            $aDataConfigView    = array(
                'aAlwEventLocZone' => $aAlwEventLocZone
            );
            $this->load->view('ticketnew/ticketloczone/wTicketloczoneFormSearchList', $aDataConfigView);
        }

        // Functionality : Call data table
        // Parameters : -
        // Creater : 03/05/2023 Papitchaya
        // Last Update: -
        // Return : Array       
        public function FSaCTCKLocZoneDataTable(){
            try {
                $aAlwEventLocZone	= FCNaHCheckAlwFunc('ticketLocZone/0/0');
                $tSearchAll         = !empty($this->input->post('tSearchAll')) ? $this->input->post('tSearchAll') : '' ;
                $nPage              = !empty($this->input->post('nPageCurrent')) ? $this->input->post('nPageCurrent') : 1 ;
                $nLangEdit          = $this->session->userdata("tLangEdit");

                $aDataCondition = array(
                    'nPage'     => $nPage,
                    'nRow'      => 10,
                    'nLngID'    => $nLangEdit,
                    'tSearchAll' => $tSearchAll
                );

                $aDataList = $this->Ticketloczone_model->FSaMTCKLocZoneGetDataTableList($aDataCondition);
                $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 
                $aGenTable = array(
                    'aAlwEventLocZone' 	=> $aAlwEventLocZone,
                    'aDataList' 		=> $aDataList,
                    'nPage'    		    => $nPage,
                    'tSearchAll'    	=> $tSearchAll,
                    'nOptDecimalShow'   => $nOptDecimalShow
                );
                $oTCKLocZoneViewDataTableList = $this->load->view('ticketnew/ticketloczone/wTicketloczoneDataTable', $aGenTable, true);
                $aReturnData = array(
                    'oTCKLocZoneViewDataTableList' => $oTCKLocZoneViewDataTableList,
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
        // Creater : 03/05/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKLocZonePageAdd(){
            $aAlwEventLocZone	= FCNaHCheckAlwFunc('ticketLocZone/0/0');
            $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 
            $aDataEdit = array(
				'aResult' 			=> array('rtCode' => '99'),
				'aAlwEventLocZone' 	=> $aAlwEventLocZone,
                'nOptDecimalShow'   => $nOptDecimalShow
		    );
            $this->load->view('ticketnew/ticketloczone/wTicketloczoneAdd', $aDataEdit);
        }

        // Functionality : Call page edit
        // Parameters : -
        // Creater : 03/05/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKLocZonePageEdit(){
            $aAlwEventLocZone	= FCNaHCheckAlwFunc('ticketLocZone/0/0');
            $tZneCode           = $this->input->post('ptZneCode');
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $aDataCondition = array(
				'ptZneCode' => $tZneCode,
				'pnLangID'  => $nLangEdit,
		    );
            $aDataList = $this->Ticketloczone_model->FSaMTCKLocZoneSearchByID($aDataCondition);
            $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 
            $aDataEdit = array(
				'aResult' 			=> $aDataList,
				'aAlwEventLocZone' 	=> $aAlwEventLocZone,
                'nOptDecimalShow'   => $nOptDecimalShow
		    );
            $this->load->view('ticketnew/ticketloczone/wTicketloczoneAdd', $aDataEdit);
        }

        // Functionality : Event add data
        // Parameters : -
        // Creater : 03/05/2023 Papitchaya
        // Last Update: 29/05/2023 Papitchaya
        // Return : Array
        public function FSaCTCKLocZoneEventAdd(){
            try {
                $tIsAutoGenCode = $this->input->post('ocbTCKLocZoneAutoGenCode');
                $tZoneName  = $this->input->post('oetTCKLocZoneName');
                $nCapacity  = !empty($this->input->post('onbTCKLocZoneCapacity')) ? $this->input->post('onbTCKLocZoneCapacity') : 0;
                $tAgnCode   = !empty($this->input->post('ohdTCKLocZoneAgnCode')) ? $this->input->post('ohdTCKLocZoneAgnCode') : '';
                $tBchCode   = !empty($this->input->post('ohdTCKLocZoneBchCode')) ? $this->input->post('ohdTCKLocZoneBchCode') : '';
                $tLocCode   = !empty($this->input->post('ohdTCKLocZoneBchLocCode')) ? $this->input->post('ohdTCKLocZoneBchLocCode') : '';
                $tLevCode   = $this->input->post('ohdTCKLocZoneLevCode');
                $tGateCode  = $this->input->post('ohdTCKLocZoneGateCode');
                $tStaUse    = ($this->input->post('ocbTCKLocZoneStaUse') == '1') ? '1' : '2';

                $tZneCode = "";
                if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){
                    $aStoreParam = array(
                        "tTblName"   => 'TTKMLocZne',                           
                        "tDocType"   => 0,                                          
                        "tBchCode"   => "",                                 
                        "tShpCode"   => "",                               
                        "tPosCode"   => "",                     
                        "dDocDate"   => date("Y-m-d")
                    );
                    $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
                    $tZneCode = $aAutogen[0]["FTXxhDocNo"];
                } else {
                    $tZneCode    = $this->input->post('oetTCKLocZoneCode');
                }

                // if(isset($tBchCode) && !empty($tBchCode)){
                //     if($this->session->userdata("tSesUsrLevel") != 'HQ'){
                //         $tAgnCode = $this->session->userdata('tSesUsrAgnCode');
                //     }else{
                //         $aAgnCode = $this->Ticketloczone_model->FSaMTCKLocZoneGetAgn($tBchCode);
                //         $tAgnCode = $aAgnCode['raItem']['FTAgnCode'];
                //     }
                // }

                if(isset($tLocCode) && !empty($tLocCode)){
                    $aLocBchAgn = $this->Ticketloczone_model->FSaMTCKLocZoneGetLocBchAgn($tLocCode);
                    $tAgnCode   = $aLocBchAgn['raItem']['FTAgnCode'];
                    $tBchCode   = $aLocBchAgn['raItem']['FTBchCode'];
                }

                $tZneChain = $tAgnCode . $tBchCode . $tLocCode . $tZneCode;
                $aDataMaster = array(
                    'FTZneChain'    => $tZneChain,
                    'FTAgnCode'     => $tAgnCode,
                    'FTBchCode'     => $tBchCode,
                    'FTLocCode'     => $tLocCode,
                    'FTZneCode'     => $tZneCode,
                    'FTZneName'     => $tZoneName,
                    'FTLevCode'     => $tLevCode,
                    'FTGteCode'     => $tGateCode,
                    'FCZneCapacity' => $nCapacity,
                    'FTZneStaUse'   => $tStaUse,
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'    => date('Y-m-d H:i:s'),
                    'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                    'FNLngID'       => $this->session->userdata("tLangEdit")
                );

                $oCountDup  = $this->Ticketloczone_model->FSaMTCKLocZoneCheckDuplicate($aDataMaster['FTZneCode']);
                $nStaDup    = $oCountDup['rtCountData'];
                if($nStaDup == 0){
                    $this->db->trans_begin();
                    $aStaMaster = $this->Ticketloczone_model->FSaMTCKLocZoneAddUpdateMaster($aDataMaster);
                    $aStaLang   = $this->Ticketloczone_model->FSaMTCKLocZoneAddUpdateLang($aDataMaster);
                    if($this->db->trans_status() === false){
                        $this->db->trans_rollback();
                        $aReturnData = array(
                            'nStaEvent'    => '900',
                            'tStaMessg'    => "Unsuccess Add Event"
                        );
                    } else {
                        $this->db->trans_commit();
                        // Input Image 
                        $tLocZoneImageOld	= trim($this->input->post('oetImgInputticketloczoneOld'));
                        $tLocZoneImage		= trim($this->input->post('oetImgInputticketloczone'));
                        if($tLocZoneImage != $tLocZoneImageOld){
                            $aImageUplode = array(
                                'tModuleName'       => 'ticket',
                                'tImgFolder'        => 'ticketloczone',
                                'tImgRefID'         => $aDataMaster['FTZneCode'],
                                'tImgObj'           => $tLocZoneImage,
                                'tImgTable'         => 'TTKMLocZne',
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
                            'tCodeReturn'	=> $aDataMaster['FTZneCode'],
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
        // Creater : 03/05/2023 Papitchaya
        // Last Update: 29/05/2023 Papitchaya
        // Return : Array
        public function FSaCTCKLocZoneEventEdit(){
            try {
                $tZneChain  = $this->input->post('ohdTCKLocZoneZneChain');
                $tZneCode   = $this->input->post('oetTCKLocZoneCode');
                $tZneName   = $this->input->post('oetTCKLocZoneName');
                $nCapacity  = !empty($this->input->post('onbTCKLocZoneCapacity')) ? $this->input->post('onbTCKLocZoneCapacity') : 0;
                $tAgnCode   = !empty($this->input->post('ohdTCKLocZoneAgnCode')) ? $this->input->post('ohdTCKLocZoneAgnCode') : '';
                $tBchCode   = !empty($this->input->post('ohdTCKLocZoneBchCode')) ? $this->input->post('ohdTCKLocZoneBchCode') : '';
                $tLocCode   = !empty($this->input->post('ohdTCKLocZoneBchLocCode')) ? $this->input->post('ohdTCKLocZoneBchLocCode') : '';
                $tLevCode   = $this->input->post('ohdTCKLocZoneLevCode');
                $tGateCode  = $this->input->post('ohdTCKLocZoneGateCode');
                $tStaUse    = ($this->input->post('ocbTCKLocZoneStaUse') == '1') ? '1' : '2';

                $tZneChainOld = $tZneChain;

                // if(isset($tBchCode) && !empty($tBchCode)){
                //     if($this->session->userdata("tSesUsrLevel") != 'HQ'){
                //         $tAgnCode = $this->session->userdata('tSesUsrAgnCode');
                //     }else{
                //         $aAgnCode = $this->Ticketloczone_model->FSaMTCKLocZoneGetAgn($tBchCode);
                //         $tAgnCode = $aAgnCode['raItem']['FTAgnCode'];
                //     }
                // }

                if(isset($tLocCode) && !empty($tLocCode)){
                    $aLocBchAgn = $this->Ticketloczone_model->FSaMTCKLocZoneGetLocBchAgn($tLocCode);
                    $tAgnCode   = $aLocBchAgn['raItem']['FTAgnCode'];
                    $tBchCode   = $aLocBchAgn['raItem']['FTBchCode'];
                }

                $tZneChainOld   = $tZneChain;
                $tZneChainNew   = $tAgnCode . $tBchCode . $tLocCode . $tZneCode;

                if($tZneChainOld != $tZneChainNew) {
                    $tZneChain = $tZneChainNew;
                }

                $aDataMaster = array(
                    'FTZneChainOld' => $tZneChainOld,
                    'FTZneChainNew' => $tZneChainNew,
                    'FTZneChain'    => $tZneChain,
                    'FTAgnCode'     => $tAgnCode,
                    'FTBchCode'     => $tBchCode,
                    'FTLocCode'     => $tLocCode,
                    'FTZneCode'     => $tZneCode,
                    'FTZneName'     => $tZneName,
                    'FTLevCode'     => $tLevCode,
                    'FTGteCode'     => $tGateCode,
                    'FCZneCapacity' => $nCapacity,
                    'FTZneStaUse'   => $tStaUse,
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FNLngID'       => $this->session->userdata("tLangEdit")
                );
                
                $this->db->trans_begin();
                $aStaMaster = $this->Ticketloczone_model->FSaMTCKLocZoneAddUpdateMaster($aDataMaster);
                $aStaLang   = $this->Ticketloczone_model->FSaMTCKLocZoneAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsuccess Edit Event"
                    );
                }else{
                    $this->db->trans_commit();
                    // Input Image 
                    $tLocZoneImageOld	= trim($this->input->post('oetImgInputticketloczoneOld'));
                    $tLocZoneImage		= trim($this->input->post('oetImgInputticketloczone'));
                    if($tLocZoneImage != $tLocZoneImageOld){
                        $aImageUplode = array(
                            'tModuleName'       => 'ticket',
                            'tImgFolder'        => 'ticketloczone',
                            'tImgRefID'         => $aDataMaster['FTZneCode'],
                            'tImgObj'           => $tLocZoneImage,
                            'tImgTable'         => 'TTKMLocZne',
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
                        'tCodeReturn'	=> $aDataMaster['FTZneCode'],
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
        // Creater : 03/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKLocZoneEventDelete(){
            $tZneCode   = $this->input->post('tZneCode');
            $tZneChain  = $this->input->post('tZneChain');
            $aDataMaster = array(
                'FTZneCode'     => $tZneCode,
                'FTZneChain'    => $tZneChain
            );

            $aResDel   = $this->Ticketloczone_model->FSnMTCKLocZoneDel($aDataMaster);
            $aDeleteImage = array(
                'tModuleName'  => 'ticket',
                'tImgFolder'   => 'ticketloczone',
                'tImgRefID'    => $tZneCode,
                'tTableDel'    => 'TCNMImgObj',
                'tImgTable'    => 'TTKMLocZne',
            );
            $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
            if($nStaDelImgInDB == 1){
                FSnHDeleteImageFiles($aDeleteImage);
            }
            echo json_encode($aResDel);	
        }
    }

?>