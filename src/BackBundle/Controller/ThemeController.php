<?php

namespace BackBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/theme")
 */
class ThemeController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="theme_index")
     * @return array
     */
    public function indexAction()
    {
        $books = $this->get('app.theme.manager')->findAll();
        return array('themes' => $books);
    }

    /**
     * @Template()
     * @Route("/new", name="theme_create")
     * @param Request $request
     * @return array
     */
    public function newAction(Request $request)
    {
        return $this->get('app.theme.manager')->save($request);
    }

    /**
     * @Template()
     * @Route("/{id}/edit", name="theme_edit")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function editAction(Request $request, $id)
    {
        return $this->get('app.theme.manager')->edit($request, $id);
    }

    /**
     * @Template()
     * @Route("/{id}/delete", name="theme_delete")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->get('app.theme.manager')->delete($request, $id);
    }

}