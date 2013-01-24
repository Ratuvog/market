<?php 
class ControllernewsHeadlines extends Controller {  
	public function index() { 
		$this->language->load('news/ncategory');
		
		$this->load->model('catalog/ncategory');
		
		$this->load->model('catalog/news');
		
		$this->load->model('tool/image'); 
		
		$this->load->model('catalog/ncomments');
							
		$limit = $this->config->get('config_catalog_limit');
					
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}
		
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);	
		$this->data['breadcrumbs'][] = array(
   	    				'text'      => $this->language->get('heading_title'),
						'href'      => $this->url->link('news/headlines'),
        				'separator' => $this->language->get('text_separator')
        );
		    $this->document->setTitle($this->language->get('heading_title')); 
			$headlines = '';
			$this->data['heading_title'] = $this->language->get('heading_title');
			$this->data['text_empty'] = $this->language->get('text_empty');			
			$this->data['text_limit'] = $this->language->get('text_limit');
			$this->data['text_comments'] = $this->language->get('text_comments');	
			$this->data['button_more'] = $this->language->get('button_more');
			$this->data['button_continue'] = $this->language->get('button_continue');
			$this->data['continue'] = $this->url->link('common/home');
					
			$url = '';
								
			$this->data['article'] = array();
			
			$data = array(
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
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $bwidth, $bheight);
				} else {
					$image = false;
				}
				
				$description_symbols = $this->config->get('config_symbols_headlines');
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
					'href'        => $this->url->link('news/article' . '&news_id=' . $result['news_id'])
				);
			}
			
			$url = '';
	
			$pagination = new Pagination();
			$pagination->total = $news_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('news/headlines' . $url . '&page={page}');
		
			$this->data['pagination'] = $pagination->render();
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/headlines.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/news/headlines.tpl';
			} else {
				$this->template = 'default/template/news/headlines.tpl';
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