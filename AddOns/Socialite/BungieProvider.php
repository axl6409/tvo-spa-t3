<?php

namespace Laravel\Socialite\Two;

use Exception;
use Illuminate\Support\Arr;
use function GuzzleHttp\Psr7\str;

class BungieProvider extends AbstractProvider implements ProviderInterface
{
    const IDENTIFIER = 'BUNGIE';

    protected $membershipId = '';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
      return $this->buildAuthUrlFromBase('https://www.bungie.net/en/oauth/authorize', $state);
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenUrl()
    {
      return 'https://www.bungie.net/platform/app/oauth/token/';
    }

    public function user()
    {
        if ($this->hasInvalidState()) {
          throw new InvalidStateException();
        }
        $response = $this->getAccessTokenResponse($this->getCode());
        $this->membershipId = $response['membership_id'];

        $user = $this->mapUserToObject($this->getUserByToken($token = Arr::get($response, 'access_token')));

        return $user->setToken($token)
                      ->setRefreshToken(Arr::get($response, 'refresh_token'))
                      ->setExpiresIn(Arr::get($response, 'expires_in'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://www.bungie.net/Platform/User/GetMembershipsById/'.$this->membershipId.'/-1', [
            'headers' => [
              'X-API-KEY'       => env('BUNGIE_API_KEY'),
              'Authorization'   => 'Bearer '. $token,
            ],
        ]);

        return (array) json_decode($response->getBody())->Response;
    }

    protected function getCodeFields($state = null)
    {
        $fields = [
          'client_id'     =>  $this->clientId,
          'redirect_uri'  =>  $this->redirectUrl,
          'state'         =>  $state,
          'response_type' =>  'code',
        ];

        return array_merge($fields, $this->parameters);
    }

    protected function mapUserToObject(array $user)
    {
        $data = $user['bungieNetUser'];
        $membershipId = "";
        $membershipType = "";
        foreach ($user['destinyMemberships'] as $ms) {
          if ($ms->membershipType == 3) {
            $membershipId = $ms->membershipId;
            $membershipType = $ms->membershipType;
          }
        }

        return ( new User() )->setRaw($user)->map([
            'bungie_id'       =>  $data->membershipId,
            'membership_id'   =>  $membershipId,
            'membership_type' =>  $membershipType,
            'name'            =>  $data->steamDisplayName,
            'nickname'        =>  $data->displayName,
            'avatar'          =>  $data->profilePicturePath,
        ]);
        
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }

}
