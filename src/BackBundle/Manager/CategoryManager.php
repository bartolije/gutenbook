<?php

namespace BackBundle\Manager;

use BackBundle\Entity\Category;
use BackBundle\Form\CategoryType;
use HttpResponseException;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CategoryManager
 * @package BackBundle\Manager
 */
class CategoryManager extends BaseManager
{

    /**
     * CategoryManager constructor.
     * @param $em
     * @param $formFactory
     * @param Router $router
     */
    public function __construct($em, $formFactory, Router $router)
    {
        parent::__construct($em, $formFactory, $router);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->em->getRepository('BackBundle:Category')->findOneBy(array('id' => $id));
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->em->getRepository('BackBundle:Category')->findAll();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        $category = new Category();
        return $this->handleForm($request, $category);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $category = $this->em->getRepository('BackBundle:Category')->find($id);
        return $this->handleForm($request, $category);
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @internal param Request $request
     */
    public function delete($request, $id)
    {
        $category = $this->em->getRepository('BackBundle:Category')->find($id);

        if($category instanceof Category)
        {
            $this->removeAndFlush($category);
            return $this->redirect('category_index');
        }else
        {
            throw new HttpException(418);
        }

    }

    /**
     * @param Request $request
     * @param Category $category
     * @return array|RedirectResponse
     */
    public function handleForm(Request $request, $category)
    {
        $form = $this->formFactory->create(CategoryType::class, $category);
        return $this->handleBaseForm($request, $form, $category, "category_index");
    }

}