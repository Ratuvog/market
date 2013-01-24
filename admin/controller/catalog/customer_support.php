<?php
class ControllerCatalogCustomerSupport extends Controller {
	private $error = array();
 	private $customer_support_status = array(
			  'Открытый'
			, 'Закрытый'
	);
	public function index() {
		$this->load->language('catalog/customer_support');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/customer_support');
		$this->load->model('catalog/customer_support_category');
		
		$this->getList();
	} 

	private function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cs.date_updated';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['filter_customer_support_id'])) {
			$filter_customer_support_id = $this->request->get['filter_customer_support_id'];
		} else {
			$filter_customer_support_id = '';
		}
		
		if (isset($this->request->get['filter_customer_support_status'])) {
			$filter_customer_support_status = $this->request->get['filter_customer_support_status'];
		} else {
			$filter_customer_support_status = '';
		}
		
		if (isset($this->request->get['filter_cs_category_id'])) {
			$filter_cs_category_id = $this->request->get['filter_cs_category_id'];
		} else {
			$filter_cs_category_id = '';
		}
		
		if (isset($this->request->get['filter_customer_subject'])) {
			$filter_customer_subject = $this->request->get['filter_customer_subject'];
		} else {
			$filter_customer_subject = '';
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = '';
		}

		$cs_category = $this->model_catalog_customer_support_category->getCategories(0);
		
		$this->data['cs_category'] = $cs_category;		
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'href'		=> $this->url->link('catalog/customer_support', 'token=' . $this->session->data['token'].$url, 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['delete'] = $this->url->link('catalog/customer_support/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['customer_supports'] = array();

		$data = array(
			'filter_customer_support_id'		=> $filter_customer_support_id,		
			'filter_customer_support_status'	=> $filter_customer_support_status,
			'filter_cs_category_id'				=> $filter_cs_category_id,
			'filter_customer_subject'			=> $filter_customer_subject,
			'filter_date_added'					=> $filter_date_added,
			'only_topics'						=> true,
			'sort'  							=> $sort,
			'order' 							=> $order,
			'start' 							=> ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' 							=> $this->config->get('config_admin_limit')
			
		);
		
		$customer_support_total = $this->model_catalog_customer_support->getTotalCustomerSupports();
	
		$results = $this->model_catalog_customer_support->getCustomerSupports($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/customer_support/update', 'token=' . $this->session->data['token'] . '&customer_support_id=' . $result['customer_support_id'] . $url, 'SSL')
			);
						
			$search_options = array(
				  'customer_support_topic_id' => $result['customer_support_topic_id']
				, 'except_topics'	=>	true
				, 'order'			=>	'ASC'
			);
			
			$this->data['customer_supports'][] = array(
				'customer_support_id'  				=> $result['customer_support_id'],
				'customer_support_topic_id'			=> $result['customer_support_topic_id'],
				'store_id'       					=> $result['store_id'],
				'store_name'       					=> $result['store_name'],
				'customer_support_1st_category'   	=> $result['customer_support_1st_category'],
				'customer_support_2nd_category'   	=> $result['customer_support_2nd_category'],
				'reference'     					=> $result['reference'],
				'customer_support_status'			=> $result['customer_support_status'],
				'customer_id'     					=> $result['customer_id'],
				'firstname'     					=> $result['firstname'],
				'lastname'     						=> $result['lastname'],
				'subject'     						=> $result['subject'],
				'enquiry'     						=> $result['enquiry'],
				'date_added' 						=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'status'				 			=> $result['status'],
				'selected'   						=> isset($this->request->post['selected']) && in_array($result['customer_support_id'], $this->request->post['selected']),
				'action'     						=> $action,
				'customer_supports_threads'			=> $this->model_catalog_customer_support->getCustomerSupports($search_options)
			);
		} 	
	
		$this->data['filter_customer_support_id'] = $filter_customer_support_id;
		$this->data['filter_customer_support_status'] = $filter_customer_support_status;
		$this->data['filter_cs_category_id'] = $filter_cs_category_id;
		$this->data['filter_customer_subject'] = $filter_customer_subject;
		$this->data['filter_date_added'] = $filter_date_added;
		
		
		$this->data['heading_title'] 		= $this->language->get('heading_title');

		$this->data['text_no_results'] 		= $this->language->get('text_no_results');
		$this->data['text_answered'] 		= $this->language->get('text_answered');
		$this->data['text_not_answered'] 	= $this->language->get('text_not_answered');

		$this->data['column_no'] 			= $this->language->get('column_no');
		$this->data['column_store'] 		= $this->language->get('column_store');
		$this->data['column_1st_category'] 	= $this->language->get('column_1st_category');
		$this->data['column_2nd_category'] 	= $this->language->get('column_2nd_category');
		$this->data['column_customer'] 		= $this->language->get('column_customer');
		$this->data['column_reference'] 	= $this->language->get('column_reference');
		$this->data['column_customer_support_status'] 	= $this->language->get('column_customer_support_status');
		$this->data['column_subject'] 		= $this->language->get('column_subject');
		$this->data['column_enquiry'] 		= $this->language->get('column_enquiry');
		$this->data['column_answer'] 		= $this->language->get('column_answer');
		$this->data['column_date_added'] 	= $this->language->get('column_date_added');
		$this->data['column_date_answer'] 	= $this->language->get('column_date_answer');
		$this->data['column_action'] 		= $this->language->get('column_action');		
		
		$this->data['button_delete'] 		= $this->language->get('button_delete');
		$this->data['button_filter']		= $this->language->get('button_filter');
		$this->data['button_manage_category'] = $this->language->get('button_manage_category');
 
		$this->data['manage_category'] = $this->url->link('catalog/customer_support_category', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['list_customer_support_status']		= $this->customer_support_status;
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['token'] = $this->session->data['token'];
		
		$pagination 			= new Pagination();
		$pagination->total 		= $customer_support_total;
		$pagination->page 		= $page;
		$pagination->limit 		= $this->config->get('config_admin_limit');
		$pagination->text 		= $this->language->get('text_pagination');
		$pagination->url 		= $this->url->link('catalog/customer_support', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/customer_support_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	public function update() {
		$this->load->language('catalog/customer_support');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/customer_support');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$parent_customer_support = $this->model_catalog_customer_support->getCustomerSupport($this->request->post['customer_support_id']);
			
			$customer_support_threads = isset($this->request->post['thread_customer_support_id']) ? $this->request->post['thread_customer_support_id'] : array();
			
			if(!empty($customer_support_threads))
			{
				$customer_support_enquiries =  isset($this->request->post['thread_enquiry']) ? $this->request->post['thread_enquiry'] : array();
				foreach($customer_support_threads as $key => $thread_id)
				{
					$tmp_customer_support = $this->model_catalog_customer_support->getCustomerSupport($thread_id);
					$tmp_customer_support['enquiry'] = $customer_support_enquiries[$key];
					$this->model_catalog_customer_support->editCustomerSupport($thread_id, $tmp_customer_support);
				}
			}
			
			if($this->request->post['answer'] != '')
			{
				$tmp_customer_support = array(
					  'customer_support_topic_id'			=>	$parent_customer_support['customer_support_id']
					, 'store_id'							=>	$parent_customer_support['store_id']
					, 'customer_id'							=>	0
					, 'reference'							=>	$parent_customer_support['reference']
					, 'customer_support_status'				=>	$this->request->post['customer_support_status']
					, 'subject'								=>	"RE: ".$parent_customer_support['subject']
					, 'enquiry'								=>	$this->request->post['answer']
					, 'date_added'							=>	date("Y/m/d H:i:s")
					, 'customer_support_1st_category_id'	=>	$parent_customer_support['customer_support_1st_category_id']
					, 'customer_support_2nd_category_id'	=>	$parent_customer_support['customer_support_2nd_category_id']
					, 'notify_customer'						=>	isset($this->request->post['notify_customer']) ? $this->request->post['notify_customer'] : ''
				);
				$this->model_catalog_customer_support->addCustomerSupport($tmp_customer_support);
			}
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
						
			$this->redirect($this->url->link('catalog/customer_support', 'token=' . $this->session->data['token']. $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() { 
		$this->load->language('catalog/customer_support');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/customer_support');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $customer_support_id) {
				$this->model_catalog_customer_support->deleteCustomerSupport($customer_support_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
						
			$this->redirect($this->url->link('catalog/customer_support', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}
	
	private function getForm() {
		$this->data['heading_title'] 				= $this->language->get('heading_title');

		$this->data['text_answered'] 				= $this->language->get('text_answered');
		$this->data['text_notify_customer'] 		= $this->language->get('text_notify_customer');
		$this->data['entry_no'] 					= $this->language->get('entry_no');
		$this->data['entry_store'] 					= $this->language->get('entry_store');
		$this->data['entry_1st_category'] 			= $this->language->get('entry_1st_category');
		$this->data['entry_2nd_category'] 			= $this->language->get('entry_2nd_category');
		$this->data['entry_reference'] 				= $this->language->get('entry_reference');
		$this->data['entry_customer_support_status'] = $this->language->get('entry_customer_support_status');
		$this->data['entry_customer'] 				= $this->language->get('entry_customer');
		$this->data['entry_subject'] 				= $this->language->get('entry_subject');
		$this->data['entry_enquiry'] 				= $this->language->get('entry_enquiry');
		$this->data['entry_answer'] 				= $this->language->get('entry_answer');
		$this->data['entry_date_added'] 			= $this->language->get('entry_date_added');

		$this->data['button_save'] 					= $this->language->get('button_save');
		$this->data['button_cancel'] 				= $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
 		
		if (isset($this->error['answer'])) {
			$this->data['error_answer'] = $this->error['answer'];
		} else {
			$this->data['error_answer'] = '';
		}

		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'href'		=> $this->url->link('catalog/customer_support', 'token=' . $this->session->data['token'] . $url, 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
										
		if (!isset($this->request->get['customer_support_id'])) { 
			die;
		} else {
			$this->data['action'] = $this->url->link('catalog/customer_support/update', 'token=' . $this->session->data['token'] . '&customer_support_id=' . $this->request->get['customer_support_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/customer_support', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['customer_support_id'])) 
		{
			$customer_support_info = $this->model_catalog_customer_support->getCustomerSupport($this->request->get['customer_support_id']);
		}
		
				
		$this->data['customer_support_id'] 				= $customer_support_info['customer_support_id'];
		$this->data['customer_support_topic_id'] 		= $customer_support_info['customer_support_topic_id'];
		$this->data['store_id'] 						= $customer_support_info['store_id'];
		$this->data['store_name'] 						= $customer_support_info['store_name'] ? $customer_support_info['store_name'] : $this->config->get('config_name');
		$this->data['customer_support_1st_category']	= $customer_support_info['customer_support_1st_category'];
		$this->data['customer_support_2nd_category']	= $customer_support_info['customer_support_2nd_category'];
		$this->data['customer_id'] 						= $customer_support_info['customer_id'];
		$this->data['reference'] 						= $customer_support_info['reference'];
		$this->data['customer_support_status'] 			= $customer_support_info['customer_support_status'];
		$this->data['firstname'] 						= $customer_support_info['firstname'];
		$this->data['lastname'] 						= $customer_support_info['lastname'];
		$this->data['subject'] 							= $customer_support_info['subject'];
		$this->data['enquiry'] 							= $customer_support_info['enquiry'];
		$this->data['date_added'] 						= $customer_support_info['date_added'];
		$this->data['status'] 							= $customer_support_info['status'];
		$this->data['customer_support_status']			= $customer_support_info['customer_support_status'];
		
		$this->data['list_customer_support_status']		= $this->customer_support_status;
		if (isset($this->request->post['answer'])) {
			$this->data['answer'] = $this->request->post['answer'];
		} else {
			$this->data['answer'] = '';
		}
		
		$search_options = array(
			  'customer_support_topic_id' => $customer_support_info['customer_support_topic_id']
			, 'except_topics'	=>	true
			, 'order'			=>	'ASC'
		);
		$this->data['threads'] = $this->model_catalog_customer_support->getCustomerSupports($search_options);
		
		$this->template = 'catalog/customer_support_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/customer_support')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/customer_support')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

}
?>