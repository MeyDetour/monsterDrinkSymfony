<?php

namespace App\Controller;

use App\Entity\Commentaire;

use App\Entity\Monster;
use App\Form\CommentaireType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentaireController extends AbstractController
{
    #[Route('/commentaire/new/{id}', name: 'create_comment')]
    public function create(Request $request, EntityManagerInterface $manager,Monster $monster)
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setMonster($monster);
            $manager->persist($commentaire);
            $manager->flush();
            dump($commentaire);
        }
        return $this->redirectToRoute('show_monster', ['id' => $monster->getId()]);
    }
    #[Route('/commentaire/delete/{idMonster}/{id}', name: 'delete_comment')]
    public function delete(  EntityManagerInterface $manager , Commentaire $commentaire , $idMonster )
    {

    $manager->remove($commentaire);
    $manager->flush();
        return $this->redirectToRoute('show_monster', ['id' =>$idMonster]);
    }
}
