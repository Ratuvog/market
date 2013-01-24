<?php
class ControllerModuleLatest extends Controller {
	protected function index($setting) {
		$this->language->load('module/latest');
		
      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['button_cart'] = $this->language->get('button_cart');
		
		$this->data['setting'] = $setting;
		
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_model'] = $this->language->get('text_model');
		$this->data['text_reward'] = $this->language->get('text_reward');
		$this->data['text_points'] = $this->language->get('text_points');
		$this->data['text_stock'] = $this->language->get('text_stock');
		$this->data['text_price'] = $this->language->get('text_price');
		$this->data['text_tax'] = $this->language->get('text_tax');
		$this->data['text_or'] = $this->language->get('text_or');
		$this->data['button_wishlist'] = $this->language->get('button_wishlist');
		$this->data['button_compare'] = $this->language->get('button_compare');	
		$this->data['button_detail'] = $this->language->get('button_detail');	
		$this->data['button_quick_view'] = $this->language->get('button_quick_view');
		$this->data['text_rating'] = $this->language->get('text_rating');
		
		$this->data['tab_description'] = $this->language->get('tab_description');
				
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');
		
		$this->document->addScript('catalog/view/javascript/jquery/modal/jquery.reveal.js');
		
		$this->data['products'] = array();
		
		$data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$results = $this->model_catalog_product->getProducts($data);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
			} else {
				$image = false;
			}
			
			if ($result['image']) {
				$popup = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
			} else {
				$popup = false;
			}
					
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
					
			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}
			
			if ($result['quantity'] <= 0) {
				$stock = $result['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$stock = $result['quantity'];
			} else {
				$stock = $this->language->get('text_instock');
			}
			
			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
			} else {
				$tax = false;
			}	
			
			if ($result['minimum']) {
				$minimum = $result['minimum'];
			} else {
				$minimum = 1;
			}

			$text_minimum = sprintf($this->language->get('text_minimum'), $result['minimum']);

			$this->data['products'][] = array(
				'product_id' 	=> $result['product_id'],
				'thumb'   	 	=> $image,
				'popup' 	 	=> $popup,
				'name'    	 	=> $result['name'],
				'model'			=> $result['model'],
				'reward'     	=> $result['reward'],
				'points' 	 	=> $result['points'],
				'description' 	=> html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
				'stock'			=> $stock,
				'minimum'		=> $minimum,
				'text_minimum'	=> $text_minimum,
				'price'   	 	=> $price,
				'special' 	 	=> $special,
				'tax'     		=> $tax,
				'rating'     	=> $rating,
				'reviews'       => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'manufacturer'  => $result['manufacturer'],
				'manufacturers' => $this->url->link('product/manufacturer/product', 'manufacturer_id=' . $result['manufacturer_id']),
				'reviews'    	=> sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 	=> $this->url->link('product/product', 'product_id=' . $result['product_id'])
			);
			
		}
		$this->data['boxgrid-height'] = $this->config->get('image_width');
		$this->data['height'] = 235-($this->config->get('config_image_thumb_height')-228);

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/latest.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/latest.tpl';
		} else {
			$this->template = 'default/template/module/latest.tpl';
		}

		$this->render();
	}
}
?>