<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use App\Repository\TaskRepository;
use App\Repository\TaskSessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/home/session')]
class PublicSessionController extends AbstractController
{
    #[Route('/', name: 'app_home_session_index', methods: ['GET'])]
    public function index(SessionRepository $sessionRepository): Response
    {
        return $this->render('home_session/index.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_home_session_show', methods: ['GET'])]
    public function show(Session $session, TaskSessionRepository $taskSessionRepository, TaskRepository $taskRepository): Response
    {
        $task_sessions = $taskSessionRepository->findBy(['Session'=>$session->getId()]);
        foreach($task_sessions as $task_session){
            $tasks[] = [
                "idTaskSession" => $task_session->getId(),
                "taskName" => $taskRepository->find($task_session->getTask()->getId())->getName(),
                "taskDescription" => $taskRepository->find($task_session->getTask()->getId())->getDescription(),
                "isTaskCompleted" => $task_session->isIsTaskCompleted()
            ];
        }
        return $this->render('home_session/show.html.twig', [
            'session' => $session,
            'tasks' => $tasks,
            'task_sessions' => $task_sessions
        ]);
    }

    #[Route('/end/{id}', name: 'app_home_session_end', methods: ['GET', 'POST'])]
    public function edit(Session $session, EntityManagerInterface $entityManager): Response
    {
        $date = new \DateTimeImmutable();
        $session->setIsCompleted(true);
        $session->setEndAt($date);
        $entityManager->flush();

        return $this->redirectToRoute('app_home_session_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/task-end/{session}/{id}', name: 'app_task_session_end', methods: ['GET', 'POST'])]
    public function taskEnd(Request $request, TaskSessionRepository $taskSessionRepository, EntityManagerInterface $entityManager): Response
    {
        $sessionId = $request->attributes->get('session');
        $taskSessionId = $request->attributes->get('id');
        $task_session = $taskSessionRepository->find($taskSessionId);
        $task_session->setIsTaskCompleted(true);
        $entityManager->flush();

        return $this->redirectToRoute('app_home_session_show', ['id' => $sessionId ], Response::HTTP_SEE_OTHER);
    }
}
