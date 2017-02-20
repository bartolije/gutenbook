<?php

namespace BackBundle\Manager;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class BaseManager
{
    protected $em;
    protected $formFactory;
    protected $router;

    /**
     * BaseManager constructor.
     * @param $em
     * @param $formFactory
     * @param Router $router
     */
    public function __construct($em, $formFactory, Router $router)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * @param $entity
     */
    protected function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @param $entity
     */
    protected function removeAndFlush($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * @param Request $request
     * @param Form $form
     * @param $entity
     * @param $path
     * @return array|RedirectResponse
     */
    protected function handleBaseForm(Request $request, Form $form, $entity, $path)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistAndFlush($entity);
            return new RedirectResponse($this->router->generate($path));
        }
        return array('form' => $form->createView());
    }

    /**
     * @param $route
     * @return RedirectResponse
     */
    protected function redirect($route)
    {
        return new RedirectResponse($this->router->generate($route));
    }
}