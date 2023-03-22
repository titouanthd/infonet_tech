<?php

namespace App\Controller\Admin;

use App\Entity\Character;
use App\Form\CharacterType;
use App\Service\FileUploader;
use App\Repository\CharacterRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/character')]
class CharacterController extends AbstractController
{
    #[Route('/', name: 'app_admin_character_index', methods: ['GET'])]
    public function index(CharacterRepository $characterRepository): Response
    {
        return $this->render('admin/character/index.html.twig', [
            'characters' => $characterRepository->findAll(),
            'page_title' => 'Characters index',
        ]);
    }
    
    #[Route('/new', name: 'app_admin_character_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CharacterRepository $characterRepository, FileUploader $fileUploader): Response
    {
        $character = new Character();
        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();

            if ($picture) {
                $uploadedFilePath = $fileUploader->upload($picture);
                $character->setPicture($uploadedFilePath);
            }

            $characterRepository->save($character, true);
            // add a flash message
            $this->addFlash('success', 'Character created successfully');

            return $this->redirectToRoute('app_admin_character_show', ['id' => $character->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/character/new.html.twig', [
            'character' => $character,
            'page_title' => 'New character',
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_character_show', methods: ['GET'])]
    public function show(Character $character): Response
    {
        return $this->render('admin/character/show.html.twig', [
            'character' => $character,
            'page_title' => 'Character details',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_character_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Character $character, CharacterRepository $characterRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();

            if ($picture) {
                $uploadedFilePath = $fileUploader->upload($picture);
                $character->setPicture($uploadedFilePath);
            }

            $characterRepository->save($character, true);
            // add a flash message
            $this->addFlash('success', 'Character updated successfully');

            return $this->redirectToRoute('app_admin_character_show', ['id' => $character->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/character/edit.html.twig', [
            'character' => $character,
            'page_title' => 'Edit character',
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_character_delete', methods: ['POST'])]
    public function delete(Request $request, Character $character, CharacterRepository $characterRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$character->getId(), $request->request->get('_token'))) {
            $characterRepository->remove($character, true);
            // add a flash message
            $this->addFlash('success', 'Character deleted successfully');
        }

        return $this->redirectToRoute('app_admin_character_index', ['id' => $character->getId()], Response::HTTP_SEE_OTHER);
    }
}
