<?php
/**
 * ContractController File Doc Comment
 *
 * PHP version 7.1
 *
 * @category ContractController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Contracts;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Offer;
use AppBundle\Service\MailerService;

/**
 * Contract controller.
 *
 * @Route("contract")
 *
 * @category ContractController
 * @package  Controller
 * @author   WildCodeSchool <contact@wildcodeschool.fr>
 */
class ContractController extends Controller
{
    /**
     * Lists all contracts.
     *
     * @route("/", methods={"GET"},
     *     name="contract_index")
     *
     * @return Response A Response instance
     */
    public function contractAction()
    {
        $em = $this->getDoctrine()->getManager();

        if ($this->getUser()->hasRole('ROLE_COMPANY')) {
            $contracts = $em->getRepository('AppBundle:Contracts')->findBy(
                array(
                    'organization' => $this->getUser()
                )
            );
        } else {
            $activities = $em->getRepository('AppBundle:Activity')->findby(
                array(
                    'organizationActivities' => $this->getUser()->getOrganization(),
                )
            );

            $offers = $em->getRepository('AppBundle:Offer')->findby(
                array(
                    'activity' => $activities,
                )
            );
            $contracts = $em->getRepository('AppBundle:Contracts')->findBy(
                array(
                    'offer' => $offers,
                )
            );
        }

        return $this->render(
            'contractualisation/index.html.twig', array(
                'contracts' => $contracts,
            )
        );
    }

    /**
     * Set contract when company click to relation button.
     *
     * @param Offer $offer The offer entity
     * @param MailerService $mailerUser The mailer service
     *
     * @Route("/{id}/partners", methods={"GET", "POST"}, name="contract_relation")
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return Response A Response instance
     */
    public function partnersAction(Offer $offer, MailerService $mailerUser)
    {
        if ($this->getUser()->hasRole('ROLE_COMPANY')
            && $this->getUser()->getOrganization()->getIsActive() === 1
        ) {
            $contract = new Contracts();
            $contract
                ->setStatus(1)
                ->setOffer($offer)
                ->setOrganization($this->getUser()->getOrganization());
            $this->getDoctrine()->getManager()->persist($contract);
            $this->getDoctrine()->getManager()->flush();

            $mailerUser->sendEmail(
                $this->getParameter('mailer_user'),
                $offer->getActivity()->getOrganizationActivities()
                    ->getUser()->getEmail(),
                'Mise en relation',
                'La marque '.$this->getUser()->getOrganization()->getName().' s\'intéresse à l\'offre '.$offer->getName().
                ' liée à votre activité '.$offer->getActivity()->getName().'.
                <br>
                <br>
                Vous venez d\'entrer dans la phase de négociation. Vous pourrez ainsi échanger
                avec la structure eSport afin de trouver un accord.
                <br>
                <br>
                Votre account manager reviendra vers vous dans les meilleurs délais afin de vous accompagner 
                durant cette phase de négociation puis dans les phases suivantes.
                <br>
                <br>
                À bientôt,
                L\'équipe Galibelum
                <br>
                <br>
                ---
                <br>
                Un doute, une question ? - Tel: 03.74.09.50.88'
            );

            $mailerUser->sendEmail(
                $this->getParameter('mailer_user'),
                $contract->getOrganization()->getUser()->getEmail(),
                'Mise en Relation',
                'Vous avez souhaité être mis en relation avec '.$offer->getActivity()->getOrganizationActivities()->getName().
                ' au sujet de l\'offre '.$offer->getName().' liée à l\'activité '.$offer->getActivity()->getName().'.
                <br>
                <br>
                Vous venez d\'entrer dans la phase de négociation. Vous pourrez ainsi échanger
                avec la structure eSport afin de trouver un accord.
                <br>
                <br>
                Votre account manager reviendra vers vous dans les meilleurs délais afin de vous accompagner 
                durant cette phase de négociation puis dans les phases suivantes.
                <br>
                <br>
                À bientôt,
                L\'équipe Galibelum
                <br>
                <br>
                ---
                <br>
                Un doute, une question ? - Tel: 03.74.09.50.88'
            );

            $mailerUser->sendEmail(
                $this->getParameter('mailer_user'),
                $contract->getOrganization()->getManagers()->getEmail(),
                'Mise en relation',
                'La marque '.$this->getUser()->getOrganization()->getName(). ' souhaite se mettre en relation
                avec la strucure '.$offer->getActivity()->getOrganizationActivities()->getName().' au sujet de l\'offre '.
                $offer->getName().' liée à l\'activité '.$offer->getActivity()->getName().'.'
            );

            $this->addFlash(
                'success',
                "Votre offre a bien été prise en compte.
                Vous pouvez retrouver le détail de vos contrats
                    en cours dans l'onglet Contractualisation."
            );

            return $this->render(
                'activity/show.html.twig', array(
                    'activity' => $offer->getActivity()
                )
            );
        }
        return $this->redirectToRoute('redirect');
    }

