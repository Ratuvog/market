<?php
/**
 * e-mail: s-m-o-k@list.ru
 */
class ControllerPaymentOnPay extends Controller {
	private $error = array();

	public function index() {

		$this->load->language('payment/onpay');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('onpay', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_help'] = $this->language->get('text_help');

		$this->data['entry_merchant'] = $this->language->get('entry_merchant');
		$this->data['entry_security'] = $this->language->get('entry_security');
		$this->data['entry_callback'] = $this->language->get('entry_callback');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_add_params'] = $this->language->get('entry_add_params');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['merchant'])) {
			$this->data['error_merchant'] = $this->error['merchant'];
		} else {
			$this->data['error_merchant'] = '';
		}

		if (isset($this->error['security'])) {
			$this->data['error_security'] = $this->error['security'];
		} else {
			$this->data['error_security'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_home'),
			'separator' => FALSE
		);

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_payment'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link('payment/onpay', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('heading_title'),
			'separator' => ' :: '
		);
		$this->data['action'] =$this->url->link('payment/onpay', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] =$this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['onpay_merchant'])) {
			$this->data['onpay_merchant'] = $this->request->post['onpay_merchant'];
		} else {
			$this->data['onpay_merchant'] = $this->config->get('onpay_merchant');
		}

		if (isset($this->request->post['onpay_add_params'])) {
			$this->data['onpay_add_params'] = $this->request->post['onpay_add_params'];
		} else {
			$this->data['onpay_add_params'] = $this->config->get('onpay_add_params');
		}

		if (isset($this->request->post['onpay_security'])) {
			$this->data['onpay_security'] = $this->request->post['onpay_security'];
		} else {
			$this->data['onpay_security'] = $this->config->get('onpay_security');
		}

		$this->data['callback'] = HTTP_CATALOG . 'index.php?route=payment/onpay/callback';

		if (isset($this->request->post['onpay_order_status_id'])) {
			$this->data['onpay_order_status_id'] = $this->request->post['onpay_order_status_id'];
		} else {
			$this->data['onpay_order_status_id'] = $this->config->get('onpay_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['onpay_geo_zone_id'])) {
			$this->data['onpay_geo_zone_id'] = $this->request->post['onpay_geo_zone_id'];
		} else {
			$this->data['onpay_geo_zone_id'] = $this->config->get('onpay_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['onpay_status'])) {
			$this->data['onpay_status'] = $this->request->post['onpay_status'];
		} else {
			$this->data['onpay_status'] = $this->config->get('onpay_status');
		}

		if (isset($this->request->post['onpay_sort_order'])) {
			$this->data['onpay_sort_order'] = $this->request->post['onpay_sort_order'];
		} else {
			$this->data['onpay_sort_order'] = $this->config->get('onpay_sort_order');
		}

		$this->template = 'payment/onpay.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/onpay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['onpay_merchant']) {
			$this->error['merchant'] = $this->language->get('error_merchant');
		}

		if (!$this->request->post['onpay_security']) {
			$this->error['security'] = $this->language->get('error_security');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

?>