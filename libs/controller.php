<?php
abstract class Controller
{
	protected $view;
	protected $model;
	protected $params;
	protected $pageParams;

	function __construct($params = array())
	{       
                
		$this->view = new View();
		$this->model = new Model();

		//Get all the page params to pass back into the view
		if(count($params)>0){
			$this->pageParams       = implode("/", $params);
		}
	}

	abstract public function loadPage();

	public function redirectTo($location){
		header("Location: ".$location);
		exit;
	}


	public function hashPassword($username, $userPass){
		$username   = strtolower($username);
		$l          = strlen($username);
		$m          = $l/2;
		$lst        = substr($username, -1);
		$md         = substr($username,$m);
		$fst        = substr($username, 0);

		$hashP      = hash("sha256",$userPass.$lst.$fst.$md.$this->salt);
		return $hashP;
	}

	public function getModel($modelName,$params=array()){
		require_once(ROOT."models/".$modelName.".php");

	}
	/**
	 *
	 * @param string $url
	 * @param String $attributes
	 * @param String $method
	 * @param boolean $tryCache
	 * @param boolean $test
	 * @param boolean $testOutput
	 * @return Array Returns the values of the api in format of data, status, message
	 */
	public function connectToApi($url,$attributes="",$method="get",$test = false,$testOutput=false )
	{

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_TIMEOUT, 300);

