<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ListReason;
use AppBundle\Form\ListReasonType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;
use VisualCraft\Bundle\CommonBundle\Controller\BaseController;


/**
 * ListReason controller.
 *
 */
class ListReasonController extends BaseController
{

    /**
     * Lists all ListReason entities.
     *
     */
    public function indexAction(Request $request)
    {
        $table = $this->getRepository('AppBundle:ListReason');
        $userReason = !$this->isGranted('ROLE_ADMIN')?$this->getUser()->getId():null;
        $entities = $table->sortFromIndex($request, $userReason);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate($entities, $request->get('page',1));

        return $this->render('AppBundle:ListReason:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }
    /**
     * Creates a new ListReason entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ListReason();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setIsUserReason($this->get('security.token_storage')->getToken()->getUser()->getId());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('listreason_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:ListReason:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ListReason entity.
     *
     * @param ListReason $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ListReason $entity)
    {
        $form = $this->createForm(new ListReasonType(), $entity, array(
            'action' => $this->generateUrl('listreason_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ListReason entity.
     *
     */
    public function newAction()
    {
        $entity = new ListReason();
        $form   = $this->createCreateForm($entity);
        if(!$this->isGranted('ROLE_ADMIN'))
        {
            $form->remove('isUserReason');
        }

        return $this->render('AppBundle:ListReason:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ListReason entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ListReason')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListReason entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:ListReason:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ListReason entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ListReason')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListReason entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:ListReason:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ListReason entity.
    *
    * @param ListReason $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ListReason $entity)
    {
        $form = $this->createForm(new ListReasonType(), $entity, array(
            'action' => $this->generateUrl('listreason_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ListReason entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ListReason')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListReason entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('listreason_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:ListReason:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ListReason entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:ListReason')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ListReason entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('listreason'));
    }

    /**
     * Creates a form to delete a ListReason entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('listreason_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
