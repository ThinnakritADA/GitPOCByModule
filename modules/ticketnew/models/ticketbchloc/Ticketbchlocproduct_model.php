<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Ticketbchlocproduct_model extends CI_Model {
    
        // Functionality : Get Data List
        // Parameters : -
        // Creater : 31/05/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocPdtDataList($paDataWhere){
            $tSQL = "
                SELECT
                    ROW_NUMBER() OVER(ORDER BY Pdt.FTLzbRefPdt ASC) AS FNRowID,
                    BchLoc.FTAgnCode,
                    BchLoc.FTBchCode,
                    BchLoc.FTLocCode,
                    Pdt.FTZneCode,
                    Zne_L.FTZneName,
                    Pdt.FTLzbRefPdt,
                    Pdt_L.FTPdtName,
                    Pdt_L.FNLngID
                FROM TTKMBchLocation		BchLoc	WITH(NOLOCK)
                INNER JOIN TTKMLocZnePdt	Pdt		WITH(NOLOCK) ON BchLoc.FTLocCode = Pdt.FTLocCode
                LEFT JOIN TCNMPdt_L			Pdt_L	WITH(NOLOCK) ON Pdt.FTLzbRefPdt = Pdt_L.FTPdtCode AND Pdt_L.FNLngID = '".$paDataWhere['pnLngID']."'
                LEFT JOIN TTKMLocZne_L		Zne_L	WITH(NOLOCK) ON Pdt.FTZneCode = Zne_L.FTZneCode AND Zne_L.FNLngID = '".$paDataWhere['pnLngID']."'
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

        // Functionality : Add Product
        // Parameters : -
        // Creater : 01/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocPdtAddData($paData){
            $tPdtLocCode    = !empty($paData['ptPdtLocCode']) ? $paData['ptPdtLocCode'] : '';
            $tPdtZneCode    = !empty($paData['ptPdtZneCode']) ? $paData['ptPdtZneCode'] : '';
            $tPdtCode       = $paData['ptPdtCode'];
            $tSesUsername   = $paData['ptSesUsername'];

            $tSQL = " 
                INSERT INTO TTKMLocZnePdt (FTLocCode, FTZneCode, FTLzbRefPdt, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
                VALUES ('$tPdtLocCode', '$tPdtZneCode', '$tPdtCode', GETDATE(), '$tSesUsername', GETDATE(), '$tSesUsername')
            ";

            $oQuery = $this->db->query($tSQL);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Product success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add Product.',
                );
            }

            unset($oQuery);
            unset($oQuery2);
            return $aStatus;
        }

        // Functionality : Event delete
        // Parameters : -
        // Creater : 02/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMTCKBchLocPdtDeleteData($paData){
            try {
                $this->db->trans_begin();

                $this->db->where_in('FTLocCode', $paData['ptLocCode']);
                $this->db->where_in('FTZneCode', $paData['ptZneCode']);
                $this->db->where_in('FTLzbRefPdt', $paData['ptPdtCode']);
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