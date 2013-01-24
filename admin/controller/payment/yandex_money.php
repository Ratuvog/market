<?php
class ControllerPaymentYandexMoney extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('payment/yandex_money');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('yandex_money', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'       ] = $this->language->get('heading_title');
		
		$this->data['text_seller'         ] = $this->language->get('text_seller');
		$this->data['text_buyer'          ] = $this->language->get('text_buyer');
		$this->data['text_enabled'        ] = $this->language->get('text_enabled');
		$this->data['text_disabled'       ] = $this->language->get('text_disabled');
		$this->data['text_all_zones'      ] = $this->language->get('text_all_zones');
		
		$this->data['entry_wallet'        ] = $this->language->get('entry_wallet');
		$this->data['entry_commission'    ] = $this->language->get('entry_commission');
		$this->data['entry_commission_pay'] = $this->language->get('entry_commission_pay');
		$this->data['entry_telephone'     ] = $this->language->get('entry_telephone');
		$this->data['entry_telephone_help'] = $this->language->get('entry_telephone_help');
		$this->data['entry_order_status'  ] = $this->language->get('entry_order_status');
		$this->data['entry_geo_zone'      ] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'        ] = $this->language->get('entry_status');
		$this->data['entry_sort_order'    ] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'         ] = $this->language->get('button_save');
		$this->data['button_cancel'       ] = $this->language->get('button_cancel');
		
		$this->data['error_warning'] = $this->data['error_wallet'] = FALSE;
		
		if (isset ($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		}
		
		if (isset ($this->error['wallet'])) {
			$this->data['error_wallet'] = $this->error['wallet'];
		}
		
		$this->data['breadcrumbs'] = array(
			array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			),
			array(
				'text'      => $this->language->get('text_payment'),
				'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			),
			array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('payment/yandex_money', 'token=' . $this->session->data['token'], 'SSL'),      		
				'separator' => ' :: '
			)
		);
		
		$this->data['action'] = $this->url->link('payment/yandex_money', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$this->data['yandex_money_setting'] = array (
			'wallet'          => FALSE,
			'commission'      => 0.5,
			'commission_pay'  => 1,
			'telephone'       => FALSE,
			'order_status_id' => FALSE,
			'geo_zone_id'     => FALSE,
		);
		
		if (isset ($this->request->post['yandex_money_setting'])) {
			$this->data['yandex_money_setting'] = $this->request->post['yandex_money_setting'];
		} else {
			$this->data['yandex_money_setting'] = $this->config->get('yandex_money_setting');
		}
		
		if (isset ($this->request->post['yandex_money_status'])) {
			$this->data['yandex_money_status'] = $this->request->post['yandex_money_status'];
		} else {
			$this->data['yandex_money_status'] = $this->config->get('yandex_money_status');
		}
		
		if (isset ($this->request->post['yandex_money_sort_order'])) {
			$this->data['yandex_money_sort_order'] = $this->request->post['yandex_money_sort_order'];
		} else {
			$this->data['yandex_money_sort_order'] = $this->config->get('yandex_money_sort_order');
		}
		
		$this->template = 'payment/yandex_money.tpl';
		$this->children = array (
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/yandex_money')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset ($this->request->post['yandex_money_setting'])) {
			if (!preg_match ('/^[0-9]*$/', $this->request->post['yandex_money_setting']['wallet'])) {
				$this->error['wallet'] = $this->language->get('error_wallet_number');
			}
			
			if (!$this->request->post['yandex_money_setting']['wallet']) {
				$this->error['wallet'] = $this->language->get('error_wallet_empty');
			}
			
			$this->request->post['yandex_money_setting']['commission'] = (float) $this->request->post['yandex_money_setting']['commission'];
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>