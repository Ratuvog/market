<?php
class ControllerCatalogFilter extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/filter');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/filter');
    $this->data['language_id'] = $this->config->get('config_language_id');
		$this->getList();
	}

	public function insert() {
		$this->load->language('catalog/filter');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/filter');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		  $this->model_catalog_filter->addOption($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect(HTTPS_SERVER . 'index.php?route=catalog/filter&token=' . $this->session->data['token']);
		}
		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/filter');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/filter');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_filter->editOption($this->request->get['option_id'], $this->request->post);
 			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect(HTTPS_SERVER . 'index.php?route=catalog/filter&token=' . $this->session->data['token']);
		}
		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/filter');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/filter');
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $option_id) {
				$this->model_catalog_filter->deleteOption($option_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect(HTTPS_SERVER . 'index.php?route=catalog/filter&token=' . $this->session->data['token']);
		}
		$this->getList();
	}

	private function getList() {

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/filter', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=catalog/filter/insert&token=' . $this->session->data['token'];
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=catalog/filter/delete&token=' . $this->session->data['token'];

    $this->data['options'] = array();

		$results = $this->model_catalog_filter->getOptions();

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=catalog/filter/update&token=' . $this->session->data['token'] . '&option_id=' . $result['option_id']
			);

			$this->data['options'][] = array(
				'option_id'     => $result['option_id'],
				'name'          => $result['name'],
				'categories'    => $result['categories'],
				'sort_order'    => $result['sort_order'],
				'selected'      => isset($this->request->post['selected']) && in_array($result['option_id'], $this->request->post['selected']),
        'values'        => $result['values'],
        'status'        => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
        'action'        => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_categories'] = $this->language->get('column_categories');
		$this->data['column_values'] = $this->language->get('column_values');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

    $this->data['button_fast_edit'] = $this->language->get('button_fast_edit');
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

		$this->template = 'catalog/filter_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function getForm() {
		$this->document->setTitle($this->language->get('heading_title'));
        $this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_delete'] = $this->language->get('text_delete');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_add_value'] = $this->language->get('text_add_value');
		$this->data['text_value'] = $this->language->get('text_value');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_values'] = $this->language->get('entry_values');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['text_select_all'] = $this->language->get('text_select_all');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

    $this->data['tab_general'] = $this->language->get('tab_general');
    $this->data['tab_data'] = $this->language->get('tab_data');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}


		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/filter', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		if (!isset($this->request->get['option_id'])) {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=catalog/filter/insert&token=' . $this->session->data['token'];
		} else {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=catalog/filter/update&token=' . $this->session->data['token'] . '&option_id=' . $this->request->get['option_id'];
		}

		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=catalog/filter&token=' . $this->session->data['token'];

		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();


    if (isset($this->request->get['option_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      $option_info = $this->model_catalog_filter->getOption($this->request->get['option_id']);
    }

    if (isset($this->request->post['name'])) {
      $this->data['name'] = $this->request->post['name'];
    } elseif (isset($option_info)) {
      $this->data['name'] = $this->model_catalog_filter->getOptionDescriptions($option_info['option_id']);
    } else {
      $this->data['name'] = array();
    }

    if (isset($this->request->post['option_values'])) {
      $this->data['option_values'] = $this->request->post['option_values'];
    } elseif (isset($option_info)) {
      $this->data['option_values'] = $this->model_catalog_filter->getOptionValues($this->request->get['option_id']);
    } else {
      $this->data['option_values'] = array();
    }

    if (isset($this->request->post['sort_order'])) {
      $this->data['sort_order'] = $this->request->post['sort_order'];
    } elseif (isset($option_info)) {
      $this->data['sort_order'] = $option_info['sort_order'];
    } else {
      $this->data['sort_order'] = 0;
    }

    if (isset($this->request->post['status'])) {
      $this->data['status'] = $this->request->post['status'];
    } elseif (isset($option_info)) {
      $this->data['status'] = $option_info['status'];
    } else {
      $this->data['status'] = 1;
    }

    $this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		$this->data['last_inserted_id'] = $this->model_catalog_filter->getLastInsertedId();

    if (isset($this->request->post['option_categories'])) {
      $this->data['option_categories'] = $this->request->post['option_categories'];
    } elseif (isset($option_info)) {
      $this->data['option_categories'] = $this->model_catalog_filter->getOptionCategories($this->request->get['option_id']);
    } else {
      $this->data['option_categories'] = array();
    }

		$this->template = 'catalog/filter_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	public function get() {

		$this->load->model('catalog/filter');
		$this->load->model('catalog/product');

    $category_options = array();

    $html = '';

    if (isset($this->request->get['path']) && $this->request->get['path'] != '') {
			$parts = explode('_', $this->request->get['path']);

		  $results = $this->model_catalog_filter->getOptionByCategoriesId($parts);
			if ($results) {
			  foreach($results as $option) {
          $category_options[] = array(
            'option_id' => $option['option_id'],
            'name' => $option['name'],
            'category_option_values' => $this->model_catalog_filter->getOptionValues($option['option_id'])
          );
        }
      } else {
        $html .= 'Этой категории товаров не присвоен ниодин фильтр';
      }
		} else {
      $html .= 'Сначала выберите категорию товаров';
    }

    if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$product_id = 0;
		}

		$product_info = $this->model_catalog_product->getProductValues($product_id);

		if (isset($this->request->post['product_to_value_id'])) {
			$product_to_value_id = $this->request->post['product_to_value_id'];
		} elseif (isset($product_info)) {
			$product_to_value_id = $this->model_catalog_product->getProductValues($product_id);
		} else {
			$product_to_value_id = array();
		}

    $language_id = $this->config->get('config_language_id');

		if ($category_options) {

      $html .= '<table class="form">';
      foreach ($category_options as $option) {
        $html .= '<tr>';
          $html .= '<td width="20%"><b>' . $option['name'] . '</b></td>';
          $html .= '<td width="80%">';
          if ($option['category_option_values']) {
            $html .= '<select name="product_to_value_id[' . $option['option_id'] . ']">';
            $html .= '<option value="">Не выбрано</option>';
            foreach ($option['category_option_values'] as $value) {
              if (in_array($value['value_id'], $product_to_value_id)) {
                $html .= '<option value="' . $value['value_id'] . '" selected="selected">' . $value['language'][$language_id]['name'] . '</option>';
              } else {
                $html .= '<option value="' . $value['value_id'] . '">' . $value['language'][$language_id]['name'] . '</option>';
              }
            }
            $html .= '</select>';
          }
          $html .= '</td>';
        $html .= '</tr>';
      }
      $html .= '</table>';
    }
		$this->response->setOutput($html, $this->config->get('config_compression'));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/filter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return TRUE;
		} else {
			if (!isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_required_data');
			}
			return FALSE;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/filter')) {
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