<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class TicketLocFac_model extends CI_Model {

    //Functionality : list Localtion Fac
    //Parameters : function parameters
    //Creator :  20/04/2023 Intouch(NEW)
    //Return : data
    //Return Type : Array
    public function FSaMFACList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtFacCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        FAC.FTFacCode AS rtFacCode,
                                        FAC_L.FTFacName AS rtFacName,
                                        FAC.FTFacStaAlwUse,
                                        FAC.FDCreateOn
                                    FROM TTKMLocFacility FAC WITH(NOLOCK)
                                    LEFT JOIN TTKMLocFacility_L FAC_L WITH(NOLOCK) ON FAC_L.FTFacCode = FAC.FTFacCode AND FAC_L.FNLngID = $nLngID
                                    WHERE 1=1 ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND UPPER(FAC.FTFacCode) LIKE UPPER('%$tSearchList%') OR UPPER(FAC_L.FTFacName) LIKE UPPER('%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMFACGetPageAll($tSearchList,$nLngID);
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

    //Functionality : All Page Of Localtion Fac
    //Parameters : function parameters
    //Creator :  20/04/2023 Intouch(NEW)
    //Return : object Count All Localtion Fac
    //Return Type : Object
    public function FSoMFACGetPageAll($ptSearchList,$ptLngID){
        try{
            $tSQL = "SELECT COUNT (FAC.FTFacCode) AS counts
                     FROM TTKMLocFacility FAC WITH(NOLOCK)
                     LEFT JOIN TTKMLocFacility_L FAC_L WITH(NOLOCK) ON FAC.FTFacCode = FAC_L.FTFacCode AND FAC_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (FAC.FTFacCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR FAC_L.FTFacName  LIKE '%$ptSearchList%')";
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

    //Functionality : Get Data Localtion Fac By ID
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : data
    //Return Type : Array
    public function FSaMFACGetDataByID($paData){
        try{
            $tFacCode   = $paData['FTFacCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT
                                FAC.FTFacCode AS rtFacCode,
                                FAC_L.FTFacName AS rtFacName,
                                FAC.FTFacStaAlwUse,
                                FAC.FDCreateOn
                            FROM TTKMLocFacility FAC WITH(NOLOCK)
                            LEFT JOIN TTKMLocFacility_L FAC_L WITH(NOLOCK) ON FAC_L.FTFacCode = FAC.FTFacCode AND FAC_L.FNLngID = $nLngID
                            WHERE 1=1 AND FAC.FTFacCode = '$tFacCode' ";
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

    //Functionality : Checkduplicate LocaltionFac
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : data
    //Return Type : Array
    public function FSnMFACCheckDuplicate($ptFacCode){
        $tSQL = "SELECT COUNT(FAC.FTFacCode) AS counts
                 FROM TTKMLocFacility FAC WITH(NOLOCK)
                 WHERE FAC.FTFacCode = '$ptFacCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array();
        }else{
            return FALSE;
        }
    }

    //Functionality : Update LocaltionFac (TTKMLocFacility)
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMFACAddUpdateMaster($paDataLocaltionFac){
        try{
            $tSQLUpdate =  "UPDATE TTKMLocFacility
                            SET
                                FTFacStaAlwUse = '".$paDataLocaltionFac['FTFacStaAlwUse']."',
                                FDLastUpdOn    = GETDATE(),
                                FTLastUpdBy    = '".$paDataLocaltionFac['FTLastUpdBy']."'
                            WHERE 1=1 
                            AND FTFacCode = '".$paDataLocaltionFac['FTFacCode']."'
            ";
            $oQueryUpdate   = $this->db->query($tSQLUpdate);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update LocaltionFac Success',
                );
            }else{
                //Add TTKMLocFacility
                $tSQLInsert = " INSERT INTO TTKMLocFacility (FTAgnCode, FTBchCode, FTLocCode, FTZneCode, FTFacCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTFacStaAlwUse)
                                VALUES (
                                    '',
                                    '',
                                    '',
                                    '',
                                    '".$paDataLocaltionFac['FTFacCode']."',
                                    GETDATE(),
                                    '".$this->session->userdata('tSesUsername')."',
                                    GETDATE(),
                                    '".$this->session->userdata('tSesUsername')."',
                                    '".$paDataLocaltionFac['FTFacStaAlwUse']."'
                                )
                ";
                $oQueryInsert   = $this->db->query($tSQLInsert);
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add LocaltionFac Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit LocaltionFac.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update LocaltionFac (TTKMLocFacility_L)
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMFACAddUpdateLang($paDataLocaltionFac){
        try{
            //Update LocaltionFac Lang
            $this->db->where('FNLngID', $paDataLocaltionFac['FNLngID']);
            $this->db->where('FTFacCode', $paDataLocaltionFac['FTFacCode']);
            $this->db->update('TTKMLocFacility_L',array(
                'FTFacName' => $paDataLocaltionFac['FTFacName']
            ));
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update LocaltionFac Lang Success.',
                );
            }else{
                //Add LocaltionFac Lang
                $this->db->insert('TTKMLocFacility_L', array(
                    'FTFacCode' => $paDataLocaltionFac['FTFacCode'],
                    'FNLngID'   => $paDataLocaltionFac['FNLngID'],
                    'FTFacName' => $paDataLocaltionFac['FTFacName']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add LocaltionFac Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit LocaltionFac Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete LocaltionFac
    //Parameters : function parameters
    //Creator : 20/04/2023 Intouch(NEW)
    //Return : Status Delete
    //Return Type : array
    public function FSaMFACDelAll($paData){
        try{
            $this->db->trans_begin();

            $this->db->where_in('FTFacCode', $paData['FTFacCode']);
            $this->db->delete('TTKMLocFacility');

            $this->db->where_in('FTFacCode', $paData['FTFacCode']);
            $this->db->delete('TTKMLocFacility_L');

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