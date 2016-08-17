<?php
include_once('vendor/autoload.php');
use Emarref\Jwt\Claim;

class PassKit {
	private $apiKey;
	private $apiSecret;
	private $apiUrl = "https://api-pass.passkit.net/v2/";
	
	function __construct($apiKey, $apiSecret) {
		$this->apiKey = $apiKey;
		$this->apiSecret = $apiSecret;
	}
	
	/**
	 * Returns a new CSR for the account
	 * @return string with the certificate
	 */
	public function GenerateCSR() {
		return $this->doQuery("passbookCsrs", "POST");
	}
	
	/**
	 * Uploads the certificate to the user account
	 * @param array $data
	 * @param string $certificateFilePath local path (asbolute) to the certificate file
	 * @return array with API result
	 */
	public function UploadCertificate($data, $certificateFilePath) {
		$files = array("passbookCER" => $certificateFilePath);
		return $this->doMultipartQuery("passbookCerts", "POST", $data, $files);
	}
	
	/**
	 * Returns the certificate details
	 * @param string $certificateId
	 * @return array with API result
	 */
	public function GetCertificateDetails($certificateId) {
		return $this->doQuery("passbookCerts" . $certificateId, "GET");
	}
	
	/**
	 * Returns a list of all the certificates for the account
	 * @return array with API result
	 */
	public function ListCertificates() {
		return $this->doQuery("passbookCerts", "GET");
	}
	
	/**
	 * Lists all campaigns for account
	 * @return array with API result
	 */
	public function ListCampaigns() {
		return $this->doQuery("campaigns", "GET");
	}
	
	/**
	 * Gets all details for a campaign.
	 * @param string $name Name of the campaign
	 * @return array with API result
	 */
	public function GetCampaign($name) {
		return $this->doQuery("campaigns/".$name, "GET");
	}
	
	/**
	 * Creates a new campaign
	 * @param array $data
	 * @return array with API result
	 */
	public function CreateCampaign($data) {
		return $this->doQuery("campaigns", "POST", $data);
	}
	
	/**
	 * Updates an existing campaign
	 * @param string $name Name of the campaign
	 * @param array $data
	 * @return array with API result
	 */
	public function UpdateCampaign($name, $data) {
		return $this->doQuery("campaigns/".$name, "PUT", $data);
	}
	
	/**
	 * Lists all the templates for a given campaign
	 * @param string $name Name of the campaign
	 * @return array with API result
	 */
	public function ListTemplatesByCampaign($name) {
		return $this->doQuery("campaigns/".$name."/templates", "GET");
	}
	
	/**
	 * Creates a new template. Requires an array of image file paths, as per format: array("passbook-IconFile" => /path/to/file).
	 * Array key format as per documentation (https://dev.passkit.net/#create-a-template): passbook-{imageType}
	 * @param unknown $data
	 * @return array with API result
	 */
	public function CreateTemplate($data, $imagesFilePaths) {
		return $this->doMultipartQuery("templates", "POST", $data, $imagesFilePaths);
	}
	
	/**
	 * Returns the template details
	 * @param string $name Name of the template
	 * @return array with API result
	 */
	public function GetTemplate($name) {
		return $this->doQuery("templates/".$name, "GET");
	}
	
	/**
	 * Updates the template data only.
	 * To update data AND images in a template, use UpdateTemplateDataImages
	 * @param string $name Name of the template
	 * @return array with API result
	 */
	public function UpdateTemplateData($name, $data) {
		return $this->doQuery("templates/".$name, "PUT", $data);
	}
	
	/**
	 * Updates the template data & images. Requires an array of image file paths, as per format: array("passbook-IconFile" => /path/to/file).
	 * Array key format as per documentation (https://dev.passkit.net/#update-a-template-with-images): passbook-{imageType}
	 * @param string $name Name of the template
	 * @return array with API result
	 */
	public function UpdateTemplateDataImages($name, $data, $imagesFilePaths) {
		return $this->doMultipartQuery("templates/".$name, "PUT", $data, $imagesFilePaths);
	}
	
	/**
	 * Method is used to push changes to all passes of a template. By default, updating a template does not automatically
	 * push. This needs to be done separately.
	 * @param string $name
	 * @return array with API result
	 */
	public function PushTemplateUpdate($name) {
		return $this->doQuery("templates/".$name, "PUT");
	}
	
