<?php


ini_set('display_errors', 1);
error_reporting(-1);

class AmazonVendor{
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

	//Format the signature correctly (convert /, +, etc.)
	function amazonEncode($text){
		$encodedText = "";
		$j = strlen($text);
		for($i=0;$i<$j;$i++)
		{
		  $c = substr($text,$i,1);
		  if (!preg_match("/[A-Za-z0-9\-_.~]/",$c)){
			$encodedText .= sprintf("%%%02X",ord($c));}
		  else{
			$encodedText .= $c;}
		}
		return $encodedText;
	}
	
	function makeAmazonTimestamp(){
		return date('Y-m-d') . 'T' . date('H') . '%3A' . date('i') . '%3A' . date('s') . '.000Z';
	}
	
	//Calculate and return the hashed signature for the Amazon URL
	function makeAmazonSignature($url){
		$secKey = 'EWftCImkJPb5IhxnKFG3OUUYAmozsYCNM2g9TPX1';
		$urlToEncode = "GET\n" . "ecs.amazonaws.com\n" . "/onca/xml\n" . $url;
		//echo "URL to encode: " . $urlToEncode . "\n";
		if (function_exists("hash_hmac")){
			$hmac = hash_hmac("sha256",$urlToEncode,$secKey,TRUE);}
		elseif(function_exists("mhash")){
			$hmac = mhash(MHASH_SHA256,$urlToEncode,$secKey);}
		else{
			die("No hash function available!");}

		$hmacBase64 = base64_encode($hmac);

		return "&Signature=" . $this->amazonEncode($hmacBase64);
	}
	
	function makeAmazonUrl($targ){
		$url = 
			"AWSAccessKeyId=" . "AKIAIR6I4BHC77LDM3EQ"
			. "&AssociateTag=" . "medlibpritra-20"
			. "&Keywords=" . $targ
			. "&Operation=" . "ItemSearch"
			. "&SearchIndex=" . "Books"
			. "&Service=" . "AWSECommerceService"
			. "&Timestamp=" . $this->makeAmazonTimestamp()
			. "&Version=" . "2011-08-01";
		//echo "Base URL: " . $url . "\n";
		$url = "http://ecs.amazonaws.com/onca/xml?" . $url . $this->makeAmazonSignature($url);
		return $url;
	}
	
	/* //Search Amazon for the given keyword, return the URL of the first image, lowest price, and average price in an array
	function getBasicAmazonStuff($targ){
		$url = $this->makeAmazonUrl($targ);
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
			if (isset($item['title'][0])) {
				echo '<h2>' . $item['title'][0] . '</h2>';
			}

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
		return array($imgUrl, $lowestPrice, $totPrice);
	}
	
	//Search Amazon for the given keyword, return the results in an array
	function getAllEbayStuff($targ){
		$url = $this->makeAmazonUrl($targ);
		$options = array();
		$response = $this->createRequest($url, $options);
		$data = json_decode($response['body'], true);
		$results = $data['findItemsByKeywordsResponse'][0]['searchResult'][0]['item'];

		return $results;
	} */
}


/*
$ab = new AmazonVendor();
echo $ab->makeAmazonTimestamp();
echo "\n\n\n\n";
echo "Amazon URL for searching for Potter:\n" . $ab->makeAmazonUrl('Potter');
*/

?>