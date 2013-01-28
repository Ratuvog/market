<?php  
class ControllerModuletest extends Controller {
	public function index() {
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/test.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/test.tpl';
		} else {
			$this->template = 'default/template/module/test.tpl';
		}
		die('123');
		$this->render();
		//$this->response->setOutput($this->render());
	}
}
?>