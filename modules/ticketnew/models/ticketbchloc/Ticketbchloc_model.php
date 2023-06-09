<?php defined('BASEPATH') or exit('No direct script access allowed');

    class Ticketbchloc_model extends CI_Model {

        // Functionality : Get Data Table List
        // Parameters : -
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocGetDataTableList($paDataCondition){
            $aRowLen        = FCNaHCallLenData($paDataCondition['nRow'], $paDataCondition['nPage']);
            $nLngID         = $paDataCondition['nLngID'];
            $tSearchList    = $paDataCondition['tSearchAll'];

            $tSql = "
                SELECT c.*
                FROM (
                    SELECT DISTINCT
                        ROW_NUMBER() OVER(ORDER BY BchLoc.FDCreateOn DESC) AS FNRowID,
                        BchLoc.FTLocCode,
                        BchLoc_L.FTLocName,
						BchLoc.FTBchCode,
						Bch_L.FTBchName,
                        BchLoc.FTLocStaAlwPet,
                        BchLoc.FTLocStaAlwBook,
                        BchLoc.FCLocCapacity,
                        BchLoc.FTLocStaUse,
                        IMG.FTImgObj,
						(	SELECT COUNT(Zne.FTLocCode)
							FROM TTKMLocZne Zne WITH(NOLOCK)
							WHERE Zne.FTLocCode = BchLoc.FTLocCode
						) nCountZne,
                        (   SELECT COUNT(LocFac.FTFacCode)
                            FROM TTKMLocFacility LocFac WITH(NOLOCK)
                            WHERE LocFac.FTLocCode = BchLoc.FTLocCode
                        ) nCountFac,
                        (
                            SELECT COUNT(ZnePdt.FTLzbRefPdt)
                            FROM TTKMLocZnePdt ZnePdt WITH(NOLOCK)
                            WHERE ZnePdt.FTLocCode = BchLoc.FTLocCode
                        ) nCountPdt
                    FROM TTKMBchLocation    BchLoc  WITH(NOLOCK)
                    LEFT JOIN TTKMBchLocation_L BchLoc_L WITH(NOLOCK) ON BchLoc.FTLocCode = BchLoc_L.FTLocCode AND BchLoc_L.FNLngID = $nLngID
                    LEFT JOIN TCNMBranch    Bch     WITH(NOLOCK) ON BchLoc.FTBchCode = Bch.FTBchCode
					LEFT JOIN TCNMBranch_L  Bch_L   WITH(NOLOCK) ON Bch.FTBchCode = Bch_L.FTBchCode AND Bch_L.FNLngID = $nLngID
                    LEFT JOIN TCNMImgObj    IMG     WITH(NOLOCK) ON BchLoc.FTLocCode = IMG.FTImgRefID  AND FTImgTable = 'TTKMBchLocation'
                    WHERE 1=1 
            ";

            // Check User Login Branch
            if ($this->session->userdata("tSesUsrLevel") != "HQ") {
                $tBchCodeMulti = $this->session->userdata("tSesUsrBchCodeMulti");
                $tSql .= " AND BchLoc.FTBchCode IN($tBchCodeMulti)";
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSql .= " AND (BchLoc.FTLocCode COLLATE THAI_BIN LIKE '%$tSearchList%' ";
                $tSql .= " OR BchLoc_L.FTLocName COLLATE THAI_BIN LIKE '%$tSearchList%') ";
            }

            $tSql .= " ) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

            $oQuery = $this->db->query($tSql);
            if ($oQuery->num_rows() > 0) {
                $oDataList          = $oQuery->result_array();
                $aDataCountAllRow   = $this->FSaMTCKBchLocGetPageAll($tSearchList, $nLngID);
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
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocGetPageAll($ptSearchList, $pnLngID){
            $nLngID         = $pnLngID;
            $tSearchList    = $ptSearchList;

            $tSql = "
                SELECT
                    COUNT(BchLoc.FTLocCode) AS counts
                FROM TTKMBchLocation BchLoc WITH(NOLOCK)
                LEFT JOIN TTKMBchLocation_L BchLoc_L WITH(NOLOCK) ON BchLoc.FTLocCode = BchLoc_L.FTLocCode AND BchLoc_L.FNLngID = $nLngID
                WHERE 1=1 
            ";

            // Check User Login Branch
            if ($this->session->userdata("tSesUsrLevel") != "HQ") {
                $tBchCodeMulti = $this->session->userdata("tSesUsrBchCodeMulti");
                $tSql .= " AND BchLoc.FTBchCode IN($tBchCodeMulti)";
            }

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSql .= " AND (BchLoc.FTLocCode COLLATE THAI_BIN LIKE '%$tSearchList%' ";
                $tSql .= " OR BchLoc_L.FTLocName COLLATE THAI_BIN LIKE '%$tSearchList%') ";
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
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocCheckDuplicate($ptLocCode){
            $tLocCode = $ptLocCode;
            $tSql = "   SELECT COUNT(FTLocCode) AS counts
                        FROM TTKMBchLocation WITH(NOLOCK)
                        WHERE FTLocCode = '$tLocCode' ";
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
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocGetAgn($ptBchCode){
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

        // Functionality : Event Add Update Master
        // Parameters : -
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocAddUpdateMaster($paData){
            try{
                //Update Master
                $this->db->set('FTAgnCode' , $paData['FTAgnCode']);
                $this->db->set('FTBchCode' , $paData['FTBchCode']);
                $this->db->set('FTLocCode' , $paData['FTLocCode']);
                $this->db->set('FTLocStaAlwPet' , $paData['FTLocStaAlwPet']);
                $this->db->set('FTLocStaAlwBook' , $paData['FTLocStaAlwBook']);
                $this->db->set('FCLocCapacity' , $paData['FCLocCapacity']);
                $this->db->set('FTLocStaUse' , $paData['FTLocStaUse']);
                $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);

                $this->db->where('FTLocCode' , $paData['FTLocCode']);
                $this->db->update('TTKMBchLocation');
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Master Success',
                    );
                } else {
                    //Add Master
                    $this->db->insert('TTKMBchLocation', array(
                        'FTAgnCode'     => $paData['FTAgnCode'],
                        'FTBchCode'     => $paData['FTBchCode'],
                        'FTLocCode'     => $paData['FTLocCode'],
                        'FTLocStaAlwPet' => $paData['FTLocStaAlwPet'],
                        'FTLocStaAlwBook' => $paData['FTLocStaAlwBook'],
                        'FCLocCapacity' => $paData['FCLocCapacity'],
                        'FTLocStaUse'   => $paData['FTLocStaUse'],
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
            }catch(Exception $Error){
                return $Error;
            }
        }

        // Functionality : Event Add Update Lang
        // Parameters : -
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocAddUpdateLang($paData){
            try{
                $this->db->set('FTLocName', $paData['FTLocName']);
                $this->db->where('FTLocCode' , $paData['FTLocCode']);
                $this->db->where('FNLngID', $paData['FNLngID']);
                $this->db->update('TTKMBchLocation_L');
                if($this->db->affected_rows() > 0 ){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Lang Success.',
                    );
                }else{
                    $this->db->insert('TTKMBchLocation_L', array(
                        'FTLocCode' => $paData['FTLocCode'],
                        'FTLocName' => $paData['FTLocName'],
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
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocSearchByID($paData){
            $tLocCode   = $paData['ptLocCode'];
            $nLngID     = $paData['pnLangID'];
            $tSql = "
                SELECT 
                    BchLoc.FTLocCode,
                    BchLoc_L.FTLocName,
                    BchLoc.FTAgnCode,
                    Agn_L.FTAgnName,
					BchLoc.FTBchCode,
					Bch_L.FTBchName,
                    BchLoc.FTLocStaAlwPet,
                    BchLoc.FTLocStaAlwBook,
                    BchLoc.FCLocCapacity,
                    BchLoc.FTLocStaUse,
                    IMG.FTImgObj,
                    (   SELECT COUNT(LocZne.FTZneCode)
						FROM TTKMLocZne LocZne WITH(NOLOCK)
						WHERE LocZne.FTLocCode = BchLoc.FTLocCode
					) nCountZne,
                    (   SELECT COUNT(LocFac.FTFacCode)
                        FROM TTKMLocFacility LocFac WITH(NOLOCK)
                        WHERE LocFac.FTLocCode = BchLoc.FTLocCode
                    ) nCountFac
                FROM TTKMBchLocation    BchLoc  WITH(NOLOCK)
                LEFT JOIN TTKMBchLocation_L BchLoc_L WITH(NOLOCK) ON BchLoc.FTLocCode = BchLoc_L.FTLocCode AND BchLoc_L.FNLngID = $nLngID
                LEFT JOIN TCNMBranch_L  Bch_L   WITH(NOLOCK) ON BchLoc.FTBchCode = Bch_L.FTBchCode AND Bch_L.FNLngID = $nLngID
				LEFT JOIN TCNMAgency_L	Agn_L	WITH(NOLOCK) ON BchLoc.FTAgnCode = Agn_L.FTAgnCode AND Agn_L.FNLngID = $nLngID
                LEFT JOIN TCNMImgObj    IMG     WITH(NOLOCK) ON BchLoc.FTLocCode = IMG.FTImgRefID  AND FTImgTable = 'TTKMBchLocation'
                WHERE 1=1 
            ";

            if(isset($tLocCode) && !empty($tLocCode)){
                $tSql .= " AND BchLoc.FTLocCode = '$tLocCode' ";
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
        // Creater : 20/04/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocDel($paData){
            try {
                $this->db->trans_begin();

                $this->db->where_in('FTLocCode', $paData['FTLocCode']);
                $this->db->delete('TTKMBchLocation');

                $this->db->where_in('FTLocCode', $paData['FTLocCode']);
                $this->db->delete('TTKMBchLocation_L');

                $this->db->where_in('FTImgRefID', $paData['FTLocCode']);
                $this->db->where_in('FTImgTable', 'TTKMBchLocation');
                $this->db->delete('TCNMImgObj');

                $this->db->where_in('FTAddGrpType', '8');
                $this->db->where_in('FTAddRefCode', $paData['FTLocCode']);
                $this->db->delete('TCNMAddress_L');

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

        // Functionality : Check zone in location
        // Parameters : -
        // Creater : 30/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocCheckZone($ptLocCode){
            $tSql = "
                SELECT COUNT(LocZne.FTZneCode) AS nCountZne
				FROM TTKMLocZne LocZne WITH(NOLOCK)
				WHERE LocZne.FTLocCode = '$ptLocCode'
            ";
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

        // Functionality : Check facility in location
        // Parameters : -
        // Creater : 31/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocCheckFac($ptLocCode){
            $tSql = "
                SELECT COUNT(LocFac.FTFacCode) AS nCountFac
                FROM TTKMLocFacility LocFac WITH(NOLOCK)
				WHERE LocFac.FTLocCode = '$ptLocCode'
            ";
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
    }

?>