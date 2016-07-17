<?php

namespace Yomat\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MediaItem
 *
 * @ORM\Table(name="media_item")
 * @ORM\Entity(repositoryClass="Yomat\CatalogBundle\Repository\MediaItemRepository")
 */
class MediaItem
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
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=3)
     */
    private $type;

    /**
     * @var Article
     * @ORM\ManyToOne(targetEntity="Article",
     * 		inversedBy="mediaItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

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
     * Set text
     *
     * @param string $text
     *
     * @return MediaItem
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return MediaItem
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return MediaItem
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
     * Set article
     *
     * @param \Yomat\CatalogBundle\Entity\Article $article
     *
     * @return MediaItem
     */
    public function setArticle(\Yomat\CatalogBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Yomat\CatalogBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
