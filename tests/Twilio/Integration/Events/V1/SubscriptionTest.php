<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Tests\Integration\Events\V1;

use Twilio\Exceptions\DeserializeException;
use Twilio\Exceptions\TwilioException;
use Twilio\Http\Response;
use Twilio\Serialize;
use Twilio\Tests\HolodeckTestCase;
use Twilio\Tests\Request;

class SubscriptionTest extends HolodeckTestCase {
    public function testReadRequest(): void {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->events->v1->subscriptions->read();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $this->assertRequest(new Request(
            'get',
            'https://events.twilio.com/v1/Subscriptions'
        ));
    }

    public function testReadEmptyResponse(): void {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "subscriptions": [],
                "meta": {
                    "page": 0,
                    "page_size": 10,
                    "first_page_url": "https://events.twilio.com/v1/Subscriptions?PageSize=10&Page=0",
                    "previous_page_url": null,
                    "url": "https://events.twilio.com/v1/Subscriptions?PageSize=10&Page=0",
                    "next_page_url": null,
                    "key": "subscriptions"
                }
            }
            '
        ));

        $actual = $this->twilio->events->v1->subscriptions->read();

        $this->assertNotNull($actual);
    }

    public function testReadResultsResponse(): void {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "subscriptions": [
                    {
                        "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "date_created": "2015-07-30T20:00:00Z",
                        "date_updated": "2015-07-30T20:01:33Z",
                        "sid": "DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "sink_sid": "DGaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "description": "A subscription",
                        "url": "https://events.twilio.com/v1/Subscriptions/DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "links": {
                            "subscribed_events": "https://events.twilio.com/v1/Subscriptions/DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/SubscribedEvents"
                        }
                    },
                    {
                        "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "date_created": "2015-07-30T20:00:00Z",
                        "date_updated": "2015-07-30T20:01:33Z",
                        "sid": "DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaab",
                        "sink_sid": "DGaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "description": "Another subscription",
                        "url": "https://events.twilio.com/v1/Subscriptions/DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaab",
                        "links": {
                            "subscribed_events": "https://events.twilio.com/v1/Subscriptions/DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaab/SubscribedEvents"
                        }
                    }
                ],
                "meta": {
                    "page": 0,
                    "page_size": 20,
                    "first_page_url": "https://events.twilio.com/v1/Subscriptions?PageSize=20&Page=0",
                    "previous_page_url": null,
                    "url": "https://events.twilio.com/v1/Subscriptions?PageSize=20&Page=0",
                    "next_page_url": null,
                    "key": "subscriptions"
                }
            }
            '
        ));

        $actual = $this->twilio->events->v1->subscriptions->read();

        $this->assertNotNull($actual);
    }

    public function testFetchRequest(): void {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->events->v1->subscriptions("DFXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")->fetch();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $this->assertRequest(new Request(
            'get',
            'https://events.twilio.com/v1/Subscriptions/DFXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'
        ));
    }

    public function testFetchResponse(): void {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "date_created": "2015-07-30T20:00:00Z",
                "date_updated": "2015-07-30T20:01:33Z",
                "sid": "DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "sink_sid": "DGaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "description": "A subscription",
                "url": "https://events.twilio.com/v1/Subscriptions/DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "links": {
                    "subscribed_events": "https://events.twilio.com/v1/Subscriptions/DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/SubscribedEvents"
                }
            }
            '
        ));

        $actual = $this->twilio->events->v1->subscriptions("DFXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")->fetch();

        $this->assertNotNull($actual);
    }

    public function testCreateRequest(): void {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->events->v1->subscriptions->create("description", "DGXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX", [[]]);
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $values = [
            'Description' => "description",
            'SinkSid' => "DGXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX",
            'Types' => Serialize::map([[]], function($e) { return Serialize::jsonObject($e); }),
        ];

        $this->assertRequest(new Request(
            'post',
            'https://events.twilio.com/v1/Subscriptions',
            null,
            $values
        ));
    }

    public function testCreateResponse(): void {
        $this->holodeck->mock(new Response(
            201,
            '
            {
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "date_created": "2015-07-30T20:00:00Z",
                "date_updated": "2015-07-30T20:01:33Z",
                "sid": "DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "sink_sid": "DGaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "description": "A subscription",
                "url": "https://events.twilio.com/v1/Subscriptions/DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "links": {
                    "subscribed_events": "https://events.twilio.com/v1/Subscriptions/DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/SubscribedEvents"
                }
            }
            '
        ));

        $actual = $this->twilio->events->v1->subscriptions->create("description", "DGXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX", [[]]);

        $this->assertNotNull($actual);
    }

    public function testUpdateRequest(): void {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->events->v1->subscriptions("DFXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")->update();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $this->assertRequest(new Request(
            'post',
            'https://events.twilio.com/v1/Subscriptions/DFXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'
        ));
    }

    public function testUpdateResponse(): void {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "date_created": "2015-07-30T20:00:00Z",
                "date_updated": "2020-07-30T20:01:33Z",
                "sid": "DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "sink_sid": "DGaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaab",
                "description": "Updated description",
                "url": "https://events.twilio.com/v1/Subscriptions/DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "links": {
                    "subscribed_events": "https://events.twilio.com/v1/Subscriptions/DFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/SubscribedEvents"
                }
            }
            '
        ));

        $actual = $this->twilio->events->v1->subscriptions("DFXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")->update();

        $this->assertNotNull($actual);
    }

    public function testDeleteRequest(): void {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->events->v1->subscriptions("DFXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")->delete();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $this->assertRequest(new Request(
            'delete',
            'https://events.twilio.com/v1/Subscriptions/DFXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'
        ));
    }

    public function testDeleteResponse(): void {
        $this->holodeck->mock(new Response(
            204,
            null
        ));

        $actual = $this->twilio->events->v1->subscriptions("DFXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")->delete();

        $this->assertTrue($actual);
    }
}