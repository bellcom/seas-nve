<?php

namespace AppBundle\Entity\RapportSektioner;

interface ROIGrafDataInterface {

    /**
     * Returns current consumption, kr.
     *
     * @return int;
     */
    function getNuvaerendeForbrugKr ();

    /**
     * Returns optimized consumption, kr.
     *
     * @return int;
     */
    function getOptimeretForbrugKr ();

    /**
     * Returns investments, kr.
     *
     * @return int;
     */
    function getInvestering ();
}
