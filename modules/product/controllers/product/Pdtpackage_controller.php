<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Pdtpackage_controller extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('product/product/Pdtpackage_model');
    }

    // Function : Get page package product
    // Parameters : -
    // Creater : 07/06/2023 Papitchaya
    // Last Update: -
    // Return : View
    public function FSvCPDTPKGPageData(){
        // Get PdtCode
        $tPdtCode = $this->input->post('tPdtCode');
        $tPdtName = $this->input->post('tPdtName');
        $tFirtImage = $this->input->post('tFirtImage');
        $aDataAdd    = array(
            'tPdtCode'      => $tPdtCode,
            'tPdtName'      => $tPdtName,
            'tFirtImage'    => $tFirtImage
        );
        $this->load->view('product/product/package/wProductPackageData', $aDataAdd);
    }

    // Function : Get data package product
    // Parameters : -
    // Creater : 07/06/2023 Papitchaya
    // Last Update: -
    // Return : Array
    public function FSaCPDTPKGPageDataGroup(){
        try{
            $nLngID         = $this->session->userdata("tLangEdit");
            $tSesSessionID  = $this->session->userdata('tSesSessionID');
            $tSesUsername   = $this->session->userdata('tSesUsername');
            $tPdtCode       = $this->input->post('ptPdtCode');

            // Clear Data In Doc DT Temp
            $aWhereClearTemp = array(
                'ptPdtCode'     => $tPdtCode,
                'ptMttTableKey' => 'TTKMPdtPkgGrp',
                'ptMttRefKey'   => "'PkgGrp', 'RefPdt'",
                'ptMttSessionID' => $tSesSessionID
            );
            $this->Pdtpackage_model->FSxMPDTPKGClearDataInMasTemp($aWhereClearTemp);

            // Move Data Pkg Grp To Mas Temp
            $aWhereMove = array(
                'pnLngID'       => $nLngID,
                'ptPdtCode'     => $tPdtCode,
                'ptSesSessionID'=> $tSesSessionID,
                'ptSesUsername' => $tSesUsername,
                'pdLastUpdOn'   => date('Y-m-d H:i:s'),
                'pdCreateOn'    => date('Y-m-d H:i:s')
            );
            $this->db->trans_begin();
            $this->Pdtpackage_model->FSxMPDTPKGMovePkgGrpToMasTemp($aWhereMove);
            $this->Pdtpackage_model->FSxMPDTPKGMovePkgPdtToMasTemp($aWhereMove);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error move package group to temp.'
                );
            } else {
                $this->db->trans_commit();
                $aDataWhere = array(
                    'pnLngID'        => $nLngID,
                    'ptPdtCode'      => $tPdtCode,
                    'ptMttTableKey'  => 'TTKMPdtPkgGrp',
                    'ptMttRefKeyGrp' => 'PkgGrp',
                    'ptMttRefKeyPdt' => 'RefPdt',
                    'ptMttSessionID' => $tSesSessionID
                );
                $aDataGrp  = $this->Pdtpackage_model->FSaMPDTPKGGetDataGroupTmpList($aDataWhere);
                $aDataPdt  = $this->Pdtpackage_model->FSaMPDTPKGGetDataPdtGroupTmp($aDataWhere);

                $aGenPanal = array(
                    'aDataGrp'  => $aDataGrp,
                    'aDataPdt'  => $aDataPdt,
                );
                $oPdtPkgViewPkgGrop = $this->load->view('product/product/package/wProductPackageDataGroup', $aGenPanal, true);
                $aReturnData = array(
                    'oPdtPkgViewPkgGrop' => $oPdtPkgViewPkgGrop,
                    'nStaEvent'         => '1',
                    'tStaMessg'         => 'Success'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function : Load data package product
    // Parameters : -
    // Creater : 07/06/2023 Papitchaya
    // Last Update: -
    // Return : Array
    public function FSaCPDTPKGLoadDataGroup(){
        try{
            $nLngID         = $this->session->userdata("tLangEdit");
            $tSesSessionID  = $this->session->userdata('tSesSessionID');
            $tPdtCode       = $this->input->post('ptPdtCode');

            $aDataWhere = array(
                'pnLngID'        => $nLngID,
                'ptPdtCode'      => $tPdtCode,
                'ptMttTableKey'  => 'TTKMPdtPkgGrp',
                'ptMttRefKeyGrp' => 'PkgGrp',
                'ptMttRefKeyPdt' => 'RefPdt',
                'ptMttSessionID' => $tSesSessionID
            );
            $aDataGrp = $this->Pdtpackage_model->FSaMPDTPKGGetDataGroupTmpList($aDataWhere);
            $aDataPdt = $this->Pdtpackage_model->FSaMPDTPKGGetDataPdtGroupTmp($aDataWhere);
            $aGenPanal = array(
                'aDataGrp'  => $aDataGrp,
                'aDataPdt'  => $aDataPdt,
            );
            $oPdtPkgViewPkgGrop = $this->load->view('product/product/package/wProductPackageDataGroup', $aGenPanal, true);
            $aReturnData = array(
                'oPdtPkgViewPkgGrop' => $oPdtPkgViewPkgGrop,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function : Add group package to temp
    // Parameters : -
    // Creater : 07/06/2023 Papitchaya
    // Last Update: -
    // Return : Array
    public function FSaCPDTPKGEventAddGroupIntoTemp(){
        try {
            $nLngID         = $this->session->userdata("tLangEdit");
            $tSesSessionID  = $this->session->userdata('tSesSessionID');
            $tSesUsername   = $this->session->userdata('tSesUsername');
            $tPkgPdtCode    = $this->input->post('ohdPdtPkgPdtCode');
            $tPkgGrpName    = $this->input->post('oetPdtPkgGrpName');

            $aWhereIns = array(
                'pnLngID'       => $nLngID,
                'ptPkgPdtCode'  => $tPkgPdtCode,
                'ptPkgGrpName'  => $tPkgGrpName,
                'ptSesSessionID'=> $tSesSessionID,
                'ptSesUsername' => $tSesUsername,
                'pdLastUpdOn'   => date('Y-m-d H:i:s'),
                'pdCreateOn'    => date('Y-m-d H:i:s')
            );

            $this->db->trans_begin();
            $nStaInsGrpToTmp = $this->Pdtpackage_model->FSaMPDTPKGInsertDataGroupToTmp($aWhereIns);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Insert Package Group.'
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Add Package Group.'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function : Edit group package to temp
    // Parameters : -
    // Creater : 07/06/2023 Papitchaya
    // Last Update: -
    // Return : Array
    public function FSaCPDTPKGEventEditGroupIntoTemp(){
        try {
            $tSesSessionID  = $this->session->userdata('tSesSessionID');
            $tSesUsername   = $this->session->userdata('tSesUsername');
            $tPkgPdtCode    = $this->input->post('ohdPdtPkgPdtCode');
            $tPkgGrpName    = $this->input->post('oetPdtPkgGrpName');
            $tPkgGrpNameOld = $this->input->post('ohdPdtPkgGrpNameOld');
            $nPkgGrpSeq     = $this->input->post('ohdPdtPkgGrpSeq');
            $nPkgGrpSeqNo   = $this->input->post('ohdPdtPkgGrpSeqNo');

            $aWhereUpd = array(
                'ptPkgPdtCode'  => $tPkgPdtCode,
                'ptPkgGrpSeq'   => $nPkgGrpSeq,
                'ptPkgGrpSeqNo' => $nPkgGrpSeqNo,
                'ptPkgGrpName'  => $tPkgGrpName,
                'ptPkgGrpNameOld' => $tPkgGrpNameOld,
                'ptSesSessionID'=> $tSesSessionID,
                'ptSesUsername' => $tSesUsername,
                'ptMttTableKey' => 'TTKMPdtPkgGrp',
                'ptMttRefKey'   => 'PkgGrp',
            );

            $this->db->trans_begin();
            $nStaUpdGrpToTmp = $this->Pdtpackage_model->FSaMPDTPKGUpdateDataGroupToTmp($aWhereUpd);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Update Package Group.'
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Update Package Group.'
                );
            }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function : Add product package to temp
    // Parameters : -
    // Creater : 07/06/2023 Papitchaya
    // Last Update: -
    // Return : Array
    public function FSaCPDTPKGEventAddPdtGroupIntoTemp(){
        try {
            $nLngID         = $this->session->userdata("tLangEdit");
            $tSesSessionID  = $this->session->userdata('tSesSessionID');
            $tSesUsername   = $this->session->userdata('tSesUsername');
            $nGrpSeq        = $this->input->post('pnGrpSeq');
            $tPkgPdtCode    = $this->input->post('ptPkgPdtCode');
            $tGrpSeqNo      = $this->input->post('ptGrpSeqNo');
            $tGrpName       = $this->input->post('ptGrpName');
            $tPkgType       = $this->input->post('pnPkgType');
            $aPdtData       = $this->input->post('paPdtData');

            for ($nI = 0; $nI < FCNnHSizeOf($aPdtData); $nI++) {
                if($tPkgType == '1'){
                    $tPdtRefCode = $aPdtData[$nI]['pnPdtCode'];
                    $tPdtRefName = $aPdtData[$nI]['packData']['PDTName'];
                } else {
                    $tPdtRefCode = $aPdtData[$nI]['2'];
                    $tPdtRefName = $aPdtData[$nI]['1'];
                }
                $aWhereIns = array(
                    'ptSesSessionID'=> $tSesSessionID,
                    'pnLngID'       => $nLngID,
                    'pnGrpSeq'      => $nGrpSeq,
                    'ptPkgPdtCode'  => $tPkgPdtCode,
                    'ptPkgGrpSeqNo' => $tGrpSeqNo,
                    'ptPkgGrpName'  => $tGrpName,
                    'ptPdtRefCode'  => $tPdtRefCode,
                    'ptPdtRefName'  => $tPdtRefName,
                    'ptPdtRefCode2' => '',
                    'ptPdtRefName2' => '',
                    'pnPkgType'     => $tPkgType,
                    'pdLastUpdOn'   => date('Y-m-d H:i:s'),
                    'ptLastUpdBy'   => $tSesUsername,
                    'pdCreateOn'    => date('Y-m-d H:i:s'),
                    'ptCreateBy'    => $tSesUsername
                );

                $this->db->trans_begin();
                $nStaInsPdtToTmp = $this->Pdtpackage_model->FSaMPDTPKGInsertDataPdtGroupToTmp($aWhereIns);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent' => '500',
                        'tStaMessg' => 'Error Insert Package Product Group.'
                    );
                } else {
                    $this->db->trans_commit();
                    $aReturnData = array(
                        'nStaEvent' => '1',
                        'tStaMessg' => 'Success Add Package Product Group.'
                    );
                }
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function : Add location/zone package to temp
    // Parameters : -
    // Creater : 07/06/2023 Papitchaya
    // Last Update: -
    // Return : Array
    public function FSaCPDTPKGEventAddLocZneGroupIntoTemp(){
        try {
            $nLngID         = $this->session->userdata("tLangEdit");
            $tSesSessionID  = $this->session->userdata('tSesSessionID');
            $tSesUsername   = $this->session->userdata('tSesUsername');
            $nGrpSeq        = $this->input->post('ohdLocZnePkgGrpSeq');
            $tPkgPdtCode    = $this->input->post('ohdPdtPkgPdtCode');
            $tGrpSeqNo      = $this->input->post('ohdLocZnePkgGrpSeqNo');
            $tGrpName       = $this->input->post('ohdLocZnePkgGrpName');
            $tPkgType       = $this->input->post('ohdLocZnePkgType');
            $tLocCode       = $this->input->post('ohdPdtPkgLocCode');
            $tLocName       = $this->input->post('oetPdtPkgLocName');
            $tZneCode       = $this->input->post('ohdPdtPkgZneCode');
            $tZneName       = $this->input->post('oetPdtPkgZneName');

            $aWhereIns = array(
                'ptSesSessionID'=> $tSesSessionID,
                'pnLngID'       => $nLngID,
                'pnGrpSeq'      => $nGrpSeq,
                'ptPkgPdtCode'  => $tPkgPdtCode,
                'ptPkgGrpSeqNo' => $tGrpSeqNo,
                'ptPkgGrpName'  => $tGrpName,
                'ptPdtRefCode'  => $tLocCode,
                'ptPdtRefName'  => $tLocName,
                'ptPdtRefCode2' => $tZneCode,
                'ptPdtRefName2' => $tZneName,
                'pnPkgType'     => $tPkgType,
                'pdLastUpdOn'   => date('Y-m-d H:i:s'),
                'ptLastUpdBy'   => $tSesUsername,
                'pdCreateOn'    => date('Y-m-d H:i:s'),
                'ptCreateBy'    => $tSesUsername
            );

            $this->db->trans_begin();
            $nStaInsPdtToTmp = $this->Pdtpackage_model->FSaMPDTPKGInsertDataPdtGroupToTmp($aWhereIns);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Insert Package Product Group.'
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Add Package Product Group.'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    public function FSaCPDTPKGEventEditGroupCondIntoTemp(){
        try {
            $tSesSessionID  = $this->session->userdata('tSesSessionID');
            $tPdtCode       = $this->input->post('ptPdtCode');
            $nGrpSeq        = $this->input->post('pnGrpSeq');
            $nPdtPkgMax     = $this->input->post('pnPdtPkgMax');
            $tStaAlwDup     = $this->input->post('ptStaAlwDup');
            $tStaSelOrChk   = $this->input->post('ptStaSelOrChk');

            $aWhereUpd = array(
                'ptMttTableKey' => 'TTKMPdtPkgGrp',
                'ptMttRefKeyGrp'=> 'PkgGrp',
                'ptSesSessionID'=> $tSesSessionID,
                'ptPdtCode'     => $tPdtCode,
                'pnGrpSeq'      => $nGrpSeq,
                'pnPdtPkgMax'   => $nPdtPkgMax,
                'ptStaAlwDup'   => $tStaAlwDup,
                'ptStaSelOrChk' => $tStaSelOrChk,
            );

            $this->db->trans_begin();
            $nStaUpdCond = $this->Pdtpackage_model->FSaMPDTPKGUpdateGroupCondToTmp($aWhereUpd);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error update condition'
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);

    }

    public function FSaCPDTPKGEventEditPdtQtyIntoTemp(){
        try {
            $tSesSessionID  = $this->session->userdata('tSesSessionID');
            $tSesUsername   = $this->session->userdata('tSesUsername');
            $tPdtCode       = $this->input->post('ptPdtCode');
            $nGrpSeq        = $this->input->post('pnGrpSeq');
            $nPdtCodeRef    = $this->input->post('pnPdtCodeRef');
            $nPdtQty        = $this->input->post('pnPdtQty');

            $aWhereUpd = array(
                'ptMttTableKey' => 'TTKMPdtPkgGrp',
                'ptMttRefKey'   => 'RefPdt',
                'ptSesSessionID'=> $tSesSessionID,
                'ptPdtCode'     => $tPdtCode,
                'pnGrpSeq'      => $nGrpSeq,
                'pnPdtCodeRef'  => $nPdtCodeRef,
                'pnPdtQty'      => $nPdtQty,
                'ptSesUsername' => $tSesUsername,
            );

            $this->db->trans_begin();
            $nStaUpdCond = $this->Pdtpackage_model->FSaMPDTPKGUpdatePdtQtyToTmp($aWhereUpd);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error update condition'
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    public function FSaCPDTPKGEventDeletePdtGrpFromTemp(){
        try {
            $tSesSessionID  = $this->session->userdata('tSesSessionID');
            $nGrpSeq        = $this->input->post('pnGrpSeq');
            $tPkgPdtCode    = $this->input->post('ptPkgPdtCode');
            $tCodeRefPdt    = $this->input->post('ptCodeRefPdt');

            $aWhereDel = array(
                'ptMttTableKey' => 'TTKMPdtPkgGrp',
                'ptMttRefKey'   => 'RefPdt',
                'pnLayNo'       => $nGrpSeq,
                'ptPdtCode'     => $tPkgPdtCode,
                'ptRefPdtCode'  => $tCodeRefPdt,
                'ptSesSessionID'=> $tSesSessionID
            );

            $this->db->trans_begin();
            $nStaDelPdt = $this->Pdtpackage_model->FSaMPDTPKGDeleteDataPdtGroupFromTmp($aWhereDel);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => "Error Unsuccess Delete."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete.',
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    } 

    public function FSaCPDTPKGEventDeleteAllPdtGrpFromTemp(){
        try {
            $tSesSessionID  = $this->session->userdata('tSesSessionID');
            $nGrpSeq        = $this->input->post('pnGrpSeq');
            $tPkgPdtCode    = $this->input->post('ptPkgPdtCode');

            $aWhereDel = array(
                'ptMttTableKey' => 'TTKMPdtPkgGrp',
                'ptMttRefKey'   => 'RefPdt',
                'pnLayNo'       => $nGrpSeq,
                'ptPdtCode'     => $tPkgPdtCode,
                'ptSesSessionID'=> $tSesSessionID
            );

            $this->db->trans_begin();
            $nStaDelAllPdt = $this->Pdtpackage_model->FSaMPDTPKGDeleteAllDataPdtGroupFromTmp($aWhereDel);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => "Error Unsuccess Delete."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete.',
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    } 

    public function FSaCPDTPKGEventDeleteGrpFromTemp(){
        try {
            $tSesSessionID  = $this->session->userdata('tSesSessionID');
            $nGrpSeq        = $this->input->post('pnGrpSeq');
            $tPkgPdtCode    = $this->input->post('ptPkgPdtCode');
            $tGrpSeqNo      = $this->input->post('ptGrpSeqNo');

            $aWhereDel = array(
                'ptMttTableKey' => 'TTKMPdtPkgGrp',
                'ptMttRefKey'   => "'PkgGrp', 'RefPdt'",
                'ptSesSessionID'=> $tSesSessionID,
                'pnLayNo'       => $nGrpSeq,
                'ptPdtCode'     => $tPkgPdtCode,
                'pnPkdGrpSeqNo' => $tGrpSeqNo
            );

            $this->db->trans_begin();
            $nStaDelGrp = $this->Pdtpackage_model->FSaMPDTPKGDeleteDataGroupFromTmp($aWhereDel);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => "Error Unsuccess Delete."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete.',
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    public function FSaCPDTPKGEventAddPdtGrpIntoMaster(){
        try {
            $nLngID         = $this->session->userdata("tLangEdit");
            $tSesSessionID  = $this->session->userdata('tSesSessionID');
            $tPdtCode       = $this->input->post('ptPkgPdtCode');

            $aWhereGrp = array(
                'ptMttTableKey'  => 'TTKMPdtPkgGrp',
                'ptMttRefKeyGrp' => 'PkgGrp',
                'ptMttSessionID' => $tSesSessionID,
                'ptPdtCode'      => $tPdtCode,
            );
            $raDataGrp  = $this->Pdtpackage_model->FSaMPDTPKGGetDataGroupTmpList($aWhereGrp);
            if($raDataGrp['rtCode'] == 1){
                $aDataGrp   = $raDataGrp['raItems'];

                $this->db->trans_begin();
                // Clear Data in Master
                $this->Pdtpackage_model->FSxMPDTPKGClearDataInMaster($tPdtCode);

                // วันลูปตามจำนวนกลุ่ม
                for ($nI = 0; $nI < FCNnHSizeOf($aDataGrp); $nI++) {
                    $tPkdGrpSeqNo = "";
                    $tPkdGrpSeqNo = $aDataGrp[$nI]['GrpNo'];
                    $aWherePdt = array(
                        'pnGrpNo'        => $aDataGrp[$nI]['GrpNo'],
                        'ptPdtCode'      => $tPdtCode,
                        'ptMttTableKey'  => 'TTKMPdtPkgGrp',
                        'ptMttRefKeyPdt' => 'RefPdt',
                        'ptMttSessionID' => $tSesSessionID
                    );

                    $raDataPdt  = $this->Pdtpackage_model->FSaMPDTPKGGetDataPdtGroupTmpBySeq($aWherePdt);
                    if($raDataPdt['rtCode'] == 1){
                        $aDataPdt   = $raDataPdt['raItems'];
                        for ($nJ = 0; $nJ < FCNnHSizeOf($aDataPdt); $nJ++) {
                            $aDataInsPdt = array(
                                'ptPdtCode'     => $aDataPdt[$nJ]['FTPdtCode'],
                                'pnPkdGrpSeqNo' => $tPkdGrpSeqNo,
                                'ptPdtCodeRef'  => $aDataPdt[$nJ]['FTPdtCodeRef'],
                                'ptPdtCodeRef2' => $aDataPdt[$nJ]['FTPdtCodeRef2'],
                                'pnPdtQty'      => $aDataPdt[$nJ]['FNPkdPdtQty'],
                                'ptPkdType'     => $aDataPdt[$nJ]['FTPkdType'],
                                'pdLastUpdOn'   => $aDataPdt[$nJ]['FDLastUpdOn'],
                                'ptLastUpdBy'   => $aDataPdt[$nJ]['FTLastUpdBy'],
                                'pdCreateOn'    => $aDataPdt[$nJ]['FDCreateOn'],
                                'ptCreateBy'    => $aDataPdt[$nJ]['FTCreateBy']
                            );
                            $aStaMaster = $this->Pdtpackage_model->FSaMPDTPKGAddDataMaster($aDataInsPdt);
                        }

                        $aDataInsGrp = array(
                            'ptPdtCode'     => $aDataGrp[$nI]['FTPdtCode'],
                            'pnPkdGrpSeqNo' => $tPkdGrpSeqNo,
                            'pnLngID'       => $nLngID,
                            'ptPkdGrpName'  => $aDataGrp[$nI]['FTPkdGrpName'],
                            'ptPkdType'     => $aDataGrp[$nI]['FTPkdType'],
                            'pnPkcQtyAlw'   => $aDataGrp[$nI]['FNPkcQtyAlw'],
                            'ptPkcStaAlwDup' => $aDataGrp[$nI]['FTPkcStaAlwDup'],
                            'ptPkcStaSelOrChk' => $aDataGrp[$nI]['FTPkcStaSelOrChk'],
                            'pdLastUpdOn'   => $aDataGrp[$nI]['FDLastUpdOn'],
                            'ptLastUpdBy'   => $aDataGrp[$nI]['FTLastUpdBy'],
                            'pdCreateOn'    => $aDataGrp[$nI]['FDCreateOn'],
                            'ptCreateBy'    => $aDataGrp[$nI]['FTCreateBy']
                        );
                        $aStaLang = $this->Pdtpackage_model->FSaMPDTPKGAddDataLang($aDataInsGrp);
                        $aStaCond = $this->Pdtpackage_model->FSaMPDTPKGAddDataCond($aDataInsGrp);

                        if($this->db->trans_status() === FALSE){
                            $this->db->trans_rollback();
                            $aReturnData = array(
                                'nStaEvent' => 500,
                                'tStaMessg' => "Error Unsuccess Insert."
                            );
                        }else{
                            $this->db->trans_commit();
                            $aReturnData = array(
                                'nStaEvent' => 1,
                                'tStaMessg' => 'Success Insert.',
                            );
                        }
                    } else {
                        $aReturnData = array(
                            'nStaEvent' => '500',
                            'tStaMessg' => 'Error Insert Package Product Group.'
                        );
                    }
                }
                
                $aDataUpdPdt = array(
                    'ptPdtCode'     => $tPdtCode,
                    'ptPdtSetOrSN'  => 6
                );

                $aStaUpdPdt = $this->Pdtpackage_model->FSaMPDTPKGUpdatePdtSetOrSN($aDataUpdPdt);

                if($aStaUpdPdt['rtCode'] == '1'){
                    $aReturnData = array(
                        'nStaEvent' => 1,
                        'tStaMessg' => 'Success Update PdtSetOrSN.',
                    );
                } else {
                    $aReturnData = array(
                        'nStaEvent' => '500',
                        'tStaMessg' => 'Error Update PdtSetOrSN.'
                    );
                }
            } else {
                $this->db->trans_begin();
                $this->Pdtpackage_model->FSxMPDTPKGClearDataInMaster($tPdtCode);
                if($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent' => 500,
                        'tStaMessg' => "Error Unsuccess."
                    );
                }else{
                    $this->db->trans_commit();
                    $aDataUpdPdt = array(
                        'ptPdtCode'     => $tPdtCode,
                        'ptPdtSetOrSN'  => 1
                    );

                    $aStaUpdPdt = $this->Pdtpackage_model->FSaMPDTPKGUpdatePdtSetOrSN($aDataUpdPdt);

                    if($aStaUpdPdt['rtCode'] == '1'){
                        $aReturnData = array(
                            'nStaEvent' => 1,
                            'tStaMessg' => 'Success Update PdtSetOrSN.',
                        );
                    } else {
                        $aReturnData = array(
                            'nStaEvent' => '500',
                            'tStaMessg' => 'Error Update PdtSetOrSN.'
                        );
                    }
                }
            }


        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }
}