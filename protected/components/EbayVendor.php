<?php


ini_set('display_errors', 1);
error_reporting(-1);

class EbayVendor{
    const API_URL = 'http://svcs.ebay.com/services/search/FindingService/';
    const API_KEY = 'MediaLib-19b0-41cc-8880-24d9f96e0fab';

    private function createRequest($url, $options = array())
    {
        $method = isset($options['method']) ? $options['method'] : 'GET';
        $params = isset($options['params']) ? $options['params'] : array();
        $headers = isset($options['headers']) ? $options['headers'] : array();

        $curlOptions = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_HTTPHEADER     => $headers,

            CURLOPT_HEADER         => true,
            CURLOPT_FOLLOWLOCATION => false,
        );

        if ($method === 'PUT' || $method === 'POST') {
            $curlOptions[CURLOPT_CUSTOMREQUEST] = $method;
            $curlOptions[CURLOPT_POSTFIELDS] = $params;
        }

        if (isset($options['username']) && isset($options['password'])) {
            $curlOptions[CURLOPT_USERPWD] = $options['username'] . ':' . $options['password'];
        }

        if (isset($options['curlopt']) && is_array($options['curlopt'])) {
            $curlOptions = array_replace($curlOptions, $options['curlopt']);
        }

        $curl = curl_init();
        curl_setopt_array($curl, $curlOptions);
        $response = curl_exec($curl);

        if (($errorMessage = curl_errno($curl)) !== 0) {
            curl_close($curl);
            return null;
        }

        if(preg_match('/Location: (.*)/', $response, $matches)) {
            curl_close($curl);
            return $this->createRequest($matches[1], $options);
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);

        curl_close($curl);

        return array(
            'status' => $status,
            'header' => $header,
            'body'   => $body,
        );
    }

    //Search ebay for the given keyword, return the URL of the first image, lowest price, and average price in an array
    public function getBasicEbayStuff($targ){
        $targ = urlencode($targ);
        $url = self::API_URL . 'v1?SECURITY-APPNAME=' . self::API_KEY . '&OPERATION-NAME=findItemsByKeywords&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&keywords='. $targ . '&paginationInput.entriesPerPage=3';
        $options = array();
        $response = $this->createRequest($url, $options);
        $data = json_decode($response['body'], true);

        $results = $data['findItemsByKeywordsResponse'][0]['searchResult'][0]['item'];
        $imgUrl;
        $numItems = 0;
        $totPrice = 0;
        $lowestPrice = 9999999;
        //echo 'Done with init';


        foreach ($results as $item) {
            $title = (isset($item['title'][0])) ? $item['title'][0] : 'Unknown';

            if (isset($item['galleryURL'][0])) {
                //echo '<img src="' . $item['galleryURL'][0] . '">';
                if (!isset($imgUrl)){
                    $imgUrl = $item['galleryURL'][0];
                    //echo 'Used this image!';
                }
            }

            if (isset($item['sellingStatus'][0]['currentPrice'][0]['__value__'])) {
                $price = $item['sellingStatus'][0]['currentPrice'][0]['__value__'];
                //echo '<h3>' . $price . '</h3>';
                $numItems++;
                $totPrice += $price;
                if ($price < $lowestPrice){
                    $lowestPrice = $price;
                    //echo 'New Lowest Price!';
                }
            }
        }
        if ($numItems > 0){
            $totPrice = $totPrice / $numItems;}

        return array(
            'title'        => $title,
            'image_url'    => $imgUrl,
            'lowest_price' => $lowestPrice,
            'total_price'  => $totPrice
        );
    }

    //Search ebay for the given keyword, return the results in an array
    public function getAllEbayStuff($targ){
        $targ = urlencode($targ);
        $url = 'http://svcs.ebay.com/services/search/FindingService/v1?SECURITY-APPNAME=MediaLib-19b0-41cc-8880-24d9f96e0fab&OPERATION-NAME=findItemsByKeywords&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&keywords='. $targ . '&paginationInput.entriesPerPage=3';
        $options = array();
        $response = $this->createRequest($url, $options);
        $data = json_decode($response['body'], true);
        $results = $data['findItemsByKeywordsResponse'][0]['searchResult'][0]['item'];

        return $results;
    }
}