    /**
     * Changes contracts' status.
     *
     * @param Contracts $contract The contract entity
     * @param Int $status Status value
     *
     * @route("/{id}/{status}", methods={"GET"},
     *     name="contract_status")
     *
     * @return Response A Response Instance
     */
    public function statusAction(Contracts $contract, int $status)
    {
        if ($status >= 0 && $status <= 5) {
            $contract->setStatus($status);

            if ($contract->getStatus() === 2) {
                $contract->getOffer()->removePartnershipNumber();
            }
            if ($contract->getStatus() === 5) {
                $contract->getOffer()->addPartnershipNumber();
            }

            $this->getDoctrine()->getManager()->persist($contract);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirectToRoute(
            'manager_contract_list'
        );
    }

    /**
     * Send a mail when the offers' status change.
     *
     * @param Contracts $contract The contract entity
     * @param Int $status Received status
     * @param MailerService $mailerUser Mailer service
     *
     * @route("/{id}/status/{status}", methods={"GET"},
     *     name="contract_status_mail")
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return Response A Response Instance
     */

    public function sendAction(Contracts $contract, int $status,
                               MailerService $mailerUser)
    {
        switch ($status) {

            case 2:
                $mailerUser->sendEmail(
                    $this->getUser()->getEmail(),
                    $contract->getOffer()->getActivity()->getOrganizationActivities()->getUser()->getEmail(),
                    'Validation',
                    'Une marque s\'est positionnée sur votre offre.'
                );
                //      Mail for the company
                $mailerUser->sendEmail(
                    $this->getUser()->getEmail(),
                    $contract->getOrganization()->getUser()->getEmail(),
                    'Validation',
                    'Une marque s\'est positionnée sur votre offre.'
                );
                break;

            case 3:
                $mailerUser->sendEmail(
                    $this->getUser()->getEmail(),
                    $contract->getOffer()->getActivity()->getOrganizationActivities()->getUser()->getEmail(),
                    'Payment',
                    'Une marque s\'est positionnée sur votre offre'
                );
                //      Mail for the company
                $mailerUser->sendEmail(
                    $this->getUser()->getEmail(),
                    $contract->getOrganization()->getUser()->getEmail(),
                    'Payment',
                    'Une marque s\'est positionnée sur votre offre'
                );
                break;

            case 4:
                $mailerUser->sendEmail(
                    $this->getUser()->getEmail(),
                    $contract->getOffer()->getActivity()->getOrganizationActivities()->getUser()->getEmail(),
                    'Offre expirée',
                    'Votre offre est expirée.'
                );
                //      Mail for the company
                $mailerUser->sendEmail(
                    $this->getUser()->getEmail(),
                    $contract->getOrganization()->getUser()->getEmail(),
                    'Payment',
                    'L\'offre sur laquelle vous vous êtes positionnées est malheureusement expirée.'
                );
        }
        return $this->redirectToRoute('manager_contract_list');
    }
}