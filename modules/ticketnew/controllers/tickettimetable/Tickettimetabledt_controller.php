
<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Tickettimetabledt_controller extends MX_Controller {
        
        public function __construct() {
            parent::__construct ();
            $this->load->model('ticketnew/tickettimetable/Tickettimetabledt_model');
            date_default_timezone_set("Asia/Bangkok");
        }
        
        // Functionality : Call page list data
        // Parameters : -
        // Creater : 09/05/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKTimeTbDTData(){
            $aAlwEventTimeTb = FCNaHCheckAlwFunc('ticketTimeTable/0/0');
            $tTmeCode = $this->input->post('ptTmeCode');
            $aGenTable = array(
                'aAlwEventTimeTb' => $aAlwEventTimeTb,
                'tTmeCode' => $tTmeCode
            );
            $this->load->view('ticketnew/tickettimetable/timetabledt/wTickettimetableDTData', $aGenTable);
        }

        // Functionality : Call data table
        // Parameters : -
        // Creater : 09/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKTimeTbDTDataTable(){
            try {
                $tTmeCode   = $this->input->post('ptTmeCode');

                $aDataWhere = array(
                    'ptTmeCode' => $tTmeCode
                );

                $aDataList = $this->Tickettimetabledt_model->FSaMTCKTimeTbDTDataList($aDataWhere);
                $aGenTable = array(
                    'aDataList' => $aDataList
                );
                $oTCKTimeTbDTDataList = $this->load->view('ticketnew/tickettimetable/timetabledt/wTickettimetableDTDataTable', $aGenTable, true);
                $aReturnData = array(
                    'oTCKTimeTbDTDataList' => $oTCKTimeTbDTDataList,
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
        // Creater : 09/05/2023 Papitchaya
        // Last Update: -
        // Return : View
        public function FSvCTCKTimeTbDTPageAdd(){
            $tTmeCode = $this->input->post('ptTmeCode');
            $aDataViewAdd = array(
                'nStaCallView'  => 1, // 1 = Call View Add , 2 = Call View Edits
                'tTmeCode'      => $tTmeCode
            );
            $this->load->view('ticketnew/tickettimetable/timetabledt/wTickettimetableDTViewForm', $aDataViewAdd);
        }

        // Functionality : Event add data
        // Parameters : -
        // Creater : 09/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKTimeTbDTEventAdd(){
            try{
                $tTmeCode   = $this->input->post("ohdTimeTbDTTmeCode");
                $tCheckIn   = $this->input->post("oetTCKTimeTbDTChackIn");
                $tStartTime = $this->input->post("oetTCKTimeTbDTStartTime");
                $tEndTime   = $this->input->post("oetTCKTimeTbDTEndTime");

                if($tCheckIn = ""){
                    $tCheckIn = $tStartTime;
                }

                $aDataDT = array(
                    'FTTmeCode'     => $tTmeCode,
                    'FTTmeCheckIn'  => $tCheckIn,
                    'FTTmeStartTime'=> $tStartTime,
                    'FTTmeEndTime'  => $tEndTime,
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'    => date('Y-m-d H:i:s'),
                    'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                );

                $this->db->trans_begin();
                $this->Tickettimetabledt_model->FSaMTCKTimeTbDTAddData($aDataDT);
                $this->Tickettimetabledt_model->FSaMTCKTimeTbDTUpdateSeq($aDataDT);
                if($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent' => 500,
                        'tStaMessg' => "Error Unsuccess Add Address."
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturnData = array(
                        'tDataCodeReturn'   => $aDataDT['FTTmeCode'],
                        'nStaReturn'        => 1,
                        'tStaMessg'         => 'Success Add Address.'
                    );
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
        // Creater : 09/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaCTCKTimeTbDTEventDelete(){
            try{
                $aDataDT = array(
                    'FTTmeCode'  => $this->input->post('FTTmeCode'),
                    'FNTmeSeqNo' => $this->input->post('FNTmeSeqNo'),
                );

                $this->db->trans_begin();
                $this->Tickettimetabledt_model->FSaMTCKTimeTbDTDeleteData($aDataDT);
                $this->Tickettimetabledt_model->FSaMTCKTimeTbDTUpdateSeq($aDataDT);
                if($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaReturn'    => 500,
                        'tStaMessg'     => "Error Unsucess Delete Address."
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturnData = array(
                        'tDataCodeReturn'   => $aDataDT['FTTmeCode'],
                        'nStaReturn'        => 1,
                        'tStaMessg'         => 'Success Delete Address.',
                    );
                }
            } catch(Exception $Error) {
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => $Error->getMessage()
                );
            }
            echo json_encode($aReturnData);
        }
    }
?>