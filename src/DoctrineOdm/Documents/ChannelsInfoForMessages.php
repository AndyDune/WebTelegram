<?php
/**
 * ----------------------------------------------
 * | Author: Andrey Ryzhov (Dune) <info@rznw.ru> |
 * | Site: www.rznw.ru                           |
 * | Phone: +7 (4912) 51-10-23                   |
 * | Date: 24.07.2018                            |
 * -----------------------------------------------
 *
 */


namespace AndyDune\WebTelegram\DoctrineOdm\Documents;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;


/** @ODM\Document(collection="channel_info_for_messages") */
class ChannelsInfoForMessages
{
    /** @ODM\Id */
    private $id;

    /** @ODM\Field(type="string") */
    private $name = '';

    /** @ODM\Field(type="string") */
    private $status;

    /** @ODM\Field(type="int") */
    private $maxKnownPostId;

    /** @ODM\Field(type="int") */
    private $maxLoadedPostId;

    /** @ODM\Field(type="int") */
    private $minLoadedPostId;

    /** @ODM\Field(type="date") */
    private $lastDateCheckChannelExist;

    /** @ODM\Field(type="date") */
    private $lastDateLoadPost = null;

    /** @ODM\Field(type="date") */
    private $lastDateLoadPostNext;

    /** @ODM\Field(type="date") */
    private $lastDateLoadPostPrevious;

    /** @ODM\Field(type="int") */
    private $postCount = 0;

    /** @ODM\Field(type="date") */
    private $dateToUpdateAfter = null;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getMaxKnownPostId()
    {
        return $this->maxKnownPostId;
    }

    /**
     * @param mixed $maxKnownPostId
     */
    public function setMaxKnownPostId($maxKnownPostId): void
    {
        $this->maxKnownPostId = $maxKnownPostId;
    }

    /**
     * @return mixed
     */
    public function getMaxLoadedPostId()
    {
        return $this->maxLoadedPostId;
    }

    /**
     * @param mixed $maxLoadedPostId
     */
    public function setMaxLoadedPostId($maxLoadedPostId): void
    {
        $this->maxLoadedPostId = $maxLoadedPostId;
    }

    /**
     * @return mixed
     */
    public function getMinLoadedPostId()
    {
        return $this->minLoadedPostId;
    }

    /**
     * @param mixed $minLoadedPostId
     */
    public function setMinLoadedPostId($minLoadedPostId): void
    {
        $this->minLoadedPostId = $minLoadedPostId;
    }

    /**
     * @return mixed
     */
    public function getLastDateCheckChannelExist()
    {
        return $this->lastDateCheckChannelExist;
    }

    /**
     * @param mixed $lastDateCheckChannelExist
     */
    public function setLastDateCheckChannelExist($lastDateCheckChannelExist): void
    {
        $this->lastDateCheckChannelExist = $lastDateCheckChannelExist;
    }

    /**
     * @return mixed
     */
    public function getLastDateLoadPost()
    {
        return $this->lastDateLoadPost;
    }

    /**
     * @param mixed $lastDateLoadPost
     */
    public function setLastDateLoadPost($lastDateLoadPost): void
    {
        $this->lastDateLoadPost = $lastDateLoadPost;
    }

    /**
     * @return mixed
     */
    public function getLastDateLoadPostNext()
    {
        return $this->lastDateLoadPostNext;
    }

    /**
     * @param mixed $lastDateLoadPostNext
     */
    public function setLastDateLoadPostNext($lastDateLoadPostNext): void
    {
        $this->lastDateLoadPostNext = $lastDateLoadPostNext;
    }

    /**
     * @return mixed
     */
    public function getLastDateLoadPostPrevious()
    {
        return $this->lastDateLoadPostPrevious;
    }

    /**
     * @param mixed $lastDateLoadPostPrevious
     */
    public function setLastDateLoadPostPrevious($lastDateLoadPostPrevious): void
    {
        $this->lastDateLoadPostPrevious = $lastDateLoadPostPrevious;
    }

    /**
     * @return mixed
     */
    public function getPostCount()
    {
        return $this->postCount;
    }

    /**
     * @param mixed $postCount
     */
    public function setPostCount($postCount): void
    {
        $this->postCount = $postCount;
    }

    /**
     * @return mixed
     */
    public function getDateToUpdateAfter()
    {
        return $this->dateToUpdateAfter;
    }

    /**
     * @param mixed $dateToUpdateAfter
     */
    public function setDateToUpdateAfter($dateToUpdateAfter): void
    {
        $this->dateToUpdateAfter = $dateToUpdateAfter;
    }



}