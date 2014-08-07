<?php

namespace Avro\TranslatorBundle\Translator;

/**
 * Uses Microsoft's Azure Translator
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class AzureTranslator implements TranslatorInterface
{
    protected $apiHelper;
    protected $session;
    protected $translateUrl;

    /**
     * @param AzureApiHelper $apiHelper
     * @param Session        $session
     * @param string         $translateUr
     */
    public function __construct($apiHelper, $session, $translateUrl)
    {
        $this->apiHelper = $apiHelper;
        $this->session = $session;
        $this->translateUrl = $translateUrl;
    }

    /**
     * Translate a string
     *
     * @param string $text The text to translate
     * @param string $from The locale to translate from
     * @param string $to The locale to translate to
     */
    public function translate($text, $from, $to)
    {
        $authHeader = $this->getAuthHeader();

        $url = sprintf('%s?text=%s&from=%s&to=%s', $this->translateUrl, urlencode($text), $from, $to);

        $response = $this->apiHelper->curlRequest($url, $authHeader);

        $xmlObj = simplexml_load_string($response);

        return (string)$xmlObj;
    }

    /**
     * Get auth header with a valid access token
     *
     * @return string
     */
    private function getAuthHeader()
    {
        $accessToken = $this->session->get('azure_access_token');
        $expiryTime = $this->session->get('azure_access_token_expires');

        // get a new access token if we dont have one or it has expired
        if (empty($azureAccessToken) || time() > $expiryTime) {
            $accessToken = $this->apiHelper->getAccessToken();

            $this->session->set('azure_access_token', $accessToken);
            $this->session->set('azure_access_token_expires', time() + 600);
        }


        return "Authorization: Bearer ". $accessToken;
    }
}

