<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Monster;
use App\Form\CommentaireType;
use App\Form\MonsterType;
use App\Repository\MonsterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MonsterController extends AbstractController
{
    #[Route('/monster', name: 'app_monster')]
    public function index(MonsterRepository $monsterRepository): Response
    {

        $monster = $monsterRepository->findAll();
        return $this->render('monster/index.html.twig', [
            'controller_name' => 'MonsterController',
            'monsters' => $monster
        ]);
    }

    #[Route('/monster/show/{id}', name: 'show_monster')]
    public function show(Monster $monster): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);

        return $this->render('monster/show.html.twig', [
            'controller_name' => 'MonsterController',
            'monster' => $monster,
            'form' => $form->createView()
        ]);
    }

    #[Route('/monster/new', name: 'create_monster')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $monster = new Monster();
        $form = $this->createForm(MonsterType::class, $monster);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($monster);
            $manager->flush();
            return $this->redirectToRoute('show_monster', ['id' => $monster->getId()]);
        }
        return $this->render('monster/create.html.twig', [
            'controller_name' => 'MonsterController',
            'formulaire' => $form->createView()
        ]);
    }

    #[Route('/monster/edit/{id}', name: 'edit_monster')]
    public function edit(Request $request, EntityManagerInterface $manager, Monster $monster): Response
    {

        $form = $this->createForm(MonsterType::class, $monster);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($monster);
            $manager->flush();
            return $this->redirectToRoute('show_monster', ['id' => $monster->getId()]);
        }

        return $this->render('monster/create.html.twig', [
            'controller_name' => 'MonsterController',
            'formulaire' => $form->createView()
        ]);
    }

    #[Route('/monster/delete/{id}', name: 'delete_monster')]
    public function delete(EntityManagerInterface $manager, Monster $monster): Response
    {
        $manager->remove($monster);
        $manager->flush();

        return $this->redirectToRoute('app_monster');

    }
}
