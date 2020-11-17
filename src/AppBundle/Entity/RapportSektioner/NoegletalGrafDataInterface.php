<?php

namespace AppBundle\Entity\RapportSektioner;

interface NoegletalGrafDataInterface {

    /**
     * Gets tekniskelevetid.
     */
    function getTekniskelevetid();

    /**
     * Gets samletBesparelseOverAar.
     */
    function getSamletBesparelseOverAar($years = 1);

}
