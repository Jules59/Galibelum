<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Activity
 *
 * @ORM\Table(name="activity")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActivityRepository")
 */
class Activity
{
    /**
     * @var /date
     *
     * @ORM\Column(name="creationDate", type="date", nullable=false)
     */
    private $creationDate;

    /*
     * Relationship Mapping Metadata
     */
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Offer", mappedBy="activity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activities;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organization", inversedBy="organizationActivity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organizationActivities;

    /*
     * Autogenerated methods / variables
     */
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @Assert\Type("integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32)
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 32,
     *      minMessage = "Your name must be at least {{ limit }} characters long",
     *      maxMessage = "Your name cannot be longer than {{ limit }} characters"
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
     * @ORM\Column(name="type", type="string", length=32)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 32,
     *      minMessage = "The activity type must be at least {{ limit }} characters long",
     *      maxMessage = "The activity type cannot be longer than {{ limit }} characters"
     * )
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "The description is a little bit too short, it must be at least {{ limit }} characters long",
     *      maxMessage = "The description cannot be longer than {{ limit }} characters"
     * )
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=16, nullable=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 16,
     *      maxMessage = "The date cannot be longer than {{ limit }} characters"
     * )
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=64, nullable=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 64,
     *      minMessage = "The address must be at least {{ limit }} characters long",
     *      maxMessage = "The address cannot be longer than {{ limit }} characters"
     * )
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="mainGame", type="string", length=64, nullable=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 64,
     *      minMessage = "The game's name must be at least {{ limit }} characters long",
     *      maxMessage = "The game's name cannot be longer than {{ limit }} characters"
     * )
     */
    private $mainGame;

    /**
     * @var string
     *
     * @ORM\Column(name="urlVideo", type="string", length=128, nullable=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 128,
     *      maxMessage = "The url link cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Url(
     *     message = "The url '{{ value }}' is not a valid url",
     *     protocols = {"http", "https", "ftp"},
     *     checkDNS = "ANY",
     *     dnsMessage = "The host '{{ value }}' could not be resolved."
     * )
     */
    private $urlVideo;

    /**
     * @var array
     *
     * @ORM\Column(name="achievement", type="array", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "The achievement description is a little bit too short, it must be at least {{ limit }} characters long",
     *      maxMessage = "The achievement description cannot be longer than {{ limit }} characters"
     * )
     */
    private $achievement;

    /**
     * @var array
     *
     * @ORM\Column(name="socialLink", type="array")
     *
     * @Assert\NotBlank()
     */
    private $socialLink;


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
     * @return Activity
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
     * @return Activity
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
     * Set type
     *
     * @param string $type
     *
     * @return Activity
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Activity
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
     * Set date
     *
     * @param string $date
     *
     * @return Activity
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Activity
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
     * Set mainGame
     *
     * @param string $mainGame
     *
     * @return Activity
     */
    public function setMainGame($mainGame)
    {
        $this->mainGame = $mainGame;

        return $this;
    }

    /**
     * Get mainGame
     *
     * @return string
     */
    public function getMainGame()
    {
        return $this->mainGame;
    }

    /**
     * Set urlVideo
     *
     * @param string $urlVideo
     *
     * @return Activity
     */
    public function setUrlVideo($urlVideo)
    {
        $this->urlVideo = $urlVideo;

        return $this;
    }

    /**
     * Get urlVideo
     *
     * @return string
     */
    public function getUrlVideo()
    {
        return $this->urlVideo;
    }

    /**
     * Set achievement
     *
     * @param array $achievement
     *
     * @return Activity
     */
    public function setAchievement($achievement)
    {
        $this->achievement = $achievement;

        return $this;
    }

    /**
     * Get achievement
     *
     * @return array
     */
    public function getAchievement()
    {
        return $this->achievement;
    }

    /**
     * Set socialLink
     *
     * @param array $socialLink
     *
     * @return Activity
     */
    public function setSocialLink($socialLink)
    {
        $this->socialLink = $socialLink;

        return $this;
    }

    /**
     * Get socialLink
     *
     * @return array
     */
    public function getSocialLink()
    {
        return $this->socialLink;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setCreationDate(new \DateTime());
    }

    /**
     * Add activity
     *
     * @param \AppBundle\Entity\Offer $activity
     *
     * @return Activity
     */
    public function addActivity(Offer $activity)
    {
        $this->activities[] = $activity;

        return $this;
    }

    /**
     * Remove activity
     *
     * @param \AppBundle\Entity\Offer $activity
     */
    public function removeActivity(Offer $activity)
    {
        $this->activities->removeElement($activity);
    }

    /**
     * Get activities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * Set organizationActivities
     *
     * @param \AppBundle\Entity\Organization $organizationActivities
     *
     * @return Activity
     */
    public function setOrganizationActivities(Organization $organizationActivities)
    {
        $this->organizationActivities = $organizationActivities;

        return $this;
    }

    /**
     * Get organizationActivities
     *
     * @return \AppBundle\Entity\Organization
     */
    public function getOrganizationActivities()
    {
        return $this->organizationActivities;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime $creationDate
     *
     * @return Activity
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate.
     *
     * @return  Date
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }
}
