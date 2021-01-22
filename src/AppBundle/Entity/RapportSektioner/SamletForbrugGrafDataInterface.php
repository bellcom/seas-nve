<?php

namespace AppBundle\Entity\RapportSektioner;

interface SamletForbrugGrafDataInterface {

    /**
     * Returns current consumption, kWh.
     *
     * @return float;
     */
    function getNuvaerendeForbrug ();

    /**
     * Returns optimized consumption, kWh.
     *
     * @return float;
     */
    function getOptimeretForbrug ();
}
