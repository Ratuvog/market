<?php  
class ControllerModuleCategorySuperfish extends Controller {
	protected $category_id = 0;
	protected $parent_id = 0;
	protected $path = array();
	
	protected function index() {
		$this->language->load('module/category_superfish');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('catalog/category');
		
		if (isset($this->request->get['path'])) {
			$this->path = explode('_', $this->request->get['path']);
			
			$this->category_id = end($this->path);
		}
		
		$this->data['category_superfish'] = $this->getCategories(0);
												
		$this->id = 'category_superfish';
		
		$this->data['superfish_path'] = $this->config->get('config_url') . '/catalog/view/javascript/jquery';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category_superfish.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/category_superfish.tpl';
		} else {
			$this->template = 'default/template/module/category_superfish.tpl';
		}
		
		$this->render();
  	}
	
	protected function getCategories($parent_id, $current_path = '') {
		$category_id = array_shift($this->path);
		$this->getParent($category_id);
		
		$output = '';
		
		$results = $this->model_catalog_category->getCategories($parent_id);
		if($results && $parent_id>0 && $parent_id != $this->parent_id) $output .= '<ul>'; 		
		foreach ($results as $result) {	
			if (!$current_path) {
				$new_path = $result['category_id'];
			} else {
				$new_path = $current_path . '_' . $result['category_id'];
			}
			
			$output .= '<li>';
			
			$children = '';
			
			$children = $this->getCategories($result['category_id'], $new_path);
						
			if($parent_id==0) $output .= '<a href="' . $this->url->link('product/category','path=' . $new_path)  . '">' . $result['name'] . '</a>';
			elseif($parent_id != $this->parent_id) $output .= '<a href="' . $this->url->link('product/category','path=' .  $new_path)  . '">' . $result['name'] . '</a>';
			else $output .= '<a href="' . $this->url->link('product/category','path=' .  $new_path)  . '">»&nbsp;&nbsp;&nbsp;&nbsp;' . $result['name'] . '</a>';
			
        	$output .= $children;
        
        	$output .= '</li>'; 
		}
 		if($results && $parent_id>0 && $parent_id != $this->parent_id) $output .= '</ul>'; 
		return $output;
	}	
	protected function getParent($category_id)
	{
		if($category_id <=0) return false;
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
		
		if($query->row['parent_id']==0) $this->parent_id = $category_id;
		else $this->getParent($query->row['parent_id']);
	}
}
?>