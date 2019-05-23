<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Smsapi extends CI_Model {

	public function getEndpoint(){
		return $this->db->get('sms_api')->row();
	}
	public function sendSms($endpoint, $mobile, $msg){	
		if( $this->url_test($endpoint)) {
			echo "test1";
			$msg = rawurlencode($msg);
			// file_get_contents($endpoint.'v1/sms/send/?phone='.$mobile.'&message='.$msg);
			$api = $endpoint.'v1/sms/send/?phone='.$mobile.'&message='.$msg; 
			header("Location:$api");
			?>
			<script type="text/javascript">
			// new_popup	();
			// function new_popup(){
			// 		var popupwin = window.open($endpoint.'v1/sms/send/?phone='.$mobile.'&message='.$msg,'_blank','width=10,height=1,left=5,top=3');
			// 		setTimeout(function() { popupwin.close();}, 5000);
			// }
			</script>
			<?php
					return true;
		}else {
			return false;
		}	
	}
	public function updateEndpoint($data){	
		$this->db->where('id', 1)->update('sms_api', $data);
		return null;
	}
	function url_test( $url ) {
		$timeout = 5;
		$ch = curl_init();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
		$http_respond = curl_exec($ch);
		$http_respond = trim( strip_tags( $http_respond ) );
		$http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		if ( ( $http_code == "200" ) || ( $http_code == "302" ) ) {
			return true;
		} else {
			// return $http_code;, possible too
			return false;
		}
		curl_close( $ch );
	}
}
