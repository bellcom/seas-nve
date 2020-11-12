<?php

namespace AppBundle\PdfExport;

use AppBundle\Entity\Bygning;
use AppBundle\Entity\RapportSektioner\RapportSektion;
use AppBundle\Entity\VirksomhedRapport;

class VirksomhedPdfExport {

    use PdfExportTrait;

    /**
     * Overview rapport render callback.
     *
     * @param VirksomhedRapport $rapport
     * @param array $options
     * @param false $review
     * @return mixed
     */
    public function exportOverview(VirksomhedRapport $rapport, array $options = array(), $review = FALSE)
    {
        $repository = $this->_em->getRepository('AppBundle:VirksomhedRapport');
        $sections = $repository->getOverviewRapportSektionerSorted($rapport);
        $cover_sections = array();
        /** @var RapportSektion $section */
        foreach ($sections as $key => $section) {
            $section->setEditUrl($this->router->generate('virksomhed_oversigt_rapport_sektioner_edit', array(
                'virksomhed_rapport' => $rapport->getId(),
                'id' => $section->getId(),
                'destination' => $this->router->generate('virksomhed_rapport_pdf_review', array('id' => $rapport->getId(), 'type' => 'oversigt')) . '#section-'. $section->getType() . $section->getId(),
            )));
            if (in_array($section->getType(), array('forside', 'kontaktinformation'))) {
                unset($sections[$key]);
                $cover_sections[] = $section;
            }
        }
        $data = array();
        $virksomhed = $rapport->getVirksomhed();

        if ($virksomhed && $virksomhedsNavn = $virksomhed->getName()) {
            $data[] = $virksomhedsNavn;
        }

        if ($screeningAt = $rapport->getDatering()) {
            $data[] = 'Screeningsdato: ' . $screeningAt->format('d.m.Y');
        }

        if ($updatedAt = $rapport->getUpdatedAt()) {
            $data[] = 'Opdateret: ' . $updatedAt->format('d.m.Y');
        }
        $default = array(
            'review' => $review,
        );
        $cover = $this->renderView('AppBundle:VirksomhedRapport:showPdfOverview.html.twig', array(
            'sections' => $cover_sections,
        ) + $default);
        $html = $this->renderView('AppBundle:VirksomhedRapport:showPdfOverview.html.twig', array(
            'sections' => $sections,
        ) + $default);
        return $review ? ($cover . $html) : $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
            array('lowquality' => FALSE,
                'encoding' => 'utf-8',
                'images' => TRUE,
                'cover' => $cover,
                'toc' => TRUE,
                'xsl-style-sheet' => $_SERVER['DOCUMENT_ROOT'] . '/../default-toc.xsl',
                'toc-header-text' => 'Indholdfortegnelse',
                'header-left' => implode(' | ', $data),
                'header-right' => "Side [page] af [toPage]",
                'footer-html' => $this->container->get('request')->getSchemeAndHttpHost().'/html/pdf2VirksomhedFooter.html'),
            $options));
    }

    /**
     * Old version of overview to be deleted.
     *
     * @deprecated
     * @param VirksomhedRapport $rapport
     * @param array $options
     * @param false $review
     * @return string
     */
    public function exportOverviewOld(VirksomhedRapport $rapport, array $options = array(), $review = FALSE) {
        $data = array();
        $virksomhed = $rapport->getVirksomhed();

        if ($virksomhed && $virksomhedsNavn = $virksomhed->getName()) {
            $data[] = $virksomhedsNavn;
        }

        if ($screeningAt = $rapport->getDatering()) {
            $data[] = 'Screeningsdato: ' . $screeningAt->format('d.m.Y');
        }

        if ($updatedAt = $rapport->getUpdatedAt()) {
            $data[] = 'Opdateret: ' . $updatedAt->format('d.m.Y');
        }

        $coverParams = array(
            'rapport' => $rapport,
            'review' => $review,
        );
        if ($virksomhed && $virksomhedsType = $virksomhed->getTypeNameLabel()) {
            $coverParams['typenavn'] = $virksomhedsType;
        }
        $cover = $this->renderView('AppBundle:VirksomhedRapport:showPdf2Cover.html.twig', $coverParams);

        $html = $this->renderView('AppBundle:VirksomhedRapport:showPdf2.html.twig', array(
            'rapport' => $rapport,
            'review' => $review,
        ));

        return $review ? ($cover . $html) : $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
            array('lowquality' => false,
                'encoding' => 'utf-8',
                'images' => true,
                'cover' => $cover,
                'header-left' => implode(' | ', $data),
                'header-right' => "Side [page] af [toPage]",
                'footer-html' => $this->container->get('request')->getSchemeAndHttpHost().'/html/pdf2VirksomhedFooter.html'),
            $options));
    }

    public function exportKortlaegning(VirksomhedRapport $rapport, array $options = array(), $review = FALSE) {
        $data = array();
        $virksomhed = $rapport->getVirksomhed();
        $datterSelskaber = $rapport->getVirksomhed()->getDatterSelskaber(TRUE);

        if ($virksomhed && $virksomhedsNavn = $virksomhed->getName()) {
            $data[] = $virksomhedsNavn;
        }

        if ($screeningAt = $rapport->getDatering()) {
            $data[] = 'Screeningsdato: ' . $screeningAt->format('d.m.Y');
        }

        if ($updatedAt = $rapport->getUpdatedAt()) {
            $data[] = 'Opdateret: ' . $updatedAt->format('d.m.Y');
        }

        $coverParams = array(
            'rapport' => $rapport,
            'review' => $review,
        );

        if ($virksomhed && $virksomhedsType = $virksomhed->getTypeNameLabel()) {
            $coverParams['typenavn'] = $virksomhedsType;
        }
        $cover = $this->renderView('AppBundle:VirksomhedRapport:showPdfKortlaegningCover.html.twig', $coverParams);

        // Summarized data for energiFordeling pie chart.
        $energiFordeling = array(
            array(
                'label' => 'El',
                'value' => $rapport->getSummarized('BaselineEl'),
            ),
            array(
                'label' => 'Varme',
                'value' =>  $rapport->getSummarized('BaselineVarme'),
            ),
            array(
                'label' => 'Brændstof',
                'value' =>  $rapport->getSummarized('BaselineBraendstof'),
            ),
        );
        $pieChartData['energiFordeling'] = $energiFordeling;

        // Split data for overordnetForrug pie chart for each virksomhed.
        $overordnetForrug = array(
            array(
                'label' => $rapport->getVirksomhed()->__toString(),
                'value' => $rapport->calculateSamletEnergiForbrug(),
            ),
        );
        foreach ($datterSelskaber as $datterSelskab) {
            if (empty($datterSelskab->getRapport())) {
                continue;
            }
            $overordnetForrug[] = array(
                'label' => $datterSelskab->getRapport()->getVirksomhed()->__toString(),
                'value' => $datterSelskab->getRapport()->calculateSamletEnergiForbrug(),
            );
        }
        $pieChartData['overordnetForrug'] = $overordnetForrug;

        // Split data for elForrug pie chart for each virksomhed.
        $elForrug = array();
        $row = array(
            'label' => $rapport->getVirksomhed()->__toString(),
            'value' => $rapport->getBaselineEl(),
            'erhvervsareal' => $rapport->getErhvervsareal(),
        );
        $row['kpi'] = $row['erhvervsareal'] ? $row['value'] / $row['erhvervsareal'] : NULL;
        $elForrug[] = $row;
        foreach ($datterSelskaber as $datterSelskab) {
            if (empty($datterSelskab->getRapport())) {
                continue;
            }
            $row = array(
                'label' => $datterSelskab->getRapport()->getVirksomhed()->__toString(),
                'value' => $datterSelskab->getRapport()->getBaselineEl(),
                'erhvervsareal' => $datterSelskab->getRapport()->getErhvervsareal(),
            );
            $row['kpi'] = $row['erhvervsareal'] ? $row['value'] / $row['erhvervsareal'] : NULL;
            $elForrug[] = $row;
        }
        $pieChartData['elForrug'] = $elForrug;

        // Split data for varmeForrug pie chart for each virksomhed.
        $varmeForrug = array();
        $row = array(
            'label' => $rapport->getVirksomhed()->__toString(),
            'value' => $rapport->getBaselineVarme(),
            'opvarmetareal' => $rapport->getOpvarmetareal(),
        );
        $row['kpi'] = $row['opvarmetareal'] ? $row['value'] / $row['opvarmetareal'] : NULL;
        $varmeForrug[] = $row;
        foreach ($datterSelskaber as $datterSelskab) {
            if (empty($datterSelskab->getRapport())) {
                continue;
            }
            $row = array(
                'label' => $datterSelskab->getRapport()->getVirksomhed()->__toString(),
                'value' => $datterSelskab->getRapport()->getBaselineVarme(),
                'opvarmetareal' => $datterSelskab->getRapport()->getOpvarmetareal(),
            );
            $row['kpi'] = $row['opvarmetareal'] ? $row['value'] / $row['opvarmetareal'] : NULL;
            $varmeForrug[] = $row;
        }
        $pieChartData['varmeForrug'] = $varmeForrug;

        // Split data for varmeForrug pie chart for each virksomhed.
        $braendstofForrug = array();
        $row = array(
            'label' => $rapport->getVirksomhed()->__toString(),
            'value' => $rapport->getBaselineVarme(),
            'erhvervsareal' => $rapport->getOpvarmetareal(),
        );
        $row['kpi'] = $row['erhvervsareal'] ? $row['value'] / $row['erhvervsareal'] : NULL;
        $braendstofForrug[] = $row;
        foreach ($datterSelskaber as $datterSelskab) {
            if (empty($datterSelskab->getRapport())) {
                continue;
            }
            $row = array(
                'label' => $datterSelskab->getRapport()->getVirksomhed()->__toString(),
                'value' => $datterSelskab->getRapport()->getBaselineVarme(),
                'erhvervsareal' => $datterSelskab->getRapport()->getOpvarmetareal(),
            );
            $row['kpi'] = $row['erhvervsareal'] ? $row['value'] / $row['erhvervsareal'] : NULL;
            $braendstofForrug[] = $row;
        }
        $pieChartData['braendstofForbrug'] = $braendstofForrug;

        // Split data for beplarelseSluanvendelse pie chart for each virksomhed.
        $labels = $rapport->getBesparelseSlutanvendelserLabels();
        $chartData = array();
        foreach ($rapport->getBesparelseSlutanvendelser(1) as $key => $value) {
            $chartData[] = array(
                'label' => $labels[$key],
                'value' => $value,
            );
        }
        $beplarelseSluanvendelse = array(
            array(
                'name' => $rapport->getVirksomhed()->getName(),
                'data' => $chartData,
            ),
        );

        foreach ($datterSelskaber as $datterSelskab) {
            if (empty($datterSelskab->getRapport())) {
                continue;
            }
            $chartData = array();
            foreach ($datterSelskab->getRapport()->getBesparelseSlutanvendelser(1) as $key => $value) {
                $chartData[] = array(
                    'label' => $labels[$key],
                    'value' => $value,
                );
            }
            $beplarelseSluanvendelse[] = array(
                'name' => $datterSelskab->getName(),
                'data' => $chartData,
            );
        }
        $pieChartData['beplarelseSluanvendelse'] = $beplarelseSluanvendelse;

        // Split data for elForbrugSluanvendelse pie chart for each virksomhed.
        $labels = $rapport->getBesparelseSlutanvendelserLabels();
        $elForbrugSluanvendelse = array();
        $chartData = array();
        if (!empty($rapport->getVirksomhed()->getKortlaegning())) {
            foreach ($rapport->getVirksomhed()->getKortlaegning()->getSlutanvendelser() as $key => $value) {
                $chartData[] = array(
                    'label' => $labels[$key],
                    'value' => $value['forbrug'],
                );
            }
            $elForbrugSluanvendelse[] = array(
                'name' => $rapport->getVirksomhed()->getName(),
                'data' => $chartData,
            );
        }

        foreach ($datterSelskaber as $datterSelskab) {
            if (empty($datterSelskab->getKortlaegning())) {
                continue;
            }
            $chartData = array();
            foreach ($datterSelskab->getKortlaegning()->getSlutanvendelser() as $key => $value) {
                $chartData[] = array(
                    'label' => $labels[$key],
                    'value' => $value['forbrug'],
                );
            }
            $elForbrugSluanvendelse[] = array(
                'name' => $datterSelskab->getName(),
                'data' => $chartData,
            );
        }
        $pieChartData['elForbrugSluanvendelse'] = $elForbrugSluanvendelse;
        $base_url = $this->container->get('request')->getSchemeAndHttpHost();
        $fm_elfinder_config = $this->container->getParameter('fm_elfinder');
        $uploadsPath =  '/' . $fm_elfinder_config['instances']['default']['connector']['roots']['uploads']['path'];
        if (!empty($uploadsPath)) {
            $uploadsUrl = $base_url . $uploadsPath;
            $rapport->setKortlaegningKonklusionTekst(str_replace('"' . $uploadsPath, '"' . $uploadsUrl, $rapport->getKortlaegningKonklusionTekst()));
            $rapport->setKortlaegningVirksomhedBeskrivelse(str_replace('"' . $uploadsPath, '"' . $uploadsUrl, $rapport->getKortlaegningVirksomhedBeskrivelse()));
        }

        $html = $this->renderView('AppBundle:VirksomhedRapport:showPdfKortlaegning.html.twig', array(
            'rapport' => $rapport,
            'pie_chart_data' => $pieChartData,
            'review' => $review,
        ));

        return $review ? ($cover . $html) : $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
            array('lowquality' => false,
                'encoding' => 'utf-8',
                'images' => true,
                'cover' => $cover,
                'header-left' => implode(' | ', $data),
                'header-right' => "Side [page] af [toPage]",
                'footer-html' => $base_url .'/html/pdfKortlaegningFooter.html'),
            $options));
    }

    public function exportDetailark(VirksomhedRapport $rapport, array $options = array(), $review = FALSE) {
        $data = array();
        $virksomhed = $rapport->getVirksomhed();

        if ($virksomhed && $virksomhedsNavn = $virksomhed->getName()) {
            $data[] = $virksomhedsNavn;
        }

        if ($screeningAt = $rapport->getDatering()) {
            $data[] = 'Screeningsdato: ' . $screeningAt->format('d.m.Y');
        }

        if ($updatedAt = $rapport->getUpdatedAt()) {
            $data[] = 'Opdateret: ' . $updatedAt->format('d.m.Y');
        }

        $html = '';
        /** @var Bygning $bygning */
        foreach ($virksomhed->getAllBygninger() as $bygning) {
            $bygningRaport = $bygning->getRapport();
            if (empty($bygningRaport)) {
                continue;
            }
            $html .= $this->renderView('AppBundle:Rapport:showPdf5CoverBody.html.twig', array(
                'rapport' => $bygningRaport,
            ));

            $html .= $this->renderView('AppBundle:Rapport:showPdf5Body.html.twig', array(
                'rapport' => $bygningRaport,
                'review' => $review,
            ));
        }

        $coverParams = array(
            'rapport' => $rapport,
            'review' => $review,
        );
        if ($virksomhed && $virksomhedsType = $virksomhed->getTypeNameLabel()) {
            $coverParams['typenavn'] = ucfirst($virksomhedsType);
        }
        $cover = $this->renderView('AppBundle:VirksomhedRapport:showPdfDetailarkCover.html.twig', $coverParams);
        $html = $this->renderView('AppBundle:VirksomhedRapport:showPdfDetailark.html.twig', array(
            'html' => $html,
            'review' => $review,
        ));

        return $review ? ($cover . $html) :  $this->container->get('knp_snappy.pdf')->getOutputFromHtml($html, array_merge(
            array('orientation'=>'Landscape',
                'lowquality' => false,
                'encoding' => 'utf-8',
                'images' => true,
                'cover' => $cover,
                'header-left' => implode(' | ', $data),
                'header-right' => "Side [page] af [toPage]",
                'footer-html' => $this->container->get('request')->getSchemeAndHttpHost().'/html/pdfVirksomhedDetailarkFooter.html'),
            $options));
    }

}
