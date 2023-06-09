<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Ticketloczonepdt_model extends CI_Model {

        // Functionality : Get Data List
        // Parameters : -
        // Creater : 04/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKLocZonePdtDataList($paDataWhere){
            $aRowLen        = FCNaHCallLenData($paDataWhere['nRow'], $paDataWhere['nPage']);
            $nLngID         = $paDataWhere['nLngID'];
            $tSearchList    = $paDataWhere['tSearchAll'];
            $tZneChain      = $paDataWhere['tZneChain'];

            $tSql = " 
                SELECT c.*
                FROM (
                    SELECT DISTINCT
                        ROW_NUMBER() OVER(ORDER BY LocZnePdt.FTLzbRefPdt ASC) AS FNRowID,
                        LocZnePdt.FTZneChain,
                        LocZnePdt.FTLzbRefPdt,
                        Pdt_L.FTPdtName,
                        Pdt_L.FNLngID
                    FROM TTKMLocZnePdt LocZnePdt    WITH(NOLOCK)
                    LEFT JOIN TCNMPdt_L Pdt_L		WITH(NOLOCK) ON LocZnePdt.FTLzbRefPdt = Pdt_L.FTPdtCode AND Pdt_L.FNLngID = $nLngID
                    WHERE 1=1
                    AND LocZnePdt.FTZneChain = '$tZneChain'
            ";

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSql .= " AND (LocZnePdt.FTLzbRefPdt COLLATE THAI_BIN LIKE '%$tSearchList%' ";
                $tSql .= " OR Pdt_L.FTPdtName COLLATE THAI_BIN LIKE '%$tSearchList%') ";
            }

            $tSql .= " ) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
            
            $oQuery = $this->db->query($tSql);
            if ($oQuery->num_rows() > 0){
                $oDataList          = $oQuery->result_array();
                $aDataCountAllRow   = $this->FSaMTCKLocZonePdtGetPageAll($tZneChain, $tSearchList, $nLngID);
                $nFoundRow          = ($aDataCountAllRow['rtCode'] == '1') ? $aDataCountAllRow['rtCountData'] : 0;
                $nPageAll           = ceil($nFoundRow/$paDataWhere['nRow']);
                $aResult = array(
                    'raItems'       => $oDataList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paDataWhere['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'Success',
                );
            }else{
                $aResult = array(
                    'rnAllRow'      => 0,
                    'rnCurrentPage' => $paDataWhere['nPage'],
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

        // Functionality : Event add data
        // Parameters : -
        // Creater : 04/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKLocZonePdtAddData($paDataPdt){
            try{
                $this->db->insert('TTKMLocZnePdt', array(
                    'FTZneChain'    => $paDataPdt['FTZneChain'],
                    'FTLzbRefPdt'   => $paDataPdt['FTLzbRefPdt'],
                    'FDLastUpdOn'   => $paDataPdt['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataPdt['FTLastUpdBy'],
                    'FDCreateOn'    => $paDataPdt['FDCreateOn'],
                    'FTCreateBy'    => $paDataPdt['FTCreateBy']
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
                return $aStatus;
            } catch(Exception $Error) {
                return $Error;
            }
        }
        
        // Functionality : Get Page All
        // Parameters : -
        // Creater : 04/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKLocZonePdtGetPageAll($ptZneChain, $ptSearchList, $pnLngID){
            $nLngID         = $pnLngID;
            $tSearchList    = $ptSearchList;
            $tZneChain      = $ptZneChain;

            $tSql = " 
                SELECT 
                    COUNT(LocZnePdt.FTLzbRefPdt) AS counts 
                FROM TTKMLocZnePdt LocZnePdt    WITH(NOLOCK)
                LEFT JOIN TCNMPdt_L Pdt_L		WITH(NOLOCK) ON LocZnePdt.FTLzbRefPdt = Pdt_L.FTPdtCode AND Pdt_L.FNLngID = $nLngID
                WHERE 1=1
                AND LocZnePdt.FTZneChain = '$tZneChain'
            ";

            if(isset($tSearchList) && !empty($tSearchList)){
                $tSql .= " AND (LocZnePdt.FTLzbRefPdt COLLATE THAI_BIN LIKE '%$tSearchList%' ";
                $tSql .= " OR Pdt_L.FTPdtName COLLATE THAI_BIN LIKE '%$tSearchList%') ";
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

        // Functionality : Check Duplicate Product
        // Parameters : -
        // Creater : 04/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKLocZonePdtCheckDuplicate($paDataPdt){
            $tZneChain = $paDataPdt['FTZneChain'];
            $tPdtCode  = $paDataPdt['FTLzbRefPdt'];

            $tSql = "   SELECT COUNT(FTLzbRefPdt) AS counts
                        FROM TTKMLocZnePdt WITH(NOLOCK)
                        WHERE FTZneChain = '$tZneChain' AND FTLzbRefPdt = '$tPdtCode' ";
                        
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

        // Functionality : Event delete data
        // Parameters : -
        // Creater : 04/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKLocZonePdtDeleteData($paDataPdt){
            $tSql = " DELETE
                FROM TTKMLocZnePdt
                WHERE 1=1
                    AND FTZneChain  = '".$paDataPdt['FTZneChain']."'
                    AND FTLzbRefPdt = '".$paDataPdt['FTLzbRefPdt']."'
            ";
            $oQuery = $this->db->query($tSql);
            
            unset($tSql);
            unset($oQuery);
            return;
        }

        // Functionality : Check Product in Zone
        // Parameters : -
        // Creater : 04/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKLocZonePdtCheckPdt($paDataPdt){
            $tSql = "
                SELECT COUNT(ZnePdt.FTZneChain) AS nCountZnePdt
                FROM TTKMLocZnePdt ZnePdt WITH(NOLOCK)
                WHERE ZnePdt.FTZneChain = '".$paDataPdt['FTZneChain']."'
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