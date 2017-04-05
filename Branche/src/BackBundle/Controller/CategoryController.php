<?php

namespace BackBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="category_index")
     * @return array
     */
    public function indexAction()
    {
        $books = $this->get('app.category.manager')->findAll();
        return array('categories' => $books);
    }

    /**
     * @Template()
     * @Route("/new", name="category_create")
     * @param Request $request
     * @return array
     */
    public function newAction(Request $request)
    {
        return $this->get('app.category.manager')->save($request);
    }

    /**
     * @Template()
     * @Route("/{id}/edit", name="category_edit")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function editAction(Request $request, $id)
    {
        return $this->get('app.category.manager')->edit($request, $id);
    }

    /**
     * @Template()
     * @Route("/{id}/delete", name="category_delete")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->get('app.category.manager')->delete($request, $id);
    }

}