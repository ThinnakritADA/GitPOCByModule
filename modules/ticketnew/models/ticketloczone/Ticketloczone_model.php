<?php defined('BASEPATH') or exit('No direct script access allowed');

    class Ticketloczone_model extends CI_Model {

        // Functionality : Get Data Table List
        // Parameters : -
        // Creater : 03/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKLocZoneGetDataTableList($paDataCondition){
            $aRowLen        = FCNaHCallLenData($paDataCondition['nRow'], $paDataCondition['nPage']);
            $nLngID         = $paDataCondition['nLngID'];
            $tSearchList    = $paDataCondition['tSearchAll'];

            $tSql = "
            SELECT c.*
                FROM (
                    SELECT DISTINCT
                        ROW_NUMBER() OVER(ORDER BY LocZne.FDCreateOn DESC) AS FNRowID,
						LocZne.FTZneChain,
						LocZne.FTZneCode,
						LocZne_L.FTZneName,
                        LocZne.FTBchCode,
						LocZne.FTLevCode,
						LocLev_L.FTLevName,
						LocZne.FTGteCode,
						LocGte_L.FTGteName,
						LocZne.FCZneCapacity,
						LocZne.FTZneStaUse,
						IMG.FTImgObj
                    FROM TTKMLocZne LocZne WITH(NOLOCK)
					LEFT JOIN TTKMLocZne_L	LocZne_L WITH(NOLOCK) ON LocZne.FTZneCode = LocZne_L.FTZneCode AND LocZne_L.FNLngID = $nLngID
					LEFT JOIN TTKMLocLev_L	LocLev_L WITH(NOLOCK) ON LocZne.FTLevCode = LocLev_L.FTLevCode AND LocLev_L.FNLngID = $nLngID
					LEFT JOIN TTKMLocGate_L	LocGte_L WITH(NOLOCK) ON LocZne.FTGteCode = LocGte_L.FTGteCode AND LocGte_L.FNLngID = $nLngID
					LEFT JOIN TCNMImgObj    IMG	     WITH(NOLOCK) ON LocZne.FTZneCode = IMG.FTImgRefID  AND FTImgTable = 'TTKMLocZne'
                    WHERE 1=1
            ";

            // Check User Login Branch
            if ($this->session->userdata("tSesUsrLevel") != "HQ") {
                $tBchCodeMulti = $this->session->userdata("tSesUsrBchCodeMulti");
                $tSql .= " AND LocZne.FTBchCode IN($tBchCodeMulti)";
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSql .= " AND (LocZne.FTZneCode COLLATE THAI_BIN LIKE '%$tSearchList%' ";
                $tSql .= " OR LocZne_L.FTZneName COLLATE THAI_BIN LIKE '%$tSearchList%') ";
            }

            $tSql .= " ) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
            
            $oQuery = $this->db->query($tSql);
            if ($oQuery->num_rows() > 0) {
                $oDataList          = $oQuery->result_array();
                $aDataCountAllRow   = $this->FSaMTCKLocZoneGetPageAll($tSearchList, $nLngID);
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
        // Creater : 03/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKLocZoneGetPageAll($ptSearchList, $pnLngID){
            $nLngID         = $pnLngID;
            $tSearchList    = $ptSearchList;

            $tSql = "
                SELECT 
                    COUNT(LocZne.FTZneCode) AS counts 
                FROM TTKMLocZne LocZne WITH(NOLOCK)
                LEFT JOIN TTKMLocZne_L	LocZne_L WITH(NOLOCK) ON LocZne.FTZneCode = LocZne_L.FTZneCode AND LocZne_L.FNLngID = $nLngID
                WHERE 1=1 
            ";

            // Check User Login Branch
            if ($this->session->userdata("tSesUsrLevel") != "HQ") {
                $tBchCodeMulti = $this->session->userdata("tSesUsrBchCodeMulti");
                $tSql .= " AND LocZne.FTBchCode IN($tBchCodeMulti)";
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSql .= " AND (LocZne.FTZneCode COLLATE THAI_BIN LIKE '%$tSearchList%' ";
                $tSql .= " OR LocZne_L.FTZneName COLLATE THAI_BIN LIKE '%$tSearchList%') ";
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
        // Creater : 03/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKLocZoneCheckDuplicate($ptZneCode){
            $tZneCode = $ptZneCode;
            $tSql = "   SELECT COUNT(FTZneCode) AS counts
                        FROM TTKMLocZne WITH(NOLOCK)
                        WHERE FTZneCode = '$tZneCode' ";
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

        // Functionality : Get Agency Branch
        // Parameters : -
        // Creater : 03/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKLocZoneGetAgn($ptBchCode){
            $tSql = "   SELECT FTBchCode, FTAgnCode 
                        FROM TCNMBranch WITH(NOLOCK)
                        WHERE FTBchCode = '$ptBchCode' ";
            $oQuery = $this->db->query($tSql);
            if ($oQuery->num_rows() > 0){
                $aDetail        = $oQuery->row_array();
                $aDataReturn = array(
                    'raItem'    => $aDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'Success',
                );
            }else{
                $aDataReturn = array(
                    'rtCode' => '800',
                    'rtDesc' => 'Data not found.',
                );
            }
            unset($oQuery);
            unset($aDetail);
            return $aDataReturn;
        }

        // Functionality : Get Branch
        // Parameters : -
        // Creater : 03/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKLocZoneGetLocBchAgn($ptLocCode){
            $tSql = "   SELECT FTLocCode, FTBchCode, FTAgnCode 
                        FROM TTKMBchLocation WITH(NOLOCK)
                        WHERE FTLocCode = '$ptLocCode' ";
            $oQuery = $this->db->query($tSql);
            if ($oQuery->num_rows() > 0){
                $aDetail        = $oQuery->row_array();
                $aDataReturn = array(
                    'raItem'    => $aDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'Success',
                );
            }else{
                $aDataReturn = array(
                    'rtCode' => '800',
                    'rtDesc' => 'Data not found.',
                );
            }
            unset($oQuery);
            unset($aDetail);
            return $aDataReturn;
        }

        // Functionality : Event Add Update Master
        // Parameters : -
        // Creater : 03/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKLocZoneAddUpdateMaster($paData){
            try{
                //Update Master
                $this->db->set('FTZneChain' , $paData['FTZneChain']);
                $this->db->set('FTAgnCode' , $paData['FTAgnCode']);
                $this->db->set('FTBchCode' , $paData['FTBchCode']);
                $this->db->set('FTLocCode' , $paData['FTLocCode']);
                $this->db->set('FTLevCode' , $paData['FTLevCode']);
                $this->db->set('FTGteCode' , $paData['FTGteCode']);
                $this->db->set('FCZneCapacity' , $paData['FCZneCapacity']);
                $this->db->set('FTZneStaUse' , $paData['FTZneStaUse']);
                $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);

                $this->db->where('FTZneCode' , $paData['FTZneCode']);
                $this->db->update('TTKMLocZne');
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Master Success',
                    );
                } else {
                    //Add Master
                    $this->db->insert('TTKMLocZne', array(
                        'FTZneChain'    => $paData['FTZneChain'],
                        'FTAgnCode'     => $paData['FTAgnCode'],
                        'FTBchCode'     => $paData['FTBchCode'],
                        'FTLocCode'     => $paData['FTLocCode'],
                        'FTZneCode'     => $paData['FTZneCode'],
                        'FTLevCode'     => $paData['FTLevCode'],
                        'FTGteCode'     => $paData['FTGteCode'],
                        'FCZneCapacity' => $paData['FCZneCapacity'],
                        'FTZneStaUse'   => $paData['FTZneStaUse'],
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
        // Creater : 03/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKLocZoneAddUpdateLang($paData){
            try{
                $this->db->set('FTZneName', $paData['FTZneName']);
                $this->db->where('FTZneCode' , $paData['FTZneCode']);
                $this->db->where('FNLngID', $paData['FNLngID']);
                $this->db->update('TTKMLocZne_L');
                if($this->db->affected_rows() > 0 ){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Lang Success.',
                    );
                }else{
                    $this->db->insert('TTKMLocZne_L', array(
                        'FTZneCode' => $paData['FTZneCode'],
                        'FTZneName' => $paData['FTZneName'],
                        'FNLngID'   => $paData['FNLngID']
                    ));
                    if($this->db->affected_rows() > 0){
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
        // Creater : 03/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKLocZoneSearchByID($paData){
            $tZneCode   = $paData['ptZneCode'];
            $nLngID     = $paData['pnLangID'];
            $tSql = "
                SELECT
                    LocZne.FTZneChain,
                    LocZne.FTZneCode,
                    LocZne_L.FTZneName,
                    LocZne.FTAgnCode,
                    Agn_L.FTAgnName,
                    LocZne.FTBchCode,
                    Bch_L.FTBchName,
                    LocZne.FTLocCode,
                    BchLoc_L.FTLocName,
                    LocZne.FTLevCode,
                    LocLev_L.FTLevName,
                    LocZne.FTGteCode,
                    LocGte_L.FTGteName,
                    LocZne.FCZneCapacity,
                    LocZne.FTZneStaUse,
                    IMG.FTImgObj,
                    (	SELECT COUNT(ZnePdt.FTZneCode)
                        FROM TTKMLocZnePdt ZnePdt WITH(NOLOCK)
                        WHERE ZnePdt.FTZneCode = LocZne.FTZneCode
                    ) nCountZnePdt 
                FROM TTKMLocZne         LocZne      WITH(NOLOCK)
                LEFT JOIN TTKMLocZne_L	LocZne_L    WITH(NOLOCK) ON LocZne.FTZneCode = LocZne_L.FTZneCode AND LocZne_L.FNLngID = $nLngID
                LEFT JOIN TCNMBranch_L	Bch_L	    WITH(NOLOCK) ON LocZne.FTBchCode = Bch_L.FTBchCode AND Bch_L.FNLngID = $nLngID
                LEFT JOIN TCNMAgency_L	Agn_L	    WITH(NOLOCK) ON LocZne.FTAgnCode = Agn_L.FTAgnCode AND Agn_L.FNLngID = $nLngID
                LEFT JOIN TTKMBchLocation_L BchLoc_L WITH(NOLOCK) ON LocZne.FTLocCode = BchLoc_L.FTLocCode AND BchLoc_L.FNLngID = $nLngID
                LEFT JOIN TTKMLocLev_L	LocLev_L    WITH(NOLOCK) ON LocZne.FTLevCode = LocLev_L.FTLevCode AND LocLev_L.FNLngID = $nLngID
                LEFT JOIN TTKMLocGate_L	LocGte_L    WITH(NOLOCK) ON LocZne.FTGteCode = LocGte_L.FTGteCode AND LocGte_L.FNLngID = $nLngID
                LEFT JOIN TCNMImgObj    IMG			WITH(NOLOCK) ON LocZne.FTZneCode = IMG.FTImgRefID  AND FTImgTable = 'TTKMLocZne'
                WHERE 1 = 1
            ";

            if(isset($tZneCode) && !empty($tZneCode)){
                $tSql .= " AND LocZne.FTZneCode = '$tZneCode' ";
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
        // Creater : 03/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        function FSnMTCKLocZoneDel($paData){
            try {
                $this->db->trans_begin();

                $this->db->where_in('FTZneCode', $paData['FTZneCode']);
                $this->db->delete('TTKMLocZne');

                $this->db->where_in('FTZneCode', $paData['FTZneCode']);
                $this->db->delete('TTKMLocZne_L');

                $this->db->where_in('FTImgRefID', $paData['FTZneCode']);
                $this->db->where_in('FTImgTable', 'TTKMLocZne');
                $this->db->delete('TCNMImgObj');

                $this->db->where_in('FTZneChain', $paData['FTZneChain']);
                $this->db->delete('TTKMLocZnePdt');

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