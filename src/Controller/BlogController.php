<?php

namespace App\Controller;

use App\Entity\BlogArticle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    public function latestList()
    {
        $em = $this->getDoctrine()->getManager();

        $blogArticleRepository = $em->getRepository(BlogArticle::class);
        $blogList = $blogArticleRepository->findBy([], ['targetDate' => 'DESC']);

        return $this->render('Blog/latestList.html.twig',
            [
                'blogList' => $blogList
            ]);
    }
}
