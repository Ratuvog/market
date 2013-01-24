<?php
class ControllerPaymentQiwi extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/qiwi');
		$this->data['qiwi_version'] = '1.3';	

	$this->document->setTitle = $this->language->get('heading_title');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('qiwi', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');


		$this->data['entry_shop_id'] = $this->language->get('entry_shop_id');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_soap_lib'] = $this->language->get('entry_soap_lib');
		$this->data['entry_rub_en'] = $this->language->get('entry_rub_en');


		$this->data['entry_result_url'] = $this->language->get('entry_result_url');
		$this->data['entry_success_url'] = $this->language->get('entry_success_url');
		$this->data['entry_fail_url'] = $this->language->get('entry_fail_url');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');

		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_order_status_cancel'] = $this->language->get('entry_order_status_cancel');
		$this->data['entry_order_status_progress'] = $this->language->get('entry_order_status_progress');
		$this->data['entry_lifetime'] = $this->language->get('entry_lifetime');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['shop_id'])) {
			$this->data['error_shop_id'] = $this->error['shop_id'];
		} else {
			$this->data['error_shop_id'] = '';
		}

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['lifetime'])) {
			$this->data['error_lifetime'] = $this->error['lifetime'];
		} else {
			$this->data['error_lifetime'] = '';
		}

				$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/qiwi', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/qiwi&token=' . $this->session->data['token'];

		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];


		// Номер магазина
		if (isset($this->request->post['qiwi_shop_id'])) {
			$this->data['qiwi_shop_id'] = $this->request->post['qiwi_shop_id'];
		} else {
			$this->data['qiwi_shop_id'] = $this->config->get('qiwi_shop_id');
		}

		if (isset($this->request->post['qiwi_password'])) {
			$this->data['qiwi_password'] = $this->request->post['qiwi_password'];
		} else {
			$this->data['qiwi_password'] = $this->config->get('qiwi_password');
		}

		// URL
		$this->data['webmoney_result_url'] 		= HTTP_CATALOG . 'index.php?route=payment/qiwi/callback';
		$this->data['webmoney_success_url'] 	= HTTP_CATALOG . 'index.php?route=payment/qiwi/success';
		$this->data['webmoney_fail_url'] 		= HTTP_CATALOG . 'index.php?route=payment/qiwi/fail';


		if (isset($this->request->post['qiwi_order_status_id'])) {
			$this->data['qiwi_order_status_id'] = $this->request->post['qiwi_order_status_id'];
		} else {
			$this->data['qiwi_order_status_id'] = $this->config->get('qiwi_order_status_id');
		}

		if (isset($this->request->post['qiwi_order_status_cancel_id'])) {
			$this->data['qiwi_order_status_cancel_id'] = $this->request->post['qiwi_order_status_cancel_id'];
		} else {
			$this->data['qiwi_order_status_cancel_id'] = $this->config->get('qiwi_order_status_cancel_id');
		}

		if (isset($this->request->post['qiwi_order_status_progress_id'])) {
			$this->data['qiwi_order_status_progress_id'] = $this->request->post['qiwi_order_status_progress_id'];
		} else {
			$this->data['qiwi_order_status_progress_id'] = $this->config->get('qiwi_order_status_progress_id');
		}

		if (isset($this->request->post['qiwi_lifetime'])) {
			$this->data['qiwi_lifetime'] = (int)$this->request->post['qiwi_lifetime'];
		} elseif( $this->config->get('qiwi_lifetime') ) {
			$this->data['qiwi_lifetime'] = (int)$this->config->get('qiwi_lifetime');
		} else {
			$this->data['qiwi_lifetime'] = 24;
		}

		// Проверка на наличие SOAP сервера
		if( class_exists('SoapServer') ) {
			$this->data['flag_soap'] = 1;
		} else {
			$this->data['flag_soap'] = 0;
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['qiwi_geo_zone_id'])) {
			$this->data['qiwi_geo_zone_id'] = $this->request->post['qiwi_geo_zone_id'];
		} else {
			$this->data['qiwi_geo_zone_id'] = $this->config->get('qiwi_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['qiwi_status'])) {
			$this->data['qiwi_status'] = $this->request->post['qiwi_status'];
		} else {
			$this->data['qiwi_status'] = $this->config->get('qiwi_status');
		}

		if (isset($this->request->post['qiwi_sort_order'])) {
			$this->data['qiwi_sort_order'] = $this->request->post['qiwi_sort_order'];
		} else {
			$this->data['qiwi_sort_order'] = $this->config->get('qiwi_sort_order');
		}



		$this->load->model('localisation/currency');

		$results = $this->model_localisation_currency->getCurrencies();	
		$this->data['flag_rub'] = 0;

		foreach ($results as $result) {
			if ($result['code'] == 'RUB') {
				$this->data['flag_rub'] = 1;
   			
			}
		}



		$this->template = 'payment/qiwi.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/qiwi')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}


		// TODO проверку на валидность номера!
		if (!$this->request->post['qiwi_shop_id']) {
			$this->error['shop_id'] = $this->language->get('error_shop_id');
		}

		if (!$this->request->post['qiwi_password']) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>