<?php

namespace Site\MainBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Site\MainBundle\Entity\News;
use Site\MainBundle\Form\NewsType;
use Site\MainBundle\Entity\MediaPhoto;

/**
 * News controller.
 *
 */
class NewsController extends Controller
{

    /**
     * Lists all News entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SiteMainBundle:News')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $request->query->get('page', 1) /*page number*/,
            10/*limit per page*/
        );

        return $this->render('SiteMainBundle:Backend/News:index.html.twig', array(
            'entities' => $pagination,
        ));
    }
    /**
     * Creates a new News entity.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entity = new News();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

//          Добавляем фотки в фотогалерею
            $imagesJson = $request->get('gallery');
            if ($imagesJson) {

                $images = json_decode($imagesJson);

                foreach ($images as $image) {
                    $mediaPhoto = new MediaPhoto();
                    $mediaPhoto->setLink("uploads/media/" . $image);
                    $mediaPhoto->setNews($entity);
                    $em->persist($mediaPhoto);
                }

            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_news_show', array('id' => $entity->getId())));
        }

        return $this->render('SiteMainBundle:Backend/News:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a News entity.
     *
     * @param News $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(News $entity)
    {
        $form = $this->createForm(NewsType::class, $entity, array(
            'action' => $this->generateUrl('backend_news_create'),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'backend.create'));

        return $form;
    }

    /**
     * Displays a form to create a new News entity.
     *
     */
    public function newAction()
    {
        $entity = new News();
        $form   = $this->createCreateForm($entity);

        return $this->render('SiteMainBundle:Backend/News:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a News entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiteMainBundle:News')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException($this->get('translator')->trans('backend.news.not_found'));
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SiteMainBundle:Backend/News:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing News entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiteMainBundle:News')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException($this->get('translator')->trans('backend.news.not_found'));
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SiteMainBundle:Backend/News:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a News entity.
    *
    * @param News $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(News $entity)
    {
        $form = $this->createForm(NewsType::class, $entity, array(
            'action' => $this->generateUrl('backend_news_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'backend.update'));

        return $form;
    }
    /**
     * Edits an existing News entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiteMainBundle:News')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException($this->get('translator')->trans('backend.news.not_found'));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
//          Добавляем фотки в фотогалерею
            $imagesJson = $request->get('gallery');
            if ($imagesJson) {

                $images = json_decode($imagesJson);

                foreach ($images as $image) {
                    $mediaPhoto = new MediaPhoto();
                    $mediaPhoto->setLink("uploads/media/" . $image);
                    $mediaPhoto->setNews($entity);
                    $em->persist($mediaPhoto);
                }

            }

//          Удаляем фотки из галареи, отмеченные на удаление
            $photos = $request->get('photos');

            if(is_array($photos)){
                foreach($photos as $photo){
                    $repository_media_photo = $this->getDoctrine()->getRepository('SiteMainBundle:MediaPhoto');
                    $photoObject = $repository_media_photo->find($photo);

                    if($photoObject){
                        unlink($photoObject->getLink());
                        $em->remove($photoObject);
                    }
                }
            }

            $em->flush();

            return $this->redirect($this->generateUrl('backend_news_edit', array('id' => $id)));
        }

        return $this->render('SiteMainBundle:Backend/News:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a News entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SiteMainBundle:News')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException($this->get('translator')->trans('backend.news.not_found'));
            }

            $entity->deleteAllPhotos();

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_news_index'));
    }

    /**
     * Creates a form to delete a News entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_news_delete', array('id' => $id)))
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
