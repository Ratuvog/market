<?php
class ControllerPaymentRobokassa extends Controller {
	protected function index() {
		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
//tesrt

		if($this->config->get('robokassa_test')) {

			$this->data['action'] = 'http://test.robokassa.ru/Index.aspx';
		} else {

			$this->data['action'] = 'http://merchant.roboxchange.com/Index.aspx';
		}

		$this->data['mrh_login'] = $this->config->get('robokassa_login');
	    $this->data['mrh_pass1']= $this->config->get('robokassa_password1');

		// Номер заказа
		$this->data['inv_id'] = $this->session->data['order_id'];

		// Комментарий к заказу
		$this->data['inv_desc'] = $this->config->get('config_store') . ' ' . $order_info['payment_firstname'] . ' ' . $order_info['payment_address_1'] . ' ' . $order_info['payment_address_2'] . ' ' . $order_info['payment_city'] . ' ' . $order_info['email'];

		// Сумма заказа
		$rur_code = 'RUB';
		$rur_order_total = $this->currency->convert($order_info['total'], $order_info['currency_code'], $rur_code);
		$this->data['out_summ'] = $this->currency->format($rur_order_total, $rur_code, $order_info['currency_value'], FALSE);


		// Кодировка
		//$this->data['encoding'] = "utf-8";

		// Сигнатура
		$this->data['crc']= md5($this->data['mrh_login']. ":" .$this->data['out_summ']. ":" .$this->data['inv_id']. ":" .$this->data['mrh_pass1']);

		$this->data['merchant_url'] = $this->data['action'] .
				'?MrchLogin=' 		. $this->data['mrh_login'] .
				'&OutSum='			. $this->data['out_summ'] .
				'&InvId='			. $this->data['inv_id']	.
				'&Desc='			. $this->data['inv_desc']	.
				'&SignatureValue='	. $this->data['crc'];
//tesrt








		if ($this->request->get['route'] != 'checkout/guest_step_3') {
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/checkout';
		} else {
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
		}

		$this->id = 'payment';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/robokassa.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/robokassa.tpl';
		} else {
			$this->template = 'default/template/payment/robokassa.tpl';
		}

		$this->render();
	}

private function result() {
		echo 1;
	}

	public function success() {


		$mrh_pass1 = $this->config->get('robokassa_password1');
		$out_summ = $this->request->post['OutSum'];
		$order_id = $this->request->post["InvId"];
		$crc = $this->request->post["SignatureValue"];

		// HTTP parameters: $out_summ, $inv_id, $crc
		$crc = strtoupper($crc);   // force uppercase

		// build own CRC
		$my_crc = strtoupper(md5($out_summ. ":" .$order_id. ":" .$mrh_pass1));

		if (strtoupper($my_crc) == strtoupper($crc))
		{

			$this->load->model('checkout/order');

			$order_info = $this->model_checkout_order->getOrder($order_id);

			// Проверка, создан ли уже заказ.
			if( $order_info['order_status_id'] == 0) {
				$this->model_checkout_order->confirm($order_id, $this->config->get('config_order_status_id') );

			}

			$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/success');

		}

		echo 'err';
		exit;

	}


	public function fail() {

		$this->redirect( HTTPS_SERVER . 'index.php?route=checkout/checkout');

	}



	public function callback() {

		$mrh_pass2 = $this->config->get('robokassa_password2');

		$out_summ = $this->request->post['OutSum'];
		$order_id = $this->request->post["InvId"];
		$crc = $this->request->post["SignatureValue"];

		// HTTP parameters: $out_summ, $inv_id, $crc
		$crc = strtoupper($crc);   // force uppercase

		// build own CRC
		$my_crc = strtoupper(md5($out_summ. ":" .$order_id. ":" .$mrh_pass2));

		if (strtoupper($my_crc) == strtoupper($crc))
		{

			$this->load->model('checkout/order');

			$order_info = $this->model_checkout_order->getOrder($order_id);
			$new_order_status_id = $this->config->get('robokassa_order_status_id');


			if( $order_info['order_status_id'] == 0) {
				$this->model_checkout_order->confirm($order_id, $new_order_status_id, 'ROBOKASSA');
				echo "OK".$order_id."\n";
				return('');
			}

			if( $order_info['order_status_id'] != $new_order_status_id) {
				$this->model_checkout_order->update($order_id, $new_order_status_id,'ROBOKASSA',TRUE);


			}

			echo "OK".$order_id."\n";

		}

	}
}
?>