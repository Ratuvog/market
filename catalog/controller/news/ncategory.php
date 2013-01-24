<?php 
class Controllernewsncategory extends Controller {  
	public function index() { 
		$this->language->load('news/ncategory');
		
		$this->load->model('catalog/ncategory');
		
		$this->load->model('catalog/news');
		
		$this->load->model('tool/image'); 
		
		$this->load->model('catalog/ncomments');
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}	
							
		$limit = $this->config->get('config_catalog_limit');
					
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);	
			
		if (isset($this->request->get['ncat'])) {
			$ncat = '';
		
			$parts = explode('_', (string)$this->request->get['ncat']);
		
			foreach ($parts as $ncat_id) {
				if (!$ncat) {
					$ncat = $ncat_id;
				} else {
					$ncat .= '_' . $ncat_id;
				}
									
				$ncategory_info = $this->model_catalog_ncategory->getncategory($ncat_id);
				
				if ($ncategory_info) {
	       			$this->data['breadcrumbs'][] = array(
   	    				'text'      => $ncategory_info['name'],
						'href'      => $this->url->link('news/ncategory', 'ncat=' . $ncat),
        				'separator' => $this->language->get('text_separator')
        			);
				}
			}		
		
			$ncategory_id = array_pop($parts);
		} else {
			$ncategory_id = 0;
		}
		
		$ncategory_info = $this->model_catalog_ncategory->getncategory($ncategory_id);
	
		if ($ncategory_info) {
	  		if ($ncategory_info['seo_title']) {
		  		$this->document->setTitle($ncategory_info['seo_title']);
			} else {
		  		$this->document->setTitle($ncategory_info['name']);
			}

			$this->document->setDescription($ncategory_info['meta_description']);
			$this->document->setKeywords($ncategory_info['meta_keyword']);
			
			$this->data['seo_h1'] = $ncategory_info['seo_h1'];

			$this->data['heading_title'] = $ncategory_info['name'];
			
			$limit = $ncategory_info['column'];
			$display_image = $ncategory_info['top'];
			$this->data['text_refine'] = $this->language->get('text_refine');
			$this->data['text_empty'] = $this->language->get('text_empty');			
			$this->data['text_limit'] = $this->language->get('text_limit');
			$this->data['text_comments'] = $this->language->get('text_comments');	
			$this->data['button_more'] = $this->language->get('button_more');
			$this->data['button_continue'] = $this->language->get('button_continue');
			$this->data['continue'] = $this->url->link('common/home');
					
			if ($ncategory_info['image']) {
				$this->data['thumb'] = $this->model_tool_image->resize($ncategory_info['image'], $this->config->get('config_image_ncategory_width'), $this->config->get('config_image_ncategory_height'));
			} else {
				$this->data['thumb'] = '';
			}
									
			$this->data['description'] = html_entity_decode($ncategory_info['description'], ENT_QUOTES, 'UTF-8');
			$this->data['compare'] = $this->url->link('product/compare');
			
			$url = '';
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
								
			$this->data['ncategories'] = array();
			
			$results = $this->model_catalog_ncategory->getncategories($ncategory_id);
			
			foreach ($results as $result) {
				$data = array(
					'filter_ncategory_id'  => $result['ncategory_id'],
					'filter_sub_ncategory' => true	
				);
							
		
				
				$this->data['ncategories'][] = array(
					'name'  => $result['name'],
					'href'  => $this->url->link('news/ncategory', 'ncat=' . $this->request->get['ncat'] . '_' . $result['ncategory_id'] . $url)
				);
			}
			
			$this->data['article'] = array();
			
			$data = array(
			    'filter_ncategory_id' => $ncategory_id,
				'start'           => ($page - 1) * $limit,
				'limit'           => $limit 
			);
			
			if ($this->config->get('config_bnews_image_width')) {
            $bwidth = $this->config->get('config_bnews_image_width');
			} else {
			$bwidth = 80;
			}
			
			if ($this->config->get('config_bnews_image_height')) {
            $bheight = $this->config->get('config_bnews_image_height');
			} else {
			$bheight = 80;
			}
			
			$news_total = $this->model_catalog_news->getTotalNews($data);
			$results = $this->model_catalog_news->getNewsLimited($data);
			
			foreach ($results as $result) {
				if ($result['image'] && !$display_image) {
					$image = $this->model_tool_image->resize($result['image'], $bwidth, $bheight);
				} else {
					$image = false;
				}
				
				$description_symbols = $this->config->get('config_symbols_ncategory');
					$descr_plaintext = strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'));
				if( mb_strlen($descr_plaintext, 'UTF-8') > $description_symbols ) {
					$descr_plaintext = mb_substr($descr_plaintext, 0, $description_symbols, 'UTF-8') . '&nbsp;&hellip;';
				}
				
				$this->data['article'][] = array(
					'article_id'  => $result['news_id'],
					'name'        => $result['title'],
					'acom'        => $result['acom'],
					'thumb'       => $image,
					'description' => $descr_plaintext,
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'total_comments' => $this->model_catalog_ncomments->getTotalNcommentsByNewsId($result['news_id']),
					'href'        => $this->url->link('news/article', 'ncat=' . $this->request->get['ncat'] . '&news_id=' . $result['news_id'])
				);
			}
			
			$url = '';
	
			$pagination = new Pagination();
			$pagination->total = $news_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('news/ncategory', 'ncat=' . $this->request->get['ncat'] . $url . '&page={page}');
		
			$this->data['pagination'] = $pagination->render();
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/ncategory.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/news/ncategory.tpl';
			} else {
				$this->template = 'default/template/news/ncategory.tpl';
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
		else {
			$url = '';
			
			if (isset($this->request->get['ncat'])) {
				$url .= '&ncat=' . $this->request->get['ncat'];
			}
				
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('news/ncategory', $url),
				'separator' => $this->language->get('text_separator')
			);
				
			$this->document->setTitle($this->language->get('text_error'));

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
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
}
?>