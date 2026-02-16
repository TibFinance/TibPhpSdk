<?php

namespace TibFinanceSDK;

use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\Rijndael;

/**
 * TibCrypto is a class that implements crypto methods and the curl method for calling Tib Finance Server
 */
class TibCrypto
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
     
    }

    private function safe_utf8_encode($input) {
        if (!is_string($input)) {
            return $input;
        }

        // Basic fallback for UTF-8 conversion
        $encoded = @iconv('ISO-8859-1', 'UTF-8', $input);

        return $encoded ?: $input;
    }

    /**
     * Perform a call to the TIB FINANCE API
     * @param string $methodName : The method name on TIB FINANCE side (e.g., /Data/CreateCustomer)
     * @param array $data : The attributes required by TIB FINANCE API
     * @return array : The response from TIB FINANCE API
     *
     */
    public function performCall($methodName, $data)
    {
        $content = $this->safe_utf8_encode((json_encode($data)));

        // Exchange keys between the SDK and the TIB FINANCE API
        $keys = $this->exchangeTibKey();

        // Execute the call to the TIB FINANCE API
        $call_data = $this->makeTibCall($methodName, $content, $keys);

        // Decrypt the response from the TIB FINANCE API
        $response = $this->decryptTibResponse($call_data, $keys['MergedKeysSym']);

        // Return the result
        return $response;
    }

    /**
     * Exchange keys with TIB FINANCE API
     *
     * @return array
     */
    public function exchangeTibKey()
    {
        $methodName = "/Data/ExecuteKeyExchange";

        // ***** Step 1: Request the asymmetric key *****
        $publicKeyResponse = $this->getPublicKey();

        // ***** Step 2: Generate the client portion of the symmetric key *****
        $client_key = random_bytes(16);

        // ***** Step 3: Generate a client-side asymmetric key *****
        // On-demand generation with phpseclib
        $privateKey = RSA::createKey(512);
        $privateKey->withPadding(RSA::ENCRYPTION_PKCS1);
        $rsa_public_key = $privateKey->getPublicKey();
        $localPublicKey = $rsa_public_key;
        $localPrivateKey = $privateKey->__toString();

        // ***** Step 4: Merge the symmetric key and the asymmetric key *****
        $merged_keys = $client_key . $rsa_public_key;

        // ***** Step 5: Encrypt the merged key *****

        $serverPublicKey = $publicKeyResponse->PublicPEMKey;

        $enc = "";
        openssl_public_encrypt($merged_keys, $enc, $publicKeyResponse->PublicPEMKey);
        $ciphertext = base64_encode($enc);

        // ***** Step 6: Transmit the first key *****
        $fields = [
                    'key' => [
                                'KeyToken' => $publicKeyResponse->KeyToken,
                                'CallNode' => $publicKeyResponse->NodeAnswered,
                                'AsymetricClientPublicKeyAndClientSymetricXmlBase64' => $ciphertext
                            ]
                ];

        $data_json = json_encode($fields);

        $ch = curl_init($this->url . $methodName);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if (curl_error($ch) != '') {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception("cURL error: " . $error);
        }

        curl_close($ch);

        $key_exchanged_decoded = json_decode($response);

        // ***** Step 7: Decrypt the server portion of the symmetric key *****
        $server_key = base64_decode($key_exchanged_decoded->SymetricHostHalfKey);

        $decoded_server_key = "";
        openssl_private_decrypt($server_key, $decoded_server_key, $localPrivateKey);

        // ***** Step 8: Combine the 2 symmetric keys *****
        $merged_keys_sym = $client_key . $decoded_server_key;

        // Data to return
        $keys = [
            "MergedKeysSym" => $merged_keys_sym,
            "CallNode" => $publicKeyResponse->NodeAnswered,
            "KeyToken" => $key_exchanged_decoded->FullSymetricKeyToken,
        ];

        return $keys;
    }

    /**
     * Get the public key from the TIB FINANCE API
     *
     * @return object
     */
    public function getPublicKey()
    {
        $methodName = "/Data/getPublicKey";

        //CURL CALL
        $ch = curl_init($this->url . $methodName);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        if (curl_error($ch) != '') {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception("cURL error: " . $error);
        }

        curl_close($ch);

        return json_decode($response);
    }

    /**
     * Create a session
     *
     * @param string $tib_client_id
     * @param string $username
     * @param string $password
     */
    public function createSession($tib_client_id, $userName, $password)
    {
        $keys = $this->exchangeTibKey();

        if (!isset($_COOKIE["SessionId"]) || $_COOKIE["SessionId"] == null || $_COOKIE["SessionId"] == "") {
            $content = $this->prepareTibSessionData($tib_client_id, $userName, $password);

            $call_data = $this->makeTibCall('/Data/CreateSession', $content, $keys);

            $response = $this->decryptTibResponse($call_data, $keys['MergedKeysSym']);

            if ($response->HasError) {
                return false;
            } else {
                $data = [
                    'keys' => $keys,
                    'SessionId' => $response->SessionId
                ];

                setcookie("SessionId", $response->SessionId, strtotime('+1 days'));

                return $data;
            }
        } else {
            $data = [
                'keys' => $keys,
                'SessionId' => $_COOKIE["SessionId"]
            ];

            return $data;
        }
    }

    /**
     * Prepare data for session creation
     *
     * @param string $tib_client_id
     * @param string $userName
     * @param string $password
     * @return string
     */
    public function prepareTibSessionData($tib_client_id, $userName, $password)
    {
        $content = [
            "ClientId" => $tib_client_id,
            "Username" => $userName,
            "Password" => $password
        ];

        return $this->safe_utf8_encode((json_encode($content)));
    }

    /**
     * Execute a cURL call to the TIB FINANCE API. This method is used by other methods in TibCrypto.php
     *
     * @param string $callUrl : The method name on TIB FINANCE side (e.g., /Data/CreateCustomer)
     * @param string $content
     * @param array $keys
     * @return array : The response from TIB FINANCE API
     */
    public function makeTibCall($callUrl, $content, $keys)
    {
        $Base64IV = random_bytes(16);

        $rijndael = new Rijndael('cbc');
        $rijndael->setBlockLength(128);
        $rijndael->setIV($Base64IV);
        $rijndael->setKey($keys['MergedKeysSym']);
        $ciphertextBase64 = base64_encode($rijndael->encrypt($content));

        $call_info = null;

        // ***** Step 9: Make the call *****
        $call_info = [
            "data" => [
                "CallNode" => $keys['CallNode'],
                "KeyToken" => $keys['KeyToken'],
                "Base64IV" => base64_encode($Base64IV),
                "Base64CryptedData" => $ciphertextBase64
            ]
        ];

        $data_json = json_encode($call_info);
        $data_json = str_replace("\/", '/', $data_json);

        $ch = curl_init($this->url . $callUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if (curl_error($ch) != '') {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception("cURL error: " . $error);
        }

        curl_close($ch);

        $call_data = json_decode($response);

        return $call_data;
    }

    /**
     * Decrypt the data returned by the TIB FINANCE API
     *
     * @param $call_data
     * @param $MergedKeysSym
     * @return object
     */
    public function decryptTibResponse($call_data, $MergedKeysSym)
    {
        // ***** Step 10: Decrypt the call response *****
        $iv = implode(array_map('chr', $call_data->IV));
        $content = base64_decode($call_data->CryptedBase64Data);

        $rijndael = new Rijndael('cbc');
        $rijndael->setBlockLength(128);
        $rijndael->setKey($MergedKeysSym);
        $rijndael->setIV($iv);
        $response = $rijndael->decrypt($content);

        return json_decode($response);
    }
}

