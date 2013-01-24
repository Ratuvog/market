<?php
class ControllerModuleFilter extends Controller {
	protected function index() {
    $this->language->load('module/filter');
    $this->data['heading_title'] = $this->language->get('heading_title');
	
		$this->load->model('catalog/filter');
		//$this->load->model('tool/seo_url');
		$this->load->model('catalog/product');

		$url = '';

    if (isset($this->request->get['sort'])) {
      $url .= '&sort=' . $this->request->get['sort'];
    }

    if (isset($this->request->get['order'])) {
      $url .= '&order=' . $this->request->get['order'];
    }

    if (isset($this->request->get['filter'])) {
      $filter = $this->request->get['filter'];
    } else {
      $filter = 0;
    }

    $this->data['filter_values_id'] = array();
    $options_in_get = array();

    if ($filter) {
      $matches = explode(';', $filter);

      foreach ($matches as $key_value) {
        $data = explode('=', $key_value);
        $options_in_get[] = $data[0];
        foreach (explode(',', $data[1]) as $value_id) {
          $this->data['filter_values_id'][] = $value_id;
        }
      }
    }

    $this->data['category_options'] = array();

    if (isset($this->request->get['path'])) {

			$parts = explode('_', $this->request->get['path']);

               // $products_total = $this->model_catalog_product->getTotalProducts(end($parts), $filter);

       $products_total = $this->model_catalog_product->getTotalProducts(array('filter_category_id'=>end($parts),'filter_sub_category'=>1) , $filter);

		$results = $this->model_catalog_filter->getOptionByCategoriesId($parts);

		if ($results)
		{
		  foreach($results as $option)
		  {

          in_array($option['option_id'], $options_in_get) ? $is_this_opt = true : $is_this_opt = false;

          $values = array();

          $values_results = $this->model_catalog_filter->getOptionValues($option['option_id']);



          foreach ($values_results as $value)
          {
           $filter_params = $this->getFilterURLParams($filter, $value['option_id'], $value['value_id'], 'filter');


           $products = $this->model_catalog_product->getTotalProducts(array('filter_category_id'=>end($parts),'filter_sub_category'=>1) , str_replace('&filter=', '', $filter_params));




            $values[] = array(
              'value_id' => $value['value_id'],
              'name' => $value['name'],
              'option_id' => $value['option_id'],
               'value_id' => $value['value_id'],
              'href'        => $this->url->link('product/category', 'path=' .$this->request->get['path'] . $filter_params . $url),
            //  'href' => $this->model_tool_seo_url->rewrite(HTTPS_SERVER . 'index.php?route=product/category&path=' . $this->request->get['path'] . $filter_params . $url),
              'products' => ($is_this_opt ? ($products ? (($products - $products_total) != 0 ? '+' . ($products - $products_total) : 0) : 0) : $products)
            );
          }

          $this->data['category_options'][] = array(
            'option_id' => $option['option_id'],
            'name' => $option['name'],
            'values' => $values
          );
        }
      }

			$path = $this->request->get['path'];
		} else {
      $path = 0;
    }

    $this->data['path'] = $path;

		$this->id = 'filter';




		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->config->get('filter_style'))) {
			$this->template = $this->config->get('config_template') . '/template/module/' . $this->config->get('filter_style');
		} else {
			$this->template = 'default/template/module/' . $this->config->get('filter_style');
		}

		$this->render();
	}
  // Тут начинается сильнейший программинг - формирование GET запроса на основе уже существующего, курите.

  private function getFilterURLParams($filter = 0, $option_id, $value_id, $variable = '') {
    // При изменении этих параметров, нужно будет поменять соответсвенно их в других файлах. Менять их не советую.

    $sep_par = ';'; // разделитель пар опций -> значений: opt1=val1,val2,val3;opt2=val1,val2,val3 ...
    $sep_opt = '='; // разделитель внутри пары опция -> значения: opt1=val1,val2,val3 ...
    $sep_val = ','; // разделитель для параметров опции: val1,val2,val3 ...

    if ($filter) {

      $matches = explode($sep_par, $filter);

      $options = array();
      $values = array();
      $parts = array();

     foreach ($matches as $option) {
        $data = explode($sep_opt, $option);
        $parts[] = $option;
        $options[] = $data[0];
        $values[] = explode($sep_val, $data[1]);
      }

      if (in_array($option_id, $options)) { // если эта опция уже есть в запросе, то мы не добавляем её

        $key = array_keys($options, $option_id); // вычисляем ключ массива для дальнейшей работы с именно этой опцией

        if (in_array($value_id, $values[$key[0]])) { // если это значение уже есть в запросе
          if (count($values[$key[0]]) == 1) { // и если оно единственное
            if (count($matches) == 1) { // еще и с единственной опцией, то удаляем из запроса весь фильтр
              $out = '';
            } else { // если опция не одна, удаляем только эту опцию с её параметром
              $out = '&' . $variable . '=' . str_replace((array_search($parts[$key[0]], $parts) ? $sep_par . $parts[$key[0]] : $parts[$key[0]] . $sep_par), '', $filter);
            }
          } else { // если значений несколько, удаляем это значение, оставляя другие с опцией
            $out = '&' . $variable . '=' . str_replace($parts[$key[0]], $options[$key[0]] . $sep_opt . str_replace((array_search($value_id, $values[$key[0]]) ? $sep_val . $value_id : $value_id . $sep_val), '', implode($sep_val, $values[$key[0]])), $filter);
          }
        } else { // если значения нет в запросе, то добавляем его к значениям этой опции
          $out = '&' . $variable . '=' . str_replace($parts[$key[0]], $options[$key[0]] . $sep_opt . implode($sep_val, $values[$key[0]]) . (count($values[$key[0]]) ? $sep_val : '') . $value_id, $filter);
        }
      } else { // если этой опции нет в запросе
        $out = '&' . $variable . '=' . $filter . $sep_par . $option_id . $sep_opt . $value_id;
      }
    } else { // если в запросе вообще нет переменной filter
      $out = '&' . $variable . '=' . $option_id . $sep_opt . $value_id;
    }

    return $out; // фух.
  }
}
?>