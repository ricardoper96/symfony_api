<?php
namespace App\Controller;
use App\Traits\HandleRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController
extends AbstractController
{
    use HandleRequest;

protected $entityManager;


public function __construct(EntityManagerInterface $entityManager)
{
    $this->entityManager =$entityManager;
}
}