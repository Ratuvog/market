<?php
class ControllerModuleNews extends Controller {
	protected function index($setting) {
		$this->load->language('module/news');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
    	$this->data['text_read_more'] = $this->language->get('text_read_more');
		
		$this->data['text_headlines'] = $this->language->get('text_headlines');
		
		$this->data['text_comments'] = $this->language->get('text_comments');
		
		$this->load->model('catalog/news');
		
		$this->load->model('catalog/ncomments');
		
		$this->data['newslink'] = $this->url->link('news/headlines');
		
		$this->data['news'] = array();
		
		$results = $this->model_catalog_news->getNewsTop5($setting['news_limit']);
		
		foreach ($results as $result) {
			
			$short_description2_symbols = $this->config->get('config_mod_news_side');
				$descr_plaintexts = strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'));
			if( mb_strlen($descr_plaintexts, 'UTF-8') > $short_description2_symbols ) {
				$descr_plaintexts = mb_substr($descr_plaintexts, 0, $short_description2_symbols, 'UTF-8') . '&nbsp;&hellip;';
			}
			
			$short_description_symbols = $this->config->get('config_mod_news');
				$descr_plaintext = strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'));
			if( mb_strlen($descr_plaintext, 'UTF-8') > $short_description_symbols ) {
				$descr_plaintext = mb_substr($descr_plaintext, 0, $short_description_symbols, 'UTF-8') . '&nbsp;&hellip;';
			}
		
     		$this->data['news'][] = array(
			    'title' => $result['title'],
				'acom' => $result['acom'],
				'short_description' => $descr_plaintexts,
				'short_description2' => $descr_plaintext,
				'total_comments' => $this->model_catalog_ncomments->getTotalNcommentsByNewsId($result['news_id']),
				'href'  => $this->url->link('news/article', 'news_id=' . $result['news_id'])
				
     		);
    	}
		
	
	$this->id = 'news';
		
		if ($setting['position'] == 'column_left') {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/news_side.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/news_side.tpl';
			} else {
				$this->template = 'default/template/module/news_side.tpl';
			}
		} else {
		if ($setting['position'] == 'column_right') {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/news_side.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/news_side.tpl';
			} else {
				$this->template = 'default/template/module/news_side.tpl';
			}
		} else {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/news.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/news.tpl';
			} else {
				$this->template = 'default/template/module/news.tpl';
			}
		}
		}
		$this->render(); 
	
	}
}
?>
