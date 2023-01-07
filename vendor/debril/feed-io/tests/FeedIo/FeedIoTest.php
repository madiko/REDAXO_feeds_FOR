<?php

namespace FeedIo;

use FeedIo\Rule\DateTimeBuilder;
use FeedIo\Standard\Atom;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-02-23 at 20:31:12.
 */
use PHPUnit\Framework\TestCase;

class FeedIoTest extends TestCase
{
    /**
     * @var FeedIo
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $client = $this->getMockForAbstractClass('\FeedIo\Adapter\ClientInterface');
        $response = $this->createMock('FeedIo\Adapter\ResponseInterface');
        $response->expects($this->any())->method('isModified')->will($this->returnValue(true));
        $response->expects($this->any())->method('getBody')->will($this->returnValue(
            file_get_contents(dirname(__FILE__)."/../samples/expected-atom.xml")
        ));
        $response->expects($this->any())->method('getLastModified')->will($this->returnValue(new \DateTime()));
        $client->expects($this->any())->method('getResponse')->will($this->returnValue($response));

        $logger = new \Psr\Log\NullLogger();

        $this->object = new FeedIo($client, $logger, new Specification($logger));
    }

    /**
     * @covers FeedIo\FeedIo::__construct
     * @covers FeedIo\FeedIo::loadCommonStandards
     */
    public function testConstruct()
    {
        $client = $this->getMockForAbstractClass('\FeedIo\Adapter\ClientInterface');
        $feedIo = new FeedIo($client, new \Psr\Log\NullLogger());
        $this->assertInstanceOf('\FeedIo\Reader', $feedIo->getReader());
    }

    public function testDiscovery()
    {
        $html = file_get_contents(dirname(__FILE__)."/../samples/discovery.html");
        $client = $this->createMock('FeedIo\Adapter\ClientInterface');
        $response = $this->createMock('FeedIo\Adapter\ResponseInterface');
        $response->expects($this->any())->method('getBody')->will($this->returnValue($html));
        $client->expects($this->any())->method('getResponse')->will($this->returnValue($response));

        $feedIo = new FeedIo($client, new \Psr\Log\NullLogger());
        $urls = $feedIo->discover('https://example.org/feed');

        $this->assertCount(2, $urls);
    }

    public function testWithModifiedSince()
    {
        $result = $this->object->read('http://localhost', new Feed(), new \DateTime());

        $this->assertInstanceOf('\FeedIo\Reader\Result', $result);
    }

    /**
     * @covers FeedIo\FeedIo::getDateTimeBuilder
     */
    public function testGetDateTimeBuilder()
    {
        $this->assertInstanceOf('\FeedIo\Rule\DateTimeBuilder', $this->object->getDateTimeBuilder());
    }

    /**
     * @covers FeedIo\FeedIo::getReader
     */
    public function testGetReader()
    {
        $this->assertInstanceOf('\FeedIo\Reader', $this->object->getReader());
    }


    /**
     * @covers FeedIo\FeedIo::read
     */
    public function testRead()
    {
        $result = $this->object->read('http://whatever.com');
        $this->assertInstanceOf('\FeedIo\Reader\Result', $result);
        $this->assertEquals('sample title', $result->getFeed()->getTitle());
    }

    /**
     * @covers FeedIo\FeedIo::format
     * @covers FeedIo\FeedIo::logAction
     */
    public function testFormat()
    {
        $feed = new Feed();
        $feed->setLastModified(new \DateTime());
        $document = $this->object->format($feed, 'atom');

        $this->assertIsString($document);
    }

    /**
     * @covers FeedIo\FeedIo::toRss
     */
    public function testToRss()
    {
        $feed = new Feed();
        $feed->setLastModified(new \DateTime());
        $document = $this->object->toRss($feed);
        $this->assertIsString($document);
    }

    /**
     * @covers FeedIo\FeedIo::toAtom
     */
    public function testToAtom()
    {
        $feed = new Feed();
        $feed->setLastModified(new \DateTime());
        $document = $this->object->toAtom($feed);
        $this->assertIsString($document);
    }

    /**
     * @covers FeedIo\FeedIo::toJson
     */
    public function testToJson()
    {
        $feed = new Feed();
        $feed->setLastModified(new \DateTime());
        $document = $this->object->toJson($feed);
        $this->assertIsString($document);
    }

    public function testPsrResponse()
    {
        $feed = new Feed();
        $feed->setUrl('http://localhost');
        $feed->setLastModified(new \DateTime());
        $feed->setTitle('test feed');

        $item = new Feed\Item();
        $item->setLink('http://localhost/item/1');
        $item->setTitle('an item');
        $item->setLastModified(new \DateTime());

        $feed->add($item);

        $response = $this->object->getPsrResponse($feed, 'atom');
        $this->assertInstanceOf('Psr\Http\Message\ResponseInterface', $response);
    }
}