		if($method == "post" || $method == "put" || $method == "delete")
		{

			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST,count($attributes));
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($attributes,'','&'));
			if($method == "put" || $method == "delete"){
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
			}
			if($test){
				echo $url."<br/>";
				echo http_build_query($attributes,'','&');exit;
			}
			curl_setopt($ch, CURLOPT_URL, $url);
		}
		else
		{
			$url = $url."?".http_build_query($attributes,'','&');
			if($test){
				echo $url;exit;
			}
			curl_setopt($ch, CURLOPT_URL, $url);
		}
		curl_setopt($ch,CURLOPT_ENCODING , "gzip");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
		$response = curl_exec($ch);
		if($testOutput){
			self::var_log_error(__FUNCTION__.": TEST OUTPUT",$response);
			var_dump($response);exit;
		}
		if(!$response)
		{
			$msg    = curl_errno($ch);
			curl_close($ch);
			return $msg;
		}
		else
		{
			$info           = curl_getinfo($ch);

			if($info['http_code'] == 404){
				$response   = "Gateway method not found.";
			}
			elseif($info['http_code'] == 403){
				$response              = json_decode(html_entity_decode($response),true);
			}
			elseif($info['http_code'] != 200)
			{
				$response              = json_decode(html_entity_decode($response),true);
				$msg                   = "Http Code - ".$info['http_code'];
				$msg                   .= " ".$response['message'];
				$response['message']   = $msg;
			}
			else{
				$response       = json_decode(html_entity_decode($response),true);

			}
			curl_close($ch);
			return $response;
		}
	}

	/**
	 *
	 * @param String $email
	 * @return boolean
	 */
	public function isEmail($email){
		$result = false;
		if(isset($email) && $email != ""){
			if(preg_match("/^([0-9a-zA-Z\-_])+(\.[0-9a-zA-Z\-_]+)*@([0-9a-zA-Z])+(\.[0-9a-zA-Z]+)*\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,64})*$/i",$email)){
				$result = true;
			}
		}
		return $result;
	}

	/**
	 *
	 * @param String $url
	 * @return boolean
	 */
	public function isUrl($url){
		$result = false;
		$url    = trim($url);
		if(isset($url)&&$url!=""){
			if(preg_match("/^\b(?:(?:https?|ftps?):\/\/|www\.)*[-a-z0-9+&@#\.]+\.[a-zA-Z]{2,64}((\/|\?)[-a-z0-9+&@#\/%?=~_|!:,.;\s]*[-a-z0-9+&@#\/%=~_|])*$/i",$url))
			{
				$result = true;
			}
		}
		return $result;
	}

	/**
	 *
	 * @param string $phone
	 * @return boolean
	 * NOTE this phone check strick format of 123-456-7890
	 */
	public function isPhone($phone){
		$result = false;
		if(isset($phone)&&$phone != ""){
			if(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}(\s*x[\d]+)*$/i",$phone)){
				$result = true;
			}
		}
		return $result;
	}

	/**
	 *
	 * @param string $zip
	 * @return boolean
	 */
	public function isZip5($zip){
		$result = false;
		if(isset($zip)){
			if(preg_match("/[0-9]{5}/",$zip)){
				$result = true;
			}
		}
		return $result;
	}

	/**
	 *
	 * @param string $zip
	 * @return boolean
	 */
	public function isZip4($zip){
		$result = false;
		if(isset($zip)){
			if(preg_match("/[0-9]{4}/",$zip)){
				$result = true;
			}
		}
		return $result;
	}

	/**
	 *
	 * @param string $string
	 * @return boolean
	 */
	public function isWord($string){
		$result = false;
		if(isset($string)){
			if(preg_match("/^[\p{L}\'\"]+$/i",$string)){
				$result = true;
			}
		}
		return $result;
	}

	/**
	 * Note: This is used for clean words only without any king of special character. (Mainly used for testing javascript and html values that a hacker may modify)
	 * @param string $string
	 * @return boolean
	 */
	public function isCleanWord($string){
		$result = false;
		if(isset($string)){
			if(preg_match("/^[a-zA-Z_\'\"]+$/i", $string)){
				$result = true;
			}
		}
		return $result;
	}

	/**
	 * @param $string
	 * @return bool
	 * Note: This is different from the isWord function in that it allows spaces and numbers.
	 * Warning: This function will return false if only spaces are submitted.
	 *
	 */
	public function isText($string){
		$result = false;
		$string = trim($string);
		if(isset($string)&&$string !== ""){
			if(preg_match("/^[\p{L}\s0-9\'\"\-]+$/i",$string)){
				$result = true;
			}
		}
		return $result;
	}

	/**
	 *
	 * @param string $payload
	 * @return String
	 * Note: This function is useful to encode matching id.
	 * For example an imageId to the ownersId, to prevent hacking where a user can attempt to change the user variable.
	 * To achieve this, when retrieving an image you can pass the special encoded userId by combining the userid with the image id
	 * then when updating the image check that the special encoded string matches what you send to the client.
	 */
	public function specialEncode($payload){
		$encodedString          = "";
		if(is_array($payload)){
			foreach($payload as $value){
				$encodedString .= $value.$this->salt;
			}

			$encodedString      = md5($encodedString);
		}
		else{
			$encodedString      = $payload.$this->salt;
			$encodedString      = md5($encodedString);
		}
		return $encodedString;
	}

	/**
	 *
	 * @param string or boolean date string
	 * @return string or false date string in the format YYYY-MM-DD or false.
	 * Note: This function is to enforce a sql format on all dates entered in the database.
	 */
	public function toSQLDate($inDate){
		return date("Y-m-d",  strtotime($inDate));

	}

	/**
	 *
	 * @param string a time string
	 * @return boolean false or string date and time string in the format YYYY-MM-DD and 24 hours HH:MM:SS or false if fails.
	 * Note: This function is to enforce a sql date time format on all date times entered in the database.
	 */
	public function toSQLDateTime($inDateTime){
		return date("Y-m-d H:i:s", strtotime($inDateTime));

	}


	/**
	 *
	 * @param  String time
	 * @return boolean false or string time string in the format 24 hours HH:MM:SS or false if it fails.
	 * Note: This function is to enforce a sql time format on all times entered into the database.
	 */
	public function toSQLTime($inTime){
		return date("H:i:s",  strtotime($inTime));
	}

	/**
	 *
	 * @param type string
	 * @return type string
	 * Note: Function will replace the less than tag (<) and greater than tag(>) into &lt; and &gt;
	 * if is a script tag <script> of if is a php tag <?php?>
	 */
	public function sanitizeScriptTags($text){
		return preg_replace('/\<[\/]*(?=script|\?[php]*)([a-zA-Z\s=\'\"\/0-9\[\]\!\\\?]*)\>/i', '&lt;$1&gt;', $text);
	}
	public function responseJSON(){
		return json_decode('{"status":"error","data":"","message":""}');
	}

	/**
	 *
	 * @param type String
	 * @return type String
	 * Note: Function will remove the number or string that angular js appends to the select values
	 */
	public function sanitizeAngularSelect($text){
		return preg_replace('/^(number|string):/','',$text);
	}



	/**
	 *
	 * @param Integer (The code for the header eg. 403, 500, 200 etc.)
	 * @param string (the message you want)
	 */
	public function sendHttpStatus($code, $string){
		header("HTTP/1.1 ".$code." ".$string);
	}

	/**
	 *
	 * @param type $array (The array of data you want to dump)
	 * @param type $messageHeader String (An optional meassage to be used as a header);
	 */
	public function var_log_error($callingModel, $payload){
		ob_start();                    // start buffer capture
		var_dump( $payload );           // dump the values
		$contents = ob_get_contents(); // put the buffer into a variable
		ob_end_clean();                // end capture
		$contents = str_replace(array("\n", "\r"), ' ', $contents);
		error_log($callingModel." ============ ".$contents.PHP_EOL);
	}

	public function sendErrorMail($callingModel,$msg){
		$msg .= "<br/>Message From Page: ".$this->db;
		self::getModel("ContactForm");
		$mail = new ContactForm();
		$mail->sendErrorMail($callingModel, $msg);
	}

	/**
	 *
	 * @return string;
	 * Note: This will generate a random password to send to the user;
	 */
	public function generatePassword() {
		$lower = "abcdefghijklmnopqrstuwxyz";
		$upper = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
		$number= "0123456789";
		$characters = "!@#$%^&*()";
		$pass = array();

		for ($i = 0; $i < 2; $i++) {
			$pass[] = $lower[(rand(0, strlen($lower)-1))];
			$pass[] = $upper[(rand(0, strlen($upper)-1))];
			$pass[] = $number[(rand(0, strlen($number)-1))];
			$pass[] = $characters[(rand(0, strlen($characters)-1))];
		}
		return implode($pass); //turn the array into a string
	}
}


 								