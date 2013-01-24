<?php
class ControllerModuleFeatured extends Controller {
	protected function index($setting) {
		$this->language->load('module/featured'); 

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

		$products = explode(',', $this->config->get('featured_product'));		

		if (empty($setting['limit'])) {
			$setting['limit'] = 5;
		}
		
		$products = array_slice($products, 0, (int)$setting['limit']);
		
		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($product_info['image']) {
				$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
			} else {
				$image = false;
			}
			
			if ($product_info['image']) {
				$popup = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
			} else {
				$popup = false;
			}
					
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
					
			if ((float)$product_info['special']) {
				$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}
			
			if ($this->config->get('config_review_status')) {
				$rating = $product_info['rating'];
			} else {
				$rating = false;
			}
			
			if ($product_info['quantity'] <= 0) {
				$stock = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$stock = $product_info['quantity'];
			} else {
				$stock = $this->language->get('text_instock');
			}
			
			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
			} else {
				$tax = false;
			}	
			
			if ($product_info['minimum']) {
				$minimum = $product_info['minimum'];
			} else {
				$minimum = 1;
			}

			$text_minimum = sprintf($this->language->get('text_minimum'), $product_info['minimum']);

			$this->data['products'][] = array(
				'product_id' 	=> $product_info['product_id'],
				'thumb'   	 	=> $image,
				'popup' 	 	=> $popup,
				'name'    	 	=> $product_info['name'],
				'model'			=> $product_info['model'],
				'reward'     	=> $product_info['reward'],
				'points' 	 	=> $product_info['points'],
				'description' 	=> html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8'),
				'stock'			=> $stock,
				'minimum'		=> $minimum,
				'text_minimum'	=> $text_minimum,
				'price'   	 	=> $price,
				'special' 	 	=> $special,
				'tax'     		=> $tax,
				'rating'     	=> $rating,
				'reviews'       => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
				'manufacturer'  => $product_info['manufacturer'],
				'manufacturers' => $this->url->link('product/manufacturer/product', 'manufacturer_id=' . $product_info['manufacturer_id']),
				'reviews'    	=> sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
				'href'    	 	=> $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
			);
			
		}
		
		$this->data['boxgrid-height'] = $this->config->get('image_width');
		$this->data['height'] = 235-($this->config->get('config_image_thumb_height')-228);

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featured.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/featured.tpl';
		} else {
			$this->template = 'default/template/module/featured.tpl';
		}

		$this->render();
	}
}
?>