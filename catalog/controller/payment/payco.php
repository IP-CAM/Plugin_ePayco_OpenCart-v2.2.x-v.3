<?php
class ControllerPaymentPayco extends Controller {
	public function index() {
		$this->load->language('payment/payco');

		$data['button_confirm'] = $this->language->get('button_confirm');

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$data['action']='https://secure.payco.co/payment.php';
		$data['p_cust_id_cliente'] = $this->config->get('payco_merchant');
		//$data['p_id_factura'] = $this->session->data['order_id'];
		$data['p_timestamp'] = time();
		$data['p_amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
		//$data['x_fp_hash'] = null; // calculated later, once all fields are populated
		$data['p_tax'] = 0;
		$data['p_amount_base']=0;
		$data['p_show_form'] = 'PAYMENT_FORM';
		$data['p_test_request'] = $this->config->get('payco_test');
		$data['p_type'] = 'AUTH_CAPTURE';
		$data['p_currency_code'] = $this->currency->getCode();
		$data['p_id_invoice'] = $this->session->data['order_id'];
		$data['p_description'] = html_entity_decode('Pago orden #'.$this->session->data['order_id']. ' en '.$this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
		$data['p_billing_first_name'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');
		$data['p_billing_last_name'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
		$data['p_billing_company'] = html_entity_decode($order_info['payment_company'], ENT_QUOTES, 'UTF-8');
		$data['p_billing_address'] = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8') . ' ' . html_entity_decode($order_info['payment_address_2'], ENT_QUOTES, 'UTF-8');
		$data['p_billing_city'] = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');
		$data['p_billing_state'] = html_entity_decode($order_info['payment_zone'], ENT_QUOTES, 'UTF-8');
		$data['p_billing_zip'] = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');
		$data['p_billing_country'] = html_entity_decode($order_info['payment_country'], ENT_QUOTES, 'UTF-8');
		$data['p_billing_phone'] = $order_info['telephone'];
		$data['p_shiping_first_name'] = html_entity_decode($order_info['shipping_firstname'], ENT_QUOTES, 'UTF-8');
		$data['p_shiping_last_name'] = html_entity_decode($order_info['shipping_lastname'], ENT_QUOTES, 'UTF-8');
		$data['p_shiping_company'] = html_entity_decode($order_info['shipping_company'], ENT_QUOTES, 'UTF-8');
		$data['p_shiping_address'] = html_entity_decode($order_info['shipping_address_1'], ENT_QUOTES, 'UTF-8') . ' ' . html_entity_decode($order_info['shipping_address_2'], ENT_QUOTES, 'UTF-8');
		$data['p_shiping_city'] = html_entity_decode($order_info['shipping_city'], ENT_QUOTES, 'UTF-8');
		$data['p_shiping_state'] = html_entity_decode($order_info['shipping_zone'], ENT_QUOTES, 'UTF-8');
		$data['p_shiping_zip'] = html_entity_decode($order_info['shipping_postcode'], ENT_QUOTES, 'UTF-8');
		$data['p_shiping_country'] = html_entity_decode($order_info['shipping_country'], ENT_QUOTES, 'UTF-8');
		$data['p_customer_ip'] = $this->request->server['REMOTE_ADDR'];
		$data['p_email'] = $order_info['email'];
		$data['p_extra1'] = 'OpenCart V 2.1.2';
		$data['p_url_response'] =$this->config->get('payco_callback');
		$data['p_url_confirmation'] =$this->config->get('payco_confirmation');

		$data['p_public_key'] = $this->config->get('payco_public_key');

		if ((int) $this->config->get('payco_test') == 1) {
			$data['p_test_mode'] = 'true';
		} else {
			$data['p_test_mode'] = 'false';
		}

		$data['p_payco_checkout_type'] = $this->config->get('payco_checkout_type');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/payco.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/payco.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/payco.tpl', $data);
		}

	}

	public function callback() {
		if ($this->request->post['x_ref_payco']>0) {
			$this->load->model('checkout/order');

			$order_info = $this->model_checkout_order->getOrder($this->request->post['x_id_factura']);
				
				$message = '';
				if (isset($this->request->post['x_respuesta'])) {
					$message .= 'Estado: ' . $this->request->post['x_respuesta'] . "\n";
				}
				if (isset($this->request->post['x_response_reason_text'])) {
					$message .= 'Respuesta: ' . $this->request->post['x_response_reason_text'] . "\n";
				}

				if (isset($this->request->post['x_franchise'])) {
					$message .= 'Franquicia: ' . $this->request->post['x_franchise'] . "\n";
				}

				if (isset($this->request->post['x_approval_code'])) {
					$message .= 'Autorización/Cus: ' . $this->request->post['x_approval_code'];
				}

				if (isset($this->request->post['x_transaction_id'])) {
					$message .= 'Recibo: ' . $this->request->post['x_transaction_id'];
				}


			if ($order_info && ($this->request->post['x_respuesta'] == 'Aceptada' || $this->request->post['x_respuesta'] == 'Pendiente' )) {
				
				$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get('payco_order_status_id'), $message, true);

				$this->response->redirect($this->url->link('checkout/success'));
			} else {
				$this->response->redirect($this->url->link('checkout/failure'));
			}
		} else {
			$this->response->redirect($this->url->link('checkout/failure'));
		}
	}
}
