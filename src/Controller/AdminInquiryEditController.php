<?php

namespace App\Controller;

use App\Entity\Inquiry;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\{
    ChoiceType,
    SubmitType,
    TextareaType,
    TextType
};
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/inquiry")
 */
class AdminInquiryEditController extends AbstractController
{
    /**
     * @Route("/{id}/edit", methods={"GET"})
     * @ParamConverter("inquiry", class="App:Inquiry")
     */
    public function input(Inquiry $inquiry)
    {
        $form = $this->createInquiryForm($inquiry);

        return $this->render('Admin/Inquiry/edit.html.twig',
            [
                'form' => $form->createView(),
                'inquiry' => $inquiry
            ]);
    }

    /**
     * @Route("/{id}/edit", methods={"POST"})
     * @ParamConverter("inquiry", class="App:Inquiry")
     */
    public function inputPost(Request $request, Inquiry $inquiry)
    {
        $form = $this->createInquiryForm($inquiry);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();;
            return $this->redirectToRoute('app_admininquirylist_index');
        }

        return $this->render('Admin/Inquiry/edit.html.twig',
            [
                'form' => $form->createView(),
                'inquiry' => $inquiry
            ]);
    }

    public function createInquiryForm(Inquiry $inquiry)
    {
        return $this->createFormBuilder($inquiry, ["validation_groups" => ["admin"]])
            ->add('processStatus', ChoiceType::class, [
                'choices' => [
                    '未対応' => '0',
                    '対応中' => '1',
                    '対応済み' => '2',
                ],
                //MEMO
                //empty_dataは空文字が送信された場合にセットする値
                //(元々entityが空だった場合にViewで表示される値ではない)
                'empty_data' => '0',
                'expanded' => true,
            ])
            ->add('processMemo', TextAreaType::class, [
                //MEMO
                //Entityが既にに存在している場合、フォームで空文字列を送信すると、
                //handleRequest実行時にnullが代入になってしまうため空文字がセットされるようにする。
                'empty_data' => '',
            ])
            ->add('submit', SubmitType::class, [
                'label' => '保存',
            ])
            ->getForm();
    }
}
