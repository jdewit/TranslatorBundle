<?php

namespace Avro\TranslatorBundle\Api;

/**
 * This class interacts with the Microsofts Translator Api
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class AzureApiHelper
{
    protected $scopeUrl;
    protected $authUrl;
    protected $clientID;
    protected $clientSecret;

    public function __construct($scopeUrl, $authUrl, $clientID, $clientSecret)
    {
        $this->scopeUrl = $scopeUrl;
        $this->authUrl = $authUrl;
        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;
    }

    /*
     * Retrieves an access token.
     *
     * @return string.
     */
     public function getAccessToken() {
        $ch = curl_init();

        $paramArr = array (
             'grant_type'    => 'client_credentials',
             'scope'         => $this->scopeUrl,
             'client_id'     => $this->clientID,
             'client_secret' => $this->clientSecret
        );

        $paramArr = http_build_query($paramArr);

        curl_setopt($ch, CURLOPT_URL, $this->authUrl);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paramArr);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $strResponse = curl_exec($ch);
        $curlErrno = curl_errno($ch);

        if ($curlErrno) {
            $curlError = curl_error($ch);
            throw new \Exception($curlError);
        }

        curl_close($ch);

        $objResponse = json_decode($strResponse);

        if (property_exists($objResponse, 'error')) {
            throw new Exception($objResponse->error_description);
        }

        return $objResponse->access_token;
    }


    /**
     * Create and execute the HTTP CURL request.
     *
     * @param string $url        HTTP Url.
     * @param string $authHeader Authorization Header string.
     * @param string $postData   Data to post.
     *
     * @return string.
     */
    public function curlRequest($url, $authHeader, $postData=''){
        $ch = curl_init();

        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array($authHeader, "Content-Type: application/json"));
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, False);

        if($postData) {
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }

        $curlResponse = curl_exec($ch);

        $curlErrno = curl_errno($ch);
        if ($curlErrno) {
            $curlError = curl_error($ch);
            throw new \Exception($curlError);
        }

        curl_close($ch);

        return $curlResponse;
    }
}
