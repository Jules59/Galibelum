<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * organization
 *
 * @ORM\Table(name="organization")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrganizationRepository")
 */
class Organization
{
    /*
     * Relationship Mapping Metadata
     */
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AccountManager", inversedBy="managerOrganizations")
     * @ORM\JoinColumn(nullable=true)
     */
    private $managerOrganization;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", mappedBy="organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Activity", mappedBy="organizationActivities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organizationActivity;

    /*
     * Autogenerated methods / variables
     */
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32)
     *
     * @Assert\NotBlank(
     *     message = "Veuillez saisir un nom"
     * )
     * @Assert\Length(
     *     min = 2,
     *     max = 32,
     *     minMessage = "Votre nom doit contenir au mmoins {{ limit }} caractères",
     *     maxMessage = "Votre nom ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="nameCanonical", type="string", length=32, nullable=true)
     */
    private $nameCanonical;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=32)
     *
     * @Assert\Type("string")
     * @Assert\NotBlank(
     *     message = "Veuillez saisir un numéro de téléphone"
     * )
     * @Assert\Length(
     *     min = 9,
     *     max = 32,
     *     exactMessage = "Veuillez saisir un numéro de téléphone valide"
     * )
     * @Assert\Regex(
     *     pattern = "/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/",
     *     message = "Veuillez saisir un numéro de téléphone valide"
     * )
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64)
     *
     * @Assert\Type("string")
     * @Assert\NotBlank(
     *     message = "Veuillez saisir une adresse mail"
     * )
     * @Assert\Length(
     *     min = 5,
     *     max = 64,
     *     minMessage = "Votre adresse mail doit contenir au mmoins {{ limit }} caractères",
     *     maxMessage = "Votre adresse mail ne peut pas contenir plus de {{ limit }} caractères"
     * )
     * @Assert\Email(
     *     message = "l'email '{{ value }}' n'est pas valide.",
     *     checkMX = true
     * )
     * @Assert\Regex(
     *     pattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$/",
     *     message = "Veuillez saisir une adresse mail valide"
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Assert\Type("string")
     * @Assert\NotBlank(
     *     message = "Veuillez saisir une description"
     * )
     * @Assert\Length(
     *     min = 32,
     *     minMessage = "Votre description doit contenir au mmoins {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="userRole", type="string", length=32)
     *
     * @Assert\Type("string")
     * @Assert\NotBlank(
     *     message = "Veuillez saisir votre poste occupé"
     * )
     * @Assert\Length(
     *     min = 2,
     *     max = 32,
     *     minMessage = "Votre saisie doit contenir au moins {{ limit }} caractères",
     *     maxMessage = "Votre saisie ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $userRole;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=32, nullable=true)
     *
     * @Assert\Type("string")
     * @Assert\NotBlank(
     *     message = "Veuillez saisir la statut juridique"
     * )
     * @Assert\Length(
     *     min = 2,
     *     max = 32,
     *     minMessage = "Votre saisie doit contenir au mmoins {{ limit }} caractères",
     *     maxMessage = "Votre saisie ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=32)
     *
     * @Assert\Type("string")
     * @Assert\NotBlank(
     *     message = "Veuillez saisir l'adresse"
     * )
     * @Assert\Length(
     *     min = 5,
     *     max = 32,
     *     minMessage = "Votre adresse doit contenir au mmoins {{ limit }} caractères",
     *     maxMessage = "Votre adresse ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="relationNumber", type="string", length=32)
     *
     */
    private $relationNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="isActive", type="integer")
     */
    private $isActive;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return organization
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nameCanonical
     *
     * @param string $nameCanonical
     *
     * @return organization
     */
    public function setNameCanonical($nameCanonical)
    {
        $this->nameCanonical = $nameCanonical;

        return $this;
    }

    /**
     * Get nameCanonical
     *
     * @return string
     */
    public function getNameCanonical()
    {
        return $this->nameCanonical;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return organization
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return organization
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return organization
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set userRole
     *
     * @param string $userRole
     *
     * @return organization
     */
    public function setUserRole($userRole)
    {
        $this->userRole = $userRole;

        return $this;
    }

    /**
     * Get userRole
     *
     * @return string
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return organization
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return organization
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set isActive
     *
     * @param integer $isActive
     *
     * @return organization
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return int
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->organizationActivity = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setIsActive(0);
    }

    /**
     * Set managerOrganization
     *
     * @param \AppBundle\Entity\AccountManager $managerOrganization
     *
     * @return Organization
     */
    public function setManagerOrganization(AccountManager $managerOrganization)
    {
        $this->managerOrganization = $managerOrganization;

        return $this;
    }

    /**
     * Get managerOrganization
     *
     * @return \AppBundle\Entity\AccountManager
     */
    public function getManagerOrganization()
    {
        return $this->managerOrganization;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Organization
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add organizationActivity
     *
     * @param \AppBundle\Entity\Activity $organizationActivity
     *
     * @return Organization
     */
    public function addOrganizationActivity(Activity $organizationActivity)
    {
        $this->organizationActivity[] = $organizationActivity;

        return $this;
    }

    /**
     * Remove organizationActivity
     *
     * @param \AppBundle\Entity\Activity $organizationActivity
     */
    public function removeOrganizationActivity(Activity $organizationActivity)
    {
        $this->organizationActivity->removeElement($organizationActivity);
    }

    /**
     * Get organizationActivity
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrganizationActivity()
    {
        return $this->organizationActivity;
    }

    /**
     * Set relationNumber.
     *
     * @param string $relationNumber
     *
     * @return Organization
     */
    public function setRelationNumber($relationNumber)
    {
        $this->relationNumber = $relationNumber;

        return $this;
    }

    /**
     * Get relationNumber.
     *
     * @return string
     */
    public function getRelationNumber()
    {
        return $this->relationNumber;
    }
}
