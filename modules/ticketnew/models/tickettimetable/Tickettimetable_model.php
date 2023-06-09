<?php defined('BASEPATH') or exit('No direct script access allowed');

    class Tickettimetable_model extends CI_Model {

        // Functionality : Get Data Table List
        // Parameters : -
        // Creater : 08/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKTimeTbGetDataTableList($paDataCondition){
            $aRowLen        = FCNaHCallLenData($paDataCondition['nRow'], $paDataCondition['nPage']);
            $nLngID         = $paDataCondition['nLngID'];
            $tSearchList    = $paDataCondition['tSearchAll'];

            $tSql = "
                SELECT c.*
                    FROM (
                        SELECT DISTINCT
                            ROW_NUMBER() OVER(ORDER BY TimeHD.FDCreateOn DESC) AS FNRowID,
                            TimeHD.FTTmeCode,
                            TimeHD_L.FTTmeName,
                            TimeHD.FTTmeStaActive
                        FROM TTKMTimeTableHD		TimeHD		WITH(NOLOCK)
                        LEFT JOIN TTKMTimeTableHD_L TimeHD_L	WITH(NOLOCK) ON TimeHD.FTTmeCode = TimeHD_L.FTTmeCode AND TimeHD_L.FNLngID = $nLngID
                        WHERE 1=1
            ";

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSql .= " AND (TimeHD.FTTmeCode COLLATE THAI_BIN LIKE '%$tSearchList%' ";
                $tSql .= " OR TimeHD_L.FTTmeName COLLATE THAI_BIN LIKE '%$tSearchList%') ";
            }

            $tSql .= " ) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

            $oQuery = $this->db->query($tSql);
            if ($oQuery->num_rows() > 0) {
                $oDataList          = $oQuery->result_array();
                $aDataCountAllRow   = $this->FSaMTCKTimeTbGetPageAll($tSearchList, $nLngID);
                $nFoundRow          = ($aDataCountAllRow['rtCode'] == '1') ? $aDataCountAllRow['rtCountData'] : 0;
                $nPageAll           = ceil($nFoundRow/$paDataCondition['nRow']);
                $aResult            = array(
                    'raItems'       => $oDataList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paDataCondition['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'Success',
                );
            } else {
                $aResult            = array(
                    'rnAllRow'      => 0,
                    'rnCurrentPage' => $paDataCondition['nPage'],
                    "rnAllPage"     => 0,
                    'rtCode'        => '800',
                    'rtDesc'        => 'Data not found',
                );
            }
            unset($oQuery);
            unset($oDataList);
            unset($aDataCountAllRow);
            unset($nFoundRow);
            unset($nPageAll);
            return $aResult;
        }

        // Functionality : Get Page All
        // Parameters : -
        // Creater : 08/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKTimeTbGetPageAll($ptSearchList, $pnLngID){
            $nLngID         = $pnLngID;
            $tSearchList    = $ptSearchList;

            $tSql = "
                SELECT 
                    COUNT(TimeHD.FTTmeCode) AS counts 
                FROM TTKMTimeTableHD		TimeHD		WITH(NOLOCK)
                LEFT JOIN TTKMTimeTableHD_L TimeHD_L	WITH(NOLOCK) ON TimeHD.FTTmeCode = TimeHD_L.FTTmeCode AND TimeHD_L.FNLngID = $nLngID
                WHERE 1=1
            ";

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSql .= " AND (TimeHD.FTTmeCode COLLATE THAI_BIN LIKE '%$tSearchList%' ";
                $tSql .= " OR TimeHD_L.FTTmeName COLLATE THAI_BIN LIKE '%$tSearchList%') ";
            }

            $oQuery = $this->db->query($tSql);
            if($oQuery->num_rows() > 0) {
                $aDetail        = $oQuery->row_array();
                $aDataReturn    = array(
                    'rtCountData'   => $aDetail['counts'],
                    'rtCode'        => '1',
                    'rtDesc'        => 'Success',
                );
            } else {
                $aDataReturn    =  array(
                    'rtCountData'   => '0',
                    'rtCode'        => '800',
                    'rtDesc'        => 'Data not found',
                );
            }

            unset($oQuery);
            unset($aDetail);
            return $aDataReturn;
        }

        // Functionality : Check Duplicate code
        // Parameters : -
        // Creater : 08/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKTimeTbCheckDuplicate($ptTmeCode){
            $tTmeCode = $ptTmeCode;
            $tSql = "   SELECT COUNT(FTTmeCode) AS counts
                        FROM TTKMTimeTableHD WITH(NOLOCK)
                        WHERE FTTmeCode = '$tTmeCode' ";
            $oQuery = $this->db->query($tSql);
            if($oQuery->num_rows() > 0){
                $aDetail        = $oQuery->row_array();
                $aDataReturn    = array(
                    'rtCountData'   => $aDetail['counts'],
                    'rtCode'        => '1',
                    'rtDesc'        => 'Success',
                );
            } else {
                $aDataReturn    =  array(
                    'rtCountData'   => '0',
                    'rtCode'        => '800',
                    'rtDesc'        => 'Data not found',
                );
            }
            unset($oQuery);
            unset($aDetail);
            return $aDataReturn;
        }

        // Functionality : Event Add Update Master
        // Parameters : -
        // Creater : 08/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKTimeTbAddUpdateMaster($paData){
            try{
                //Update Master
                $this->db->set('FTTmeStaActive' , $paData['FTTmeStaActive']);
                $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);

                $this->db->where('FTTmeCode' , $paData['FTTmeCode']);
                $this->db->update('TTKMTimeTableHD');
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Master Success',
                    );
                } else {
                    //Add Master
                    $this->db->insert('TTKMTimeTableHD', array(
                        'FTTmeCode'     => $paData['FTTmeCode'],
                        'FTTmeStaActive' => $paData['FTTmeStaActive'],
                        'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                        'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                        'FDCreateOn'    => $paData['FDCreateOn'],
                        'FTCreateBy'    => $paData['FTCreateBy']
                    ));
                    if($this->db->affected_rows() > 0){
                        $aStatus = array(
                            'rtCode' => '1',
                            'rtDesc' => 'Add Master Success',
                        );
                    }else{
                        $aStatus = array(
                            'rtCode' => '905',
                            'rtDesc' => 'Error Cannot Add/Edit Master.',
                        );
                    }
                }
                return $aStatus;
            } catch(Exception $Error){
                return $Error;
            }
        }

        // Functionality : Event Add Update Lang
        // Parameters : -
        // Creater : 08/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKTimeTbAddUpdateLang($paData){
            try{
                $this->db->set('FTTmeName', $paData['FTTmeName']);
                $this->db->where('FTTmeCode' , $paData['FTTmeCode']);
                $this->db->where('FNLngID', $paData['FNLngID']);
                $this->db->update('TTKMTimeTableHD_L');
                if($this->db->affected_rows() > 0 ){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Lang Success.',
                    );
                }else{
                    $this->db->insert('TTKMTimeTableHD_L', array(
                        'FTTmeCode' => $paData['FTTmeCode'],
                        'FTTmeName' => $paData['FTTmeName'],
                        'FNLngID'   => $paData['FNLngID']
                    ));if($this->db->affected_rows() > 0){
                        $aStatus = array(
                            'rtCode' => '1',
                            'rtDesc' => 'Add Lang Success',
                        );
                    }else{
                        $aStatus = array(
                            'rtCode' => '905',
                            'rtDesc' => 'Error Cannot Add/Edit Lang.',
                        );
                    }
                }
                return $aStatus;
            }catch(Exception $Error){
                return $Error;
            }
        }

        // Functionality : Get Data by ID
        // Parameters : -
        // Creater : 08/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKTimeTbSearchByID($paData){
            $tTmeCode   = $paData['ptTmeCode'];
            $nLngID     = $paData['pnLangID'];
            $tSql = "
                SELECT
	                TmeHD.FTTmeCode,
	                TmeHD_L.FTTmeName,
	                TmeHD.FTTmeStaActive
                FROM TTKMTimeTableHD TmeHD WITH(NOLOCK)
                LEFT JOIN TTKMTimeTableHD_L TmeHD_L WITH(NOLOCK) ON TmeHD.FTTmeCode = TmeHD_L.FTTmeCode AND TmeHD_L.FNLngID = $nLngID
                WHERE 1 = 1
            ";

            if(isset($tTmeCode) && !empty($tTmeCode)){
                $tSql .= " AND TmeHD.FTTmeCode = '$tTmeCode' ";
            }

            $oQuery = $this->db->query($tSql);
            if ($oQuery->num_rows() > 0) {
                $aDetail        = $oQuery->row_array();
                $aDataReturn = array(
                    'raItem'    => $aDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'Success',
                );
            }else{
                $aDataReturn = array(
                    'rtCode'    => '800',
                    'rtDesc'    => 'Data not found.',
                );
            }

            unset($oQuery);
            unset($aDetail);
            return $aDataReturn;
        }

        // Functionality : Event delete
        // Parameters : -
        // Creater : 08/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKTimeTbDel($paData){
            try {
                $this->db->trans_begin();

                $this->db->where_in('FTTmeCode', $paData['FTTmeCode']);
                $this->db->delete('TTKMTimeTableHD');

                $this->db->where_in('FTTmeCode', $paData['FTTmeCode']);
                $this->db->delete('TTKMTimeTableHD_L');

                $this->db->where_in('FTTmeCode', $paData['FTTmeCode']);
                $this->db->delete('TTKMTimeTableDT');

                $this->db->where_in('FTTmeCode', $paData['FTTmeCode']);
                $this->db->delete('TTKMTimeTableDT_L');
                
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Cannot Delete Item.',
                    );
                } else {
                    $this->db->trans_commit();
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Delete Complete.',
                    );
                }
                return $aStatus;
            } catch (Exception $Error) {
                return $Error;
            }
        }
    }

?>