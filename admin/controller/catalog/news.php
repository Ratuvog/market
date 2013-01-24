<?php
class ControllerCatalogNews extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/news');
		
		$this->load->model('catalog/ncomments');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/news');
		
		$this->getList();
	}

	public function insert() {
		$this->load->language('catalog/news');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/news');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateForm())) {
			$this->model_catalog_news->addNews($this->request->post);
			
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
			$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			
		}
		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/news');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/news');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateForm())) {
			$this->model_catalog_news->editNews($this->request->get['news_id'], $this->request->post);
			
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
			$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/news');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/news');
		
		if ((isset($this->request->post['delete'])) && ($this->validateDelete())) {
			foreach ($this->request->post['delete'] as $news_id) {
				$this->model_catalog_news->deleteNews($news_id);
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
			$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'nd.title';
		}
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
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
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('catalog/news/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['npages'] = $this->url->link('module/news', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['tocomments'] = $this->url->link('catalog/ncomments', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['delete'] = $this->url->link('catalog/news/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		 
		$this->data['total_coments'] = $this->model_catalog_ncomments->getTotalComments(); 
		
		$this->data['total_comments_approval'] = $this->model_catalog_ncomments->getTotalCommentsAwaitingApproval();
		
		$this->data['total_articles'] =  $this->model_catalog_news->getTotalNews();
		
		$this->data['text_articles'] = $this->language->get('text_articles');
		
		$this->data['text_comtot'] = $this->language->get('text_comtot');
		
		$this->data['text_tcaa'] = $this->language->get('text_tcaa');
		
		$this->data['text_commod'] = $this->language->get('text_commod');
		
		$this->data['news'] = array();
		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * 10,
			'limit' => 10
		);
		$news_total = $this->model_catalog_news->getTotalNews();
		
		$results = $this->model_catalog_news->getNewsLimited($data);
		
    	foreach ($results as $result) {
			$action = array();
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $result['news_id'] . $url, 'SSL')
				          
			);  
			$this->data['news'][] = array(
				'news_id'     => $result['news_id'],
				'title'       => $result['title'],
				'status'		  => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'delete'   => isset($this->request->post['delete']) && in_array($result['news_id'], $this->request->post['delete']),
				'action'      => $action
			);
		}
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['entry_npages'] = $this->language->get('entry_npages');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		
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
		if ($order == 'ASC') {
			$url .= '&order=' .  'DESC';
		} else {
			$url .= '&order=' .  'ASC';
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		
		
		$this->data['sort_title'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . '&sort=nd.title' . $url, 'SSL');
		                            
		$this->data['sort_sort_order'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . '&sort=n.sort_order' . $url, 'SSL');
		                                 
		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		$pagination = new Pagination();
		$pagination->total = $news_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . '&page={page}' . $url, 'SSL');;
		
		
		
		
		$this->data['pagination'] = $pagination->render();
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->template = 'catalog/news_list.tpl';
		$this->children = array(
			'common/header',
			'common/newspanel',	
			'common/footer'	
		);
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');
    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
    	$this->data['text_fullsize'] = $this->language->get('text_fullsize');
    	$this->data['text_thumbnail'] = $this->language->get('text_thumbnail');
		$this->data['text_upload'] = $this->language->get('text_upload');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_meta_desc'] = $this->language->get('entry_meta_desc');
		$this->data['entry_meta_key'] = $this->language->get('entry_meta_key');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_image_size'] = $this->language->get('entry_image_size');
		$this->data['entry_seo_title'] = $this->language->get('entry_seo_title');
		$this->data['entry_seo_h1'] = $this->language->get('entry_seo_h1');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_design'] = $this->language->get('tab_design');
		$this->data['tab_seo'] = $this->language->get('tab_seo');
		$this->data['tab_settings'] = $this->language->get('tab_settings');
		$this->data['tab_image'] = $this->language->get('tab_image');
		$this->data['entry_category'] = $this->language->get('tab_category');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_layout'] = $this->language->get('tab_layout');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['entry_image'] = $this->language->get('entry_image');
    	$this->data['entry_acom'] = $this->language->get('entry_acom');
		$this->data['entry_related'] = $this->language->get('entry_related');
		$this->data['tab_related'] = $this->language->get('tab_related');
		
		$this->data['token'] = $this->session->data['token'];
		
	if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}
		
	 	if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = '';
		}
		$url = '';
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (!isset($this->request->get['news_id'])) {
			$this->data['action'] = $this->url->link('catalog/news/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
			
		} else {
			$this->data['action'] = $this->url->link('catalog/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $this->request->get['news_id'] . $url, 'SSL');
		                  
		}
		$this->data['cancel'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		if ((isset($this->request->get['news_id'])) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$news_info = $this->model_catalog_news->getNewsStory($this->request->get['news_id']);
		}
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['news_description'])) {
			$this->data['news_description'] = $this->request->post['news_description'];
		} elseif (isset($this->request->get['news_id'])) {
			$this->data['news_description'] = $this->model_catalog_news->getNewsDescriptions($this->request->get['news_id']);
		} else {
			$this->data['news_description'] = array();
		}
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($news_info)) {
			$this->data['keyword'] = $news_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		if (isset($this->request->post['acom'])) {
			$this->data['acom'] = $this->request->post['acom'];
		} elseif (isset($news_info)) {
			$this->data['acom'] = $news_info['acom'];
		} else {
			$this->data['acom'] = '';
		}
		if (isset($this->request->post['sort_order'])) {
      		$this->data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (isset($news_info)) {
      		$this->data['sort_order'] = $news_info['sort_order'];
    	} else {
			$this->data['sort_order'] = 1;
		}
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($news_info)) {
			$this->data['image'] = $news_info['image'];
		} else {
			$this->data['image'] = '';
		}
		
		$this->load->model('tool/image');
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		if (!empty($news_info) && $news_info['image'] && file_exists(DIR_IMAGE . $news_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($news_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['news_store'])) {
			$this->data['news_store'] = $this->request->post['news_store'];
		} elseif (isset($this->request->get['news_id'])) {
			$this->data['news_store'] = $this->model_catalog_news->getNewsStores($this->request->get['news_id']);
		} else {
			$this->data['news_store'] = array(0);
		}	
		
		$this->load->model('catalog/ncategory');
				
		$this->data['ncategories'] = $this->model_catalog_ncategory->getncategories(0);
		
		if (isset($this->request->post['news_ncategory'])) {
			$this->data['news_ncategory'] = $this->request->post['news_ncategory'];
		} elseif (isset($this->request->get['news_id'])) {
			$this->data['news_ncategory'] = $this->model_catalog_news->getNewsNcategories($this->request->get['news_id']);
		} else {
			$this->data['news_ncategory'] = array();
		}	
		
		if (isset($this->request->post['news_related'])) {
			$products = $this->request->post['news_related'];
		} elseif (isset($this->request->get['news_id'])) {		
			$products = $this->model_catalog_news->getNewsRelated($this->request->get['news_id']);
		} else {
			$products = array();
		}
	
		$this->data['news_related'] = array();
		$this->load->model('catalog/product');
		foreach ($products as $product_id) {
			$related_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($related_info) {
				$this->data['news_related'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
				);
			}
		}
		
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		}  elseif (isset($news_info)) {
			$this->data['status'] = $news_info['status'];
		} else {
      		$this->data['status'] = '';
    	}
		if (isset($this->request->post['news_layout'])) {
			$this->data['news_layout'] = $this->request->post['news_layout'];
		} elseif (isset($this->request->get['news_id'])) {
			$this->data['news_layout'] = $this->model_catalog_news->getNewsLayouts($this->request->get['news_id']);
		} else {
			$this->data['news_layout'] = array();
		}

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
			
		
		
		$this->template = 'catalog/news_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
 		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/news')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		foreach ($this->request->post['news_description'] as $language_id => $value) {
			if ((strlen($value['title']) < 3) || (strlen($value['title']) >100)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
			if (strlen($value['description']) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}
		}
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/news')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>
