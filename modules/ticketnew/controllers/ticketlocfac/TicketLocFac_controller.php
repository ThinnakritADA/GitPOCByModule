<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class TicketLocFac_controller extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('ticketnew/ticketlocfac/TicketLocFac_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nFacBrowseType,$tFacBrowseOption){

        $nMsgResp   = array('title'=>"TicketLocationFac");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $vBtnSave       = FCNaHBtnSaveActiveHTML('ticketLocFac/0/0');
        $aAlwEventFac   = FCNaHCheckAlwFunc('ticketLocFac/0/0');
        $this->load->view('ticketnew/ticketlocfac/wTicketLocFac', array(
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nFacBrowseType'    => $nFacBrowseType,
            'tFacBrowseOption'  => $tFacBrowseOption
        ));
    }

    //Functionality : Function Call LocaltionFac Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : String View
    //Return Type : View
    public function FSvCFACListPage(){ 
        $this->load->view('ticketnew/ticketlocfac/wTicketLocFacList');
    }

    
    //Functionality : Function Call DataTables LocaltionFac
    //Parameters : Ajax Call View DataTable
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : String View
    //Return Type : View
    public function FSvCFACDataList(){
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
            $aFacDataList   = $this->TicketLocFac_model->FSaMFACList($aData); 
            $aGenTable  = array(
                'aFacDataList'  => $aFacDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll
            );
            $this->load->view('ticketnew/ticketlocfac/wTicketLocFacDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage LocaltionFac
    //Parameters : Ajax Call View Add
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : String View
    //Return Type : View
    public function FSvCFACAddPage(){
        try{
            $aDataLocaltionFac = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('ticketnew/ticketlocfac/wTicketLocFacAdd',$aDataLocaltionFac);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage LocaltionFac Edits
    //Parameters : Ajax Call View Add
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : String View
    //Return Type : View
    public function FSvCFACEditPage(){
        try{
            $tFacCode       = $this->input->post('tFacCode');
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
                'FTFacCode' => $tFacCode,
                'FNLngID'   => $nLangEdit
            );
                                                
            $aFacData       = $this->TicketLocFac_model->FSaMFACGetDataByID($aData);
            $aDataLocaltionFac   = array(
                'nStaAddOrEdit' => 1,
                'aFacData'      => $aFacData
            );
            $this->load->view('ticketnew/ticketlocfac/wTicketLocFacAdd',$aDataLocaltionFac);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add LocaltionFac
    //Parameters : Ajax Event
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCFACAddEvent(){ 
        try{
            $aDataLocaltionFac   = array(
                'tIsAutoGenCode' => $this->input->post('ocbFacAutoGenCode'),
                'FTFacCode'      => $this->input->post('oetFacCode'),
                'FTFacName'      => $this->input->post('oetFacName'),
                'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'        => $this->session->userdata("tLangEdit"),
                'FTFacStaAlwUse' => (!empty($this->input->post('ocbFacStatusUse'))) ? 1 : 2,
            );

            // Check Auto Gen Department Code? 15/05/2020 Saharat(Golf)
            if($aDataLocaltionFac['tIsAutoGenCode'] == '1'){ 
                $aStoreParam = array(
                    "tTblName"   => 'TTKMLocFacility',                           
                    "tDocType"   => 0,                                          
                    "tBchCode"   => "",                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataLocaltionFac['FTFacCode']   = $aAutogen[0]["FTXxhDocNo"];
            }
            $oCountDup      = $this->TicketLocFac_model->FSnMFACCheckDuplicate($aDataLocaltionFac['FTFacCode']);
            $nStaDup        = $oCountDup['counts'];

            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaFacMaster  = $this->TicketLocFac_model->FSaMFACAddUpdateMaster($aDataLocaltionFac);
                $aStaFacLang    = $this->TicketLocFac_model->FSaMFACAddUpdateLang($aDataLocaltionFac);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add LocaltionFac"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataLocaltionFac['FTFacCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add LocaltionFac'
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


    //Functionality : Event Edit LocaltionFac
    //Parameters : Ajax Event
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCFACEditEvent(){ 
        try{
            $this->db->trans_begin();
            $aDataLocaltionFac   = array(
                'FTFacCode'      => $this->input->post('oetFacCode'),
                'FTFacName'      => $this->input->post('oetFacName'),
                'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'        => $this->session->userdata("tLangEdit"),
                'FTFacStaAlwUse' => (!empty($this->input->post('ocbFacStatusUse'))) ? 1 : 2,
            );

            $aStaFacMaster  = $this->TicketLocFac_model->FSaMFACAddUpdateMaster($aDataLocaltionFac);
            $aStaFacLang    = $this->TicketLocFac_model->FSaMFACAddUpdateLang($aDataLocaltionFac);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit LocaltionFac"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataLocaltionFac['FTFacCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit LocaltionFac'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete LocaltionFac
    //Parameters : Ajax jReason()
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCFACDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTFacCode' => $tIDCode
        );
        $aResDel    = $this->TicketLocFac_model->FSaMFACDelAll($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

}