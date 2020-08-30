<?php
class ControllerExtensionModuleReviewExtender extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/review_extender');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('review_extender', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->cache->delete('product');

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_store_review'] = $this->language->get('text_store_review');
		$data['text_products_review'] = $this->language->get('text_products_review');
		$data['text_module_class_list'] = $this->language->get('text_module_class_list');
		$data['text_module_class_form'] = $this->language->get('text_module_class_form');
		$data['text_orders_check'] = $this->language->get('text_orders_check');
		$data['text_orders_skip'] = $this->language->get('text_orders_skip');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_check_orders'] = $this->language->get('entry_check_orders');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_type'] = $this->language->get('entry_type');
		$data['entry_module_class'] = $this->language->get('entry_module_class');
		$data['entry_rating'] = $this->language->get('entry_rating');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['check_orders'])) {
			$data['error_check_orders'] = $this->error['check_orders'];
		} else {
			$data['error_check_orders'] = '';
		}

		if (isset($this->error['type'])) {
			$data['error_type'] = $this->error['type'];
		} else {
			$data['error_type'] = '';
		}

		if (isset($this->error['module_class'])) {
			$data['error_module_class'] = $this->error['module_class'];
		} else {
			$data['error_module_class'] = '';
		}

		if (isset($this->error['rating'])) {
			$data['error_rating'] = $this->error['rating'];
		} else {
			$data['error_rating'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/review_extender', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/review_extender', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/review_extender', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/review_extender', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['check_orders'])) {
			$data['check_orders'] = $this->request->post['check_orders'];
		} elseif (!empty($module_info)) {
			$data['check_orders'] = $module_info['check_orders'];
		} else {
			$data['check_orders'] = '1';
		}

		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 5;
		}

		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($module_info)) {
			$data['type'] = $module_info['type'];
		} else {
			$data['type'] = 0;
		}

		if (isset($this->request->post['module_class'])) {
			$data['module_class'] = $this->request->post['module_class'];
		} elseif (!empty($module_info)) {
			$data['module_class'] = $module_info['module_class'];
		} else {
			$data['module_class'] = "L";
		}

		if (isset($this->request->post['rating'])) {
			$data['rating'] = $this->request->post['rating'];
		} elseif (!empty($module_info)) {
			$data['rating'] = $module_info['rating'];
		} else {
			$data['rating'] = 4;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/review_extender', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/review_extender')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!in_array($this->request->post['check_orders'],array("0","1"))) {
			$this->error['check_orders'] = $this->language->get('error_check_orders');
		}

		if (!in_array($this->request->post['type'],array("0","-1"))) {
			$this->error['type'] = $this->language->get('error_type');
		}

		if (!$this->request->post['module_class']) {
			$this->error['module_class'] = $this->language->get('module_class');
		}

		if (!$this->request->post['rating']) {
			$this->error['rating'] = $this->language->get('error_rating');
		}

		return !$this->error;
	}
}