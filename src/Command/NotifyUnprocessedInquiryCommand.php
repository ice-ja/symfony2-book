<?php

namespace App\Command;

use App\Entity\Inquiry;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Mailer\MailerInterface;

class NotifyUnprocessedInquiryCommand extends ContainerAwareCommand
{

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('cs:inquiry:notify-unprocessed')
            ->setDescription('未処理お問い合わせ一覧を通知');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $em = $container->get('doctrine')->getManager();
        $inquiryRepository = $em->getRepository(Inquiry::class);

        /** @var ArrayCollection $inquiryList */
        $inquiryList = $inquiryRepository->findUnprocessed();

        if (count($inquiryList) > 0) {

            $output->writeln(count($inquiryList) . "件の未処理お問い合わせがあります");

            if ($this->confirmSend($input, $output)) {
                $this->sendMail($inquiryList);
            }
        } else {
            $output->writeln("未処理なし");
        }
    }

    private function confirmSend($input, $output)
    {
        $qHelper = $this->getHelper('question');

        /** @var Question $question */
        $question = new Question('通知メールを送信しますか？ [y/n]', null);
        $question->setValidator(function ($answer) {
            $answer = strtolower(substr($answer, 0, 1));
            if (!in_array($answer, ['y', 'n'])) {
                throw new \RuntimeException('yまたはnを入力してください');
            }
            return $answer;
        });
        $question->setMaxAttempts(3);
        return $qHelper->ask($input, $output, $question) == 'y';
    }

    private function sendMail($inquiryList)
    {
        $email = (new TemplatedEmail())
            ->from('webmaster@example.com')
            ->to('test@example.com')
            ->subject('[CS] 未処理お問い合わせ通知')
            ->textTemplate('mail/admin_unprocessedInquiryList.txt.twig')
            ->context([
                'inquiryList' => $inquiryList
            ]);
        // メールが送信されないようコメントアウトした
        // $this->mailer->send($email);
    }

}