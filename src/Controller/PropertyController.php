<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
use Doctrine\ORM\Mapping\Id;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ContainerWKIk2Bf\PaginatorInterface_82dac15;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{
    //dans index on recupere le repository(quand on a plusieur methode qui font appel au repository)
    public function __construct(PropertyRepository $repository)
    {
      $this->repository= $repository;  
      
    }
    
    #[Route('/biens', name: 'property.index')]
    public function index(PaginatorInterface  $paginator, Request $request): Response
    {
        
   
      $search=new PropertySearch();  

      $form = $this->createForm(PropertySearchType::class, $search);

      $form->handleRequest($request);
      
      
      $properties = $paginator->paginate($this->repository->findAllVisibleQuery($search),
        $request->query->getInt('page', 1),
        12/*la limite a mettre en place*/);
        /*$property[0]->setSold(true);
        $this->em->flush();*/
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties'=>$properties,
            'form'=> $form->createView()
        ]);
    }

        
         /**
          * @Route("/biens-{id}", name= "property.show")
         * @param Property $property
         * @return response
         */

        public function show(Property $property, Request $request, ContactNotification $notification): Response
        {

          $contact= new Contact();

          $contact->setProperty($property);

          $form= $this->createForm(ContactType::class, $contact);

          $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {

            $notification->notify($contact);

            $this->addFlash('success', 'Votre email a bien ete envoye');

            /*$this->redirectToRoute('property.show', [
              'id'=> $property->getId()
            ]);*/
          } 

          // $property = $this->repository->find($id);
            return $this->render('property/show.html.twig', [
                'property'=> $property,
                'current_menu' => 'properties',
                'form'=> $form->createView()
            ]);
        }
    
}
