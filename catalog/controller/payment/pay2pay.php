<?php
class ControllerPaymentpay2pay extends Controller {
	protected function index() {
	$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');


		$this->data['action'] = 'https://merchant.pay2pay.com/?page=init';

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);


		// Переменные
		$this->data['version'] = $this->config->get('pay2pay_version');
		$this->data['merchant_id'] = $this->config->get('pay2pay_login');
		$this->data['language'] = $this->config->get('pay2pay_lang');
        $this->data['order_id'] =  $this->session->data['order_id'];
		$rur_code = $this->config->get('pay2pay_currency');
        $rur_order_total = $this->currency->convert($order_info['total'], $order_info['currency_code'], $rur_code);
	    $this->data['amount'] = $this->currency->format($rur_order_total, $rur_code, $order_info['currency_value'], FALSE);
		$this->data['currency'] = $this->config->get('pay2pay_currency');
        $this->data['description'] = $this->config->get('config_store') . ' ' . $order_info['payment_firstname'] . ' ' . $order_info['payment_address_1'] . ' ' . $order_info['payment_address_2'] . ' ' . $order_info['payment_city'] . ' ' . $order_info['email'];
		$this->data['test_mode'] = $this->config->get('pay2pay_test');
        $this->data['SecretKey'] = $this->config->get('pay2pay_password1');



    	$this->data['xml'] = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        $this->data['xml'] .="<request>";
 		$this->data['xml'] .= "<version>" .$this->data['version']. "</version>";
 		$this->data['xml'] .= "<merchant_id>" .$this->data['merchant_id']. "</merchant_id>";
 		$this->data['xml'] .= "<language>" .$this->data['language']. "</language>";
 		$this->data['xml'] .= "<order_id>" .$this->data['order_id']. "</order_id>";
 		$this->data['xml'] .= "<amount>" .$this->data['amount']. "</amount>";
 		$this->data['xml'] .= "<currency>" .$this->data['currency']. "</currency>";
		$this->data['xml'] .= "<description>" .$this->data['description']. "</description>";
 		$this->data['xml'] .= "<paymode></paymode>";
 		$this->data['xml'] .= "<purse></purse>";
		$this->data['xml'] .= "<test_mode>" .$this->data['test_mode']. "</test_mode>";
		$this->data['xml'] .= "</request>";


    	$this->data['sign']= md5($this->data['SecretKey'] .$this->data['xml']. $this->data['SecretKey']);

           $this->data['xml'] =  base64_encode($this->data['xml']);
           $this->data['sign']= base64_encode($this->data['sign']);

		if ($this->request->get['route'] != 'checkout/guest_step_3') {
			$this->data['cancel_return'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
		} else {
			$this->data['cancel_return'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
		}

		if ($this->request->get['route'] != 'checkout/guest_step_3') {
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
		} else {
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
		}

		$this->id = 'payment';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pay2pay.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/pay2pay.tpl';
		} else {
			$this->template = 'default/template/payment/pay2pay.tpl';
		}

		$this->render();
	}

	public function fail() {


		$this->redirect( HTTPS_SERVER . 'index.php?route=checkout/checkout');
	}

	public function success() {

    $xml_post = base64_decode(str_replace(' ', '+', $this->request->post['xml']));

  	$vars = simplexml_load_string($xml_post);

  	$ar_req['version']     = $vars->version;
  	$ar_req['merchant_id'] = $vars->merchant_id;
  	$ar_req['order_id']    = $vars->order_id;
  	$ar_req['amount']      = $vars->amount;
  	$ar_req['language']      = $vars->language;
  	$ar_req['currency']    = $vars->currency;
  	$ar_req['description'] = $vars->description;
  	$ar_req['paymode']     = $vars->paymode;
  	$ar_req['trans_id']    = $vars->trans_id;
  	$ar_req['status']      = $vars->status;
  	$ar_req['test_mode']      = $vars->test_mode;
  	$ar_req['error_msg']   = $vars->error_msg;

  	$inv_id = $ar_req['order_id'];

		$this->load->model('checkout/order');
        if ($ar_req['status'] == 'success'){
	  	 $this->model_checkout_order->confirm($inv_id, $this->config->get('pay2pay_order_status_id') );

		$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/success');
        }

		exit;
	}

	public function callback() {



    $SecretKey = $this->config->get('pay2pay_password1');
    $xml_post = base64_decode(str_replace(' ', '+', $this->request->post['xml']));
    $xml = base64_decode( $this->request->post['xml']);
  	$vars = simplexml_load_string($xml_post);
  	$ar_req['status']      = $vars->status;
  	$ar_req['order_id']    = $vars->order_id;
  	$ar_req['amount']      = $vars->amount;
  	$inv_id = $ar_req['order_id'];
	$sign = md5($SecretKey .$xml_post. $SecretKey);

	$sign = base64_encode($sign);
	$sign_post = $this->request->post['sign'];
	$sign_encode =  $sign;
    $this->load->model('checkout/order');
 $order_info = $this->model_checkout_order->getOrder($inv_id);
	$rur_code = $this->config->get('pay2pay_currency');
    $rur_order_total = $this->currency->convert($order_info['total'], $order_info['currency_code'], $rur_code);
	$amount = $this->currency->format($rur_order_total, $rur_code, $order_info['currency_value'], FALSE);

		 if ($sign_post != $sign_encode) {
		 echo "result=no&description=Security check failed";

		}

        if ($amount != $ar_req['amount']) {
		 echo "result=no&description=Amount check failed";

		}

  	    if ($ar_req['status'] == 'success'){


	  	$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($inv_id);


		if ( ! $order_info) {
			echo "result=no&description=Нет такого заказа";

		}

		if( $order_info['order_status_id'] == 0) {
			$this->model_checkout_order->confirm($inv_id, $this->config->get('pay2pay_order_status_id'), 'Pay2Pay');

		}

		if( $order_info['order_status_id'] != $this->config->get('pay2pay_order_status_id')) {
			$this->model_checkout_order->update($inv_id, $this->config->get('pay2pay_order_status_id'),'Pay2Pay',TRUE);
		}

           echo "result=yes";
        }



	}

}
?>