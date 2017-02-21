<?php

namespace FrontBundle\Controller;

use BackBundle\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('FrontBundle:Default:index.html.twig');
    }

    /**
     * @Template()
     * @Route("/read", name="read")
     * @param Request $request
     * @return array
     */
    public function readBookAction(Request $request)
    {
        return $this->render('FrontBundle:Default:read.html.twig');
    }


//    /**
//     * @Template()
//     * @Route("/read/{token}", name="read")
//     * @param Request $request
//     * @param $token
//     * @return array
//     */
//    public function readAction(Request $request, $token)
//    {
//        $repository = $this ->getDoctrine() ->getManager() ->getRepository('AppBundle:Book');
//        $book = $repository->findOneBy(array('token' => $token));
//
//        if(!($book instanceof Book))
//        {
//            throw new NotFoundHttpException();
//        }
//
//        return array('book' => $book);
//    }

}
