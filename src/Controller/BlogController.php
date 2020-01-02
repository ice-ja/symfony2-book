<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    public function latestList()
    {
        $blogList = [
            [
                'targetDate' => '2015年3月15日',
                'title' => '東京公演レポート',
            ],
            [
                'targetDate' => '2015年2月8日',
                'title' => '最近の練習風景',
            ],
            [
                'targetDate' => '2015年1月3日',
                'title' => '本年もよろしくお願いいたします',
            ],
        ];
        return $this->render('blog/latestList.html.twig', [
            'blogList' => $blogList,
        ]);
    }
}
