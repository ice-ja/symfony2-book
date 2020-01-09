<?php

namespace App\Controller;

use App\Entity\Inquiry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\{ButtonType, SearchType};
use League\Csv\Writer;

/**
 * @Route("/admin/inquiry")
 */
class AdminInquiryListController extends AbstractController
{
    /**
     * @Route("/search.{_format}", defaults={"_format": "html"},
     *     requirements={"_format": "html|csv"}
     *     )
     *
     */
    public function index(Request $request, $_format)
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

        if ($_format == 'csv') {
            $response = new Response($this->createCsv($inquiryList));
            $d = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                'inquiry_list.csv'
            );
            $response->headers->set('Content-Disposition', $d);

            return $response;
        }

        return $this->render('admin/inquiry/index.html.twig', ['form' => $form->createView(),
            'inquiryList' => $inquiryList]);
    }

    private function createSearchForm()
    {
        return $this->createFormBuilder()
            ->add('search', SearchType::class)
            ->add('submit', ButtonType::class, [
                'label' => '検索',
            ])
            ->getForm();
    }

    private function createCsv($inquiryList)
    {
        $writer = Writer::createFromString(",");
        $writer->setNewline("\r\n");

        foreach($inquiryList as $inquiry){
            /** @var Inquiry $inquiry */
            $writer->insertOne([
                $inquiry->getId(),
                $inquiry->getName(),
                $inquiry->getEmail()
            ]);
        }
        return (string)$writer;
    }
}
