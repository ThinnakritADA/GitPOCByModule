<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class TicketLocGate_model extends CI_Model {

    //Functionality : list Localtion Gate
    //Parameters : function parameters
    //Creator :  20/04/2023 Intouch(NEW)
    //Return : data
    //Return Type : Array
    public function FSaMGTEList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtGteCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        GTE.FTGteCode   AS rtGteCode,
                                        GTE_L.FTGteName AS rtGteName,
                                        GTE.FDCreateOn
                                    FROM TTKMLocGate GTE WITH(NOLOCK)
                                    LEFT JOIN TTKMLocGate_L GTE_L WITH(NOLOCK) ON GTE.FTGteCode = GTE_L.FTGteCode AND GTE_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND UPPER(GTE.FTGteCode) LIKE UPPER('%$tSearchList%') OR UPPER(GTE_L.FTGteName) LIKE UPPER('%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMGTEGetPageAll($tSearchList,$nLngID);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            }else{
                //No Data
                $aResult = array(
                    'rnAllRow' => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage"=> 0,
                    'rtCode' => '800',
                    'rtDesc' => 'data not found',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : All Page Of Localtion Gate
    //Parameters : function parameters
    //Creator :  20/04/2023 Intouch(NEW)
    //Return : object Count All Localtion Gate
    //Return Type : Object
    public function FSoMGTEGetPageAll($ptSearchList,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (GTE.FTGteCode) AS counts
                     FROM TTKMLocGate GTE WITH(NOLOCK)
                     LEFT JOIN TTKMLocGate_L GTE_L WITH(NOLOCK) ON GTE.FTGteCode = GTE_L.FTGteCode AND GTE_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (GTE.FTGteCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR GTE_L.FTGteName  LIKE '%$ptSearchList%')";
            }
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Get Data Localtion Gate By ID
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : data
    //Return Type : Array
    public function FSaMGTEGetDataByID($paData){
        try{
            $tGateCode   = $paData['FTGteCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                GTE.FTGteCode   AS rtGteCode,
                                GTE_L.FTGteName AS rtGteName,
                                GTE_L.FTGteRmk  AS rtGteRmk
                            FROM TTKMLocGate GTE WITH(NOLOCK)
                            LEFT JOIN TTKMLocGate_L GTE_L WITH(NOLOCK) ON GTE.FTGteCode = GTE_L.FTGteCode AND GTE_L.FNLngID = $nLngID 
                            WHERE 1=1 AND GTE.FTGteCode = '$tGateCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDetail = $oQuery->row_array();
                $aResult = array(
                    'raItems'   => $aDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'Data not found.',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Checkduplicate LocaltionGate
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : data
    //Return Type : Array
    public function FSnMGTECheckDuplicate($ptGateCode){
        $tSQL = "SELECT COUNT(GTE.FTGteCode) AS counts
                 FROM TTKMLocGate GTE WITH(NOLOCK)
                 WHERE GTE.FTGteCode = '$ptGateCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update LocaltionGate (TTKMLocGate)
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMGTEAddUpdateMaster($paDataLocaltionGate){
        try{
            $tSQLUpdate =  "UPDATE TTKMLocGate
                            SET
                                FDLastUpdOn    = GETDATE(),
                                FTLastUpdBy    = '".$paDataLocaltionGate['FTLastUpdBy']."'
                            WHERE 1=1 
                            AND FTGteCode = '".$paDataLocaltionGate['FTGteCode']."'
            ";
            $oQueryUpdate   = $this->db->query($tSQLUpdate);

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update LocaltionGate Success',
                );
            }else{
                //Add TTKMLocGate
                $tSQLInsert = " INSERT INTO TTKMLocGate (FTGteCode,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy)
                                VALUES (
                                    '".$paDataLocaltionGate['FTGteCode']."',
                                    GETDATE(),
                                    '".$this->session->userdata('tSesUsername')."',
                                    GETDATE(),
                                    '".$this->session->userdata('tSesUsername')."'
                                )
                ";
                $oQueryInsert   = $this->db->query($tSQLInsert);
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add LocaltionGate Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit LocaltionGate.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update LocaltionGate (TTKMLocGate_L)
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMGTEAddUpdateLang($paDataLocaltionGate){
        try{
            //Update LocaltionGate Lang
            $this->db->where('FNLngID', $paDataLocaltionGate['FNLngID']);
            $this->db->where('FTGteCode', $paDataLocaltionGate['FTGteCode']);
            $this->db->update('TTKMLocGate_L',array(
                'FTGteName' => $paDataLocaltionGate['FTGteName'],
                'FTGteRmk'  => $paDataLocaltionGate['FTGteRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update LocaltionGate Lang Success.',
                );
            }else{
                //Add LocaltionGate Lang
                $this->db->insert('TTKMLocGate_L', array(
                    'FTGteCode' => $paDataLocaltionGate['FTGteCode'],
                    'FNLngID'   => $paDataLocaltionGate['FNLngID'],
                    'FTGteName' => $paDataLocaltionGate['FTGteName'],
                    'FTGteRmk'  => $paDataLocaltionGate['FTGteRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add LocaltionGate Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit LocaltionGate Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete LocaltionGate
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Status Delete
    //Return Type : array
    public function FSaMGTEDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTGteCode', $paData['FTGteCode']);
            $this->db->delete('TTKMLocGate');

            $this->db->where_in('FTGteCode', $paData['FTGteCode']);
            $this->db->delete('TTKMLocGate_L');

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Delete Unsuccess.',
                );
            }else{
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Success.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

}