<?php

namespace App\Listeners\User;

use GuzzleHttp\Client;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateApiConsumer
{

    /**
     * The Client instance.
     *
     * @var  Client $client
     */
    protected $client;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('api-gateway.endpoint')
        ]);
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $event->user;

        try {

            $consumerCreatingRequest = $this->client->post('/consumers', [
                'form_params' => [
                    'username'  => $user->email,
                    'custom_id' => $user->id
                ]
            ]);

        } catch(\Exception $e) {
            \Log::error('Unable to create consumer due to: ' . $e->getMessage());

            return;
        }

        $consumerCreatingResponse = json_decode($consumerCreatingRequest->getBody()->getContents(), true);

        if(
            is_array($consumerCreatingResponse) &&
            isset($consumerCreatingResponse['id'])
        ) {
            $user->update(['consumer_id' => $consumerCreatingResponse['id']]);
        }
    }
}
