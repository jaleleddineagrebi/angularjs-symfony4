<?php

namespace App\Controller;


use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;

class FirstController extends AbstractController
{
    /**
     * @Route("/page", name="page")
     */
    public function index()
    {
        return $this->render('first/home.html.twig');
    }
    /**
     * @Route("/first", name="first")
     */
    public function test()
    {
       //$livre = new livre();
       $liv = $this->getDoctrine()->getRepository(Livre::class)->findAll();
        $data = $this->get('serializer')->serialize($liv,'json');
        return new JsonResponse(json_decode($data));

    }

    /**
     * @Route("/first", name="livre_home", methods="GET")
     */
    public function list(LivreRepository $livreRepository): Response
    {
        return $this->render('livre/index.html.twig', ['livres' => $livreRepository->findAll()]);
    }
    /**
    * @Route("/create" ,name="create")
    */
    public function create (Request $request ,ObjectManager $manager,LivreRepository $livreRepository){

     $livreRepository->findby();
      if ($request->request->count() > 0) {
        $livre = new Livre();
        $titre=$request->request->get('titre');
        $livre->setTitre($titre)
              ->setDescription($request->request->get('description'))
              ->setPaye($request->request->get('paye'));

              $manager->persist($livre);
              $manager->flush();
        // code...
      }
      return $this->render('livre/create.html.twig');
    }
}
