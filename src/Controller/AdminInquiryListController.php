<?php

namespace App\Controller;

use App\Entity\Inquiry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\{
    SubmitType,
    SearchType
};

/**
 * @Route("/admin/inquiry")
 */
class AdminInquiryListController extends AbstractController
{
    /**
     * @Route("/search")
     */
    public function index(Request $request)
    {
        $form = $this->createSearchForm();
        $form->handleRequest($request);
        $keyword = null;
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $keyword = $form->get('search')->getData();
            }
        }

        $em = $this->getDoctrine()->getManager();
        $inquiryRepository = $em->getRepository(Inquiry::class);

        $inquiryList = $inquiryRepository->findAllByKeyword($keyword);

        return $this->render('admin/inquiry/index.html.twig', ['form' => $form->createView(),
            'inquiryList' => $inquiryList]);
    }

    private
    function createSearchForm()
    {
        return $this->createFormBuilder()
            ->add('search', SearchType::class)
            ->add('submit', SubmitType::class, [
                'label' => '検索',
            ])
            ->getForm();
    }
}
