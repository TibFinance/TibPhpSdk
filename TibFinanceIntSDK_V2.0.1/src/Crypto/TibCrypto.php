<?php

namespace TibFinanceSDK;

use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\Rijndael;

/**
 * TibCrypto is a class who implement crypto methods and the curl method for calling Tib Finance Server
 */
class TibCrypto
{
    private $url;
    public $ma_public_key = "";
    public $ma_private_key = "";
    public $server_public_key = "";

    public function __construct($url)
    {
        $this->url = $url;
     
    }

	function safe_utf8_encode($input) {
		if (!is_string($input)) {
			return $input;
		}
		
		// Basic fallback for UTF-8 conversion
		$encoded = @iconv('ISO-8859-1', 'UTF-8', $input);
		
		return $encoded ?: $input;
	}

    /**
     * Méthode qui permet de faire un appel à l'API TIBFINANCE
     * @param string $methodName : Le nom de la methode côté TIBFINANCE (Ex: /Data/CreateCustomer)
     * @param array $data : Les attribut demandés par TIBFINANCE API
     * @return array : Le retour de l'API TIBFINANCE
     *
     */
    public function performCall($methodName, $data)
    {
        $content = $this->safe_utf8_encode((json_encode($data)));

        //Echanger les clés entre le SDK et l'API TIBFINANCE
        $keys = $this->exchangeTibKey();

        //Exécuter l'appel à l'API TIBFINANCE
        $call_data = $this->makeTibCall($methodName, $content, $keys);

        //Décrypter le retour de l'API TIBFINANCE
        $response = $this->decryptTibResponse($call_data, $keys['MergedKeysSym']);

        //Retourner le résultat
        return $response;
    }

    /**
     * Exchange de clés avec TIBFINANE API
     *
     * @return array
     */
    public function exchangeTibKey()
    {
        $methodName = "/Data/ExecuteKeyExchange";

        // ***** Étape 1 : Demander la clef asymétrique *****
        $cle_asymetrique_decoded = $this->getPublicKey();

        // ***** Étape 2 : Générer la partie client de la clef symétrique *****
        $client_key = random_bytes(16);

        // ***** Étape 3 : Générer une clef asymétrique côté client *****
        // génération sur demande avec phpseclib
        $privateKey = RSA::createKey(512);
        $privateKey->withPadding(RSA::ENCRYPTION_PKCS1);
        $rsa_public_key = $privateKey->getPublicKey();
        $ma_public_key = $rsa_public_key;
        $ma_private_key = $privateKey->__toString();

        // ***** Étape 4 : Fusionner la clef symétrique et la clef asymétrique *****
        $merged_keys = $client_key . $rsa_public_key;

        // ***** Étape 5 : Encrypter la clef fusionnée *****

        $server_public_key = $cle_asymetrique_decoded->PublicPEMKey;

        $enc = "";
        openssl_public_encrypt($merged_keys, $enc, $cle_asymetrique_decoded->PublicPEMKey);
        $ciphertext = base64_encode($enc);

        // ***** Étape 6 : Transmettre la première clef *****
        $fields = [
                    'key' => [
                                'KeyToken' => $cle_asymetrique_decoded->KeyToken,
                                'CallNode' => $cle_asymetrique_decoded->NodeAnswered,
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
            die(var_dump(curl_error($ch)));
        }

        $key_exchanged_decoded = json_decode($response);

        // ***** Étape 7 : Décrypter la portion serveur de la clef symétrique. *****
        $server_key = base64_decode($key_exchanged_decoded->SymetricHostHalfKey);

        $decoded_server_key = "";
        openssl_private_decrypt($server_key, $decoded_server_key, $ma_private_key);

        // ***** Étape 8 : Combiner les 2 clefs symétriques *****
        $merged_keys_sym = $client_key . $decoded_server_key;

        // Données à retourner
        $keys = [
            "MergedKeysSym" => $merged_keys_sym,
            "CallNode" => $cle_asymetrique_decoded->NodeAnswered,
            "KeyToken" => $key_exchanged_decoded->FullSymetricKeyToken,
        ];

        return $keys;
    }

    /**
     * Obtenir la clé public de l'API TIBFINANCE
     *
     * @return array
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
            die(var_dump(curl_error($ch)));
        }

        return json_decode($response);
    }

    /**
     * Créer une session
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
     * Préparer les données pour création de session
     *
     * @param string $tib_client_id
     * @param string $userName
     * @param string $password
     * @return json
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
     * Exécuter un appel curl vers l'API TIBFINANCE. Cette methode est utilisée par les autres méthodes de TibCrypto.php
     *
     * @param string $callUrl : Le nom de la methode côté TIBFINANCE (Ex: /Data/CreateCustomer)
     * @param string $content
     * @param array $keys
     * @return array: Le retour de l'API TIBFINANCE
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

        // ***** Étape 9 : Faire l’appel *****
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

        $call_data = json_decode($response);

        return $call_data;
    }

    /**
     * Decrypter les données retournées par l'API TIBFINANCE
     *
     * @param $call_data
     * @param $MergedKeysSym
     * @return array
     */
    public function decryptTibResponse($call_data, $MergedKeysSym)
    {
        // ***** Étape 10 : Décrypter le retour de l’appel *****
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

