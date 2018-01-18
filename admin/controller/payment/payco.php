<?php
class ControllerPaymentPayco extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/payco');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('payco', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_info'] = $this->language->get('text_info');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_title_description'] = $this->language->get('entry_title_description');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_description_description'] = $this->language->get('entry_description_description');
		$data['entry_merchant'] = $this->language->get('entry_merchant');
		$data['entry_merchant_description'] = $this->language->get('entry_merchant_description');
		$data['entry_key'] = $this->language->get('entry_key');
		$data['entry_key_description'] = $this->language->get('entry_key_description');
		$data['entry_public_key'] = $this->language->get('entry_public_key');
		$data['entry_public_key_description'] = $this->language->get('entry_public_key_description');
		$data['entry_checkout_type'] = $this->language->get('entry_checkout_type');
		$data['entry_checkout_type_description'] = $this->language->get('entry_checkout_type_description');
		$data['entry_callback'] = $this->language->get('entry_callback');
		$data['entry_callback_description'] = $this->language->get('entry_callback_description');
		$data['entry_confirmation'] = $this->language->get('entry_confirmation');
		$data['entry_confirmation_description'] = $this->language->get('entry_confirmation_description');
		//$data['entry_md5'] = $this->language->get('entry_md5');
		//$data['entry_total'] = $this->language->get('entry_total');
		//$data['entry_comision'] = $this->language->get('entry_comision');
		//$data['entry_valor_comision'] = $this->language->get('entry_valor_comision');
		
		$data['entry_test'] = $this->language->get('entry_test');
		$data['entry_test_description'] = $this->language->get('entry_test_description');
		$data['entry_initial_order_status'] = $this->language->get('entry_initial_order_status');
		$data['entry_initial_order_status_description'] = $this->language->get('entry_initial_order_status_description');
		$data['entry_final_order_status'] = $this->language->get('entry_final_order_status');
		$data['entry_final_order_status_description'] = $this->language->get('entry_final_order_status_description');
		
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_status_description'] = $this->language->get('entry_status_description');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['help_callback'] = $this->language->get('help_callback');
		//$data['help_md5'] = $this->language->get('help_md5');
		//$data['help_total'] = $this->language->get('help_total');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['merchant'])) {
			$data['error_merchant'] = $this->error['merchant'];
		} else {
			$data['error_merchant'] = '';
		}

		if (isset($this->error['key'])) {
			$data['error_key'] = $this->error['key'];
		} else {
			$data['error_key'] = '';
		}

		if (isset($this->error['public_key'])) {
			$data['error_public_key'] = $this->error['public_key'];
		} else {
			$data['error_public_key'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}

		if (isset($this->error['callback'])) {
			$data['error_callback'] = $this->error['callback'];
		} else {
			$data['error_callback'] = '';
		}

		if (isset($this->error['confirmation'])) {
			$data['error_confirmation'] = $this->error['confirmation'];
		} else {
			$data['error_confirmation'] = '';
		}

		/*if (isset($this->error['comision'])) {
			$data['error_comision'] = $this->error['comision'];
		} else {
			$data['error_comision'] = '';
		}

		if (isset($this->error['valor_comision'])) {
			$data['error_valor_comision'] = $this->error['valor_comision'];
		} else {
			$data['error_valor_comision'] = '';
		}*/

		if ($this->config->get('payco_callback')  === null) {
			$this->request->post['payco_callback'] = HTTP_CATALOG . 'index.php?route=payment/payco/callback&'; //permitir success
		}

		if ($this->config->get('payco_confirmation') === null) {
			$this->request->post['payco_confirmation'] = HTTP_CATALOG . 'index.php?route=payment/payco/callback';
		} 

		if ($this->config->get('payco_initial_order_status_id')  === null) {
			$this->request->post['payco_initial_order_status_id'] = 1;
		}

		if ($this->config->get('payco_final_order_status_id') === null) {
			$this->request->post['payco_final_order_status_id'] = 5;
		} 

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/payco', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('payment/payco', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['payco_merchant'])) {
			$data['payco_merchant'] = $this->request->post['payco_merchant'];
		} else {
			$data['payco_merchant'] = $this->config->get('payco_merchant');
		}

		if (isset($this->request->post['payco_title'])) {
			$data['payco_title'] = $this->request->post['payco_title'];
		} else {
			if ($this->config->get('payco_title') !== null) {
				$data['payco_title'] = $this->config->get('payco_title');
			} else {
				$data['payco_title'] = $this->language->get('entry_title_default');
			}
		}

		if (isset($this->request->post['payco_description'])) {
			$data['payco_description'] = $this->request->post['payco_description'];
		} else {
			if ($this->config->get('payco_description') !== null) {
				$data['payco_description'] = $this->config->get('payco_description');
			} else {
				$data['payco_description'] = $this->language->get('entry_description_default');
			}
		}

		if (isset($this->request->post['payco_key'])) {
			$data['payco_key'] = $this->request->post['payco_key'];
		} else {
			$data['payco_key'] = $this->config->get('payco_key');
		}

		if (isset($this->request->post['payco_public_key'])) {
			$data['payco_public_key'] = $this->request->post['payco_public_key'];
		} else {
			$data['payco_public_key'] = $this->config->get('payco_public_key');
		}

		if (isset($this->request->post['payco_checkout_type'])) {
			$data['payco_checkout_type'] = $this->request->post['payco_checkout_type'];
		} else {
			$data['payco_checkout_type'] = $this->config->get('payco_checkout_type');
		}

		if (isset($this->request->post['payco_comision'])) {
			$data['payco_comision'] = $this->request->post['payco_comision'];
		} else {
			$data['payco_comision'] = $this->config->get('payco_comision')?$this->config->get('payco_comision'):2.99;
		}

		if (isset($this->request->post['payco_valor_comision'])) {
			$data['payco_valor_comision'] = $this->request->post['payco_valor_comision'];
		} else {
			$data['payco_valor_comision'] = $this->config->get('payco_valor_comision')?$this->config->get('payco_valor_comision'):600;
		}

		if (isset($this->request->post['payco_test'])) {
			$data['payco_test'] = $this->request->post['payco_test'];
		} else {
			$data['payco_test'] = $this->config->get('payco_test');
		}

		if (isset($this->request->post['payco_status'])) {
			$data['payco_status'] = $this->request->post['payco_status'];
		} else {
			$data['payco_status'] = 0;
		}

	/*	if (isset($this->request->post['payco_callback'])) {
			$data['payco_callback'] = $this->request->post['payco_callback'];
		} else {
			$data['payco_callback'] = HTTP_CATALOG . 'index.php?route=payment/payco/callback';
		}*/

		if (isset($this->request->post['payco_callback'])) {
			$data['payco_callback'] = $this->request->post['payco_callback'];
		} else {
			$data['payco_callback'] = $this->config->get('payco_callback');
		}

		if (isset($this->request->post['payco_confirmation'])) {
			$data['payco_confirmation'] = $this->request->post['payco_confirmation'];
		} else {
			$data['payco_confirmation'] = $this->config->get('payco_confirmation');

		}


		/*if (isset($this->request->post['payco_confirmation'])) {
			$data['payco_confirmation'] = $this->request->post['payco_confirmation'];
		} else {
			$data['payco_confirmation'] = HTTP_CATALOG . 'index.php?route=payment/payco/callback';
		}*/


		/*if (isset($this->request->post['payco_md5'])) {
			$data['payco_md5'] = $this->request->post['payco_md5'];
		} else {
			$data['payco_md5'] = $this->config->get('payco_md5');
		}*/

		/*if (isset($this->request->post['payco_total'])) {
			$data['payco_total'] = $this->request->post['payco_total'];
		} else {
			$data['payco_total'] = $this->config->get('payco_total');
		}*/

		if (isset($this->request->post['payco_initial_order_status_id'])) {
			$data['payco_initial_order_status_id'] = $this->request->post['payco_initial_order_status_id'];
		} else {
			$data['payco_initial_order_status_id'] = $this->config->get('payco_initial_order_status_id');
		}

		if (isset($this->request->post['payco_final_order_status_id'])) {
			$data['payco_final_order_status_id'] = $this->request->post['payco_final_order_status_id'];
		} else {
			$data['payco_final_order_status_id'] = $this->config->get('payco_final_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['payco_geo_zone_id'])) {
			$data['payco_geo_zone_id'] = $this->request->post['payco_geo_zone_id'];
		} else {
			$data['payco_geo_zone_id'] = $this->config->get('payco_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['payco_status'])) {
			$data['payco_status'] = $this->request->post['payco_status'];
		} else {
			$data['payco_status'] = $this->config->get('payco_status');
		}

		if (isset($this->request->post['payco_sort_order'])) {
			$data['payco_sort_order'] = $this->request->post['payco_sort_order'];
		} else {
			$data['payco_sort_order'] = $this->config->get('payco_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/payco.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/payco')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['payco_title']) {
			$this->error['title'] = $this->language->get('error_title');
		}

		if (!$this->request->post['payco_description']) {
			$this->error['description'] = $this->language->get('error_description');
		}

		if (!$this->request->post['payco_merchant']) {
			$this->error['merchant'] = $this->language->get('error_merchant');
		}

		if (!$this->request->post['payco_key']) {
			$this->error['key'] = $this->language->get('error_key');
		}

		if (!$this->request->post['payco_public_key']) {
			$this->error['public_key'] = $this->language->get('error_public_key');
		}

		if (!$this->request->post['payco_callback']) {
			$this->request->post['payco_callback'] = HTTP_CATALOG . 'index.php?route=payment/payco/callback&'; //permitir success
		}

		if (!$this->request->post['payco_confirmation']) {
			$this->request->post['payco_confirmation'] = HTTP_CATALOG . 'index.php?route=payment/payco/callback';
		}

		return !$this->error;
	}
}