<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Ticketbchlocaddress_model extends CI_Model {

        // Functionality : Get Data List
        // Parameters : -
        // Creater : 21/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocAddressDataList($paDataWhere){
            $tSQL = " 
                SELECT
                    ADDL.FNLngID,
                    ADDL.FTAddGrpType,
                    ADDL.FTAddRefCode,
                    ADDL.FNAddSeqNo,
                    ADDL.FTAddRefNo,
                    ADDL.FTAddName,
                    ADDL.FTAddTaxNo,
                    ADDL.FTAddWebsite,
                    ADDL.FTAddRmk,
                    ADDL.FDCreateOn
                FROM TCNMAddress_L ADDL WITH(NOLOCK)
                WHERE 1=1
                AND ADDL.FTAddGrpType   = 8
                AND ADDL.FNLngID        = '".$paDataWhere['pnLngID']."'
                AND ADDL.FTAddRefCode   = '".$paDataWhere['ptLocCode']."'
                ORDER BY FDCreateOn ASC
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

        // Functionality : Get by ID
        // Parameters : -
        // Creater : 21/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocAddressGetDataID($paDataAddr){
            $tSQL = " 
                SELECT DISTINCT
                    ADDL.FNLngID,
                    ADDL.FTAddGrpType,
                    ADDL.FTAddRefCode,
                    ADDL.FNAddSeqNo,
                    ADDL.FTAddRefNo,
                    ADDL.FTAddName,
                    ADDL.FTAddTaxNo,
                    ADDL.FTAddRmk,
                    ADDL.FTAddCountry,
                    ADDL.FTAddVersion,
                    ADDL.FTAddV1No,
                    ADDL.FTAddV1Soi,
                    ADDL.FTAddV1Village,
                    ADDL.FTAddV1Road,
                    ADDL.FTAddV1SubDist AS FTSudCode,
                    SDSTL.FTSudName,
                    ADDL.FTAddV1DstCode AS FTDstCode,
                    DSTL.FTDstName,
                    ADDL.FTAddV1PvnCode AS FTPvnCode,
                    PVNL.FTPvnName,
                    ADDL.FTAddV1PostCode,
                    ADDL.FTAddV2Desc1,
                    ADDL.FTAddV2Desc2,
                    ADDL.FTAddWebsite,
                    ADDL.FTAddLongitude,
                    ADDL.FTAddLatitude,
                    ADDL.FTAddTel,
                    ADDL.FTAddFax
                FROM TCNMAddress_L ADDL WITH(NOLOCK)
                LEFT JOIN TCNMSubDistrict_L SDSTL WITH(NOLOCK) ON ADDL.FTAddV1SubDist = SDSTL.FTSudCode AND SDSTL.FNLngID = '".$paDataAddr['FNLngID']."'
                LEFT JOIN TCNMDistrict_L DSTL WITH(NOLOCK) ON ADDL.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = '".$paDataAddr['FNLngID']."'
                LEFT JOIN TCNMProvince_L PVNL WITH(NOLOCK) ON ADDL.FTAddV1PvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = '".$paDataAddr['FNLngID']."'
                WHERE 1=1
                    AND ADDL.FNLngID         = '".$paDataAddr['FNLngID']."'
                    AND ADDL.FTAddGrpType    = '".$paDataAddr['FTAddGrpType']."'
                    AND ADDL.FTAddRefCode    = '".$paDataAddr['FTAddRefCode']."'
                    AND ADDL.FNAddSeqNo      = '".$paDataAddr['FNAddSeqNo']."'
            ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDetail    = $oQuery->row_array();
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

        // Functionality : Event add data
        // Parameters : -
        // Creater : 21/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocAddressAddData($paDataAddr){
            try{
                $tAddrVersion = $paDataAddr['FTAddVersion'];
                if(isset($tAddrVersion) && $tAddrVersion == 1){
                    $this->db->insert('TCNMAddress_L', array(
                        'FNLngID'           => $paDataAddr['FNLngID'],
                        'FTAddGrpType'      => $paDataAddr['FTAddGrpType'],
                        'FTAddRefCode'      => $paDataAddr['FTAddRefCode'],
                        'FTAddName'         => $paDataAddr['FTAddName'],
                        'FTAddTaxNo'        => $paDataAddr['FTAddTaxNo'],
                        'FTAddRmk'          => $paDataAddr['FTAddRmk'],
                        'FTAddVersion'      => $paDataAddr['FTAddVersion'],
                        'FTAddV1No'         => $paDataAddr['FTAddV1No'],
                        'FTAddV1Soi'        => $paDataAddr['FTAddV1Soi'],
                        'FTAddV1Village'    => $paDataAddr['FTAddV1Village'],
                        'FTAddV1Road'       => $paDataAddr['FTAddV1Road'],
                        'FTAddV1SubDist'    => $paDataAddr['FTAddV1SubDist'],
                        'FTAddV1DstCode'    => $paDataAddr['FTAddV1DstCode'],
                        'FTAddV1PvnCode'    => $paDataAddr['FTAddV1PvnCode'],
                        'FTAddV1PostCode'   => $paDataAddr['FTAddV1PostCode'],
                        'FTAddWebsite'      => $paDataAddr['FTAddWebsite'],
                        'FTAddTel'          => $paDataAddr['FTAddTel'],
                        'FTAddFax'          => $paDataAddr['FTAddFax'],
                        'FTAddLongitude'    => $paDataAddr['FTAddLongitude'],
                        'FTAddLatitude'     => $paDataAddr['FTAddLatitude'],
                        'FDLastUpdOn'       => $paDataAddr['FDLastUpdOn'],
                        'FTLastUpdBy'       => $paDataAddr['FTLastUpdBy'],
                        'FDCreateOn'        => $paDataAddr['FDCreateOn'],
                        'FTCreateBy'        => $paDataAddr['FTCreateBy']
                    ));
                }else{
                    $this->db->insert('TCNMAddress_L', array(
                        'FNLngID'           => $paDataAddr['FNLngID'],
                        'FTAddGrpType'      => $paDataAddr['FTAddGrpType'],
                        'FTAddRefCode'      => $paDataAddr['FTAddRefCode'],
                        'FTAddName'         => $paDataAddr['FTAddName'],
                        'FTAddTaxNo'        => $paDataAddr['FTAddTaxNo'],
                        'FTAddRmk'          => $paDataAddr['FTAddRmk'],
                        'FTAddVersion'      => $paDataAddr['FTAddVersion'],
                        'FTAddV2Desc1'      => $paDataAddr['FTAddV2Desc1'],
                        'FTAddV2Desc2'      => $paDataAddr['FTAddV2Desc2'],
                        'FTAddWebsite'      => $paDataAddr['FTAddWebsite'],
                        'FTAddTel'          => $paDataAddr['FTAddTel'],
                        'FTAddFax'          => $paDataAddr['FTAddFax'],
                        'FTAddLongitude'    => $paDataAddr['FTAddLongitude'],
                        'FTAddLatitude'     => $paDataAddr['FTAddLatitude'],
                        'FDLastUpdOn'       => $paDataAddr['FDLastUpdOn'],
                        'FTLastUpdBy'       => $paDataAddr['FTLastUpdBy'],
                        'FDCreateOn'        => $paDataAddr['FDCreateOn'],
                        'FTCreateBy'        => $paDataAddr['FTCreateBy']
                    ));
                }
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
                return $aStatus;
            }catch(Exception $Error){
                return $Error;
            }
        }

        // Functionality : Event edit data
        // Parameters : -
        // Creater : 21/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        function FSaMTCKBchLocAddressEditData($paDataAddr){
            try{
                $tAddrVersion = $paDataAddr['FTAddVersion'];
                if(isset($tAddrVersion) && $tAddrVersion == 1){
                    $this->db->set('FTAddName' , $paDataAddr['FTAddName']);
                    $this->db->set('FTAddTaxNo' , $paDataAddr['FTAddTaxNo']);
                    $this->db->set('FTAddRmk' , $paDataAddr['FTAddRmk']);
                    $this->db->set('FTAddVersion' , $paDataAddr['FTAddVersion']);
                    $this->db->set('FTAddV1No' , $paDataAddr['FTAddV1No']);
                    $this->db->set('FTAddV1Soi' , $paDataAddr['FTAddV1Soi']);
                    $this->db->set('FTAddV1Village' , $paDataAddr['FTAddV1Village']);
                    $this->db->set('FTAddV1Road' , $paDataAddr['FTAddV1Road']);
                    $this->db->set('FTAddV1SubDist' , $paDataAddr['FTAddV1SubDist']);
                    $this->db->set('FTAddV1DstCode' , $paDataAddr['FTAddV1DstCode']);
                    $this->db->set('FTAddV1PvnCode' , $paDataAddr['FTAddV1PvnCode']);
                    $this->db->set('FTAddV1PostCode' , $paDataAddr['FTAddV1PostCode']);
                    $this->db->set('FTAddWebsite' , $paDataAddr['FTAddWebsite']);
                    $this->db->set('FTAddTel' , $paDataAddr['FTAddTel']);
                    $this->db->set('FTAddFax' , $paDataAddr['FTAddFax']);
                    $this->db->set('FTAddLongitude' , $paDataAddr['FTAddLongitude']);
                    $this->db->set('FTAddLatitude' , $paDataAddr['FTAddLatitude']);
                    $this->db->set('FDLastUpdOn' , $paDataAddr['FDLastUpdOn']);
                    $this->db->set('FTLastUpdBy' , $paDataAddr['FTLastUpdBy']);

                    $this->db->where('FNLngID' , $paDataAddr['FNLngID']);
                    $this->db->where('FTAddGrpType' , $paDataAddr['FTAddGrpType']);
                    $this->db->where('FTAddRefCode' , $paDataAddr['FTAddRefCode']);
                    $this->db->where('FNAddSeqNo' , $paDataAddr['FNAddSeqNo']);
                    $this->db->update('TCNMAddress_L');
                }else{
                    $this->db->set('FTAddName' , $paDataAddr['FTAddName']);
                    $this->db->set('FTAddTaxNo' , $paDataAddr['FTAddTaxNo']);
                    $this->db->set('FTAddRmk' , $paDataAddr['FTAddRmk']);
                    $this->db->set('FTAddVersion' , $paDataAddr['FTAddVersion']);
                    $this->db->set('FTAddV2Desc1' , $paDataAddr['FTAddV2Desc1']);
                    $this->db->set('FTAddV2Desc2' , $paDataAddr['FTAddV2Desc2']);
                    $this->db->set('FTAddWebsite' , $paDataAddr['FTAddWebsite']);
                    $this->db->set('FTAddTel' , $paDataAddr['FTAddTel']);
                    $this->db->set('FTAddFax' , $paDataAddr['FTAddFax']);
                    $this->db->set('FTAddLongitude' , $paDataAddr['FTAddLongitude']);
                    $this->db->set('FTAddLatitude' , $paDataAddr['FTAddLatitude']);
                    $this->db->set('FDLastUpdOn' , $paDataAddr['FDLastUpdOn']);
                    $this->db->set('FTLastUpdBy' , $paDataAddr['FTLastUpdBy']);

                    $this->db->where('FNLngID' , $paDataAddr['FNLngID']);
                    $this->db->where('FTAddGrpType' , $paDataAddr['FTAddGrpType']);
                    $this->db->where('FTAddRefCode' , $paDataAddr['FTAddRefCode']);
                    $this->db->where('FNAddSeqNo' , $paDataAddr['FNAddSeqNo']);
                    $this->db->update('TCNMAddress_L');
                }
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Address.',
                    );
                }
                return $aStatus;
            }catch(Exception $Error){
                return $Error;
            }
        }

        // Functionality : Update seq data
        // Parameters : -
        // Creater : 21/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        function FSaMTCKBchLocAddressUpdateSeq($paDataAddr){
            $tSql   = " UPDATE ADDRUPD
                        SET	ADDRUPD.FTAddRefNo = DATARUNSEQ.FTAddRefNo
                        FROM TCNMAddress_L AS ADDRUPD WITH(NOLOCK)
                        INNER JOIN (
                            SELECT
                                ROW_NUMBER() OVER(ORDER BY FNAddSeqNo ASC) AS FTAddRefNo,
                                FNLngID,
                                FTAddGrpType,
                                FTAddRefCode,
                                FNAddSeqNo
                            FROM TCNMAddress_L WITH(NOLOCK)
                            WHERE 1=1
                            AND FNLngID         = '".$paDataAddr['FNLngID']."'
                            AND FTAddRefCode    = '".$paDataAddr['FTAddRefCode']."'
                            AND FTAddGrpType    = '".$paDataAddr['FTAddGrpType']."'
                        ) AS DATARUNSEQ
                        ON 1=1
                        AND ADDRUPD.FNLngID         = DATARUNSEQ.FNLngID
                        AND ADDRUPD.FTAddGrpType	= DATARUNSEQ.FTAddGrpType
                        AND ADDRUPD.FTAddRefCode	= DATARUNSEQ.FTAddRefCode
                        AND ADDRUPD.FNAddSeqNo		= DATARUNSEQ.FNAddSeqNo
            ";
            $oQuery = $this->db->query($tSql);

            unset($tSql);
            unset($oQuery);
            return;
        }

        // Functionality : Event delete data
        // Parameters : -
        // Creater : 21/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        function FSaMTCKBchLocAddressDeleteData($paDataAddr){
            $tSql = " DELETE
                FROM TCNMAddress_L
                WHERE 1=1
                    AND FNLngID         = '".$paDataAddr['FNLngID']."'
                    AND FTAddGrpType    = '".$paDataAddr['FTAddGrpType']."'
                    AND FTAddRefCode    = '".$paDataAddr['FTAddRefCode']."'
                    AND FNAddSeqNo      = '".$paDataAddr['FNAddSeqNo']."'
            ";
            $oQuery = $this->db->query($tSql);
            
            unset($tSql);
            unset($oQuery);
            return;
        }
    }

?>