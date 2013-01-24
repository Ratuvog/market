<?php
class ControllerCommonNewspanel extends Controller {

	public function index() {
		$this->load->language('common/newspanel');
		
		$this->load->model('catalog/ncomments');
		
		$this->load->model('catalog/news');
		
		$this->data['nmod'] = $this->url->link('module/news', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['ncmod'] = $this->url->link('module/ncategory', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['npages'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['ncategory'] = $this->url->link('catalog/ncategory', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['tocomments'] = $this->url->link('catalog/ncomments', 'token=' . $this->session->data['token'], 'SSL');	
		$this->data['total_coments'] = $this->model_catalog_ncomments->getTotalComments(); 
		$this->data['total_comments_approval'] = $this->model_catalog_ncomments->getTotalCommentsAwaitingApproval();
		$this->data['total_articles'] =  $this->model_catalog_news->getTotalNews();
		$this->data['text_articles'] = $this->language->get('text_articles');
		$this->data['text_comtot'] = $this->language->get('text_comtot');
		$this->data['text_tcaa'] = $this->language->get('text_tcaa');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['text_yess'] = $this->language->get('text_bysort');
		$this->data['text_noo'] = $this->language->get('text_latest');
		$this->data['text_commod'] = $this->language->get('text_commod');
		$this->data['text_bnews_image'] = $this->language->get('text_bnews_image');
		$this->data['text_bnews_thumb'] = $this->language->get('text_bnews_thumb');
		$this->data['text_bnews_order'] = $this->language->get('text_bnews_order');
		$this->data['text_bsettings'] = $this->language->get('text_bsettings');
		$this->data['text_bwidth'] = $this->language->get('text_bwidth');
		$this->data['text_bheight'] = $this->language->get('text_bheight');
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['heading_news_button'] = $this->language->get('heading_news_button');
		$this->data['entry_npages'] = $this->language->get('entry_npages');
		$this->data['entry_nsettings'] = $this->language->get('entry_nsettings');
		$this->data['entry_nmod'] = $this->language->get('entry_nmod');
		$this->data['entry_ncmod'] = $this->language->get('entry_ncmod');
		$this->data['entry_ncategory'] = $this->language->get('entry_ncategory');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_status'] = $this->language->get('column_status');
		
		$this->template = 'common/newspanel.tpl';
		
		$this->render();
	}
}
?>