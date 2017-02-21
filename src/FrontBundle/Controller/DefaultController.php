<?php

namespace FrontBundle\Controller;

use BackBundle\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $defaultData = array();
        $form = $this->createFormBuilder($defaultData)
            ->add('title', TextType::class)
            ->add('email', EmailType::class)
            ->add('theme', ChoiceType::class, array('choices' => array('Aventure', 'Action', 'Science')))
            ->add('categories', ChoiceType::class, array('choices' => array('Roman', 'Magazine', 'Nouvelle')))
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();

        }

        return $this->render('FrontBundle:Default:index.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Template()
     * @Route("/read/{token}", name="read_book")
     * @param $token
     * @return array
     * @internal param Request $request
     */
    public function readAction($token)
    {
        $repository = $this ->getDoctrine() ->getManager() ->getRepository('AppBundle:Book');
        $book = $repository->findOneBy(array('token' => $token));

        if(!($book instanceof Book))
        {
            throw new NotFoundHttpException();
        }

        return array('book' => $book);
    }

}
