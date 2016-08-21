<?php

namespace Site\MainBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Site\MainBundle\Entity\NewsPaper;
use Site\MainBundle\Form\NewsPaperType;
use Site\MainBundle\Entity\MediaPhoto;

/**
 * NewsPaper controller.
 *
 */
class NewsPaperController extends Controller
{

    /**
     * Lists all NewsPaper entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SiteMainBundle:NewsPaper')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $request->query->get('page', 1) /*page number*/,
            10/*limit per page*/
        );

        return $this->render('SiteMainBundle:Backend/NewsPaper:index.html.twig', array(
            'entities' => $pagination,
        ));
    }
    /**
     * Creates a new NewsPaper entity.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entity = new NewsPaper();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_news_paper_show', array('id' => $entity->getId())));
        }

        return $this->render('SiteMainBundle:Backend/NewsPaper:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a NewsPaper entity.
     *
     * @param NewsPaper $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(NewsPaper $entity)
    {
        $form = $this->createForm(NewsPaperType::class, $entity, array(
            'action' => $this->generateUrl('backend_news_paper_create'),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'backend.create'));

        return $form;
    }

    /**
     * Displays a form to create a new NewsPaper entity.
     *
     */
    public function newAction()
    {
        $entity = new NewsPaper();
        $form   = $this->createCreateForm($entity);

        $form->remove('document');
        $form->remove('img');

        return $this->render('SiteMainBundle:Backend/NewsPaper:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a NewsPaper entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiteMainBundle:NewsPaper')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException($this->get('translator')->trans('backend.news_paper.not_found'));
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SiteMainBundle:Backend/NewsPaper:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing NewsPaper entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiteMainBundle:NewsPaper')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException($this->get('translator')->trans('backend.news_paper.not_found'));
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SiteMainBundle:Backend/NewsPaper:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a NewsPaper entity.
    *
    * @param NewsPaper $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(NewsPaper $entity)
    {
        $form = $this->createForm(NewsPaperType::class, $entity, array(
            'action' => $this->generateUrl('backend_news_paper_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'backend.update'));

        return $form;
    }
    /**
     * Edits an existing NewsPaper entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiteMainBundle:NewsPaper')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException($this->get('translator')->trans('backend.news_paper.not_found'));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $em->flush();

            return $this->redirect($this->generateUrl('backend_news_paper_edit', array('id' => $id)));
        }

        return $this->render('SiteMainBundle:Backend/NewsPaper:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a NewsPaper entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SiteMainBundle:NewsPaper')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException($this->get('translator')->trans('backend.news_paper.not_found'));
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_news_paper_index'));
    }

    /**
     * Creates a form to delete a NewsPaper entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_news_paper_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array(
                'label' => 'backend.delete',
                'attr' => array(
                    'class' => 'btn-danger'
                )
            ))
            ->getForm()
        ;
    }
}
