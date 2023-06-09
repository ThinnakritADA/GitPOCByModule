<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class TicketLocLevel_model extends CI_Model {

    //Functionality : list Localtion Level
    //Parameters : function parameters
    //Creator :  20/04/2023 Intouch(NEW)
    //Return : data
    //Return Type : Array
    public function FSaMLEVList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtLevCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        LEV.FTLevCode   AS rtLevCode,
                                        LEV_L.FTLevName AS rtLevName,
                                        LEV.FDCreateOn
                                    FROM TTKMLocLev LEV WITH(NOLOCK)
                                    LEFT JOIN TTKMLocLev_L LEV_L WITH(NOLOCK) ON LEV.FTLevCode = LEV_L.FTLevCode AND LEV_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND LEV.FTLevCode COLLATE THAI_BIN LIKE '%$tSearchList%'  OR LEV_L.FTLevName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMLEVGetPageAll($tSearchList,$nLngID);
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

    //Functionality : All Page Of Localtion Level
    //Parameters : function parameters
    //Creator :  20/04/2023 Intouch(NEW)
    //Return : object Count All Localtion Level
    //Return Type : Object
    public function FSoMLEVGetPageAll($ptSearchList,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (LEV.FTLevCode) AS counts
                     FROM TTKMLocLev LEV WITH(NOLOCK)
                     LEFT JOIN TTKMLocLev_L LEV_L WITH(NOLOCK) ON LEV.FTLevCode = LEV_L.FTLevCode AND LEV_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (LEV.FTLevCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR LEV_L.FTLevName  LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data Localtion Level By ID
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : data
    //Return Type : Array
    public function FSaMLEVGetDataByID($paData){
        try{
            $tLevCode   = $paData['FTLevCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                LEV.FTLevCode   AS rtLevCode,
                                LEV_L.FTLevName AS rtLevName,
                                LEV_L.FTLevRmk  AS rtLevRmk
                            FROM TTKMLocLev LEV WITH(NOLOCK)
                            LEFT JOIN TTKMLocLev_L LEV_L WITH(NOLOCK) ON LEV.FTLevCode = LEV_L.FTLevCode AND LEV_L.FNLngID = $nLngID 
                            WHERE 1=1 AND LEV.FTLevCode = '$tLevCode' ";
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

    //Functionality : Checkduplicate LocaltionLevel
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : data
    //Return Type : Array
    public function FSnMLEVCheckDuplicate($ptLevCode){
        $tSQL = "SELECT COUNT(LEV.FTLevCode) AS counts
                 FROM TTKMLocLev LEV WITH(NOLOCK)
                 WHERE LEV.FTLevCode = '$ptLevCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update LocaltionLevel (TTKMLocLev)
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMLEVAddUpdateMaster($paDataLocaltionLevel){
        try{
            $tSQLUpdate =  "UPDATE TTKMLocLev
                            SET
                                FDLastUpdOn    = GETDATE(),
                                FTLastUpdBy    = '".$paDataLocaltionLevel['FTLastUpdBy']."'
                            WHERE 1=1 
                            AND FTLevCode = '".$paDataLocaltionLevel['FTLevCode']."'
            ";
            $oQueryUpdate   = $this->db->query($tSQLUpdate);

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update LocaltionLevel Success',
                );
            }else{
                //Add TTKMLocLev
                $tSQLInsert = " INSERT INTO TTKMLocLev (FTLevCode,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy)
                                VALUES (
                                    '".$paDataLocaltionLevel['FTLevCode']."',
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
                        'rtDesc' => 'Add LocaltionLevel Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit LocaltionLevel.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update LocaltionLevel (TTKMLocLev_L)
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMLEVAddUpdateLang($paDataLocaltionLevel){
        try{
            //Update LocaltionLevel Lang
            $this->db->where('FNLngID', $paDataLocaltionLevel['FNLngID']);
            $this->db->where('FTLevCode', $paDataLocaltionLevel['FTLevCode']);
            $this->db->update('TTKMLocLev_L',array(
                'FTLevName' => $paDataLocaltionLevel['FTLevName'],
                'FTLevRmk'  => $paDataLocaltionLevel['FTLevRmk']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update LocaltionLevel Lang Success.',
                );
            }else{
                //Add LocaltionLevel Lang
                $this->db->insert('TTKMLocLev_L', array(
                    'FTLevCode' => $paDataLocaltionLevel['FTLevCode'],
                    'FNLngID'   => $paDataLocaltionLevel['FNLngID'],
                    'FTLevName' => $paDataLocaltionLevel['FTLevName'],
                    'FTLevRmk'  => $paDataLocaltionLevel['FTLevRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add LocaltionLevel Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit LocaltionLevel Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete LocaltionLevel
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Status Delete
    //Return Type : array
    public function FSaMLEVDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTLevCode', $paData['FTLevCode']);
            $this->db->delete('TTKMLocLev');

            $this->db->where_in('FTLevCode', $paData['FTLevCode']);
            $this->db->delete('TTKMLocLev_L');

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