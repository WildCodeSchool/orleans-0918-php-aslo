<?php
/**
 * Created by PhpStorm.
 * User: wcs
 * Date: 23/10/17
 * Time: 10:57
 * PHP version 7
 */

namespace Model;

/**
 * Class Event
 *
 */
class Event
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $imageUrl;

    /**
     * @var string
     */
    private $linkUrl;


    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId():int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */ 
    public function setId(int $id):Event
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return  string
     */ 
    public function getTitle():string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param  string  $title
     *
     * @return  self
     */ 
    public function setTitle(string $title):Event
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of linkUrl
     */ 
    public function getLinkUrl():string
    {
        return $this->linkUrl;
    }

    /**
     * Set the value of linkUrl
     *
     * @return  self
     */ 
    public function setLinkUrl(string $linkUrl):Event
    {
        $this->linkUrl = $linkUrl;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent():string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent(string $content):Event
    {
        $this->content = $content;

        return $this;
    }

}
