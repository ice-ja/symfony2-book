<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminMenuController extends AbstractController
{
    /**
     * @Route("/admin/")
     */
    public function index()
    {
        return $this->render('Admin/Common/index.html.twig');
    }
}
