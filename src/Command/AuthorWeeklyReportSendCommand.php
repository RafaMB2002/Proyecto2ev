<?php

namespace App\Command;

use App\Repository\UserRepository;
use App\Service\MailGenerator;
use App\Service\PdfGenerator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Dompdf\Dompdf;

#[AsCommand(
    name: 'app:create-pdf',
    description: 'Crea un pdf personalizado',
)]
class AuthorWeeklyReportSendCommand extends Command
{
    private $mailGenetator;
    private $pdfGenerator;


    public function __construct(MailGenerator $mailGenerator, PdfGenerator $pdfGenerator)
    {
        parent::__construct();
        $this->mailGenetator = $mailGenerator;
        $this->pdfGenerator = $pdfGenerator;
    }



    protected function configure(): void
    {
        $this
            ->addArgument('destinatario', InputArgument::REQUIRED, 'Correo de la persona a la que va dirigido el mensaje')
            ->addArgument('mensaje', InputArgument::REQUIRED, 'Mensaje')
            ->addArgument('asunto', InputArgument::REQUIRED, 'Asunto');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $destinatario = $input->getArgument('destinatario');
        $mensaje = $input->getArgument('mensaje');
        $asunto = $input->getArgument('asunto');
        //$archivo = $input->getArgument('archivo');

        /* if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        } */

        $archivo = $this->pdfGenerator->createPdf();

        $this->mailGenetator->sendEmail($destinatario, $mensaje, $asunto, 'public/img/avatar/user.png');

        $io->success('Correo enviado correctamente');

        return Command::SUCCESS;
    }

    private function imageToBase64($path)
    {
        $path = $path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}
