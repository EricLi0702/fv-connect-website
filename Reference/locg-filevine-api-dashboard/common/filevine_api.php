<?php
class Filevine_API {
    
    protected $_baseUrl;
    protected $_accessToken;
    protected $_refreshToken;
    protected $_userId;
    protected $_orgId;
    
    public function __construct() {
        include 'config.php';
        $this->openFileVineSession($zapier_api);
    }
    
    // OPEN A FILEVINE SESSION
    function openFileVineSession($config) {
        
        // Pre-request script to hash API key, API secret, and timestamp to be used for authentication in the next step to open a Filevine session. Uses Crypot Hash (MD5).
        // Pass the API key, the hashed API key, and the hashed Timestamp in the body and you will be returned an accessToken and a refreshToken to be used in authenticating for API requests to Filevine
        $this->_baseUrl = $config['base_url'];
        $api_url = $this->_baseUrl."/session";
        $apiTimestamp = (new \DateTime('UTC'))->format('Y-m-d\TH:i:s.v\Z');
        // Ordering is important!
        $apiHash = md5($config['apiKey']."/".$apiTimestamp."/".$config['apiSecret']);
        $params = array (
            'mode'          => 'key',
            'apiKey'        => $config['apiKey'],
            'apiHash'       => $apiHash,
            'apiTimestamp'  => $apiTimestamp,
        );
//         var_dump(json_encode($params));
        
        $curl = curl_init();
        curl_setopt_array($curl, array (CURLOPT_URL             => $api_url,
                                        CURLOPT_RETURNTRANSFER  => true,
                                        CURLOPT_CUSTOMREQUEST   => "POST",
                                        CURLOPT_POSTFIELDS      => json_encode($params),
                                        CURLOPT_HTTPHEADER      => array( "Content-Type: application/json"),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
//             echo $response;
            $response = json_decode($response, TRUE);
            $this->_accessToken = $response['accessToken'];
            $this->_refreshToken = $response['refreshToken'];
            $this->_userId = $response['userId'];
            $this->_orgId = $response['orgId'];
//             var_dump($this);
        }
    }

	// Once we have the tokens have been returned, you can interact with the API. Authentication requires the acessToken as the auth:bearer, x-fv-sessionid (which is the refreshToken), x-fv-orgid (defined in Filevine dev portal), and the x-fv-userid (defined in Filevine dev portal).
	
    // Get Collection Item
    function getCollectionItem($params) {
         // In this example, we are going to GET from the collections section endpoint a specific collection item to test if it's a "SETTLEMENT" item. URL parameters include the Project ID, the Collection Section ("negotiations"), and the objectId_itemId (44c9d4e6-0fcd-4ade-a3eb-dfbf701f144d).
        $api_url = $this->_baseUrl."/core/projects/".$params['projectId']."/collections/".$params['sectionSelector']."/".$params['uniqueId'];
        $curl = curl_init();
        curl_setopt_array($curl, array( CURLOPT_URL             => $api_url,
                                        CURLOPT_RETURNTRANSFER  => true,
                                        CURLOPT_CUSTOMREQUEST   => "GET",
                                        CURLOPT_HTTPHEADER      => array( "Authorization: Bearer ".$this->_accessToken,
                                                                          "Content-Type: application/json",
                                                                          "x-fv-sessionid: ".$this->_refreshToken,
																		 "x-fv-orgid: ".$this->_orgId,
																		  "x-fv-userid: ".$this->_userId,
																		),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }

        return $response;    
    }
	
	// Get Case Summary Team Details: Attorney, Paralegal, and Assistant
    function getCaseSummary_Team($params) {
        $api_url = $this->_baseUrl."/core/projects/".$params['projectId']."/forms/casesummary?requestedFields=primaryattorney,paralegal,legalassistant";
        $curl = curl_init();
        curl_setopt_array($curl, array( CURLOPT_URL             => $api_url,
                                        CURLOPT_RETURNTRANSFER  => true,
                                        CURLOPT_CUSTOMREQUEST   => "GET",
                                        CURLOPT_HTTPHEADER      => array( "Authorization: Bearer ".$this->_accessToken,
                                                                          "Content-Type: application/json",
                                                                          "x-fv-sessionid: ".$this->_refreshToken,
																		 "x-fv-orgid: ".$this->_orgId,
																		  "x-fv-userid: ".$this->_userId,
                                                                        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
//             echo $response;
        }

        return $response;    
    }
	
	// Get Intake Information
    function getIntakeInfo($projectId) {
        $api_url = $this->_baseUrl."/core/projects/".$projectId."/forms/intake";
        $curl = curl_init();
        curl_setopt_array($curl, array( CURLOPT_URL             => $api_url,
                                        CURLOPT_RETURNTRANSFER  => true,
                                        CURLOPT_CUSTOMREQUEST   => "GET",
                                        CURLOPT_HTTPHEADER      => array( "Authorization: Bearer ".$this->_accessToken,
                                                                          "Content-Type: application/json",
                                                                          "x-fv-sessionid: ".$this->_refreshToken,
																		 "x-fv-orgid: ".$this->_orgId,
																		  "x-fv-userid: ".$this->_userId,
																		),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }

        return $response;    
    }
    
    // Get Project By LastName
    function getProjectsByLastName($firstname, $lastname, $limit=0) {
        if ($limit == 0)
            $api_url = $this->_baseUrl."/core/projects?name=".$lastname.",%20".$firstname;
        else
            $api_url = $this->_baseUrl."/core/projects?name=".$lastname."&limit=".$limit;
        $curl = curl_init();
        curl_setopt_array($curl, array( CURLOPT_URL             => $api_url,
                                        CURLOPT_RETURNTRANSFER  => true,
                                        CURLOPT_CUSTOMREQUEST   => "GET",
                                        CURLOPT_HTTPHEADER      => array( "Authorization: Bearer ".$this->_accessToken,
																		  "x-fv-sessionid: ".$this->_refreshToken,
                                                                          "Content-Type: application/json",
																		 "x-fv-orgid: ".$this->_orgId,
																		  "x-fv-userid: ".$this->_userId,
																		),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            //echo $response;
        }

        return $response;    
    }
    
    // Get Contacts
    function getContacts() {
        
        $api_url = $this->_baseUrl."/core/contacts";
        $curl = curl_init();
        curl_setopt_array($curl, array( CURLOPT_URL             => $api_url,
                                        CURLOPT_RETURNTRANSFER  => true,
                                        CURLOPT_CUSTOMREQUEST   => "GET",
                                        CURLOPT_HTTPHEADER      => array( "Authorization: Bearer ".$this->_accessToken,
																		  "x-fv-sessionid: ".$this->_refreshToken,
                                                                          "Content-Type: application/json",
																		 "x-fv-orgid: ".$this->_orgId,
																		  "x-fv-userid: ".$this->_userId,
																		),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }

        return $response;    
    }
    
    // Get Contact By ContactId
    function getContactByContactId($contactId) {
        
        $api_url = $this->_baseUrl."/core/contacts/".$contactId;
        $curl = curl_init();
        curl_setopt_array($curl, array( CURLOPT_URL             => $api_url,
                                        CURLOPT_RETURNTRANSFER  => true,
                                        CURLOPT_CUSTOMREQUEST   => "GET",
                                        CURLOPT_HTTPHEADER      => array( "Authorization: Bearer ".$this->_accessToken,
                                                                          "Content-Type: application/json",
                                                                          "x-fv-sessionid: ".$this->_refreshToken,
																		 "x-fv-orgid: ".$this->_orgId,
																		  "x-fv-userid: ".$this->_userId,
																		),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }

        return $response;    
    }
    
    // Get Contact By ContactId
    function getContactByFullName($fullName) {
        
        $api_url = $this->_baseUrl."/core/contacts?fullName=".$fullName;
        $curl = curl_init();
        curl_setopt_array($curl, array( CURLOPT_URL             => $api_url,
                                        CURLOPT_RETURNTRANSFER  => true,
                                        CURLOPT_CUSTOMREQUEST   => "GET",
                                        CURLOPT_HTTPHEADER      => array( "Authorization: Bearer ".$this->_accessToken,
                                                                          "Content-Type: application/json",
                                                                          "x-fv-sessionid: ".$this->_refreshToken,
																		 "x-fv-orgid: ".$this->_orgId,
																		  "x-fv-userid: ".$this->_userId,
                                                                         ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
//             echo $response;
        }

        return $response;    
    }
    
    // Create the Contact
    function createContact($params) {
//         var_dump(json_encode($params));
        $api_url = $this->_baseUrl."/core/contacts";
        $curl = curl_init();
        curl_setopt_array($curl, array( CURLOPT_URL             => $api_url,
                                        CURLOPT_RETURNTRANSFER  => true,
                                        CURLOPT_ENCODING        => "",
                                        CURLOPT_MAXREDIRS       => 10,
                                        CURLOPT_TIMEOUT         => 0,
                                        CURLOPT_FOLLOWLOCATION  => true,
                                        CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST   => "POST",
                                        CURLOPT_POSTFIELDS      => json_encode($params),
                                        CURLOPT_HTTPHEADER      => array( "Authorization: Bearer ".$this->_accessToken,
                                                                          "x-fv-sessionid: ".$this->_refreshToken,
                                                                          "Content-Type: application/json",
																		 "x-fv-orgid: ".$this->_orgId,
																		  "x-fv-userid: ".$this->_userId,
                                                                        )
        ));
//                                                                           

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
//             echo $response;
        }

        return $response;    
    }
    
    // Get Contact By ContactId
    function updateContact($contactId, $params) {
    
        $api_url = $this->_baseUrl."/core/contacts/".$contactId;
        $curl = curl_init();
        curl_setopt_array($curl, array( CURLOPT_URL             => $api_url,
                                        CURLOPT_RETURNTRANSFER  => true,
                                        CURLOPT_CUSTOMREQUEST   => "PATCH",
                                        CURLOPT_POSTFIELDS      => json_encode($params),
//                                         CURLOPT_POSTFIELDS      => "{'personTypes':['Client', 'Plaintiff', 'Firm']}",
                                        CURLOPT_HTTPHEADER      => array( "Authorization: Bearer ".$this->_accessToken,
                                                                          "x-fv-sessionid: ".$this->_refreshToken,
																		  "x-fv-orgid: ".$this->_orgId,
																		  "x-fv-userid: ".$this->_userId,
																		  "Content-Type: application/json",
																		),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
//             echo $response;
        }

        return $response;    
    }
}
?>