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


/** @ODM\Document(collection="channel_messages", repositoryClass="AndyDune\WebTelegram\DoctrineOdm\Repository\ChannelMessages") */
class ChannelMessages
{
    /** @ODM\Id */
    private $id;

    /** @ODM\Field(type="int") */
    private $idWithinChannel;

    /** @ODM\Field(type="string") */
    private $channelName = '';


    /** @ODM\ReferenceOne(targetDocument="ChannelsInfoForMessages", storeAs="id") */
    private $channel;

    /** @ODM\Field(type="date") */
    private $date;

    /** @ODM\Field(type="date") */
    private $dateLoaded;

    /** @ODM\Field(type="bool") */
    private $deleted = false;

    /** @ODM\Field(type="string") */
    private $text = '';

    /** @ODM\Field(type="string") */
    private $widgetMessagePhotoLink = '';

    /** @ODM\Field(type="int") */
    private $views = 0;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getIdWithinChannel()
    {
        return $this->idWithinChannel;
    }

    /**
     * @param mixed $idWithinChannel
     * @return ChannelMessages
     */
    public function setIdWithinChannel($idWithinChannel): ChannelMessages
    {
        $this->idWithinChannel = $idWithinChannel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChannelName()
    {
        return $this->channelName;
    }

    /**
     * @param mixed $channelName
     */
    public function setChannelName($channelName): void
    {
        $this->channelName = $channelName;
    }

    /**
     * @return mixed
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param ChannelsInfoForMessages $channel
     * @return  ChannelMessages
     */
    public function setChannel(ChannelsInfoForMessages $channel): ChannelMessages
    {
        $this->channel = $channel;
        $this->setChannelName($channel->getName());
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDateLoaded()
    {
        return $this->dateLoaded;
    }

    /**
     * @param mixed $dateLoaded
     */
    public function setDateLoaded($dateLoaded): void
    {
        $this->dateLoaded = $dateLoaded;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted): void
    {
        $this->deleted = $deleted;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getWidgetMessagePhotoLink()
    {
        return $this->widgetMessagePhotoLink;
    }

    /**
     * @param mixed $widgetMessagePhotoLink
     */
    public function setWidgetMessagePhotoLink($widgetMessagePhotoLink): void
    {
        $this->widgetMessagePhotoLink = $widgetMessagePhotoLink;
    }

    /**
     * @return mixed
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param mixed $views
     */
    public function setViews($views): void
    {
        $this->views = $views;
    }



}