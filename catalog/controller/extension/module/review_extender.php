<?php
class ControllerExtensionModuleReviewExtender extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/review_extender');

		$data["module_class"] = $setting["module_class"];

		if($setting["module_class"]=="L"){
			$data['heading_title'] = $this->language->get('heading_title');
			
			$this->load->model('catalog/review');
			
			$data['reviews'] = $this->model_catalog_review->getRandomReviews($setting);
			if(!$data['reviews']){
				$setting["type"] = -1;
				$data['reviews'] = $this->model_catalog_review->getRandomReviews($setting);
			}
			$this->rebuildAuthors($data['reviews']);

		}elseif($setting["module_class"]=="F"){
			$data['heading_title'] = $this->language->get('store_review_form');

			$data['review_guest'] = false;
			$data['allowed_to_review'] = false;

			$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));
			$data['text_note'] = $this->language->get('text_note');
			$data['text_loading'] = $this->language->get('text_loading');
			$data['text_no_orders'] = $this->language->get('text_no_orders');

			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_review'] = $this->language->get('entry_review');
			$data['entry_rating'] = $this->language->get('entry_rating');
			$data['entry_good'] = $this->language->get('entry_good');
			$data['entry_bad'] = $this->language->get('entry_bad');

			$data['button_continue'] = $this->language->get('button_continue');

			if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {

				$data['review_guest'] = true;
				if($setting["check_orders"]){
					$this->load->model("account/order");
					if($this->model_account_order->getTotalOrders()){
						$data['allowed_to_review'] = true;
					}
				}else{
					$data['allowed_to_review'] = true;
				}

			}

			if ($this->customer->isLogged()) {
				$data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
			} else {
				$data['customer_name'] = '';
			}

			// Captcha
			if (!$this->customer->isLogged() && $this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
				$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
			} else {
				$data['captcha'] = '';
			}

		}else{
			return false;
		}

		return $this->load->view('extension/module/review_extender', $data);
	}
	private function rebuildAuthors(&$reviews){
		foreach($reviews as $i=>$review){
			$author = explode(" ",$review["author"]);
			$reviews[$i]["author"] = $author[0].(isset($author[1])?" ".mb_substr($author[1],0,1,"UTF-8").".":"");
		}
	}
	public function review() {
		$this->load->language('extension/module/review_extender');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}

			if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
				$json['error'] = $this->language->get('error_rating');
			}
			
			// Captcha
			if (!$this->customer->isLogged() && $this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
				$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

				if ($captcha) {
					$json['error'] = $captcha;
				}
			}

			if (!isset($json['error'])) {
				$this->load->model('catalog/review');

				$this->model_catalog_review->addReview(0, $this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}