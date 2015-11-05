<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('::base.html.twig');
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('username', 'text',array(
                'max_length' => 30,
            ))
            ->add('password','password',array(
                'max_length' => 40
            ))
            ->getForm();
        return $this->render('@AppUser/Default/form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function tpaginatorAction(Request $request)
    {
        return new Response("TODO tpaginatorAction");
    }
}
