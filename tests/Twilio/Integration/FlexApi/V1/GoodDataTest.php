<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Tests\Integration\FlexApi\V1;

use Twilio\Exceptions\DeserializeException;
use Twilio\Exceptions\TwilioException;
use Twilio\Http\Response;
use Twilio\Tests\HolodeckTestCase;
use Twilio\Tests\Request;

class GoodDataTest extends HolodeckTestCase {
    public function testCreateRequest(): void {
        $this->holodeck->mock(new Response(500, ''));

        $options = ['token' => "token", ];

        try {
            $this->twilio->flexApi->v1->goodData()->create($options);
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $headers = ['Token' => "token", ];

        $this->assertRequest(new Request(
            'post',
            'https://flex-api.twilio.com/v1/Accounts/GoodData',
            [],
            [],
            $headers
        ));
    }

    public function testCreateResponse(): void {
        $this->holodeck->mock(new Response(
            201,
            '
            {
                "session_expiry": "2022-09-27T09:28:01Z",
                "workspace_id": "clbi1eelh1x8z4.......ijpnyu",
                "session_id": "-----BEGIN PGP MESSAGE-----\n\nwcBMA11tX1FL13rp\u2026\u2026kHXd\n=vOBk\n-----END PGP MESSAGE-----\n",
                "gd_base_url": "https://analytics.ytica.com/",
                "url": "https://flex-api.twilio.com/v1/Accounts/GoodData"
            }
            '
        ));

        $actual = $this->twilio->flexApi->v1->goodData()->create();

        $this->assertNotNull($actual);
    }
}