<?php

namespace Yaoi\Twbs\Tests\PHPUnit;

use Yaoi\Test\PHPUnit\TestCase;
use Yaoi\Twbs\Io\Content\Badge;
use Yaoi\Twbs\Io\Content\Label;
use Yaoi\Twbs\Response;

class ResponseTest extends TestCase
{
    /** @var Response */
    private $response;
    protected function setUp()
    {
        $this->response = new Response();
    }

    public function testBadge()
    {
        $badge = new Badge('text');
        $this->assertSame('<span class="badge">text</span>', $this->response->renderMessage($badge));
    }


    public function testLabel()
    {
        $label = new Label('text');
        $this->assertSame('<span class="label label-default">text</span>', $this->response->renderMessage($label));
    }

}