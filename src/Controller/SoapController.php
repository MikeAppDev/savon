<?php

namespace App\Controller;

use App\Entity\Soap;
use App\Form\SoapType;
use App\Repository\SoapRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/soap')]
class SoapController extends AbstractController
{
    #[Route('/', name: 'app_soap_index', methods: ['GET'])]
    public function index(SoapRepository $soapRepository): Response
    {
        return $this->render('soap/index.html.twig', [
            'soap' => $soapRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_soap_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SoapRepository $soapRepository): Response
    {
        $soap = new Soap();
        $form = $this->createForm(SoapType::class, $soap);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $soapRepository->save($soap, true);

            return $this->redirectToRoute('app_soap_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('soap/new.html.twig', [
            'soap' => $soap,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_soap_show', methods: ['GET'])]
    public function show(Soap $soap): Response
    {
        return $this->render('soap/show.html.twig', [
            'soap' => $soap,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_soap_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Soap $soap, SoapRepository $soapRepository): Response
    {
        $form = $this->createForm(SoapType::class, $soap);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $soapRepository->save($soap, true);

            return $this->redirectToRoute('app_soap_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('soap/edit.html.twig', [
            'soap' => $soap,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_soap_delete', methods: ['POST'])]
    public function delete(Request $request, Soap $soap, SoapRepository $soapRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$soap->getId(), $request->request->get('_token'))) {
            $soapRepository->remove($soap, true);
        }

        return $this->redirectToRoute('app_soap_index', [], Response::HTTP_SEE_OTHER);
    }
}
