<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

    class Pdtpackage_model extends CI_Model {

        // Function : Get data package group from tmp
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGGetDataGroupTmpList($paDataWhere){
            $tMttTableKey   = $paDataWhere['ptMttTableKey'];
            $tMttRefKeyGrp  = $paDataWhere['ptMttRefKeyGrp'];
            $tMttSessionID  = $paDataWhere['ptMttSessionID'];
            $tPdtCode       = $paDataWhere['ptPdtCode'];

            $tSQL = "
                SELECT
                    FNLayNo AS GrpNo,
                    FTPdtCode,
                    FNPkdGrpSeqNo,
                    FTPkdGrpName,
                    FTPkdType,
                    FNLngID,
                    FNPkcQtyAlw,
                    FTPkcStaAlwDup,
                    FTPkcStaSelOrChk,
                    (
                        SELECT COUNT(SubTmp.FTRefPdtCode) AS nRefPdt
                        FROM TsysMasTmp SubTmp WITH(NOLOCK) 
                        WHERE 1 = 1
                            AND SubTmp.FTMttTableKey    = '$tMttTableKey'
                            AND SubTmp.FTMttRefKey      = 'RefPdt' 
                            AND SubTmp.FTMttSessionID   = '$tMttSessionID'
                            AND SubTmp.FTPdtCode        = '$tPdtCode'
                            AND SubTmp.FNLayNo          = MasTmp.FNLayNo
                    ) nRefPdt, 
                    FDLastUpdOn,
                    FTLastUpdBy,
                    FDCreateOn,
                    FTCreateBy
                FROM TsysMasTmp MasTmp WITH(NOLOCK) 
                WHERE 1 = 1
                    AND FTMttTableKey   = '$tMttTableKey'
                    AND FTMttRefKey     = '$tMttRefKeyGrp'
                    AND FTMttSessionID  = '$tMttSessionID'
                    AND FTPdtCode       = '$tPdtCode'
                ORDER BY FNLayNo DESC
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

        // Function : Get data product/location in all package group from tmp
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGGetDataPdtGroupTmp($paDataWhere){
            $tMttTableKey   = $paDataWhere['ptMttTableKey'];
            $tMttRefKeyPdt  = $paDataWhere['ptMttRefKeyPdt'];
            $tMttSessionID  = $paDataWhere['ptMttSessionID'];
            $tPdtCode       = $paDataWhere['ptPdtCode'];
            
            $tSQL = "
                SELECT
                    FNLayNo AS GrpNo,
                    FTPdtCode,
                    FNPkdGrpSeqNo,
                    FTPkdGrpName,
                    FTRefPdtCode AS FTPdtCodeRef,
                    FTPdtName,
                    FTRefPdtCode2 AS FTPdtCodeRef2,
                    FTPdtName2,
                    FNPkdPdtQty,
                    FTPkdType
                FROM TsysMasTmp MasTmp WITH(NOLOCK)
                WHERE 1 = 1
                    AND FTMttTableKey   = '$tMttTableKey'
                    AND FTMttRefKey     = '$tMttRefKeyPdt'
                    AND FTMttSessionID  = '$tMttSessionID'
                    AND FTPdtCode       = '$tPdtCode'
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

        // Function : Get data product/location package group from tmp by seq
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGGetDataPdtGroupTmpBySeq($paDataWhere){
            $tMttTableKey  = $paDataWhere['ptMttTableKey'];
            $tMttRefKey    = $paDataWhere['ptMttRefKeyPdt'];
            $tMttSessionID = $paDataWhere['ptMttSessionID'];
            $tPdtCode      = $paDataWhere['ptPdtCode'];
            $nGrpNo        = $paDataWhere['pnGrpNo'];
            
            $tSQL = "
                SELECT
                    FNLayNo         AS GrpNo,
                    FTPdtCode,
                    FNPkdGrpSeqNo,
                    FTPkdGrpName,
                    FTRefPdtCode    AS FTPdtCodeRef,
                    FTPdtName,
                    FTRefPdtCode2   AS FTPdtCodeRef2,
                    FTPdtName2,
                    FNPkdPdtQty,
                    FTPkdType,
                    FNLngID,
                    FDLastUpdOn,
                    FTLastUpdBy,
                    FDCreateOn,
                    FTCreateBy
                FROM TsysMasTmp MasTmp WITH(NOLOCK)
                WHERE 1 = 1
                    AND FTMttTableKey   = '$tMttTableKey'
                    AND FTMttRefKey     = '$tMttRefKey'
                    AND FTMttSessionID  = '$tMttSessionID'
                    AND FTPdtCode       = '$tPdtCode'
                    AND FNLayNo         = '$nGrpNo'
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

        // Function : Clear data in Master
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : -
        public function FSxMPDTPKGClearDataInMaster($ptPdtCode){
            try{
                //Delete Data in Master
                $this->db->where('FTPdtCode', $ptPdtCode);
                $this->db->delete('TTKMPdtPkgGrp');

                $this->db->where('FTPdtCode', $ptPdtCode);
                $this->db->delete('TTKMPdtPkgGrp_L');

                $this->db->where('FTPdtCode', $ptPdtCode);
                $this->db->delete('TTKMPdtPkgCond');

            } catch(Exception $Error){
                return $Error;
            }
        }

        // Function : Clear data in temp
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : -
        public function FSxMPDTPKGClearDataInMasTemp($paWhereClearTemp){
            $tMttTableKey   = $paWhereClearTemp['ptMttTableKey'];
            $tMttRefKey     = $paWhereClearTemp['ptMttRefKey'];
            $tMttSessionID  = $paWhereClearTemp['ptMttSessionID'];
            $tPdtCode       = $paWhereClearTemp['ptPdtCode'];

            $tSQL = "
                DELETE FROM TsysMasTmp 
                WHERE 1=1 
                    AND FTMttTableKey   = '$tMttTableKey'
                    AND FTMttRefKey     IN ($tMttRefKey)
                    AND FTMttSessionID  = '$tMttSessionID'
                    AND FTPdtCode       = '$tPdtCode'
            ";

            $this->db->query($tSQL);
            return;
        }

        // Function : Move data pagkage group from master to temp
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : -
        public function FSxMPDTPKGMovePkgGrpToMasTemp($paDataWhere){
            $nLngID         = $paDataWhere['pnLngID'];
            $tPdtCode       = $paDataWhere['ptPdtCode'];
            $tSesSessionID  = $paDataWhere['ptSesSessionID'];
            $tSesUsername   = $paDataWhere['ptSesUsername'];
            $dLastUpdOn     = $paDataWhere['pdLastUpdOn'];
            $dCreateOn      = $paDataWhere['pdCreateOn'];

            $this->db->where('FTMttTableKey', 'TTKMPdtPkgGrp');
            $this->db->where('FTMttRefKey', 'PkgGrp');
            $this->db->where('FTPdtCode', $tPdtCode);
            $this->db->delete('TsysMasTmp');

            $tSQL = "
                INSERT INTO TsysMasTmp (
                    FNLayNo, FTMttTableKey, FTMttRefKey, FTMttSessionID, FTPdtCode,
                    FNPkdGrpSeqNo, FTPkdGrpName, FNLngID, FTPkdType, FNPkcQtyAlw, FTPkcStaAlwDup, FTPkcStaSelOrChk, 
                    FDLastUpdOn, FDCreateOn, FTLastUpdBy, FTCreateBy
                )
                SELECT 
                    ROW_NUMBER() OVER( ORDER BY  C.FTPdtCode ASC,  C.FNPkdGrpSeqNo ASC
                    ) AS FNRowID, 
                    C.FTMttTableKey, 
                    C.FTMttRefKey, 
                    C.FTMttSessionID, 
                    C.FTPdtCode, 
                    C.FNPkdGrpSeqNo, 
                    C.FTPkdGrpName, 
                    C.FNLngID, 
                    C.FTPkdType, 
                    C.FNPkcQtyAlw, 
                    C.FTPkcStaAlwDup, 
                    C.FTPkcStaSelOrChk, 
                    C.FDLastUpdOn, 
                    C.FDCreateOn, 
                    C.FTLastUpdBy, 
                    C.FTCreateBy 
                FROM (
                    SELECT DISTINCT
                        'TTKMPdtPkgGrp' AS FTMttTableKey,
                        'PkgGrp'		AS FTMttRefKey,
                        CONVERT(VARCHAR,'$tSesSessionID') AS FTMttSessionID,
                        PkgGrp.FTPdtCode, 
                        PkgGrp.FNPkdGrpSeqNo, 
                        PkgGrp_L.FTPkdGrpName, 
                        PkgGrp_L.FNLngID, 
                        PkgCond.FTPkdType, 
                        PkgCond.FNPkcQtyAlw, 
                        PkgCond.FTPkcStaAlwDup, 
                        PkgCond.FTPkcStaSelOrChk, 
                        CONVERT(DATETIME,'$dLastUpdOn') AS FDLastUpdOn,
                        CONVERT(DATETIME,'$dCreateOn') AS FDCreateOn,
                        CONVERT(VARCHAR,'$tSesUsername') AS FTLastUpdBy,
                        CONVERT(VARCHAR,'$tSesUsername') AS FTCreateBy
                        FROM TTKMPdtPkgGrp PkgGrp           WITH(NOLOCK)
                        LEFT JOIN TTKMPdtPkgGrp_L PkgGrp_L WITH(NOLOCK) ON PkgGrp.FTPdtCode = PkgGrp_L.FTPdtCode AND PkgGrp.FNPkdGrpSeqNo = PkgGrp_L.FNPkdGrpSeqNo AND PkgGrp_L.FNLngID = '$nLngID' 
                        LEFT JOIN TTKMPdtPkgCond PkgCond WITH(NOLOCK) ON PkgGrp.FTPdtCode = PkgCond.FTPdtCode AND PkgGrp.FNPkdGrpSeqNo = PkgCond.FNPkdGrpSeqNo 
                        WHERE 1 = 1
                            AND PkgGrp.FTPdtCode = '$tPdtCode'
                ) C
            ";

            $oQuery = $this->db->query($tSQL);
            return;
        }

        // Function : Move data product/location in pagkage group from master to temp
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : -
        public function FSxMPDTPKGMovePkgPdtToMasTemp($paDataWhere){
            $nLngID         = $paDataWhere['pnLngID'];
            $tPdtCode       = $paDataWhere['ptPdtCode'];
            $tSesSessionID  = $paDataWhere['ptSesSessionID'];
            $tSesUsername   = $paDataWhere['ptSesUsername'];
            $dLastUpdOn     = $paDataWhere['pdLastUpdOn'];
            $dCreateOn      = $paDataWhere['pdCreateOn'];

            $this->db->where('FTMttTableKey', 'TTKMPdtPkgGrp');
            $this->db->where('FTMttRefKey', 'RefPdt');
            $this->db->where('FTPdtCode', $tPdtCode);
            $this->db->delete('TsysMasTmp');

            $tSQL = "
                INSERT INTO TsysMasTmp (
                    FNLayNo, FTMttTableKey, FTMttRefKey, FTMttSessionID, FTPdtCode, FTRefPdtCode, 
                    FTPdtName, FTRefPdtCode2, FTPdtName2, FNPkdGrpSeqNo, FTPkdGrpName, FNLngID, FTPkdType, FNPkdPdtQty, 
                    FDLastUpdOn, FDCreateOn, FTLastUpdBy, FTCreateBy
                )
                SELECT 
                    DENSE_RANK() OVER(PARTITION BY C.FTPdtCode ORDER BY C.FNPkdGrpSeqNo ASC ) AS FNRowID,
                    C.FTMttTableKey,
                    C.FTMttRefKey,
                    C.FTMttSessionID,
                    C.FTPdtCode,
                    C.FTPdtCodeRef, 
                    CASE WHEN C.FTPkdType = '1' THEN C.FTPdtName ELSE C.FTLocName END AS FTPdtName, 
                    ISNULL(C.FTPdtCodeRef2, '') FTPdtCodeRef2,
                    ISNULL(c.FTZneName, '') FTPdtName2,
                    C.FNPkdGrpSeqNo,
                    C.FTPkdGrpName,
                    C.FNLngID,
                    C.FTPkdType,
                    C.FNPkdPdtQty,
                    C.FDLastUpdOn,
                    C.FDCreateOn,
                    C.FTLastUpdBy,
                    C.FTCreateBy
                FROM (
                    SELECT
                        'TTKMPdtPkgGrp' AS FTMttTableKey,
                        'RefPdt'		AS FTMttRefKey,
                        CONVERT(VARCHAR,'$tSesSessionID') AS FTMttSessionID,
                        PkgGrp.FTPdtCode, 
                        PkgGrp.FTPdtCodeRef, 
                        Pdt_L.FTPdtName, 
                        Loc_L.FTLocName,
                        PkgGrp.FTPdtCodeRef2, 
                        Zne_L.FTZneName, 
                        PkgGrp.FNPkdGrpSeqNo, 
                        PkgGrp_L.FTPkdGrpName, 
                        PkgGrp_L.FNLngID, 
                        PkgGrp.FTPkdType, 
                        ISNULL(PkgGrp.FNPkdPdtQty, 1) AS FNPkdPdtQty,
                        CONVERT(DATETIME,'$dLastUpdOn') AS FDLastUpdOn,
                        CONVERT(DATETIME,'$dCreateOn') AS FDCreateOn,
                        CONVERT(VARCHAR,'$tSesUsername') AS FTLastUpdBy,
                        CONVERT(VARCHAR,'$tSesUsername') AS FTCreateBy
                        FROM TTKMPdtPkgGrp PkgGrp               WITH(NOLOCK)
                        LEFT JOIN TTKMPdtPkgGrp_L   PkgGrp_L    WITH(NOLOCK) ON PkgGrp.FTPdtCode = PkgGrp_L.FTPdtCode AND PkgGrp.FNPkdGrpSeqNo = PkgGrp_L.FNPkdGrpSeqNo AND PkgGrp_L.FNLngID = '$nLngID'
                        LEFT JOIN TCNMPdt_L         Pdt_L       WITH(NOLOCK) ON PkgGrp.FTPdtCodeRef = Pdt_L.FTPdtCode AND Pdt_L.FNLngID = '$nLngID'
                        LEFT JOIN TTKMBchLocation   Loc         WITH(NOLOCK) ON PkgGrp.FTPdtCodeRef = Loc.FTLocCode
                        LEFT JOIN TTKMBchLocation_L Loc_L       WITH(NOLOCK) ON Loc.FTLocCode = Loc_L.FTLocCode AND Loc_L.FNLngID = '$nLngID'
                        LEFT JOIN TTKMLocZne        Zne         WITH(NOLOCK) ON PkgGrp.FTPdtCodeRef2 = Zne.FTZneCode 
                        LEFT JOIN TTKMLocZne_L      Zne_L       WITH(NOLOCK) ON Zne.FTZneCode = Zne_L.FTZneCode AND Zne_L.FNLngID = '$nLngID' 
                        WHERE 1 = 1
                            AND PkgGrp.FTPdtCode = '$tPdtCode'
                ) C
            ";

            $oQuery = $this->db->query($tSQL);
            return;
        }

        // Function : Add new group to temp
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGInsertDataGroupToTmp($paWhereIns){
            $nLngID         = $paWhereIns['pnLngID'];
            $tPkgPdtCode    = $paWhereIns['ptPkgPdtCode'];
            $tPkgGrpName    = $paWhereIns['ptPkgGrpName'];
            $tSesSessionID  = $paWhereIns['ptSesSessionID'];
            $tSesUsername   = $paWhereIns['ptSesUsername'];
            $dLastUpdOn     = $paWhereIns['pdLastUpdOn'];
            $dCreateOn      = $paWhereIns['pdCreateOn'];

            $aSeqLastGrp = $this->FSaMPDTPKGGetSeqLastGroup($tSesSessionID, $tPkgPdtCode);
            $nLastSeq    = ($aSeqLastGrp['rtCode'] == '1') ? $aSeqLastGrp['rtSeq'] : 0;
            $nNewSeq     = $nLastSeq + 1;

            $aDataInsert = array(
                'FTMttTableKey'     => 'TTKMPdtPkgGrp',
                'FTMttRefKey'       => 'PkgGrp',
                'FTMttSessionID'    => $tSesSessionID,
                'FTPdtCode'         => $tPkgPdtCode,
                'FNPkdGrpSeqNo'     => '',
                'FTPkdGrpName'      => $tPkgGrpName,
                'FNLayNo'           => $nNewSeq,
                'FNLngID'           => $nLngID,
                'FTPkdType'         => 0,
                'FNPkcQtyAlw'       => 1,
                'FTPkcStaAlwDup'    => 2,
                'FTPkcStaSelOrChk'  => 2,
                'FDLastUpdOn'       => $dLastUpdOn,
                'FTLastUpdBy'       => $tSesUsername,
                'FDCreateOn'        => $dCreateOn,
                'FTCreateBy'        => $tSesUsername
            );
            $this->db->insert('TsysMasTmp', $aDataInsert);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode'    => '1',
                    'rtDesc'    => 'Add Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Add.',
                );
            }
            return $aStatus;
        }

        // Function : Update name group to temp
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGUpdateDataGroupToTmp($paWhereUpd){
            $tPkgPdtCode    = $paWhereUpd['ptPkgPdtCode'];
            $tPkgGrpName    = $paWhereUpd['ptPkgGrpName'];
            $nPkgGrpSeq     = $paWhereUpd['ptPkgGrpSeq'];
            $nPkgGrpSeqNo   = $paWhereUpd['ptPkgGrpSeqNo'];
            $tPkgGrpNameOld = $paWhereUpd['ptPkgGrpNameOld'];
            $tSesSessionID  = $paWhereUpd['ptSesSessionID'];
            $tSesUsername   = $paWhereUpd['ptSesUsername'];
            $tMttTableKey   = $paWhereUpd['ptMttTableKey'];
            $tMttRefKey     = $paWhereUpd['ptMttRefKey'];

            $tSQL = "
                UPDATE TsysMasTmp WITH(ROWLOCK)
                SET FTPkdGrpName    = '$tPkgGrpName',
                    FDLastUpdOn     = GETDATE(),
                    FTLastUpdBy     = '$tSesUsername'
                WHERE FTMttTableKey     = '$tMttTableKey'
                    AND FTMttRefKey     = '$tMttRefKey'
                    AND FTMttSessionID  = '$tSesSessionID'
                    AND FTPdtCode       = '$tPkgPdtCode'
                    AND FNLayNo         = '$nPkgGrpSeq'
                    AND FNPkdGrpSeqNo   = '$nPkgGrpSeqNo'
                    AND FTPkdGrpName    = '$tPkgGrpNameOld'
            ";

            $oQuery = $this->db->query($tSQL);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode'    => '1',
                    'rtDesc'    => 'Update Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Update.',
                );
            }

            unset($oQuery);
            return $aStatus;
        }

        // Function : Insert item in group to temp
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGInsertDataPdtGroupToTmp($paWhereIns){
            $nLngID         = $paWhereIns['pnLngID'];
            $nGrpSeq        = $paWhereIns['pnGrpSeq'];
            $tPkgPdtCode    = $paWhereIns['ptPkgPdtCode'];
            $tPdtRefCode    = $paWhereIns['ptPdtRefCode'];
            $tPdtRefName    = $paWhereIns['ptPdtRefName'];
            $tPdtRefCode2   = $paWhereIns['ptPdtRefCode2'];
            $tPdtRefName2   = $paWhereIns['ptPdtRefName2'];
            $tPkgGrpSeqNo   = $paWhereIns['ptPkgGrpSeqNo'];
            $tPkgGrpName    = $paWhereIns['ptPkgGrpName'];
            $nPkgType       = $paWhereIns['pnPkgType'];
            $dLastUpdOn     = $paWhereIns['pdLastUpdOn'];
            $tLastUpdBy     = $paWhereIns['ptLastUpdBy'];
            $dCreateOn      = $paWhereIns['pdCreateOn'];
            $tCreateBy      = $paWhereIns['ptCreateBy'];
            $tSesSessionID  = $paWhereIns['ptSesSessionID'];

            $aDataInsert = array(
                'FTMttTableKey'     => 'TTKMPdtPkgGrp',
                'FTMttRefKey'       => 'RefPdt',
                'FTMttSessionID'    => $tSesSessionID,
                'FTPdtCode'         => $tPkgPdtCode,
                'FTRefPdtCode'      => $tPdtRefCode,
                'FTPdtName'         => $tPdtRefName,
                'FTRefPdtCode2'     => $tPdtRefCode2,
                'FTPdtName2'        => $tPdtRefName2,
                'FNPkdGrpSeqNo'     => $tPkgGrpSeqNo,
                'FTPkdGrpName'      => $tPkgGrpName,
                'FNLayNo'           => $nGrpSeq,
                'FNLngID'           => $nLngID,
                'FTPkdType'         => $nPkgType,
                'FDLastUpdOn'       => $dLastUpdOn,
                'FTLastUpdBy'       => $tLastUpdBy,
                'FDCreateOn'        => $dCreateOn,
                'FTCreateBy'        => $tCreateBy
            );
            $this->db->insert('TsysMasTmp', $aDataInsert);
            if($this->db->affected_rows() > 0){
                $this->db->set('FTPkdType' , $nPkgType);
                $this->db->where('FTMttTableKey' , 'TTKMPdtPkgGrp');
                $this->db->where('FTMttRefKey' , 'PkgGrp');
                $this->db->where('FTMttSessionID' , $tSesSessionID);
                $this->db->where('FTPdtCode' , $tPkgPdtCode);
                $this->db->where('FNLayNo' , $nGrpSeq);
                $this->db->update('TsysMasTmp');
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode'    => '1',
                        'rtDesc'    => 'Add Success.',
                    );
                }else{
                    $aStatus = array(
                        'rtCode'    => '905',
                        'rtDesc'    => 'Error Cannot Add.',
                    );
                }
            }else{
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Add.',
                );
            }
            return $aStatus;
        }

        // Function : Update condition group to temp
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGUpdateGroupCondToTmp($paWhereUpd){
            try{
                $this->db->set('FNPkcQtyAlw' , $paWhereUpd['pnPdtPkgMax']);
                $this->db->set('FTPkcStaAlwDup' , $paWhereUpd['ptStaAlwDup']);
                $this->db->set('FTPkcStaSelOrChk' , $paWhereUpd['ptStaSelOrChk']);

                $this->db->where('FTMttTableKey' , $paWhereUpd['ptMttTableKey']);
                $this->db->where('FTMttRefKey' , $paWhereUpd['ptMttRefKeyGrp']);
                $this->db->where('FTMttSessionID' , $paWhereUpd['ptSesSessionID']);
                $this->db->where('FTPdtCode' , $paWhereUpd['ptPdtCode']);
                $this->db->where('FNLayNo' , $paWhereUpd['pnGrpSeq']);
                $this->db->update('TsysMasTmp');
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode'    => '1',
                        'rtDesc'    => 'Update Success.',
                    );
                }else{
                    $aStatus = array(
                        'rtCode'    => '905',
                        'rtDesc'    => 'Error Cannot Update.',
                    );
                }
                return $aStatus;
            } catch(Exception $Error){
                return $Error;
            }
        }

        // Function : Update pdt qty in group to temp
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGUpdatePdtQtyToTmp($paWhereUpd){
            $tMttTableKey   = $paWhereUpd['ptMttTableKey'];
            $tMttRefKey     = $paWhereUpd['ptMttRefKey'];
            $tSesSessionID  = $paWhereUpd['ptSesSessionID'];
            $tPdtCode       = $paWhereUpd['ptPdtCode'];
            $nGrpSeq        = $paWhereUpd['pnGrpSeq'];
            $nPdtCodeRef    = $paWhereUpd['pnPdtCodeRef'];
            $nPdtQty        = $paWhereUpd['pnPdtQty'];
            $tSesUsername        = $paWhereUpd['ptSesUsername'];

            $tSQL = "
                UPDATE TsysMasTmp WITH(ROWLOCK)
                SET FNPkdPdtQty = '$nPdtQty',
                    FDLastUpdOn     = GETDATE(),
                    FTLastUpdBy     = '$tSesUsername'
                WHERE FTMttTableKey     = '$tMttTableKey'
                    AND FTMttRefKey     = '$tMttRefKey'
                    AND FTMttSessionID  = '$tSesSessionID'
                    AND FTPdtCode       = '$tPdtCode'
                    AND FNLayNo         = '$nGrpSeq'
                    AND FTRefPdtCode    = '$nPdtCodeRef'
            ";

            $oQuery = $this->db->query($tSQL);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode'    => '1',
                    'rtDesc'    => 'Update Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Update.',
                );
            }

            unset($oQuery);
            return $aStatus;
        }

        // Function : Delete pdt/location in group from temp
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGDeleteDataPdtGroupFromTmp($paWhereDel){
            $tMttTableKey  = $paWhereDel['ptMttTableKey'];
            $tMttRefKey    = $paWhereDel['ptMttRefKey'];
            $nLayNo        = $paWhereDel['pnLayNo'];
            $tPdtCode      = $paWhereDel['ptPdtCode'];
            $tRefPdtCode   = $paWhereDel['ptRefPdtCode'];
            $tSesSessionID = $paWhereDel['ptSesSessionID'];

            $tSQL = "
                DELETE FROM TsysMasTmp 
                WHERE 1=1 
                    AND FTMttTableKey   = '$tMttTableKey'
                    AND FTMttRefKey     = '$tMttRefKey'
                    AND FTMttSessionID  = '$tSesSessionID'
                    AND FNLayNo         = '$nLayNo'
                    AND FTPdtCode       = '$tPdtCode'
                    AND FTRefPdtCode    = '$tRefPdtCode'
            ";

            $oQuery = $this->db->query($tSQL);
            
            unset($tSQL);
            unset($oQuery);
            return;
        }
        
        // Function : Delete all pdt/location in group from temp
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGDeleteAllDataPdtGroupFromTmp($paWhereDel){
            $tMttTableKey  = $paWhereDel['ptMttTableKey'];
            $tMttRefKey    = $paWhereDel['ptMttRefKey'];
            $nLayNo        = $paWhereDel['pnLayNo'];
            $tPdtCode      = $paWhereDel['ptPdtCode'];
            $tSesSessionID = $paWhereDel['ptSesSessionID'];

            $tSQL = "
                DELETE FROM TsysMasTmp 
                WHERE 1=1 
                    AND FTMttTableKey   = '$tMttTableKey'
                    AND FTMttRefKey     = '$tMttRefKey'
                    AND FTMttSessionID  = '$tSesSessionID'
                    AND FNLayNo         = '$nLayNo'
                    AND FTPdtCode       = '$tPdtCode'
            ";

            $oQuery = $this->db->query($tSQL);
            
            unset($tSQL);
            unset($oQuery);
            return;
        }

        // Function : Delete group from temp
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGDeleteDataGroupFromTmp($paWhereDel){
            $tMttTableKey      = $paWhereDel['ptMttTableKey'];
            $tMttRefKey        = $paWhereDel['ptMttRefKey'];
            $nLayNo            = $paWhereDel['pnLayNo'];
            $tPdtCode          = $paWhereDel['ptPdtCode'];
            $tSesSessionID     = $paWhereDel['ptSesSessionID'];

            
            
            $tSQL = "
                DELETE FROM TsysMasTmp 
                WHERE 1=1 
                    AND FTMttTableKey   = '$tMttTableKey'
                    AND FTMttRefKey     IN ($tMttRefKey)
                    AND FTMttSessionID  = '$tSesSessionID'
                    AND FNLayNo         = '$nLayNo'
                    AND FTPdtCode       = '$tPdtCode'
            ";
            $oQuery = $this->db->query($tSQL);
            
            unset($tSQL);
            unset($oQuery);
            return;
        }

        
        // Function : Get last seq group
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGGetSeqLastGroup($ptSesSessionID, $ptPkgPdtCode){
            $tSesSessionID  = $ptSesSessionID;
            $tPkgPdtCode    = $ptPkgPdtCode;

            $tSQL = "
                SELECT TOP 1 FNLayNo AS nSeq
                FROM TsysMasTmp WITH(NOLOCK) 
                WHERE 1 = 1
                    AND FTMttTableKey = 'TTKMPdtPkgGrp'
                    AND FTMttRefKey = 'PkgGrp' 
                    AND FTMttSessionID = '$tSesSessionID' 
                    AND FTPdtCode = '$tPkgPdtCode'
                ORDER BY FNLayNo DESC
            ";

            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0) {
                $aDetail        = $oQuery->row_array();
                $aDataReturn    = array(
                    'rtSeq'     => $aDetail['nSeq'],
                    'rtCode'    => '1',
                    'rtDesc'    => 'Success',
                );
            } else {
                $aDataReturn    =  array(
                    'rtCode'    => '800',
                    'rtDesc'    => 'Data not found',
                );
            }

            unset($oQuery);
            unset($aDetail);
            return $aDataReturn;
        }

        // Function : Add data to master
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGAddDataMaster($paDataInsPdt){
            try{
                $this->db->insert('TTKMPdtPkgGrp', array(
                    'FTPdtCode'     => $paDataInsPdt['ptPdtCode'],
                    'FNPkdGrpSeqNo' => $paDataInsPdt['pnPkdGrpSeqNo'],
                    'FTPdtCodeRef'  => $paDataInsPdt['ptPdtCodeRef'],
                    'FTPdtCodeRef2' => $paDataInsPdt['ptPdtCodeRef2'],
                    'FTPkdType'     => $paDataInsPdt['ptPkdType'],
                    'FNPkdPdtQty'   => $paDataInsPdt['pnPdtQty'],
                    'FDLastUpdOn'   => $paDataInsPdt['pdLastUpdOn'],
                    'FTLastUpdBy'   => $paDataInsPdt['ptLastUpdBy'],
                    'FDCreateOn'    => $paDataInsPdt['pdCreateOn'],
                    'FTCreateBy'    => $paDataInsPdt['ptCreateBy']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add Master.',
                    );
                }
                return $aStatus;
            } catch(Exception $Error){
                return $Error;
            }
        }

        // Function : Add name group to master
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGAddDataLang($paDataInsGrp){
            try{
                $this->db->insert('TTKMPdtPkgGrp_L', array(
                    'FTPdtCode'     => $paDataInsGrp['ptPdtCode'],
                    'FNPkdGrpSeqNo' => $paDataInsGrp['pnPkdGrpSeqNo'],
                    'FNLngID'       => $paDataInsGrp['pnLngID'],
                    'FTPkdGrpName'  => $paDataInsGrp['ptPkdGrpName'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add Master.',
                    );
                }
                return $aStatus;
            } catch(Exception $Error){
                return $Error;
            }
        }

        // Function : Add condition group to master
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGAddDataCond($paDataInsGrp){
            try{
                $this->db->insert('TTKMPdtPkgCond', array(
                    'FTPdtCode'     => $paDataInsGrp['ptPdtCode'],
                    'FNPkdGrpSeqNo' => $paDataInsGrp['pnPkdGrpSeqNo'],
                    'FTPkdType'     => $paDataInsGrp['ptPkdType'],
                    'FNPkcQtyAlw'   => $paDataInsGrp['pnPkcQtyAlw'],
                    'FTPkcStaAlwDup' => $paDataInsGrp['ptPkcStaAlwDup'],
                    'FTPkcStaSelOrChk' => $paDataInsGrp['ptPkcStaSelOrChk'],
                    'FDLastUpdOn'   => $paDataInsGrp['pdLastUpdOn'],
                    'FTLastUpdBy'   => $paDataInsGrp['ptLastUpdBy'],
                    'FDCreateOn'    => $paDataInsGrp['pdCreateOn'],
                    'FTCreateBy'    => $paDataInsGrp['ptCreateBy']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add Master.',
                    );
                }
                return $aStatus;
            } catch(Exception $Error){
                return $Error;
            }
        }

        // Function : Update FTPdtSetOrSN to master product
        // Parameters : -
        // Creater : 07/06/2023 Papitchaya
        // Last Update: -
        // Return : Array
        public function FSaMPDTPKGUpdatePdtSetOrSN($paDataUpdPdt){
            try{
                $this->db->set('FTPdtSetOrSN' , $paDataUpdPdt['ptPdtSetOrSN']);
                $this->db->where('FTPdtCode' , $paDataUpdPdt['ptPdtCode']);
                $this->db->update('TCNMPdt');
                
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode'    => '1',
                        'rtDesc'    => 'Update Success.',
                    );
                }else{
                    $aStatus = array(
                        'rtCode'    => '905',
                        'rtDesc'    => 'Error Cannot Update.',
                    );
                }
                return $aStatus;
            } catch(Exception $Error){
                return $Error;
            }
        }
    }

?>