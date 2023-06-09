<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Ticketbchloczone_model extends CI_Model {

        // Functionality : Get Data List
        // Parameters : -
        // Creater : 30/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocZoneDataList($paDataWhere){
            $tSQL = " 
                SELECT
                    ROW_NUMBER() OVER(ORDER BY LocZne.FTZneCode ASC) AS FNRowID,
					BchLoc.FTAgnCode,
					BchLoc.FTBchCode,
                    BchLoc.FTLocCode,
                    LocZne.FTZneCode,
                    LocZne.FTZneChain,
                    LocZne_L.FTZneName,
                    LocZne_L.FNLngID
                FROM TTKMBchLocation BchLoc WITH(NOLOCK)
                INNER JOIN TTKMLocZne LocZne WITH(NOLOCK) ON BchLoc.FTLocCode = LocZne.FTLocCode
                LEFT JOIN TTKMLocZne_L LocZne_L WITH(NOLOCK) ON LocZne.FTZneCode = LocZne_L.FTZneCode AND LocZne_L.FNLngID = '".$paDataWhere['pnLngID']."'
                WHERE 1=1
                    AND BchLoc.FTLocCode = '".$paDataWhere['ptLocCode']."'
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

        // Functionality : Get Pdt in Zone
        // Parameters : -
        // Creater : 30/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocZonePdtList($ptZoneCode){
            $tSQL = " 
                SELECT 
                    LocZnePdt.FTZneCode,
                    LocZnePdt.FTLzbRefPdt
                FROM TTKMLocZnePdt LocZnePdt WITH(NOLOCK)
                WHERE 1=1
                AND LocZnePdt.FTZneCode = '$ptZoneCode'
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

        // Functionality : Update Zone Chain
        // Parameters : -
        // Creater : 30/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocZoneUpdateZoneChain($paData, $paDataPdt){
            $tZoneAgnCode   = !empty($paData['ptZoneAgnCode']) ? $paData['ptZoneAgnCode'] : '';
            $tZoneBchCode   = !empty($paData['ptZoneBchCode']) ? $paData['ptZoneBchCode'] : '';
            $tZoneLocCode   = !empty($paData['ptZoneLocCode']) ? $paData['ptZoneLocCode'] : '';
            $tZoneCode      = $paData['ptZoneCode'];
            $tZoneChainOld  = $paData['ptZoneChainOld'];
            $tZoneChainNew  = $paData['ptZoneChainNew'];
            $tSesUsername   = $paData['ptSesUsername'];

            $tSQL = " 
                UPDATE TTKMLocZne WITH(ROWLOCK)
                SET
                    FTZneChain  = '$tZoneChainNew',
                    FTAgnCode   = '$tZoneAgnCode',
                    FTBchCode   = '$tZoneBchCode',
                    FTLocCode   = '$tZoneLocCode',
                    FDLastUpdOn = GETDATE(),
                    FTLastUpdBy = '$tSesUsername'
                WHERE FTZneCode = '$tZoneCode'
            ";
            $oQuery = $this->db->query($tSQL);

            if($this->db->affected_rows() > 0){
                // if($paDataPdt['rtCode'] == 1){
                //     $tSQL2 = " 
                //         UPDATE TTKMLocZnePdt WITH(ROWLOCK)
                //         SET
                //             FTZneChain  = '$tZoneChainNew',
                //             FDLastUpdOn = GETDATE(),
                //             FTLastUpdBy = '$tSesUsername'
                //         WHERE FTZneChain = '$tZoneChainOld'
                //     ";
                //     $oQuery2 = $this->db->query($tSQL2);
                    
                //     if($this->db->affected_rows() > 0){
                //         $aStatus = array(
                //             'rtCode' => '1',
                //             'rtDesc' => 'Update Zone Chain Success',
                //         );
                        
                //     }else{
                //         $aStatus = array(
                //             'rtCode' => '905',
                //             'rtDesc' => 'Error Cannot Update Zone Chain.',
                //         );
                //     }
                // } else {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Zone Chain Success',
                    );
                // }
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Update Zone Chain.',
                );
            }

            unset($oQuery);
            unset($oQuery2);
            return $aStatus;
        }

        // Functionality : Delete Zone Pdt
        // Parameters : -
        // Creater : 02/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocZoneDeleteZonePdt($paData){
            $tZoneCode      = $paData['ptZoneCode'];
            $tSesUsername   = $paData['ptSesUsername'];

            $tSQL = " 
                UPDATE TTKMLocZnePdt WITH(ROWLOCK)
                SET
                    FTZneCode  = '',
                    FDLastUpdOn = GETDATE(),
                    FTLastUpdBy = '$tSesUsername'
                WHERE FTZneCode = '$tZoneCode'
            ";

            $oQuery = $this->db->query($tSQL);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Zone product Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Update Zone product.',
                );
            }

            unset($oQuery);
            return $aStatus;
        }

        // Functionality : Delete Zone Pdt
        // Parameters : -
        // Creater : 02/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocZoneDeleteZoneFac($paData){
            $tZoneCode      = $paData['ptZoneCode'];
            $tSesUsername   = $paData['ptSesUsername'];

            $tSQL = " 
                UPDATE TTKMLocFacility WITH(ROWLOCK)
                SET
                    FTZneCode  = '',
                    FDLastUpdOn = GETDATE(),
                    FTLastUpdBy = '$tSesUsername'
                WHERE FTZneCode = '$tZoneCode'
            ";

            $oQuery = $this->db->query($tSQL);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Zone facility Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Update Zone facility.',
                );
            }

            unset($oQuery);
            return $aStatus;
        }

        // // Functionality : Check zone in location
        // // Parameters : -
        // // Creater : 30/05/2023 Papitchaya
        // // Last Update: -
        // // Return : Array
        // public function FSaMTCKBchLocZoneCheckZone($ptLocCode){
        //     $tSql = "
        //         SELECT COUNT(LocZne.FTZneCode) AS nCountZne
		// 		FROM TTKMLocZne LocZne WITH(NOLOCK)
		// 		WHERE LocZne.FTLocCode = '$ptLocCode'
        //     ";
        //     $oQuery = $this->db->query($tSql);
        //     if ($oQuery->num_rows() > 0){
        //         $aDetail        = $oQuery->row_array();
        //         $aDataReturn = array(
        //             'raItem'    => $aDetail,
        //             'rtCode'    => '1',
        //             'rtDesc'    => 'Success',
        //         );
        //     }else{
        //         $aDataReturn = array(
        //             'rtCode' => '800',
        //             'rtDesc' => 'Data not found.',
        //         );
        //     }
        //     unset($oQuery);
        //     unset($aDetail);
        //     return $aDataReturn;
        // }

    }
?>