<?php

namespace FrontBundle\Controller;

use BackBundle\Controller\CategoryController;
use BackBundle\Entity\Book;
use BackBundle\Entity\Category;
use BackBundle\Entity\Theme;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function indexAction()
    {
        return $this->render('FrontBundle:Default:index.html.twig');
    }


    /**
     * @Route("/results", name="search_results")
     * @param Request $request
     * @param $books
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resultsAction(Request $request, $books = null)
    {
        $categoriesM = $this->getDoctrine()->getManager()-> getRepository('BackBundle:Category')->findAll();
        $themesM = $this->getDoctrine()->getManager()-> getRepository('BackBundle:Theme')->findAll();


        // $books = $this->getDoctrine()->getManager()-> getRepository('BackBundle:Book') -> searchBooks( $data ['title'], $data ['theme'], $data ['categories']);

        $request = Request::createFromGlobals();
        $pm = $request->query->all();
        // $pm['theme']

        //-------------------------\\
        $repoTheme = $this->getDoctrine()->getManager()-> getRepository('BackBundle:Theme');
        $repoBook = $this->getDoctrine()->getManager()-> getRepository('BackBundle:Book');

        $books = null;

        if (isset($pm['theme']) && intval($pm['theme'])){


            $themeId = $pm['theme'];

            $theme = $repoTheme->findOneBy(
                array('id' => $themeId)
            );

            if($theme instanceof Theme)
            {
                $books = $repoBook -> searchBooks(null, null, $theme);
            }
        }

        //-------------------------\\
        $repoCat = $this->getDoctrine()->getManager()-> getRepository('BackBundle:Category');


        if (isset($pm['category']) && intval($pm['category'])){

            $categoryId = $pm['category'];

            $category = $repoCat->findOneBy(
                array('id' => $categoryId)
            );

            if($category instanceof Category)
            {
                $books = $repoBook -> searchBooks(null, $category, null);
            }

            // $books += ****
        }

        if (!$books){

            $books = $repoBook -> searchBooks(null, null, null);
            $repoBook->findAll();
        }

        return $this->render('FrontBundle:Default:results.html.twig', array('books' => $books, 'categories' => $categoriesM, 'themes' => $themesM));
    }
    //searchBooks

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {

        $defaultData = array();
        $form = $this->createFormBuilder($defaultData)
            ->add('title', TextType::class, array(
                'required' => false,
            ))
            ->add('theme', EntityType::class, array(
                    'class' => 'BackBundle:Theme',
                    'choice_label' => 'name',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                            ->orderBy('t.name', 'ASC');
                    })
            )
            ->add('categories', EntityType::class, array(
                    'class' => 'BackBundle:Category',
                    'choice_label' => 'name',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy('c.name', 'ASC');
                    })
            )
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();
            $books = $this->getDoctrine()->getManager()-> getRepository('BackBundle:Book')
                -> searchBooks( $data ['title'], $data ['theme'], $data ['categories']);
        }

        return $this->render('FrontBundle:UI:search.html.twig', array('form' => $form->createView()));
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
