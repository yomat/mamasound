<?php

namespace Yomat\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="Yomat\CatalogBundle\Repository\TransactionRepository")
 */
class Transaction
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
     * @var boolean
     * @ORM\OneToOne(targetEntity="Consumer" )
     */
    private $consumer;

    /**
     * @var boolean
     * @ORM\OneToOne(targetEntity="Producer" )
     */
    private $producer;

    /**
     * @var boolean
     * @ORM\OneToOne(targetEntity="Article" )
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
     * Set consumer
     *
     * @param \Yomat\CatalogBundle\Entity\Consumer $consumer
     *
     * @return Transaction
     */
    public function setConsumer(\Yomat\CatalogBundle\Entity\Consumer $consumer = null)
    {
        $this->consumer = $consumer;

        return $this;
    }

    /**
     * Get consumer
     *
     * @return \Yomat\CatalogBundle\Entity\Consumer
     */
    public function getConsumer()
    {
        return $this->consumer;
    }

    /**
     * Set producer
     *
     * @param \Yomat\CatalogBundle\Entity\Producer $producer
     *
     * @return Transaction
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

    /**
     * Set article
     *
     * @param \Yomat\CatalogBundle\Entity\Article $article
     *
     * @return Transaction
     */
    public function setArticle(\Yomat\CatalogBundle\Entity\Article $article = null)
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
