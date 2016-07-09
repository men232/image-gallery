<?php

namespace AlbumGalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation as JMS;

/**
 * Album
 *
 * @ORM\Table(name="album")
 * @ORM\Entity(repositoryClass="AlbumGalleryBundle\Repository\AlbumRepository")
 */
class Album
{
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=600)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="album")
     * @JMS\Exclude
     */
    private $images;

    public $count = 0;

    public function __construct($params = null)
    {
        if (is_null($params)) {
            $this->images = new ArrayCollection();
        } else {
            $this->setTitle(isset($params['title']) ? $params['title'] : '');
            $this->setDescription(isset($params['description']) ? $params['description'] : '');
        }
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Album
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Album
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
     * Set images
     *
     * @param string $images
     * @return Album
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }

    /**
     * Get description
     *
     * @return Array 
     */
    public function getImages()
    {
        return $this->images;
    }
}
