<?php  
class ControllerModulencategory extends Controller {
	protected function index() {
		$this->language->load('module/ncategory');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['heading_ncat'] = $this->language->get('heading_ncat');
		
		$this->data['button_headlines'] = $this->language->get('button_headlines');
		
		$this->data['button_search'] = $this->language->get('button_search');
		
		$this->data['head_search'] = $this->language->get('head_search');
		
		$this->data['artkey'] = $this->language->get('artkey');
		
		$this->data['headlines'] = $this->url->link('news/headlines');
		
		if (isset($this->request->get['filter_artname'])) {
			$this->data['filter_name'] = $this->request->get['filter_artname'];
		} else {
			$this->data['filter_name'] = '';
		}
		
		if (isset($this->request->get['ncat'])) {
			$parts = explode('_', (string)$this->request->get['ncat']);
		} else {
			$parts = array();
		}
		
		if (isset($parts[0])) {
			$this->data['ncategory_id'] = $parts[0];
		} else {
			$this->data['ncategory_id'] = 0;
		}
		
		if (isset($parts[1])) {
			$this->data['child_id'] = $parts[1];
		} else {
			$this->data['child_id'] = 0;
		}
							
		$this->load->model('catalog/ncategory');
		
		$this->data['ncategories'] = array();
					
		$ncategories = $this->model_catalog_ncategory->getncategories(0);
		
		foreach ($ncategories as $ncategory) {
			$children_data = array();
			
			$children = $this->model_catalog_ncategory->getncategories($ncategory['ncategory_id']);
			
			foreach ($children as $child) {
				$data = array(
					'filter_ncategory_id'  => $child['ncategory_id'],
					'filter_sub_ncategory' => true
				);		
				
							
				$children_data[] = array(
					'ncategory_id' => $child['ncategory_id'],
					'name'        => $child['name'],
					'href'        => $this->url->link('news/ncategory', 'ncat=' . $ncategory['ncategory_id'] . '_' . $child['ncategory_id'])	
				);					
			}
			
			$data = array(
				'filter_ncategory_id'  => $ncategory['ncategory_id'],
				'filter_sub_ncategory' => true	
			);		
						
			$this->data['ncategories'][] = array(
				'ncategory_id' => $ncategory['ncategory_id'],
				'name'        => $ncategory['name'],
				'children'    => $children_data,
				'href'        => $this->url->link('news/ncategory', 'ncat=' . $ncategory['ncategory_id'])	
			);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ncategory.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/ncategory.tpl';
		} else {
			$this->template = 'default/template/module/ncategory.tpl';
		}
		
		$this->render();
  	}
}
?>