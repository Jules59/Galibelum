<?php
/**
 * ActivityController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category ActivityController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Activity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Activity controller.
 *
 * @Route("activity")
 *
 * @category ActivityController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class ActivityController extends Controller
{
    /**
     * Lists all activity entities.
     *
     * @param Request $request Edit posted info
     *
     * @Route("/",    name="activity_index")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $activities = $em->getRepository('AppBundle:Activity')->findBy(
            array(
                'organizationActivities' => $this->getUser()->getOrganization()
            )
        );

        $request->getSession()
            ->getFlashBag()
            ->add(
                "warning", "Pour faire une offre, faites votre choix parmi la liste
                 des activités présentées ci-dessous puis cliquez sur le bouton 
                 Créer une offre."
            );

        return $this->render(
            'activity/index.html.twig', array(
                'activities' => $activities,
            )
        );
    }

    /**
     * Creates a new activity entity.
     *
     * @param Request $request Delete posted info
     *
     * @return         Response A Response instance
     * @Route("/new",  name="activity_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $activity = new Activity();
        $form = $this->createForm('AppBundle\Form\ActivityType', $activity);
        $organization = $this->getUser()->getOrganization();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $activity
                ->setOrganizationActivities($organization)
                ->setNameCanonical(strtolower($activity->getName()));
            $em->persist($activity);
            $em->flush();

            return $this->redirectToRoute(
                'activity_show',
                array('id' => $activity->getId())
            );
        }

        return $this->render(
            'activity/new.html.twig', array(
                'activity' => $activity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a activity entity.
     *
     * @param Activity $activity The activity entity
     *
     * @Route("/{id}", name="activity_show")
     * @Method("GET")
     *
     * @return Response A Response instance
     */
    public function showAction(Activity $activity)
    {
        $deleteForm = $this->_createDeleteForm($activity);

        return $this->render(
            'activity/show.html.twig', array(
                'activity' => $activity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     * @param Request  $request  Delete posted info
     * @param Activity $activity The activity entity
     *
     * @Route("/{id}/edit", name="activity_edit")
     * @Method({"GET",      "POST"})
     *
     * @return Response A Response instance
     */
    public function editAction(Request $request, Activity $activity)
    {
        $deleteForm = $this->_createDeleteForm($activity);
        $editForm = $this->createForm('AppBundle\Form\ActivityType', $activity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Vos modifications ont bien été prises en compte.');

            return $this->redirectToRoute(
                'dashboard_index',
                array('id' => $activity->getId())
            );
        }

        return $this->render(
            'activity/edit.html.twig', array(
                'activity' => $activity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a activity entity.
     *
     * @param Request  $request  Delete posted info
     * @param Activity $activity The activity entity
     *
     * @Route("/{id}",   name="activity_delete")
     * @Method("DELETE")
     *
     * @return Response A Response instance
     */
    public function deleteAction(Request $request, Activity $activity)
    {
        $form = $this->_createDeleteForm($activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($activity);
            $em->flush();
        }

        return $this->redirectToRoute('activity_index');
    }

    /**
     * Creates a form to delete a activity entity.
     *
     * @param Activity $activity The activity entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function _createDeleteForm(Activity $activity)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'activity_delete',
                    array('id' => $activity->getId())
                )
            )
            ->setMethod('DELETE')
            ->getForm();
    }
}
