<?php

namespace Yomat\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="cat_article")
 * @ORM\Entity(repositoryClass="Yomat\CatalogBundle\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(	targetEntity="MediaItem",
     * 					mappedBy="article")
     */
    private $mediaItems;

    /**
     * @var boolean
     * @ORM\OneToOne(targetEntity="Producer", cascade={"persist"} )
     */
    private $producer;

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
     * Set title
     *
     * @param string $title
     *
     * @return Consumer
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
     *
     * @return Consumer
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
     * Set price
     *
     * @param float $price
     *
     * @return Consumer
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mediaItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add mediaItem
     *
     * @param \Yomat\CatalogBundle\Entity\MediaItem $mediaItem
     *
     * @return Article
     */
    public function addMediaItem(\Yomat\CatalogBundle\Entity\MediaItem $mediaItem)
    {
        $this->mediaItems[] = $mediaItem;

        return $this;
    }

    /**
     * Remove mediaItem
     *
     * @param \Yomat\CatalogBundle\Entity\MediaItem $mediaItem
     */
    public function removeMediaItem(\Yomat\CatalogBundle\Entity\MediaItem $mediaItem)
    {
        $this->mediaItems->removeElement($mediaItem);
    }

    /**
     * Get mediaItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMediaItems()
    {
        return $this->mediaItems;
    }

    /**
     * Set producer
     *
     * @param \Yomat\CatalogBundle\Entity\Producer $producer
     *
     * @return Article
     */
    public function setProducer(\Yomat\CatalogBundle\Entity\Producer $producer = null)
    {
        $this->producer = $producer;

        return $this;
    }

    /**
     * Get producer
     *
     * @return \Yomat\CatalogBundle\Entity\Producer
     */
    public function getProducer()
    {
        return $this->producer;
    }
}
