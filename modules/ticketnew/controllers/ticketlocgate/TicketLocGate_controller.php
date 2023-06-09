<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class TicketLocGate_controller extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('ticketnew/ticketlocgate/TicketLocGate_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nGateBrowseType,$tGateBrowseOption){

        $nMsgResp   = array('title'=>"TicketLocationGate");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $vBtnSave       = FCNaHBtnSaveActiveHTML('ticketLocGate/0/0');
        $aAlwEventGate   = FCNaHCheckAlwFunc('ticketLocGate/0/0');
        $this->load->view('ticketnew/ticketlocgate/wTicketLocGate', array(
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nGteBrowseType'    => $nGateBrowseType,
            'tGteBrowseOption'  => $tGateBrowseOption
        ));
    }

    //Functionality : Function Call LocaltionGate Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : String View
    //Return Type : View
    public function FSvCGTEListPage(){ 
        $this->load->view('ticketnew/ticketlocgate/wTicketLocGateList');
    }

    
    //Functionality : Function Call DataTables LocaltionGate
    //Parameters : Ajax Call View DataTable
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : String View
    //Return Type : View
    public function FSvCGTEDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );
            $aGateDataList   = $this->TicketLocGate_model->FSaMGTEList($aData); 
            $aGenTable  = array(
                'aGateDataList'  => $aGateDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll
            );
            $this->load->view('ticketnew/ticketlocgate/wTicketLocGateDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage LocaltionGate
    //Parameters : Ajax Call View Add
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : String View
    //Return Type : View
    public function FSvCGTEAddPage(){
        try{
            $aDataLocaltionGate = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('ticketnew/ticketlocgate/wTicketLocGateAdd',$aDataLocaltionGate);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage LocaltionGate Edits
    //Parameters : Ajax Call View Add
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : String View
    //Return Type : View
    public function FSvCGTEEditPage(){
        try{
            $tGateCode       = $this->input->post('tGteCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMSplType_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }

            $aData  = array(
                'FTGteCode' => $tGateCode,
                'FNLngID'   => $nLangEdit
            );
                                                
            $aGateData       = $this->TicketLocGate_model->FSaMGTEGetDataByID($aData);
            $aDataLocaltionGate   = array(
                'nStaAddOrEdit' => 1,
                'aGateData'      => $aGateData
            );
            $this->load->view('ticketnew/ticketlocgate/wTicketLocGateAdd',$aDataLocaltionGate);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add LocaltionGate
    //Parameters : Ajax Event
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCGTEAddEvent(){ 
        try{
            $aDataLocaltionGate   = array(
                'tIsAutoGenCode' => $this->input->post('ocbGteAutoGenCode'),
                'FTGteCode'      => $this->input->post('oetGteCode'),
                'FTGteName'      => $this->input->post('oetGteName'),
                'FTGteRmk'       => $this->input->post('otaGteRmk'),
                'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'        => $this->session->userdata("tLangEdit")
            );

            // Check Auto Gen Department Code? 15/05/2020 Saharat(Golf)
            if($aDataLocaltionGate['tIsAutoGenCode'] == '1'){ 
                $aStoreParam = array(
                    "tTblName"   => 'TTKMLocGate',                           
                    "tDocType"   => 0,                                          
                    "tBchCode"   => "",                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataLocaltionGate['FTGteCode']   = $aAutogen[0]["FTXxhDocNo"];
            }
            $oCountDup      = $this->TicketLocGate_model->FSnMGTECheckDuplicate($aDataLocaltionGate['FTGteCode']);
            $nStaDup        = $oCountDup['counts'];

            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaGateMaster  = $this->TicketLocGate_model->FSaMGTEAddUpdateMaster($aDataLocaltionGate);
                $aStaGateLang    = $this->TicketLocGate_model->FSaMGTEAddUpdateLang($aDataLocaltionGate);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add LocaltionGate"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataLocaltionGate['FTGteCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add LocaltionGate'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Edit LocaltionGate
    //Parameters : Ajax Event
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCGTEEditEvent(){ 
        try{
            $this->db->trans_begin();
            $aDataLocaltionGate   = array(
                'FTGteCode'   => $this->input->post('oetGteCode'),
                'FTGteName'   => $this->input->post('oetGteName'),
                'FTGteRmk'    => $this->input->post('otaGteRmk'),
                'FDCreateOn'  => date('Y-m-d H:i:s'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FNLngID'     => $this->session->userdata("tLangEdit")
            );
            $aStaGateMaster  = $this->TicketLocGate_model->FSaMGTEAddUpdateMaster($aDataLocaltionGate);
            $aStaGateLang    = $this->TicketLocGate_model->FSaMGTEAddUpdateLang($aDataLocaltionGate);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit LocaltionGate"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataLocaltionGate['FTGteCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit LocaltionGate'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete LocaltionGate
    //Parameters : Ajax jReason()
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCGTEDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTGteCode' => $tIDCode
        );
        $aResDel    = $this->TicketLocGate_model->FSaMGTEDelAll($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

}