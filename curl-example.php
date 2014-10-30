<?php


ini_set('display_errors', 1);
error_reporting(-1);


function createRequest($url, $options = array())
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
        return createRequest($matches[1], $options);
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



$targ = 'laptop';
$url = 'http://svcs.ebay.com/services/search/FindingService/v1?SECURITY-APPNAME=MediaLib-19b0-41cc-8880-24d9f96e0fab&OPERATION-NAME=findItemsByKeywords&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&keywords=' . $targ . '&paginationInput.entriesPerPage=3';
$options = array();



$response = createRequest($url, $options);


$data = json_decode($response['body'], true);
$results = $data['findItemsByKeywordsResponse'][0]['searchResult'][0]['item'];

foreach ($results as $item) {
    if (isset($item['title'][0])) {
        echo '<h2>' . $item['title'][0] . '</h2>';
    }

    if (isset($item['galleryURL'][0])) {
        echo '<img src="' . $item['galleryURL'][0] . '">';
    }

    if (isset($item['sellingStatus'][0]['currentPrice'][0]['__value__'])) {
        $price = $item['sellingStatus'][0]['currentPrice'][0]['__value__'];
        echo '<h3>' . $price . '</h3>';
    }
}

