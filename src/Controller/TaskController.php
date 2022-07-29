<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController

extends BaseController
{
    protected $taskRepository;

    public function __construct(EntityManagerInterface $entityManager, TaskRepository $taskRepository )
    {
        parent::__construct($entityManager);
        $this->taskRepository =$taskRepository;
    }
    #[Route('/store/task', methods:'POST')]
public function storeTask(Request $request){
       $data = json_decode($request->getContent(),true);
       $name = $data['name'];
       $description = $data['description'];
       $price =(float) $data['price'];
       $task = $this->taskRepository->storeTask($name,$description,$price);

       return $this->json($task);


    }

        #[Route('/get/task', methods:'GET')]
public function getTask(Request $request){
          $tasks = $this->taskRepository->findAll();
          return $this->json($tasks);

    }
       #[Route('/update/task/{id}', methods: 'PUT')]
    public function updateTask($id,Request $request){
        $task = $this->taskRepository->find($id);
        if(!empty($task)){
            $data = json_decode($request->getContent(), true);

            $name = $data['name'];
            $description = $data['description'];
            $price = $data['price'];

            $task= $this->taskRepository->updateTask($task, $name, $description, $price);

            return $this->json($task);


        }
        return new Response('tarea no encontrada');
    }
  #[Route('/delete/task/{id}' , methods: 'DELETE')]

     public function delete($id): JsonResponse
  {
      $task = $this->taskRepository->findOneBy(['id' => $id]);

      $this->taskRepository->taskRemove($task, true);

      return  $this->json($task, Response::HTTP_OK);
  }
}