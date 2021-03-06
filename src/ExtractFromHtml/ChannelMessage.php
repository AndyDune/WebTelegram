<?php
/**
 * ----------------------------------------------
 * | Author: Andrey Ryzhov (Dune) <info@rznw.ru> |
 * | Site: www.rznw.ru                           |
 * | Phone: +7 (4912) 51-10-23                   |
 * | Date: 23.07.2018                            |
 * -----------------------------------------------
 *
 */


namespace AndyDune\WebTelegram\ExtractFromHtml;
use Zend\Dom\Document;

/**
 * @deprecated use pipeline as in test
 *
 * @see \AndyDuneTest\WebTelegram\ChannelPipesLoadInfoTest
 *
 * @see PipeExtractChannelMessages
 *
 * Class ChannelMessage
 * @package AndyDune\WebTelegram\ExtractFromHtml
 */
class ChannelMessage
{

    protected $id;

    protected $html;

    protected $messageBody = null;
    protected $messageDate = null;
    protected $messageViews = null;
    protected $messagePhotoLink = null;
    protected $messageSticker = null;

    protected $messageVoice = null;

    protected $success;

    protected $errorCode = null;
    protected $errorMassage = null;

    const ERROR_BAD_DATA_FORMAT = 100;
    const ERROR_NO_FIND_TEXT = 101;
    const ERROR_POST_NOT_FOUND = 404;
    const ERROR_UNKNOWN = 399;

    protected $tagPathForMessage = 'div.tgme_widget_message_text';
    protected $tagPathForViewsCount = 'div.tgme_widget_message_info span.tgme_widget_message_views';
    protected $tagPathForDate = 'div.tgme_widget_message_info time';
    protected $tagPathForError = 'div.tgme_widget_message_error';
    protected $tagPathForMessagePhoto = 'a.tgme_widget_message_photo_wrap';

    //https://t.me/shomalmuzic/5636?embed=1
    protected $tagPathForMessageVoice = 'audio.tgme_widget_message_voice';

    // https://t.me/nim_ru/2021?embed=1
    protected $tagPathForSticker = '.tgme_widget_message_sticker_wrap a';

    public function __construct($html)
    {
        $this->html = $html;
        $this->success = $this->extract($html);
    }

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
     * @return null
     */
    public function getMessageBody()
    {
        return $this->messageBody;
    }

    /**
     * @return null
     */
    public function getMessageDate($toDateTime = false)
    {
        if (!$this->messageDate) {
            return null;
        }

        if ($toDateTime) {
            try {
                return \DateTime::createFromFormat('Y-m-d\TH:i:sP', $this->messageDate);
            } catch (\Exception $e) {
                return new \DateTime();
            }

        }

        return $this->messageDate;
    }

    /**
     * @return null
     */
    public function getMessageViews()
    {
        return $this->messageViews;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return null
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return null
     */
    public function getErrorMassage()
    {
        return $this->errorMassage;
    }

    /**
     * @return null
     */
    public function getMessagePhotoLink()
    {
        return $this->messagePhotoLink;
    }

    /**
     * @return null
     */
    public function getMessageVoice()
    {
        return $this->messageVoice;
    }

    /**
     * @return null|string
     */
    public function getMessageSticker()
    {
        return $this->messageSticker;
    }


    /**
     * https://docs.zendframework.com/zend-dom/query/
     *
     * https://ru.wikipedia.org/wiki/XPath
     *
     * @param $html
     * @return array|bool
     */
    protected function extract($html)
    {
        if (!preg_match('|<title>Telegram Widget</title>|ui', $html)) {
            $this->errorCode = self::ERROR_BAD_DATA_FORMAT;
            $this->errorMassage = '';
            return false;
        }

        $doc = new Document($html);
        /** @var Document\NodeList $res */
        $res = Document\Query::execute($this->tagPathForError, $doc, Document\Query::TYPE_CSS);
        $res->count();
        if ($res->count()) {
            /** @var \DOMNodeList $content */
            $content = current($res);
            $string = $content->item(0)->nodeValue;
            $this->errorMassage = $string;
            if (preg_match('|Post not found|ui', $string)) {
                $this->errorCode = self::ERROR_POST_NOT_FOUND;
            } else {
                $this->errorCode = self::ERROR_UNKNOWN;
            }
            return false;
        }

        try {
            return $this->extractUsefulDataFromHtml($doc);
        } catch (\Exception $e) {
            $this->errorCode = self::ERROR_UNKNOWN;
            $this->errorMassage = $e->getMessage();
            return false;
        }
    }

    protected function extractUsefulDataFromHtml(Document $doc)
    {
        $findInfoCountFind = 0;
        $info = [];
        $res = Document\Query::execute($this->tagPathForViewsCount, $doc, Document\Query::TYPE_CSS);
        $res->count();
        if ($res->count()) {
            /** @var \DOMNodeList $content */
            $content = current($res);
            $this->messageViews = $content->item(0)->nodeValue;
            $findInfoCountFind++;
        }

        $res = Document\Query::execute($this->tagPathForMessageVoice, $doc, Document\Query::TYPE_CSS);
        $res->count();
        if ($res->count()) {
            /** @var \DOMNodeList $content */
            $content = current($res);
            $this->messageVoice = $content->item(0)->getAttribute('src');
            $findInfoCountFind++;
        }

        $res = Document\Query::execute($this->tagPathForSticker, $doc, Document\Query::TYPE_CSS);
        $res->count();
        if ($res->count()) {
            /** @var \DOMNodeList $content */
            $content = current($res);
            $this->messageSticker = $content->item(0)->getAttribute('href');
            $findInfoCountFind++;
        }


        $res = Document\Query::execute($this->tagPathForDate, $doc, Document\Query::TYPE_CSS);
        $res->count();
        if ($res->count()) {
            /** @var \DOMNodeList $content */
            $content = current($res);
            $this->messageDate = $content->item(0)->getAttribute('datetime');
            $findInfoCountFind++;
        }

        $res = Document\Query::execute($this->tagPathForMessagePhoto, $doc, Document\Query::TYPE_CSS);
        $res->count();
        if ($res->count()) {
            /** @var \DOMNodeList $content */
            $content = current($res);
            $style = $content->item(0)->getAttribute('style');
            if ($style) {
                $match = [];
                if (preg_match("|url\('([^']+)'\)|ui", $style, $match)) {
                    $this->messagePhotoLink = $match[1];
                }
            }
            $findInfoCountFind++;
        }


        $res = Document\Query::execute($this->tagPathForMessage, $doc, Document\Query::TYPE_CSS);
        $res->count();
        if ($res->count()) {
            /** @var \DOMNodeList $content */
            $content = current($res);
            //$this->messageBody = $content->item(0)->nodeValue;
            $item = $content->item(0);
            //$this->messageBody = $item->ownerDocument->saveHTML($item);
            foreach ($item->childNodes as $child) {
                $this->messageBody .= $item->ownerDocument->saveXML( $child );
            }

        } else if (!$findInfoCountFind) {
            $this->errorCode = self::ERROR_NO_FIND_TEXT;
            $this->errorMassage = 'Не найден блок ' . $this->tagPathForMessage;
            return false;
        }
        return true;
    }
}