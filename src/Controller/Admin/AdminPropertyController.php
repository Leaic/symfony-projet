<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\EventListener\Doctrine\UploadListener;

class AdminPropertyController extends AbstractController
{
    #[Route('/admin/admin/property', name: 'app_admin_admin_property')]
    
   
    public function __construct(PropertyRepository $repository)
    {
        /**
        * @var PropertyRepository
        */
        $this->repository=$repository;

        
        
    }


     /**
     * @Route("/admin/admin_property", name="admin.admin_property.index")
     */
    public function index(): Response
    {
        $properties=$this->repository->findAll();

        return $this->render('admin/admin_property/index.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'properties'=>$properties
        ]);
    }



    /**
     * @Route("/admin/admin_property/create", name="admin.admin_property.new")
     */
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $property=new Property();

        $form = $this->createForm(PropertyType::class, $property);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$todoFormData = $form->getData();

            

                //$entityManager = $this->getDoctrine()->getManager();

                $entityManager = $doctrine->getManager();

                $entityManager->persist($property);

                $entityManager->flush();

                $this->addFlash('success', 'Bien creer avec success');

                return $this->redirectToRoute('admin.admin_property.index');
            }

            return $this->render('admin/admin_property/new.html.twig',[
                'property'=>$property,
                'form' => $form->createView()
                ]
            );
    }


        /**
     * @Route("/admin/admin_delete/{id}", name="admin.delete")
     * @param Property $property
     * @return Response
     */
    public function delete(Property $property, Request $request, ManagerRegistry $doctrine, $id)
    {
        //if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
           
            //$em=$this->getDoctrine()->getManager();

            $entityManager = $doctrine->getManager();
            

            dump($property);

            $entityManager->remove($property);

            $entityManager->flush();

            $this->addFlash('success', 'Bien supprimer avec success');

            return $this->redirectToRoute('admin.admin_property.index');

           
            

        //}

        

       // return $this->redirectToRoute('admin.admin_property.index');
        
       //return new Response('maison supprimer');
    }


    /**
     * @Route("/admin/admin_property/{id}", name="admin.admin_property.edit", methods="GET|POST")
     * @param   Property $property
     */
    public function edit(Property $property, Request $request, ManagerRegistry $doctrine): Response
    {

        /*$option=new Option();

        $property->addOption($option);*/

       $form = $this->createForm(PropertyType::class, $property);

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
        //$todoFormData = $form->getData();
            //$entityManager = $this->getDoctrine()->getManager();

           
            $entityManager = $doctrine->getManager();


            $entityManager->flush();
            $this->addFlash('success', 'Bien modifier avec success');
            
            return $this->redirectToRoute('admin.admin_property.index');
       }

        return $this->render('admin/admin_property/edit.html.twig',[
            'property'=>$property,
            'form' => $form->createView()
            ]
        );
    }

}
