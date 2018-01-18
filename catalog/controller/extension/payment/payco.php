<?php
class ControllerExtensionPaymentPayco extends Controller {
	public function index() {
		$this->load->language('extension/payment/payco');

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
		$data['p_currency_code'] = $order_info['currency_code'];;
		$data['p_id_invoice'] = $this->session->data['order_id'];
		$data['p_description'] = html_entity_decode( $this->language->get('text_payment_description').$this->session->data['order_id']. ' '.$this->language->get('text_payment_description_in').' '.$this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
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
		$data['p_extra1'] = 'OpenCart V 2.3.x';
		$data['p_url_response'] =$this->config->get('payco_callback');
		$data['p_url_confirmation'] =$this->config->get('payco_confirmation');

		$data['p_public_key'] = $this->config->get('payco_public_key');
		$data['p_itemname']="";
		foreach ($this->cart->getProducts() as $product) {
			 if(trim($product['name'])!=""){
			 	if($data['p_itemname']==""){
			 		$data['p_itemname']=$product['name'];
			 	}else{
			 		$data['p_itemname'] = $data['p_itemname'].",".$product['name'];
			 	}
			 	
			 }
		}

		if ((int) $this->config->get('payco_test') == 1) {
			$data['p_test_mode'] = 'true';
		} else {
			$data['p_test_mode'] = 'false';
		}

		$data['p_payco_checkout_type'] = $this->config->get('payco_checkout_type');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/payco.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/payco.tpl', $data);
		} else {
			return $this->load->view('extension/payment/payco', $data);
		}

	}

	public function callback() 
	{
		

		if(isset($_GET['ref_payco']) || isset($_GET['?ref_payco'])){
			if(isset($_GET['?ref_payco'])){
				$_GET['ref_payco']=$_GET['?ref_payco'];
			}

			$url="https://secure.epayco.co/validation/v1/reference/".$_GET['ref_payco'];
			$response=json_decode(file_get_contents($url));
			$_REQUEST=(array)$response->data;
			
		}
		if (isset($_REQUEST['x_id_invoice'])) {
			$order_id = $_REQUEST['x_id_invoice'];
		} else {
			$order_id = 0;
		}
		if (isset($_REQUEST['x_ref_payco'])) {
			$this->load->model('checkout/order');
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('payco_final_order_status_id'));
			$p_cust_id_cliente=$this->config->get('payco_merchant');
             $p_key=$this->config->get('payco_key');

                $x_ref_payco=$_REQUEST['x_ref_payco'];
                $x_transaction_id=$_REQUEST['x_transaction_id'];
                $x_amount=$_REQUEST['x_amount'];
                $x_currency_code=$_REQUEST['x_currency_code'];
                $x_signature=$_REQUEST['x_signature'];

                $signature=hash('sha256',
                       $p_cust_id_cliente.'^'
                      .$p_key.'^'
                      .$x_ref_payco.'^'
                      .$x_transaction_id.'^'
                      .$x_amount.'^'
                      .$x_currency_code
                    );

				//Validamos la firma
                if($x_signature==$signature){
                $x_cod_response=$_REQUEST['x_cod_response'];
                switch ((int)$x_cod_response) {
                    case 1:
                       $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('payco_final_order_status_id'), '', true);
                        break;
                    case 2:
                        $this->model_checkout_order->addOrderHistory($order_id, 8, '', true);
                        break;
                    case 3:
                        $this->model_checkout_order->addOrderHistory($order_id, 1, '', true);
                        break;
                    case 4:
                       $this->model_checkout_order->addOrderHistory($order_id, 10, '', true);
                        break;              
                    
                }

                if($x_cod_response==1 || $x_cod_response==3){
                	$this->response->redirect($this->url->link('checkout/success'));
                }else{
                	$this->response->redirect($this->url->link('checkout/failure'));
                }

                }else{
                    die("Firma no valida");
                }                	

		}else{
			echo "no hay  request";
		}
	}
}
