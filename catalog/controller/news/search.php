<?php 
class ControllerNewsSearch extends Controller { 	
	public function index() { 
    	$this->language->load('news/search');
		
		$this->load->model('catalog/ncategory');
		
		$this->load->model('catalog/news');
		
		$this->load->model('tool/image'); 
	
		$this->load->model('catalog/ncomments');
		
		if (isset($this->request->get['filter_artname'])) {
			$filter_name = $this->request->get['filter_artname'];
		} else {
			$filter_name = '';
		} 
				
		if (isset($this->request->get['filter_description'])) {
			$filter_description = $this->request->get['filter_description'];
		} else {
			$filter_description = '';
		} 
				
		if (isset($this->request->get['filter_category_id'])) {
			$filter_category_id = $this->request->get['filter_category_id'];
		} else {
			$filter_category_id = 0;
		} 
		
		if (isset($this->request->get['filter_sub_category'])) {
			$filter_sub_category = $this->request->get['filter_sub_category'];
		} else {
			$filter_sub_category = '';
		}
  		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$limit = $this->config->get('config_catalog_limit');
		
		
		if (isset($this->request->get['keyword'])) {
			$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->request->get['keyword']);
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array( 
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
      		'separator' => false
   		);
		
		$url = '';
		
		if (isset($this->request->get['filter_artname'])) {
			$url .= '&filter_artname=' . $this->request->get['filter_artname'];
		}
				
		if (isset($this->request->get['filter_description'])) {
			$url .= '&filter_description=' . $this->request->get['filter_description'];
		}
				
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
		
		if (isset($this->request->get['filter_sub_category'])) {
			$url .= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
		}
				
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}	
						
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('news/search', $url),
      		'separator' => $this->language->get('text_separator')
   		);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_empty'] = $this->language->get('text_empty');
    	$this->data['text_critea'] = $this->language->get('text_critea');
    	$this->data['text_search'] = $this->language->get('text_search');
		$this->data['text_keyword'] = $this->language->get('text_keyword');
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_sub_category'] = $this->language->get('text_sub_category');
		$this->data['text_comments'] = $this->language->get('text_comments');	
		$this->data['button_more'] = $this->language->get('button_more');
		$this->data['entry_search'] = $this->language->get('entry_search');
    	$this->data['entry_description'] = $this->language->get('entry_description');
		  
    	$this->data['button_search'] = $this->language->get('button_search');
		
		$this->load->model('catalog/ncategory');
		
		// 3 Level Category Search
		$this->data['categories'] = array();
					
		$categories_1 = $this->model_catalog_ncategory->getncategories(0);
		
		foreach ($categories_1 as $category_1) {
			$level_2_data = array();
			
			$categories_2 = $this->model_catalog_ncategory->getncategories($category_1['ncategory_id']);
			
			foreach ($categories_2 as $category_2) {
				$level_3_data = array();
				
				$categories_3 = $this->model_catalog_ncategory->getncategories($category_2['ncategory_id']);
				
				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'category_id' => $category_3['ncategory_id'],
						'name'        => $category_3['name'],
					);
				}
				
				$level_2_data[] = array(
					'category_id' => $category_2['ncategory_id'],	
					'name'        => $category_2['name'],
					'children'    => $level_3_data
				);					
			}
			
			$this->data['categories'][] = array(
				'category_id' => $category_1['ncategory_id'],
				'name'        => $category_1['name'],
				'children'    => $level_2_data
			);
		}
		
		$this->data['article'] = array();
		
		if (isset($this->request->get['filter_artname'])) {
			$data = array(
				'filter_name'         => $filter_name,
				'filter_description'  => $filter_description,
				'filter_ncategory_id'  => $filter_category_id, 
				'filter_sub_ncategory' => $filter_sub_category, 
				'start'               => ($page - 1) * $limit,
				'limit'               => $limit
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
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $bwidth, $bheight);
				} else {
					$image = false;
				}
				
				$description_symbols = $this->config->get('config_symbols_nsearch');
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
					'href'        => $this->url->link('news/article', '&news_id=' . $result['news_id'])
				);
			}
					
			$url = '';
			
			if (isset($this->request->get['filter_artname'])) {
				$url .= '&filter_artname=' . $this->request->get['filter_artname'];
			}
			
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
			
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
			}
			
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
			}
					
			$pagination = new Pagination();
			$pagination->total = $news_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('news/search', $url . '&page={page}');
			
			$this->data['pagination'] = $pagination->render();
		}	
		
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_description'] = $filter_description;
		$this->data['filter_category_id'] = $filter_category_id;
		$this->data['filter_sub_category'] = $filter_sub_category;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/search.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/news/search.tpl';
		} else {
			$this->template = 'default/template/news/search.tpl';
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