	/**
	 * Creates a new pass
	 * @param array $data
	 * @return array with API result
	 */
	public function CreatePass($data) {
		return $this->doQuery("passes", "POST", $data);
	}
	
	/**
	 * Gets the pass details
	 * @param string $pid the ID of the pass
	 * @return array with API result
	 */
	public function GetPassById($pid) {
		return $this->doQuery("passes/".$pid, "GET");
	}
	
	/**
	 * Gets the pass details by user defined ID and campaign name
	 * @param string $userDefinedId
	 * @param string $campainName
	 * @return array with API result
	 */
	public function GetPassByUserDefinedId($userDefinedId, $campainName) {
		return $this->doQuery("passes?userDefinedId=".$userDefinedId."&campaignName=".$campainName, "GET");
	}
	
	/**
	 * Updates the pass details by user 
	 * @param string $pid The ID of the pass
	 * @param array $data
	 * @return array with API result
	 */
	public function UpdatePassById($pid, $data) {
		return $this->doQuery("passes/".$pid, "PUT", $data);
	}
	
	/**
	 * Updates the pass details by user defined ID and campaign name
	 * @param string $pid The ID of the pass
	 * @param array $data
	 * @return array with API result
	 */
	public function UpdatePassByUserDefinedId($userDefinedId, $campainName, $data) {
		return $this->doQuery("passes?userDefinedId=".$userDefinedId."&campaignName=".$campainName, "PUT");
	}
	
	/**
	 * Creates passes in batch. Data array needs to be in the format set out in the documentation:
	 * https://dev.passkit.net/#batch-create-passes
	 * @param array $data
	 * @return array with API result
	 */
	public function CreatePassBatch($data) {
		return $this->doQuery("passesBatch", "POST", $data);
	}
	
	/**
	 * Updates passes in batch. Data array needs to be in the format set out in the documentation:
	 * https://dev.passkit.net/#batch-update-passes
	 * @param array $data
	 * @return array with API result
	 */
	public function UpdatePassBatch($data) {
		return $this->doQuery("passesBatch", "PUT", $data);
	}
	
	private function doQuery($path, $type, $data = null) {
		$url = $this->apiUrl. $path;
	
		$headers = array(
			'Accept' => 'application/json',
			'Authorization' => 'PKAuth ' . $this->generateJwt(),
			'Content-Type' => 'application/json',
		);

		switch($type) {
			case "POST":
				$body = Unirest\Request\Body::json($data);
				$response = Unirest\Request::post($url, $headers, $body);
				break;
			case "PUT":
				$body = Unirest\Request\Body::json($data);
				$response = Unirest\Request::put($url, $headers, $body);
				break;
			case "GET":
				$response = Unirest\Request::get($url, $headers, $body);
				break;
		}
		
		if(!empty($response->body)) {
			return $response->body;
		}
		else {
			return null;
		}
	}
	
	private function doMultipartQuery($path, $type, $data, $files) {
		$url = $this->apiUrl. $path;
		
		$headers = array(
			'Accept' => 'application/json',
			'Authorization' => 'PKAuth ' . $this->generateJwt(),
		);
		
		$data = array(
			"jsonBody" => json_encode($data)
		);
		
		$body = Unirest\Request\Body::multipart($data, $files);
		
		switch($type) {
			case "POST":
				$response = Unirest\Request::post($url, $headers, $body);
				break;
			case "PUT":
				$response = Unirest\Request::put($url, $headers, $body);
				break;
		}
		
		
		if(!empty($response->body)) {
			return $response->body;
		}
		else {
			return null;
		}
	}
	
	private function generateJwt() {
		$token = new Emarref\Jwt\Token();
		$token->addHeader(new Emarref\Jwt\HeaderParameter\Custom("typ", "JWT"));
		$token->addClaim(new Claim\PublicClaim("key", $this->apiKey));
		// expiry of 1 min
		$token->addClaim(new Claim\PublicClaim("exp", round(microtime(true) * 1000) + 6000));
		
		$jwt = new Emarref\Jwt\Jwt();
		$algorithm = new Emarref\Jwt\Algorithm\Hs256($this->apiSecret);
		$encryption = Emarref\Jwt\Encryption\Factory::create($algorithm);
		$jwt->sign($token, $encryption);
		$serializedToken = $jwt->serialize($token, $encryption);
		
		return $serializedToken;
	}
	
}