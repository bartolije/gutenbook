<?php

namespace BackBundle\Manager;

use BackBundle\Entity\Book;
use BackBundle\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class BookManager
 * @package BackBundle\Manager
 */
class BookManager extends BaseManager
{

    /**
     * BookManager constructor.
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
        return $this->em->getRepository('BackBundle:Book')->findOneBy(array('id' => $id));
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->em->getRepository('BackBundle:Book')->findAll();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        $book = new Book();
        return $this->handleForm($request, $book);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $book = $this->em->getRepository('BackBundle:Book')->find($id);
        return $this->handleForm($request, $book);
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
     * @param Book $book
     * @return array|RedirectResponse
     */
    public function handleForm(Request $request, $book)
    {
        $form = $this->formFactory->create(BookType::class, $book);
        return $this->handleBaseForm($request, $form, $book, "book_index");
    }

}