<?php

namespace Swis\Laravel\Mautic\Auth;

use League\OAuth2\Client\Provider\GenericProvider;

class OauthProvider extends GenericProvider
{
    public function __construct(array $options = [], array $collaborators = [])
    {
        $options = array_merge([
            'urlAuthorize' => rtrim($options['url'] ?? '', '/').'/oauth/v2/authorize',
            'urlAccessToken' => rtrim($options['url'] ?? '', '/').'/oauth/v2/token',
            'urlResourceOwnerDetails' => rtrim($options['url'] ?? '', '/').'/oauth/v2/resource',
        ], $options);

        parent::__construct($options, $collaborators);
    }

    /**
     * Returns all options that are required.
     *
     * @return array
     */
    protected function getRequiredOptions()
    {
        return [
            'url',
        ];
    }

    /**
     * Returns all options that can be configured.
     *
     * @return array
     */
    protected function getConfigurableOptions()
    {
        // TODO: Remove url

        return array_merge(parent::getConfigurableOptions(), [
            'urlAuthorize',
            'urlAccessToken',
            'urlResourceOwnerDetails',
        ]);
    }
}
