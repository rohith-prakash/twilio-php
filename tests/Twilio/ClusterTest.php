<?php

namespace Twilio\Tests;
require "vendor/autoload.php";

//require __FILE__ . "/src/Twilio/Rest/Client.php";
//require __DIR__ . '/Twilio/Rest/Client.php';
//require_once '/path/to/vendor/autoload.php';
//require_once "Twilio/autoload.php";
//include('src/Twilio/Rest/Client.php');
//require_once('src/Twilio/Http/CurlClient.php');
//require_once('src/Twilio/Http/Client.php');
//use Twilio\Rest\Client;
//require_once '/path/to/vendor/autoload.php';
//require_once "Twilio/autoload.php";
//set_include_path("src/Twilio/"/);
//foreach (glob("src/Twilio/Rest/*.php") as $filename)
//{
//    include $filename;
//}

//function include_all_files_in_path($dir){
//    $results = array();
//    $files = scandir($dir);
//
//    foreach($files as $key => $value){
//        if(!is_dir($dir. DIRECTORY_SEPARATOR .$value)){
//            include $value;
//        } else if(is_dir($dir. DIRECTORY_SEPARATOR .$value)) {
//            $results[] = $value;
//            include_all_files_in_path($dir. DIRECTORY_SEPARATOR .$value);
//        }
//    }
//}
//
//include_all_files_in_path("src/Twilio");

class ClusterTest extends \PHPUnit\Framework\TestCase
{
    public static $accountSid = "";
    public static $toNumber = "";
    public static $apiKey = "";
    public static $secret = "";
    public static $fromNumber = "";
    public static $twilio;

    public static function setUpBeforeClass(): void
    {
        self::$accountSid = getenv("TWILIO_ACCOUNT_SID");
        self::$toNumber = getenv("TWILIO_TO_NUMBER");
        self::$apiKey = getenv("TWILIO_API_KEY");
        self::$secret = getenv("TWILIO_API_SECRET");
        self::$fromNumber = getenv("TWILIO_FROM_NUMBER");
        self::$twilio = new \Twilio\Rest\Client($username = self::$apiKey, $password = self::$secret, $accountSid = self::$accountSid);
    }

    public function testSendingAText(): void
    {
        $message = self::$twilio->messages->create(self::$toNumber,
            [
                "from" => self::$fromNumber,
                "body" => "Twilio-php Cluster test message"
            ]
        );
        $this->assertNotNull($message);
        $this->assertTrue(strpos($message->body, "Twilio-php Cluster test message") !== false);
        $this->assertEquals(self::$fromNumber, $message->from);
        $this->assertEquals(self::$toNumber, $message->to);
    }

    public function testListingNumbers(): void
    {
        $phoneNumbers = self::$twilio->incomingPhoneNumbers->read();
        $this->assertNotNull($phoneNumbers);
        $this->assertNotEmpty($phoneNumbers);
    }

    public function testListingANumber(): void
    {
        $phoneNumbers = self::$twilio->incomingPhoneNumbers->read(
            ['phoneNumber' => self::$fromNumber]
        );
        $this->assertNotNull($phoneNumbers);
        $this->assertEquals(self::$fromNumber, $phoneNumbers[0]->phoneNumber);
    }

    public function testSpecialCharacters(): void
    {
        $service = self::$twilio->chat->v2->services->create("service|friendly&name");
        $this->assertNotNull($service);

        $user = self::$twilio->chat->v2->services($service->sid)->users->create("user|identity&string");
        $this->assertNotNull($user);

        $isUserDeleted = self::$twilio->chat->v2->services($service->sid)->users($user->sid)->delete();
        $this->assertTrue($isUserDeleted);

        $isServiceDeleted = self::$twilio->chat->v2->services($service->sid)->delete();
        $this->assertTrue($isServiceDeleted);
    }

    public function testListParams(): void
    {
        $sinkConfiguration = ["destination" => "http://example.org/webhook", "method" => "post", "batch_events" => false];
        $types = [["type" => "com.twilio.messaging.message.delivered"], ["type" => "com.twilio.messaging.message.sent"]];

        $sink = self::$twilio->events->v1->sinks->create("test sink php", $sinkConfiguration, "webhook");
        $this->assertNotNull($sink);

        $subscription = self::$twilio->events->v1->subscriptions
            ->create("test subscription php", $sink->sid, $types);
        $this->assertNotNull($subscription);

        $this->assertTrue(self::$twilio->events->v1->subscriptions($subscription->sid)->delete());
        $this->assertTrue(self::$twilio->events->v1->sinks($sink->sid)->delete());
    }
}