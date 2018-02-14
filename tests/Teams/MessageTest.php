<?php

namespace Teams\Test;

use Teams\TeamsMessage;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Teams\TeamsMessage::send
     */
    public function testMessage()
    {
        $client = $this->getMockBuilder('\Slack\Client')
            ->disableOriginalConstructor()
            ->getMock(array('post'));

        $request = $this->getMockBuilder('\Guzzle\Http\Message\Request')
            ->disableOriginalConstructor()
            ->getMock(array('send'));

        $message = new TeamsMessage('This is a test', 'Hello world');

        $message->addActivity('Update test');
        $message->addFacts('Possible test', []);
        $message->addImage('image', '');

        $expectedDatas = json_encode(
            array(
                'title'       => 'Hello world',
                'text' => 'This is a test',
                'sections' => [
                    [
                        'activityTitle' => null,
                        'activityText' => 'Update test'
                    ],
                    [
                        'title' => 'Possible test'
                    ],
                    [
                        'title' => 'image',
                        'images' => [
                            [
                                'image' => ''
                            ]
                        ]
                    ]
                ]
            )
        );

        $this->assertEquals($message->getJson(), $expectedDatas);
    }
}