<?php

namespace AppBundle\Controller\InternalAPI;

use AppBundle\Entity\CssFile;
use AppBundle\Form\ApiCssFileType;
use AppBundle\Entity\JavascriptFile;
use AppBundle\Form\ApiJavascriptFileType;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ResourceController extends FOSRestController
{
    public function patchCssfileAction(CssFile $cssFile, Request $request)
    {
        $form = $this->createForm(new ApiCssFileType(), $cssFile, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cssFile);
            $em->flush();
            $view = $this->view(['cssFile' => $cssFile]);
        } else {
            $view = $this->view(['form' => $form]);
        }

        return $this->handleView($view);
    }

    public function patchJavascriptfileAction(JavascriptFile $javascriptFile, Request $request)
    {
        $form = $this->createForm(new ApiJavascriptFileType(), $javascriptFile, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($javascriptFile);
            $em->flush();
            $view = $this->view(['javascriptFile' => $javascriptFile]);
        } else {
            $view = $this->view(['form' => $form]);
        }

        return $this->handleView($view);
    }
}
