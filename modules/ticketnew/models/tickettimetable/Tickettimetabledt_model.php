<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Tickettimetabledt_model extends CI_Model {

        // Functionality : Get Data List
        // Parameters : -
        // Creater : 09/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKTimeTbDTDataList($paDataWhere){
            $tSQL = " 
                SELECT
                    ROW_NUMBER() OVER(ORDER BY TmeDT.FDCreateOn ASC) AS FNRowID,
                    TmeDT.FTTmeCode,
                    TmeDT.FNTmeSeqNo,
                    TmeDT.FTTmeCheckIn,
                    TmeDT.FTTmeStartTime,
                    TmeDT.FTTmeEndTime
                FROM TTKMTimeTableDT TmeDT WITH(NOLOCK)
                WHERE 1=1
                AND TmeDT.FTTmeCode = '".$paDataWhere['ptTmeCode']."'
            ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $oDataList = $oQuery->result_array();
                $aResult = array(
                    'raItems'   => $oDataList,
                    'rtCode'    => '1',
                    'rtDesc'    => 'Success',
                );
            }else{
                $aResult = array(
                    'rtCode'    => '800',
                    'rtDesc'    => 'Data not found',
                );
            }

            unset($oQuery);
            unset($oDataList);
            return $aResult;
        }
        
        // Functionality : Event add data
        // Parameters : -
        // Creater : 09/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKTimeTbDTAddData($paDataDT){
            try{
                $this->db->insert('TTKMTimeTableDT', array(
                    'FTTmeCode'     => $paDataDT['FTTmeCode'],
                    'FNTmeSeqNo'    => '',
                    'FTTmeCheckIn'  => $paDataDT['FTTmeCheckIn'],
                    'FTTmeStartTime'=> $paDataDT['FTTmeStartTime'],
                    'FTTmeEndTime'  => $paDataDT['FTTmeEndTime'],
                    'FDLastUpdOn'   => $paDataDT['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataDT['FTLastUpdBy'],
                    'FDCreateOn'    => $paDataDT['FDCreateOn'],
                    'FTCreateBy'    => $paDataDT['FTCreateBy']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add Master.',
                    );
                }
                return $aStatus;
            }catch(Exception $Error){
                return $Error;
            }
        }

        // Functionality : Update Seq Time table DT
        // Parameters : -
        // Creater : 09/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKTimeTbDTUpdateSeq($paDataDT){
            $tSql   = "
                UPDATE TimeDT1
				SET TimeDT1.FNTmeSeqNo = TimeDT2.FNRowID
				FROM TTKMTimeTableDT AS TimeDT1 WITH(NOLOCK)
				INNER JOIN (
					SELECT
						ROW_NUMBER() OVER(ORDER BY FDCreateOn ASC) AS FNRowID,
						FTTmeCode,
						FNTmeSeqNo
					FROM TTKMTimeTableDT WITH(NOLOCK)
					WHERE 1=1
					AND FTTmeCode = '".$paDataDT['FTTmeCode']."'
				) AS TimeDT2
				ON 1=1
				AND TimeDT1.FTTmeCode = TimeDT2.FTTmeCode
				AND TimeDT1.FNTmeSeqNo = TimeDT2.FNTmeSeqNo
            ";
            $oQuery = $this->db->query($tSql);

            unset($tSql);
            unset($oQuery);
            return;
        }

        // Functionality : Event delete data
        // Parameters : -
        // Creater : 09/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKTimeTbDTDeleteData($paDataDT){
            $tSql = " DELETE
                FROM TTKMTimeTableDT
                WHERE 1=1
                    AND FTTmeCode = '".$paDataDT['FTTmeCode']."'
                    AND FNTmeSeqNo = '".$paDataDT['FNTmeSeqNo']."'
            ";
            $oQuery = $this->db->query($tSql);
            
            unset($tSql);
            unset($oQuery);
            return;
        }
    }
?>