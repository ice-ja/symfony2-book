<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConcertController extends AbstractController
{
    /**
     * @Route("/concert")
     */
    public function index()
    {

        $concertList = [
            [
                'date' => '2015年5月3日',
                'time' => '14:00',
                'place' => '東京文化会館',
                'available' => false,
            ], [
                'date' => '2015年7月12日',
                'time' => '14:00',
                'place' => '鎌倉芸術館',
                'available' => true,
            ], [
                'date' => '2015年9月20日',
                'time' => '15:00',
                'place' => '横浜みなとみらいホール',
                'available' => true,
            ], [
                'date' => '2015年11月8日',
                'time' => '15:00',
                'place' => 'よこすか芸術劇場',
                'available' => false,
            ], [
                'date' => '2016年1月10日',
                'time' => '14:00',
                'place' => '渋谷公会堂',
                'available' => true,
            ],
        ];
$this->get('router');
        return $this->render('concert/index.html.twig',
            ['concertList' => $concertList]);
    }
}
