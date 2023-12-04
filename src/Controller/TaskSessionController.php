<?php

namespace App\Controller;

use App\Entity\TaskSession;
use App\Form\TaskSessionType;
use App\Repository\TaskSessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/task-session')]
class TaskSessionController extends AbstractController
{
    #[Route('/', name: 'app_task_session_index', methods: ['GET'])]
    public function index(TaskSessionRepository $taskSessionRepository): Response
    {
        return $this->render('task_session/index.html.twig', [
            'task_sessions' => $taskSessionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_task_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $taskSession = new TaskSession();
        $form = $this->createForm(TaskSessionType::class, $taskSession);
        
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            
            $taskSession->setIsTaskCompleted(false);
            $entityManager->persist($taskSession);
            $entityManager->flush();

            return $this->redirectToRoute('app_task_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task_session/new.html.twig', [
            'task_session' => $taskSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_session_show', methods: ['GET'])]
    public function show(TaskSession $taskSession): Response
    {
        return $this->render('task_session/show.html.twig', [
            'task_session' => $taskSession,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TaskSession $taskSession, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskSessionType::class, $taskSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_task_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task_session/edit.html.twig', [
            'task_session' => $taskSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_session_delete', methods: ['POST'])]
    public function delete(Request $request, TaskSession $taskSession, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taskSession->getId(), $request->request->get('_token'))) {
            $entityManager->remove($taskSession);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_task_session_index', [], Response::HTTP_SEE_OTHER);
    }
}
