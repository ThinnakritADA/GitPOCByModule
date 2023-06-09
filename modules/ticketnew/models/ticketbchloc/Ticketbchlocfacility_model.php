<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Ticketbchlocfacility_model extends CI_Model {

        // Functionality : Get Data List
        // Parameters : -
        // Creater : 31/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocFacDataList($paDataWhere){
            $tSQL = " 
                SELECT
                    ROW_NUMBER() OVER(ORDER BY Fac.FTFacCode ASC) AS FNRowID,
                    BchLoc.FTAgnCode,
                    BchLoc.FTBchCode,
                    BchLoc.FTLocCode,
                    Fac.FTZneCode,
                    Zne_L.FTZneName,
                    Fac.FTFacCode,
                    Fac_L.FTFacName,
                    Fac_L.FNLngID
                FROM TTKMBchLocation		BchLoc	WITH(NOLOCK)
                INNER JOIN TTKMLocFacility	Fac		WITH(NOLOCK) ON BchLoc.FTLocCode = Fac.FTLocCode
                LEFT JOIN TTKMLocFacility_L Fac_L	WITH(NOLOCK) ON Fac.FTFacCode = Fac_L.FTFacCode AND Fac_L.FNLngID = '".$paDataWhere['pnLngID']."'
                LEFT JOIN TTKMLocZne_L		Zne_L	WITH(NOLOCK) ON Fac.FTZneCode = Zne_L.FTZneCode AND Zne_L.FNLngID = '".$paDataWhere['pnLngID']."'
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

        // Functionality : Update facility
        // Parameters : -
        // Creater : 31/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocFacUpdateLocZne($paData){
            $tFacAgnCode    = !empty($paData['ptFacAgnCode']) ? $paData['ptFacAgnCode'] : '';
            $tFacBchCode    = !empty($paData['ptFacBchCode']) ? $paData['ptFacBchCode'] : '';
            $tFacLocCode    = !empty($paData['ptFacLocCode']) ? $paData['ptFacLocCode'] : '';
            $tFacZneCode    = !empty($paData['ptFacZneCode']) ? $paData['ptFacZneCode'] : '';
            $tFacCode       = $paData['ptFacCode'];
            $tSesUsername   = $paData['ptSesUsername'];

            $tSQL = " 
                UPDATE TTKMLocFacility WITH(ROWLOCK)
                SET
                    FTAgnCode   = '$tFacAgnCode',
                    FTBchCode   = '$tFacBchCode',
                    FTLocCode   = '$tFacLocCode',
                    FTZneCode   = '$tFacZneCode',
                    FDLastUpdOn = GETDATE(),
                    FTLastUpdBy = '$tSesUsername'
                WHERE FTFacCode = '$tFacCode'
            ";

            $oQuery = $this->db->query($tSQL);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update facility success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Update facility.',
                );
            }

            unset($oQuery);
            unset($oQuery2);
            return $aStatus;
        }

        // // Functionality : Check facility in location
        // // Parameters : -
        // // Creater : 31/05/2023 Papitchaya
        // // Last Update: -
        // // Return : Array
        // public function FSaMTCKBchLocFacCheckFac($ptLocCode){
        //     $tSql = "
        //         SELECT COUNT(LocFac.FTFacCode) AS nCountFac
        //         FROM TTKMLocFacility LocFac WITH(NOLOCK)
		// 		WHERE LocFac.FTLocCode = '$ptLocCode'
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