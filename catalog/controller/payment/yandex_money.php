<?php
class ControllerPaymentYandexMoney extends Controller {
	protected function index() {
		$this->data['setting'] = $this->config->get('yandex_money_setting');
		
		$this->load->language('payment/yandex_money');
		
		$this->data['button_pay'     ] = $this->language->get('button_pay');
		$this->data['button_confirm' ] = $this->language->get('button_confirm');
		
		$this->data['text_note'      ] = $this->language->get('text_note');
		$this->data['text_commission'] = $this->language->get('text_commission');
		
		$this->data['action'         ] = $this->url->link('payment/yandex_money/getPaymentForm');
		$this->data['confirm'        ] = $this->url->link('checkout/confirm');
		$this->data['continue'       ] = $this->url->link('checkout/success');
		
		if ($this->data['setting']['commission_pay']) {
			$this->data['text_commission_pay'] = $this->language->get('text_buyer');
		} else {
			$this->data['text_commission_pay'] = $this->language->get('text_seller');
		}
		
		$this->data['payment_form'] = FALSE;
		
		if (file_exists (DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/yandex_money.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/yandex_money.tpl';
		} else {
			$this->template = 'default/template/payment/yandex_money.tpl';
		}
		
		$this->render();
	}
	
	public function getPaymentForm () {
		if (isset ($this->session->data['order_id'])) {
			$this->data['setting'] = $this->config->get('yandex_money_setting');
			
			if ($this->data['setting']['telephone']) {
				$this->data['text_telephone'] = $this->data['setting']['telephone'];
			} else {
				$this->data['text_telephone'] = $this->config->get('config_telephone');
			}
			
			$this->load->language('payment/yandex_money');
			
			$this->data['text_shop_name' ] = $this->config->get('config_name');
			$this->data['text_help'      ] = $this->language->get('text_help');
			
			$this->data['heading_title'  ] = $this->language->get('heading_title');
			$this->data['text_commission'] = $this->language->get('text_commission');
			$this->data['text_amount'    ] = $this->language->get('text_amount');
			$this->data['text_total'     ] = $this->language->get('text_total');
			$this->data['text_payment'   ] = $this->language->get('text_payment');
			$this->data['text_currency'  ] = $this->language->get('text_currency');
			
			$this->load->model('checkout/order');
			
			$this->data['order_id'] = (int) $this->session->data['order_id'];
			
			$order_info = $this->model_checkout_order->getOrder($this->data['order_id']);
			
			$rur_order_total = $this->currency->convert($order_info['total'], $order_info['currency_code'], 'RUB');
			
			if ($this->data['setting']['commission_pay']) {
				$this->data['amount'] = $this->currency->format($rur_order_total, 'RUB', $order_info['currency_value'], FALSE);
				
				$this->data['amount_total'] = $this->data['amount'] + ($this->data['amount'] * $this->data['setting']['commission']) / 100;
				
				$amendment = $this->data['amount'] - ($this->data['amount_total'] - ($this->data['amount_total'] * $this->data['setting']['commission']) / 100);
				
				$this->data['amount_total'] = round ($this->data['amount_total'] + $amendment, 2);
			} else {
				$this->data['amount_total'] = $this->currency->format($rur_order_total, 'RUB', $order_info['currency_value'], FALSE);
				
				$this->data['amount'] = round ($this->data['amount_total'] - ($this->data['amount_total'] * $this->data['setting']['commission']) / 100, 2);
			}
			
			$this->data['amount_commission'] = round ($this->data['amount_total'] - $this->data['amount'], 2);
			
			$this->data['payment_form'] = TRUE;
			
			if (file_exists (DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/yandex_money.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/payment/yandex_money.tpl';
			} else {
				$this->template = 'default/template/payment/yandex_money.tpl';
			}
			
			$this->response->setOutput($this->render());
		} else {
			$this->redirect($this->url->link('checkout/cart'));
		}
	}
	
	public function confirm() {
		$setting = $this->config->get('yandex_money_setting');
		
		$this->load->model('checkout/order');
		
		$this->model_checkout_order->confirm($this->session->data['order_id'], $setting['order_status_id']);
	}
}
?>