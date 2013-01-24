<?php
class ControllerAffiliatePayment extends Controller {
	private $error = array();

	public function index() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/payment', '', 'SSL');

			$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}

		$this->language->load('affiliate/payment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('affiliate/affiliate');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_affiliate_affiliate->editPayment($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('affiliate/account', '', 'SSL'));
		}

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),     	
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('affiliate/account', '', 'SSL'),        	
        	'separator' => $this->language->get('text_separator')
      	);

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('affiliate/payment', '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_your_payment'] = $this->language->get('text_your_payment');
		$this->data['text_cheque'] = $this->language->get('text_cheque');
		$this->data['text_paypal'] = $this->language->get('text_paypal');
		$this->data['text_bank'] = $this->language->get('text_bank');
		$this->data['text_webmoney'] = $this->language->get('text_webmoney');
		$this->data['text_yandex_money'] = $this->language->get('text_yandex_money');
		$this->data['text_marker'] = $this->language->get('text_marker');
		
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_payment'] = $this->language->get('entry_payment');
		$this->data['entry_webmoney_wmr'] = $this->language->get('entry_webmoney_wmr');
		$this->data['entry_webmoney_wmz'] = $this->language->get('entry_webmoney_wmz');
		$this->data['entry_webmoney_wme'] = $this->language->get('entry_webmoney_wme');
		$this->data['entry_webmoney_wmu'] = $this->language->get('entry_webmoney_wmu');
		$this->data['entry_yandex_money'] = $this->language->get('entry_yandex_money');
		$this->data['entry_marker'] = $this->language->get('entry_marker');
		$this->data['entry_cheque'] = $this->language->get('entry_cheque');
		$this->data['entry_paypal'] = $this->language->get('entry_paypal');
		$this->data['entry_bank_name'] = $this->language->get('entry_bank_name');
		$this->data['entry_bank_branch_number'] = $this->language->get('entry_bank_branch_number');
		$this->data['entry_bank_swift_code'] = $this->language->get('entry_bank_swift_code');
		$this->data['entry_bank_account_name'] = $this->language->get('entry_bank_account_name');
		$this->data['entry_bank_account_number'] = $this->language->get('entry_bank_account_number');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');
		
		$this->data['action'] = $this->url->link('affiliate/payment', '', 'SSL');

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$affiliate_info = $this->model_affiliate_affiliate->getAffiliate($this->affiliate->getId());
		}

		if (isset($this->request->post['tax'])) {
    		$this->data['tax'] = $this->request->post['tax'];
		} elseif (!empty($affiliate_info)) {
			$this->data['tax'] = $affiliate_info['tax'];		
		} else {
			$this->data['tax'] = '';
		}
			
		if (isset($this->request->post['payment'])) {
    		$this->data['payment'] = $this->request->post['payment'];
		} elseif (!empty($affiliate_info)) {
			$this->data['payment'] = $affiliate_info['payment'];			
		} else {
			$this->data['payment'] = 'webmoney';
		}
		
		if (isset($this->request->post['webmoney_wmr'])) {
    		$this->data['webmoney_wmr'] = $this->request->post['webmoney_wmr'];
		} elseif (!empty($affiliate_info)) {
			$this->data['webmoney_wmr'] = $affiliate_info['webmoney_wmr'];			
		} else {
			$this->data['webmoney_wmr'] = '';
		}
		
		if (isset($this->request->post['webmoney_wmz'])) {
    		$this->data['webmoney_wmz'] = $this->request->post['webmoney_wmz'];
		} elseif (!empty($affiliate_info)) {
			$this->data['webmoney_wmz'] = $affiliate_info['webmoney_wmz'];			
		} else {
			$this->data['webmoney_wmz'] = '';
		}
		
		if (isset($this->request->post['webmoney_wme'])) {
    		$this->data['webmoney_wme'] = $this->request->post['webmoney_wme'];
		} elseif (!empty($affiliate_info)) {
			$this->data['webmoney_wme'] = $affiliate_info['webmoney_wme'];			
		} else {
			$this->data['webmoney_wme'] = '';
		}
		
		if (isset($this->request->post['webmoney_wmu'])) {
    		$this->data['webmoney_wmu'] = $this->request->post['webmoney_wmu'];
		} elseif (!empty($affiliate_info)) {
			$this->data['webmoney_wmu'] = $affiliate_info['webmoney_wmu'];			
		} else {
			$this->data['webmoney_wmu'] = '';
		}
		
		if (isset($this->request->post['yandex_money'])) {
    		$this->data['yandex_money'] = $this->request->post['yandex_money'];
		} elseif (!empty($affiliate_info)) {
			$this->data['yandex_money'] = $affiliate_info['yandex_money'];			
		} else {
			$this->data['yandex_money'] = '';
		}

		if (isset($this->request->post['cheque'])) {
    		$this->data['cheque'] = $this->request->post['cheque'];
		} elseif (!empty($affiliate_info)) {
			$this->data['cheque'] = $affiliate_info['cheque'];			
		} else {
			$this->data['cheque'] = '';
		}

		if (isset($this->request->post['paypal'])) {
    		$this->data['paypal'] = $this->request->post['paypal'];
		} elseif (!empty($affiliate_info)) {
			$this->data['paypal'] = $affiliate_info['paypal'];		
		} else {
			$this->data['paypal'] = '';
		}

		if (isset($this->request->post['bank_name'])) {
    		$this->data['bank_name'] = $this->request->post['bank_name'];
		} elseif (!empty($affiliate_info)) {
			$this->data['bank_name'] = $affiliate_info['bank_name'];			
		} else {
			$this->data['bank_name'] = '';
		}

		if (isset($this->request->post['bank_branch_number'])) {
    		$this->data['bank_branch_number'] = $this->request->post['bank_branch_number'];
		} elseif (!empty($affiliate_info)) {
			$this->data['bank_branch_number'] = $affiliate_info['bank_branch_number'];		
		} else {
			$this->data['bank_branch_number'] = '';
		}

		if (isset($this->request->post['bank_swift_code'])) {
    		$this->data['bank_swift_code'] = $this->request->post['bank_swift_code'];
		} elseif (!empty($affiliate_info)) {
			$this->data['bank_swift_code'] = $affiliate_info['bank_swift_code'];			
		} else {
			$this->data['bank_swift_code'] = '';
		}

		if (isset($this->request->post['bank_account_name'])) {
    		$this->data['bank_account_name'] = $this->request->post['bank_account_name'];
		} elseif (!empty($affiliate_info)) {
			$this->data['bank_account_name'] = $affiliate_info['bank_account_name'];		
		} else {
			$this->data['bank_account_name'] = '';
		}
		
		if (isset($this->request->post['bank_account_number'])) {
    		$this->data['bank_account_number'] = $this->request->post['bank_account_number'];
		} elseif (!empty($affiliate_info)) {
			$this->data['bank_account_number'] = $affiliate_info['bank_account_number'];			
		} else {
			$this->data['bank_account_number'] = '';
		}
		
		$this->data['back'] = $this->url->link('affiliate/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/payment.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/payment.tpl';
		} else {
			$this->template = 'default/template/affiliate/payment.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);
						
		$this->response->setOutput($this->render());		
	}
}
?>