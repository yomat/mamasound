<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

//use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image 
 *
 * @ORM\Table(name="image")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 */
class Image {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255,nullable=true)
     */
    private $alt;
////////////////////////////////////////////
    private $tempFilename;
    private $temp;

    /**
     *
     * @Assert\Image(mimeTypesMessage="Choisir un fichier image valide") 
     */
    private $file;

    public function setFile(UploadedFile $file = null) {
        var_dump("TO: setFile");

        $this->file = $file;
        if (null !== $this->url) {
            $this->tempFilename = $this->url;
            $this->url = null;
        }
    }

    public function getFile() {
        return $this->file;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        var_dump("TO: PrePersist");

        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->url = $filename . '.' . $this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        var_dump("TO: setFile");

        if ($this->file === null)
            return;
        $name = $this->file->getClientOriginalName();
        $this->file->move($this->getUploadRootDir(), $this->url);
        var_dump($this->getUploadRootDir());
        var_dump($this->url);
//        exit;
        if (null !== $this->tempFilename) {

            // delete the old image
            var_dump($this->url);
            //if(substr($this->url, 0, 4)!="http")
	        unlink($this->getUploadRootDir() . '/' . $this->tempFilename);
            // clear the temp image path
            $this->tempFilename = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {

        if (is_file($this->temp) && file_exists($this->temp)) {
            if (unlink($this->temp) !== true) {
                throw new \Exception("Error Processing Request" . $this->temp, 1);
                exit;
            }
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload() {

        $this->temp = $this->getUploadRootDir() . '/' . $this->url;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'images';
    }

    public function getWebPath() {
        return null === $this->url ? null : $this->getUploadDir() . '/' . $this->url;
    }

/////////////////////////////////////////////
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Image
     */
    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt) {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt() {
        return $this->alt;
    }

}
