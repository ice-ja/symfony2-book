<?php

namespace App\Controller;

use App\Entity\MemberCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/member")
 */
class MemberController extends Controller
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function index()
    {
        // サービスを直接getするにはControllerクラスをextendsしないとエラーになってしまった。
        // Symfony4の場合はコンストラクタインジェクションするのが推奨だが、
        // Extensionでregisterしたサービスをコンストラクタインジェクションする方法がわからなかった・・。
        $memberCollection = $this->get('app.member_collection');

        return $this->render('Member/index.html.twig',
            [
                'memberCollection' => $memberCollection
            ]);
    }
}
