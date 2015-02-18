<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TradeApp extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	function __construct() {
		
		parent::__construct();
		
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->helper(array('common'));		
		$this->load->model('model_message', 'message', true);
		
	}
	
	public function call() {
		
		$arrResponse = array();
		if(isset($_POST['data'])) {
			if($this->message->validateUserLimit(getUserIP()) > API_ACCESS_RATE_LIMIT) {
				$arrRequest = json_decode($_POST['data'], true);
				if(!is_null($arrRequest) && array_search("", $arrRequest) === false) {
					$arrData = array(
										'user_id' => $arrRequest['userId'],
										'currency_from' => $arrRequest['currencyFrom'],
										'currency_to' => $arrRequest['currencyTo'],
										'amount_sell' => $arrRequest['amountSell'],
										'amount_buy' => $arrRequest['amountBuy'],
										'rate' => $arrRequest['rate'],
										'time_placed' => $arrRequest['timePlaced'],
										'country' => $arrRequest['originatingCountry'],
										'msg_user_ip' => getUserIP(),
										'msg_timestamp' => strtotime('now')
									);
					$msgID = $this->message->saveValues(TABLE_MESSAGES, $arrData);
					$this->process($arrRequest['originatingCountry']);
					$arrResponse['success'] = 1;
				} else {
					$arrResponse['error'] = 1;
					$arrResponse['message'] = API_DATA_FORMAT_MSG;
				}
			} else {
				$arrResponse['error'] = 1;
				$arrResponse['message'] = API_ACCESS_RATE_LIMIT_MSG;
			}
		} else {
			$arrResponse['error'] = 1;
			$arrResponse['message'] = 'No data provided';
		}
		
		echo json_encode($arrResponse);
	}
	
	private function process($countryCode) {
		$this->message->updateCountryStat($countryCode);
	}
	
	public function view() {
		$data['arrMessages'] = $this->message->getMessages();
		$data['arrStats'] = $this->message->getCountryStat();
		$this->load->view('messages', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/tradeapp.php */