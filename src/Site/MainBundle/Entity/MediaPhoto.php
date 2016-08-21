<?php

namespace Site\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Site\MainBundle\Entity\MediaPhoto
 *
 * @ORM\Table(name="media_photo")
 * @ORM\Entity(repositoryClass="Site\MainBundle\Entity\Repository\MediaPhotoRepository")
 */
class MediaPhoto
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="text", nullable=false)
     */
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity="Media", inversedBy="photos")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     **/
    private $media;

    /**
     * @ORM\ManyToOne(targetEntity="News", inversedBy="photos")
     * @ORM\JoinColumn(name="news_id", referencedColumnName="id")
     **/
    private $news;

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
     * Set link
     *
     * @param string $link
     * @return MediaPhoto
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set media
     *
     * @param \Site\MainBundle\Entity\Media $media
     * @return MediaPhoto
     */
    public function setMedia(\Site\MainBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Site\MainBundle\Entity\Media 
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @ORM\PreRemove
     */
    public function removeUpload()
    {
        if(file_exists($this->getLink())){
            unlink($this->getLink());
        }
    }

    /**
     * Set news
     *
     * @param \Site\MainBundle\Entity\News $news
     * @return MediaPhoto
     */
    public function setNews(\Site\MainBundle\Entity\News $news = null)
    {
        $this->news = $news;

        return $this;
    }

    /**
     * Get news
     *
     * @return \Site\MainBundle\Entity\News 
     */
    public function getNews()
    {
        return $this->news;
    }
}
