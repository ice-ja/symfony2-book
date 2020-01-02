<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ToppageController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $information = "5月と6月の公園情報を追加しました。";

        return $this->render('toppage/index.html.twig', ['information' => $information]);
    }
}
