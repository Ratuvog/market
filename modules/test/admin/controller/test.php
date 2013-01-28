<?php  
class ControllerModuletest extends Controller {
	public function index() {
	
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->template = 'module/test.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
		//$this->response->setOutput($this->render());
	}
}
?>