<?php

namespace BackBundle\Manager;


use BackBundle\Entity\Theme;
use BackBundle\Form\ThemeType;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class ThemeManager
 * @package BackBundle\Manager
 */
class ThemeManager extends BaseManager
{

    /**
     * ThemeManager constructor.
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
        return $this->em->getRepository('BackBundle:Theme')->findOneBy(array('id' => $id));
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->em->getRepository('BackBundle:Theme')->findAll();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        $theme = new Theme();
        return $this->handleForm($request, $theme);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $theme = $this->em->getRepository('BackBundle:Theme')->find($id);
        return $this->handleForm($request, $theme);
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
     * @param Theme $theme
     * @return array|RedirectResponse
     */
    public function handleForm(Request $request, $theme)
    {
        $form = $this->formFactory->create(ThemeType::class, $theme);
        return $this->handleBaseForm($request, $form, $theme, "theme_index");
    }

}