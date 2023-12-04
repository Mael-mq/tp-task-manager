<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\TaskSession;
use App\Form\TaskSessionType;
use App\Repository\SessionRepository;
use App\Repository\TaskSessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/task-session')]
class TaskSessionController extends AbstractController
{

    #[Route('/new/{id}', name: 'app_task_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SessionRepository $sessionRepository): Response
    {
        $taskSession = new TaskSession();
        $idSession = $request->attributes->get('id');
        $session = $sessionRepository->find($idSession);
        $form = $this->createForm(TaskSessionType::class, $taskSession);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $taskSession->setIsTaskCompleted(false);
            $taskSession->setSession($session);
            $entityManager->persist($taskSession);
            $entityManager->flush();

            return $this->redirectToRoute('app_session_show', ['id'=>$idSession], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task_session/new.html.twig', [
            'task_session' => $taskSession,
            'form' => $form,
        ]);
    }

    #[Route('/{session}/{id}', name: 'app_task_session_delete', methods: ['POST'])]
    public function delete(Request $request, TaskSession $taskSession, EntityManagerInterface $entityManager): Response
    {
        $idSession = $request->attributes->get('session');
        if ($this->isCsrfTokenValid('delete'.$taskSession->getId(), $request->request->get('_token'))) {
            $entityManager->remove($taskSession);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_session_show', ['id'=>$idSession], Response::HTTP_SEE_OTHER);
    }
}
