<?php
namespace App\Libraries;

/**
 * BOL Retailer API
 *
 * @author  Joey Tocino <joey@mindproductions.nl>
 * @version v1.0
 * @access  public
 */

class BolRetailer
{
    private $base_url = 'https://api.bol.com/retailer/';
    public $token = null;
    private static $userAgent = null;

    public function getAuth($clientid = '1751f9af-b669-4acd-a554-5d243ab3097d', $clientsecret = 'Bgk_5RcrhJTLfQcZ9BdT90fGH56L0RFRr3uKbtQn6llFHWtcAf12Myr4HInAVYfwip7-B5Dp11x7We9MyKND0A') {
        $encoded_bearer = base64_encode($clientid.':'.$clientsecret);
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://login.bol.com/token?grant_type=client_credentials',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic '.$encoded_bearer
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $token = json_decode($response, TRUE);

        if (! is_array($token) || empty($token['access_token']) || empty($token['expires_in'])) {
            return FALSE;
        }

        $token['expires_at'] = time() + $token['expires_in'] ?? 0;
        $token['token_id'] = uniqid();
        $this->token = $token;
        return $token;
    }

    /**
     * Do API Call
     * @param $response - Return Curl Output?
     */
    public function search_terms($keyword, $period, $number, $related = 'false')
    {
        $header = static::addAuthenticationOptions();
        if($header == false) {
            throw new \AuthenticationException('Header could not be found in search terms.');
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.bol.com/retailer/insights/search-terms?search-term='.urlencode($keyword).'&period='.$period.'&number-of-periods='.$number.'&related-search-terms='.$related,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . $header['headers']['Authorization'],
                'Accept: ' . $header['headers']['Accept'],
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if((int)$httpcode === 200) {
            return json_decode($response, TRUE);
        } else {
            return FALSE;
        }
    }

    /**
     * Do API Call
     * @param $response - Return Curl Output?
     */
    public function stats_offer($offerid, $period, $number)
    {
        $header = static::addAuthenticationOptions();
        if($header == false) {
            throw new \AuthenticationException('Header could not be found in search terms.');
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.bol.com/retailer/insights/offer?offer-id='.$offerid.'&period='.$period.'&number-of-periods='.$number.'&name=PRODUCT_VISITS&name=BUY_BOX_PERCENTAGE',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . $header['headers']['Authorization'],
                'Accept: application/vnd.retailer.v4+json',
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if((int)$httpcode === 200) {
            return json_decode($response, TRUE);
        } else {
            return $response;
        }
    }

    /**
     * Do API Call
     * @param $response - Return Curl Output?
     */
    public function productsync_stap1_create_export()
    {
        $header = static::addAuthenticationOptions();
        if($header == false) {
            throw new \AuthenticationException('Header could not be found in search terms.');
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.bol.com/retailer/offers/export',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"format": "CSV"}',
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . $header['headers']['Authorization'],
                'Accept: application/vnd.retailer.v4+json',
                'Content-Type: application/vnd.retailer.v4+json',
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return json_decode($response, TRUE);
    }

    /**
     * Do API Call
     * @param $response - Return Curl Output?
     */
    public function productsync_stap2_check_process($processid)
    {
        $header = static::addAuthenticationOptions();
        if($header == false) {
            throw new \AuthenticationException('Header could not be found in search terms.');
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.bol.com/retailer/process-status/'.$processid,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . $header['headers']['Authorization'],
                'Accept: application/vnd.retailer.v4+json',
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return json_decode($response, TRUE);
    }

    /**
     * Do API Call
     * @param $response - Return Curl Output?
     */
    public function productsync_stap3_get_export($entityId)
    {
        $header = static::addAuthenticationOptions();
        if($header == false) {
            throw new \AuthenticationException('Header could not be found in search terms.');
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.bol.com/retailer/offers/export/'.$entityId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . $header['headers']['Authorization'],
                'Accept: application/vnd.retailer.v4+csv',
                'Content-Type: application/x-www-form-urlencoded',
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $response;
    }

    /**
     * Do API Call
     * @param $response - Return Curl Output?
     */
    public function getOpenOrders()
    {
        $header = static::addAuthenticationOptions();
        if($header == false) {
            throw new \AuthenticationException('Header could not be found in search terms.');
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.bol.com/retailer/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . $header['headers']['Authorization'],
                'Accept: application/vnd.retailer.v4+json',
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return json_decode($response, TRUE);
    }

    /**
     * Zoekvolume ophalen
     * @param $response - Return Curl Output?
     */
    public function offer_insights($offerid, $period, $number)
    {
        $header = static::addAuthenticationOptions();
        if($header == false) {
            throw new \AuthenticationException('Header could not be found in search terms.');
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.bol.com/retailer/insights/offer?offer-id='.$offerid.'&period='.$period.'&number-of-periods='.$number.'&name=PRODUCT_VISITS',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization:' . $header['headers']['Authorization'],
                'Accept: application/vnd.retailer.v4+json'
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if((int)$httpcode === 200) {
            return json_decode($response, TRUE);
        } else {
            return FALSE;
        }
    }

    /**
     * Clear the credentials of the client. This will effectively sign out.
     */
    public function clearCredentials(): void
    {
        $this->token = null;
    }

    /**
     * Check if the client is authenticated.
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        if (!is_array($this->token)) {
            return false;
        }

        if (!isset($this->token['expires_at']) || !isset($this->token['access_token'])) {
            return false;
        }

        return $this->token['expires_at'] > time();
    }

    private function addAuthenticationOptions(): array
    {
        if (!static::isAuthenticated() || !is_array($this->token)) {
            return false;
        }

        $authorization = [
            'Authorization' => sprintf('Bearer %s', $this->token['access_token']),
            'Accept' => 'application/vnd.retailer.v5+json',
        ];

        $options['headers'] = array_merge($options['headers'] ?? [], $authorization);

        return $options;
    }
}