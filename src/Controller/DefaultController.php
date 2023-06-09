<?php
// src/Controller/Defaultontroller.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Repository\UserRepository;

Class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findBy([], ['id' => 'DESC'], 6);

        return $this->render('index.html.twig', [
            'program' => $program,
         ]);
    }

    #[Route('/admin', name: 'admin_index')]
    public function indexAdmin(): Response
    {
        return $this->render('admin.html.twig');
    }

    #[Route('/MyProfil', name: 'Mon_compte')]
    public function MonCompte(): Response
    {
        $user = $this->getUser();
        return $this->render('monCompte.html.twig', ['user' => $user]);
    }
}