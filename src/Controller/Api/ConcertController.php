<?php

namespace App\Controller\Api;

use App\Entity\Concert;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations AS Rest;

class ConcertController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/api/concerts.{_format}")
     */
    public function getConcerts()
    {
        $em = $this->get('doctrine')->getManager();
        $repository = $em->getRepository(Concert::class);
        $concertList = $repository->findAll();

        return $concertList;
    }
}
