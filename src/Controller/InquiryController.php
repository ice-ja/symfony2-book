<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\{
    TextType,
    ChoiceType,
    SubmitType
};
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Entity\Inquiry;

/**
 * @Route("/inquiry")
 */
class InquiryController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function index()
    {
        return $this->render('inquiry/index.html.twig', [
            'form' => $this->createInquiryForm()->createView()
        ]);
    }

    /**
     * @Route("/", methods={"POST"})
     */
    public function indexPost(Request $request, MailerInterface $mailer)
    {
        $form = $this->createInquiryForm();
        $form->handleRequest($request);

        if ($form->isValid()) {

//            $data = $form->getData();
//            $inquiry = new Inquiry();
//            $inquiry->setName($data['name']);
//            $inquiry->setEmail($data['email']);
//            $inquiry->setTel($data['tel']);
//            $inquiry->setType($data['type']);
//            $inquiry->setContent($data['content']);
            $inquiry = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($inquiry);
            $em->flush();

            $email = (new TemplatedEmail())
                ->from('webmaster@example.com')
                ->to('test@example.com')
                ->subject('Webサイトからのお知らせ')
                ->textTemplate('mail/inquiry.txt.twig')
                ->context([
                    'data' => $inquiry
                ]);

            // メールが送信されないようコメントアウトした
            // $mailer->send($email);
            return $this->redirectToRoute('app_inquiry_complete');
        }

        return $this->render('inquiry/index.html.twig', [
            'form' => $this->createInquiryForm()->createView()
        ]);
    }

    /**
     * @Route("/complete")
     */
    public function complete()
    {
        return $this->render('inquiry/complete.html.twig');
    }

    private function createInquiryForm()
    {
        return $this->createFormBuilder(new Inquiry())
            ->add('name', TextType::class)
            ->add('email', TextType::class)
            ->add('tel', TextType::class, [
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    '公演について' => 0,
                    'その他' => 1,
                ],
                'expanded' => true,
            ])
            ->add('content', TextType::class)
            ->add('submit', SubmitType::class, [
                'label' => '送信',
            ])
            ->getForm();
    }
}
