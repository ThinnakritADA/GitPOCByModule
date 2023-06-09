<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class TicketLocLevel_controller extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('ticketnew/ticketloclevel/TicketLocLevel_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nLevBrowseType,$tLevBrowseOption){

        $nMsgResp   = array('title'=>"TicketLocationLevel");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $vBtnSave       = FCNaHBtnSaveActiveHTML('ticketLocLev/0/0');
        $aAlwEventLev   = FCNaHCheckAlwFunc('ticketLocLev/0/0');
        $this->load->view('ticketnew/ticketloclevel/wTicketLocLev', array(
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nLevBrowseType'    => $nLevBrowseType,
            'tLevBrowseOption'  => $tLevBrowseOption
        ));
    }

    //Functionality : Function Call LocaltionLevel Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : String View
    //Return Type : View
    public function FSvCLEVListPage(){ 
        $this->load->view('ticketnew/ticketloclevel/wTicketLocLevList');
    }
    
    //Functionality : Function Call DataTables LocaltionLevel
    //Parameters : Ajax Call View DataTable
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : String View
    //Return Type : View
    public function FSvCLEVDataList(){
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
            $aLevDataList   = $this->TicketLocLevel_model->FSaMLEVList($aData); 
            $aGenTable  = array(
                'aLevDataList'  => $aLevDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll
            );
            $this->load->view('ticketnew/ticketloclevel/wTicketLocLevDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage LocaltionLevel
    //Parameters : Ajax Call View Add
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : String View
    //Return Type : View
    public function FSvCLEVAddPage(){
        try{
            $aDataLocaltionLevel = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('ticketnew/ticketloclevel/wTicketLocLevAdd',$aDataLocaltionLevel);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage LocaltionLevel Edits
    //Parameters : Ajax Call View Add
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : String View
    //Return Type : View
    public function FSvCLEVEditPage(){
        try{
            $tLevCode       = $this->input->post('tLevCode');
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
                'FTLevCode' => $tLevCode,
                'FNLngID'   => $nLangEdit
            );
                                                
            $aLevData       = $this->TicketLocLevel_model->FSaMLEVGetDataByID($aData);
            $aDataLocaltionLevel   = array(
                'nStaAddOrEdit' => 1,
                'aLevData'      => $aLevData
            );
            $this->load->view('ticketnew/ticketloclevel/wTicketLocLevAdd',$aDataLocaltionLevel);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add LocaltionLevel
    //Parameters : Ajax Event
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCLEVAddEvent(){ 
        try{
            $aDataLocaltionLevel   = array(
                'tIsAutoGenCode' => $this->input->post('ocbLevAutoGenCode'),
                'FTLevCode'      => $this->input->post('oetLevCode'),
                'FTLevName'      => $this->input->post('oetLevName'),
                'FTLevRmk'       => $this->input->post('otaLevRmk'),
                'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'        => $this->session->userdata("tLangEdit")
            );

            // Check Auto Gen Department Code? 15/05/2020 Saharat(Golf)
            if($aDataLocaltionLevel['tIsAutoGenCode'] == '1'){ 
                $aStoreParam = array(
                    "tTblName"   => 'TTKMLocLev',                           
                    "tDocType"   => 0,                                          
                    "tBchCode"   => "",                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataLocaltionLevel['FTLevCode']   = $aAutogen[0]["FTXxhDocNo"];
            }

            $oCountDup      = $this->TicketLocLevel_model->FSnMLEVCheckDuplicate($aDataLocaltionLevel['FTLevCode']);
            $nStaDup        = $oCountDup['counts'];

            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaLevMaster  = $this->TicketLocLevel_model->FSaMLEVAddUpdateMaster($aDataLocaltionLevel);
                $aStaLevLang    = $this->TicketLocLevel_model->FSaMLEVAddUpdateLang($aDataLocaltionLevel);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add LocaltionLevel"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataLocaltionLevel['FTLevCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add LocaltionLevel'
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


    //Functionality : Event Edit LocaltionLevel
    //Parameters : Ajax Event
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCLEVEditEvent(){ 
        try{
            $this->db->trans_begin();
            $aDataLocaltionLevel   = array(
                'FTLevCode'   => $this->input->post('oetLevCode'),
                'FTLevName'   => $this->input->post('oetLevName'),
                'FTLevRmk'    => $this->input->post('otaLevRmk'),
                'FDCreateOn'  => date('Y-m-d H:i:s'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FNLngID'     => $this->session->userdata("tLangEdit")
            );
            $aStaLevMaster  = $this->TicketLocLevel_model->FSaMLEVAddUpdateMaster($aDataLocaltionLevel);
            $aStaLevLang    = $this->TicketLocLevel_model->FSaMLEVAddUpdateLang($aDataLocaltionLevel);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit LocaltionLevel"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataLocaltionLevel['FTLevCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit LocaltionLevel'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete LocaltionLevel
    //Parameters : Ajax jReason()
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCLEVDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTLevCode' => $tIDCode
        );
        $aResDel    = $this->TicketLocLevel_model->FSaMLEVDelAll($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

}