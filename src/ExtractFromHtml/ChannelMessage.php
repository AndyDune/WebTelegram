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

class ChannelMessage
{
    protected $html;

    protected $messageBody = null;
    protected $messageDate = null;
    protected $messageViews = null;

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

    public function __construct($html)
    {
        $this->html = $html;
        $this->success = $this->extract($html);
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
    public function getMessageDate()
    {
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
     * https://docs.zendframework.com/zend-dom/query/
     *
     * @param $html
     * @return array|bool
     */
    protected function extract($html)
    {
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
        $info = [];
        $res = Document\Query::execute($this->tagPathForViewsCount, $doc, Document\Query::TYPE_CSS);
        $res->count();
        if ($res->count()) {
            /** @var \DOMNodeList $content */
            $content = current($res);
            $this->messageViews = $content->item(0)->nodeValue;
        }

        $res = Document\Query::execute($this->tagPathForDate, $doc, Document\Query::TYPE_CSS);
        $res->count();
        if ($res->count()) {
            /** @var \DOMNodeList $content */
            $content = current($res);
            $this->messageDate = $content->item(0)->getAttribute('datetime');
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
                $this->messageBody .= $item->ownerDocument->saveHTML( $child );
            }

        } else {
            $this->errorCode = self::ERROR_NO_FIND_MESSAGE_TEXT;
            $this->errorMassage = 'Не найден блок ' . $this->tagPathForMessage;
            return false;
        }
        return true;
    }
}