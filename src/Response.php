<?php

namespace Yaoi\Twbs;

use Yaoi\Io\Content\Anchor;
use Yaoi\Mappable\Contract;
use Yaoi\Twbs\Io\Content\Badge;
use Yaoi\Io\Content\Error;
use Yaoi\Io\Content\Heading;
use Yaoi\Io\Content\ItemList;
use Yaoi\Io\Content\Multiple;
use Yaoi\Io\Content\Rows;
use Yaoi\Io\Content\SubContent;
use Yaoi\Io\Content\Success;
use Yaoi\Io\Content\Text;
use Yaoi\View\Renderer;
use Yaoi\View\Table\HTML;

class Response extends \Yaoi\Io\Response implements Renderer
{
    private $content = '';

    public function error($message)
    {
        $this->addContent(new Error($message));
    }

    public function success($message)
    {
        $this->addContent(new Success($message));
    }

    public function addContent($message)
    {
        $this->content .= $this->renderMessage($message);
    }


    public function renderMessage($message)
    {
        if ($message instanceof SubContent) {
            return '<div class="padded">' . $this->renderMessage($message->content) . '</div>';
        }

        switch (true) {
            case $message instanceof Rows:
                $table = new HTML();
                $table->addClass('table table-striped table-responsive');
                foreach ($message->getIterator() as $item) {
                    if ($item instanceof Contract) {
                        $item = $item->toArray();
                    }
                    foreach ($item as $key => $value) {
                        $item [$key] = $this->renderMessage($value);
                    }
                    $table->addRow($item);
                }
                return (string)$table;

            case $message instanceof Heading:
                return '<h2>' . $message->value . '</h2>';

            case $message instanceof Error:
                return '<div role="alert" class="alert alert-danger"><strong>OOPS!</strong> '
                . $this->renderMessage($message->value) . '</div>';

            case $message instanceof Success:
                return '<div role="alert" class="alert alert-success">' . $this->renderMessage($message->value)
                . '</div>';

            case $message instanceof Anchor:
                return '<a href="' . $message->anchor . '">'
                . $this->renderMessage($message->value) . '</a>';

            case $message instanceof Multiple:
                $ret = '';
                foreach ($message->items as $item) {
                    $ret .= $this->renderMessage($item);
                }
            return $ret;

            case $message instanceof Badge:
                return '<span class="badge label label-default">' . $this->renderMessage($message->value) . '</span>';

            case $message instanceof Text:
                return '<div class="text ' . $message->type . '">' . $this->renderMessage($message->value) . '</div>';

            case $message instanceof ItemList:
                $ret = '<ul class="list-group">';
                foreach ($message->items as $item) {
                    $ret .= '<li class="list-group-item">' . $this->renderMessage($item) . '</li>';
                }
                $ret .= '</ul>';
                return $ret;


            default:
                return $message;
        }
    }

    public function isEmpty()
    {
        return empty($this->content);
    }

    public function render()
    {
        echo $this->content;
    }

    public function __toString()
    {
        return $this->content;
    }


    public function setLayout(Layout $layout)
    {
        $this->layout = $layout;
    }

    /**
     * @var Layout
     */
    protected $layout;

    /**
     * @return Layout
     */
    public function getLayout()
    {
        return $this->layout;
    }


}