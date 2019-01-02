<?php

namespace NFePHP\EFDReinf\Factories;

/**
 * Class EFD-Reinf EvtServPrest Event R-2020 constructor
 *
 * @category  API
 * @package   NFePHP\EFDReinf
 * @copyright NFePHP Copyright (c) 2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-efdreinf for the canonical source repository
 */

use NFePHP\EFDReinf\Common\Factory;
use NFePHP\EFDReinf\Common\FactoryInterface;
use NFePHP\EFDReinf\Common\FactoryId;
use NFePHP\Common\Certificate;
use stdClass;

class EvtServPrest extends Factory implements FactoryInterface
{
    /**
     * Constructor
     * @param string $config
     * @param stdClass $std
     * @param Certificate $certificate
     * @param string $data
     */
    public function __construct(
        $config,
        stdClass $std,
        Certificate $certificate = null,
        $data = ''
    ) {
        $params = new \stdClass();
        $params->evtName = 'evtPrestadorServicos';
        $params->evtTag = 'evtServPrest';
        $params->evtAlias = 'R-2020';
        parent::__construct($config, $std, $params, $certificate, $data);
    }
    
    /**
     * Node constructor
     */
    protected function toNode()
    {
        $ideContri = $this->node->getElementsByTagName('ideContri')->item(0);
        //o idEvento pode variar de evento para evento
        //então cada factory individualmente terá de construir o seu
        $ideEvento = $this->dom->createElement("ideEvento");
        $this->dom->addChild(
            $ideEvento,
            "indRetif",
            $this->std->indretif,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "nrRecibo",
            !empty($this->std->nrrecibo) ? $this->std->nrrecibo : null,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "perApur",
            $this->std->ideestabprest->perapur,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "tpAmb",
            $this->tpAmb,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "procEmi",
            $this->procEmi,
            true
        );
        $this->dom->addChild(
            $ideEvento,
            "verProc",
            $this->verProc,
            true
        );

        $this->node->insertBefore($ideEvento, $ideContri);

        $info = $this->dom->createElement("infoServPrest");
        $ideEstabPrest = $this->dom->createElement("ideEstabPrest");
        $this->dom->addChild(
            $ideEstabPrest,
            "tpInscEstabPrest",
            $this->std->ideestabprest->tpinscestabprest,
            true
        );
        $this->dom->addChild(
            $ideEstabPrest,
            "nrInscEstabPrest",
            $this->std->ideestabprest->nrinscestabprest,
            true
        );
        $ideTomador = $this->dom->createElement("ideTomador");
        $this->dom->addChild(
            $ideTomador,
            "tpInscTomador",
            $this->std->ideestabprest->idetomador->tpinsctomador,
            true
        );
        $this->dom->addChild(
            $ideTomador,
            "nrInscTomador",
            $this->std->ideestabprest->idetomador->nrinsctomador,
            true
        );
        $this->dom->addChild(
            $ideTomador,
            "indObra",
            $this->std->ideestabprest->idetomador->indobra,
            true
        );
        $this->dom->addChild(
            $ideTomador,
            "vlrTotalBruto",
            number_format($this->std->ideestabprest->idetomador->vlrtotalbruto, 2, ',', ''),
            true
        );
        $this->dom->addChild(
            $ideTomador,
            "vlrTotalBaseRet",
            number_format($this->std->ideestabprest->idetomador->vlrtotalbaseret, 2, ',', ''),
            true
        );
        $this->dom->addChild(
            $ideTomador,
            "vlrTotalRetPrinc",
            isset($this->std->ideestabprest->idetomador->vlrtotalretprinc) ? number_format($this->std->ideestabprest->idetomador->vlrtotalretprinc, 2, ',', '') : null,
            true
        );
        $this->dom->addChild(
            $ideTomador,
            "vlrTotalRetAdic",
            !empty($this->std->ideestabprest->idetomador->vlrtotalretadic) ? number_format($this->std->ideestabprest->idetomador->vlrtotalretadic, 2, ',', '') : null,
            false
        );
        $this->dom->addChild(
            $ideTomador,
            "vlrTotalNRetPrinc",
            !empty($this->std->ideestabprest->idetomador->vlrtotalnretprinc) ? number_format($this->std->ideestabprest->idetomador->vlrtotalnretprinc, 2, ',', '') : null,
            false
        );
        $this->dom->addChild(
            $ideTomador,
            "vlrTotalNRetAdic",
            !empty($this->std->ideestabprest->idetomador->vlrtotalnretadic) ? number_format($this->std->ideestabprest->idetomador->vlrtotalnretadic, 2, ',', '') : null,
            false
        );

        foreach ($this->std->ideestabprest->idetomador->nfs as $n) {
            $nfs = $this->dom->createElement("nfs");
            $this->dom->addChild(
                $nfs,
                "serie",
                $n->serie,
                true
            );
            $this->dom->addChild(
                $nfs,
                "numDocto",
                $n->numDocto,
                true
            );
            $this->dom->addChild(
                $nfs,
                "dtEmissaoNF",
                $n->dtEmissaoNF,
                true
            );
            $this->dom->addChild(
                $nfs,
                "vlrBruto",
                number_format($n->vlrBruto, 2, ',', ''),
                true
            );
            $this->dom->addChild(
                $nfs,
                "obs",
                $n->obs ?? null,
                false
            );

            foreach ($n->infoTpServ as $its) {
                $infoTpServ = $this->dom->createElement("infoTpServ");
                $this->dom->addChild(
                    $infoTpServ,
                    "tpServico",
                    $its->tpServico,
                    true
                );
                $this->dom->addChild(
                    $infoTpServ,
                    "vlrBaseRet",
                    number_format($its->vlrBaseRet, 2, ',', ''),
                    true
                );
                $this->dom->addChild(
                    $infoTpServ,
                    "vlrRetencao",
                    number_format($its->vlrRetencao, 2, ',', ''),
                    true
                );
                $this->dom->addChild(
                    $infoTpServ,
                    "vlrRetSub",
                    !empty($its->vlrRetSub) ? number_format($its->vlrRetSub, 2, ',', '') : null,
                    false
                );
                $this->dom->addChild(
                    $infoTpServ,
                    "vlrNRetPrinc",
                    !empty($its->vlrNRetPrinc) ? number_format($its->vlrNRetPrinc, 2, ',', '') : null,
                    false
                );
                $this->dom->addChild(
                    $infoTpServ,
                    "vlrServicos15",
                    !empty($its->vlrServicos15) ? number_format($its->vlrServicos15, 2, ',', '') : null,
                    false
                );
                $this->dom->addChild(
                    $infoTpServ,
                    "vlrServicos20",
                    !empty($its->vlrServicos20) ? number_format($its->vlrServicos20, 2, ',', '') : null,
                    false
                );
                $this->dom->addChild(
                    $infoTpServ,
                    "vlrServicos25",
                    !empty($its->vlrServicos25) ? number_format($its->vlrServicos25, 2, ',', '') : null,
                    false
                );
                $this->dom->addChild(
                    $infoTpServ,
                    "vlrAdicional",
                    !empty($its->vlrAdicional) ? number_format($its->vlrAdicional, 2, ',', '') : null,
                    false
                );
                $this->dom->addChild(
                    $infoTpServ,
                    "vlrNRetAdic",
                    !empty($its->vlrNRetAdic) ? number_format($its->vlrNRetAdic, 2, ',', '') : null,
                    false
                );

                $nfs->appendChild($infoTpServ);
            }
            $ideTomador->appendChild($nfs);
        }
        if (!empty($this->std->ideestabprest->idetomador->infoprocretpr)) {
            foreach ($this->std->ideestabprest->idetomador->infoprocretpr as $irp) {
                $infoProcRetPr = $this->dom->createElement("infoProcRetPr");
                $this->dom->addChild(
                    $infoProcRetPr,
                    "tpProcRetPrinc",
                    $irp->tpProcRetPrinc,
                    true
                );
                $this->dom->addChild(
                    $infoProcRetPr,
                    "nrProcRetPrinc",
                    $irp->nrProcRetPrinc,
                    true
                );
                $this->dom->addChild(
                    $infoProcRetPr,
                    "codSuspPrinc",
                    $irp->codSuspPrinc ?? null,
                    false
                );
                $this->dom->addChild(
                    $infoProcRetPr,
                    "valorPrinc",
                    number_format($irp->valorPrinc, 2, ',', ''),
                    true
                );
                $ideTomador->appendChild($infoProcRetPr);
            }
        }
        if (!empty($this->std->ideestabprest->idetomador->infoprocretad)) {
            foreach ($this->std->ideestabprest->idetomador->infoprocretad as $rad) {
                $infoProcRetAd = $this->dom->createElement("infoProcRetAd");
                $this->dom->addChild(
                    $infoProcRetAd,
                    "tpProcRetAdic",
                    $rad->tpProcRetAdic,
                    true
                );
                $this->dom->addChild(
                    $infoProcRetAd,
                    "nrProcRetAdic",
                    $rad->nrProcRetAdic,
                    true
                );
                $this->dom->addChild(
                    $infoProcRetAd,
                    "codSuspAdic",
                    $rad->codSuspAdic ?? null,
                    false
                );
                $this->dom->addChild(
                    $infoProcRetAd,
                    "valorAdic",
                    number_format($rad->valorAdic, 2, ',', ''),
                    true
                );
                $ideTomador->appendChild($infoProcRetAd);
            }
        }
        $ideEstabPrest->appendChild($ideTomador);
        $info->appendChild($ideEstabPrest);
        $this->node->appendChild($info);
        $this->reinf->appendChild($this->node);
        //$this->xml = $this->dom->saveXML($this->reinf);
        $this->sign($this->evtTag);
    }
}
