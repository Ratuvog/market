<?php
class ControllerNewsArticle extends Controller {
	public function index() {
		$this->load->language('news/article');
		
		$this->load->model('catalog/news');
		
		$this->load->model('catalog/ncomments');
		
		$this->load->model('tool/image');
		
		$this->data['breadcrumbs'] = array();
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);
			$this->load->model('catalog/ncategory');	
		
		if (isset($this->request->get['ncat'])) {
			$ncat = '';
				
			foreach (explode('_', $this->request->get['ncat']) as $ncat_id) {
				if (!$ncat) {
					$ncat = $ncat_id;
				} else {
					$ncat .= '_' . $ncat_id;
				}
				
				$ncategory_info = $this->model_catalog_ncategory->getncategory($ncat_id);
				
				if ($ncategory_info) {
					$this->data['breadcrumbs'][] = array(
						'text'      => $ncategory_info['name'],
						'href'      => $this->url->link('news/ncategory', 'ncat=' . $ncat),
						'separator' => $this->language->get('text_separator')
					);
				}
			}
		} else {
		$this->data['breadcrumbs'][] = array(
						'text'      => $this->language->get('button_news'),
						'href'      => $this->url->link('news/headlines'),
						'separator' => $this->language->get('text_separator')
		);
			
		}
		
		if (isset($this->request->get['news_id'])) {
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_review'] = $this->language->get('entry_comment');
		$this->data['entry_captcha'] = $this->language->get('entry_captcha');
		$this->data['text_note'] = $this->language->get('text_note');
		$this->data['nocomment'] = $this->language->get('nocomment');
		$this->data['writec'] = $this->language->get('writec');
		$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_send'] = $this->language->get('bsend');
		$this->data['title_comments'] = sprintf($this->model_catalog_ncomments->getTotalNcommentsByNewsId($this->request->get['news_id']));
		$this->data['text_coms'] = $this->language->get('title_comments');
		$this->data['item_comments'] = $this->language->get('item_comments');
		
		$this->data['news_id'] = $this->request->get['news_id'];
			
			$news_info = $this->model_catalog_news->getNewsStory($this->request->get['news_id']);
			
			if ($news_info) {
				if ($news_info['seo_title']) {
				$this->document->setTitle($news_info['seo_title']);
				} else {
					$this->document->setTitle($news_info['title']);
				}
				$this->document->setDescription($news_info['meta_desc']);
				$this->document->setKeywords($news_info['meta_key']);
				
				$this->data['breadcrumbs'][] = array(
					'text'      => $news_info['title'],
					'href'      => $this->url->link('news/article', 'news_id=' .  $this->request->get['news_id']),      		
					'separator' => $this->language->get('text_separator')
      		    );	
			
				$this->data['news_info'] = $news_info;
				
				$this->data['seo_h1'] = $news_info['seo_h1'];
				
				$this->data['heading_title'] = $news_info['title'];
				
				$this->data['acom'] = $news_info['acom'];
				
				$this->data['description'] = html_entity_decode($news_info['description']);
				
				$this->data['date_added'] = date($this->language->get('date_format_short'), strtotime($news_info['date_added']));
				
				$this->data['button_news'] = $this->language->get('button_news');
				
				$this->data['button_cart'] = $this->language->get('button_cart');
				
				$this->data['news_prelated'] = $this->language->get('news_prelated');
				
		    $this->data['products'] = array();
			
			$results = $this->model_catalog_news->getProductRelated($this->request->get['news_id']);
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				} else {
					$image = false;
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
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
							
				$this->data['products'][] = array(
					'product_id' => $result['product_id'],
					'thumb'   	 => $image,
					'name'    	 => $result['name'],
					'price'   	 => $price,
					'special' 	 => $special,
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				);
			}	
			if ($this->config->get('config_bnews_thumb_width')) {
            $bwidth = $this->config->get('config_bnews_thumb_width');
			} else {
			$bwidth = 150;
			}
			
			if ($this->config->get('config_bnews_thumb_height')) {
            $bheight = $this->config->get('config_bnews_thumb_height');
			} else {
			$bheight = 150;
			}
				
				if ($news_info['image']) {
				$this->data['thumb'] = $this->model_tool_image->resize($news_info['image'], $bwidth, $bheight);
				$this->data['popup'] = $this->model_tool_image->resize($news_info['image'], 600, 600);
			   } else {
				$this->data['thumb'] = '';
				$this->data['popup'] = '';
			   }
				
				$this->data['news'] = $this->url->link('news/headlines');
				if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}
				
				$this->data['comment'] = array();
		
		        $comment_total = $this->model_catalog_ncomments->getTotalNcommentsByNewsId($this->request->get['news_id']);
			
		        $results = $this->model_catalog_ncomments->getCommentsByNewsId($this->request->get['news_id'], ($page - 1) * 10, 10);
      		
		        foreach ($results as $result) {
        	    $this->data['comment'][] = array(
        		'author'     => $result['author'],
				'text'       => strip_tags($result['text']),
        		'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	     );
				}
                $pagination = new Pagination();
		        $pagination->total = $comment_total;
		        $pagination->page = $page;
		        $pagination->limit = 10; 
		        $pagination->text = $this->language->get('text_pagination');
		        $pagination->url = $this->url->link('news/article', 'news_id=' . $this->request->get['news_id'] . '&page={page}');
			    $this->data['pagination'] = $pagination->render();
				
				
				
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/article.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/news/article.tpl';
				} else {
					$this->template = 'default/template/news/article.tpl';
				}
				
				$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
			
				$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));

			} else {
				$this->document->setTitle = $this->language->get('text_error');
				
				$this->data['breadcrumbs'][] = array(
        		'text'      => $news_info['title'],
				'href'      => $this->url->link('news/article', 'news_id=' .  $this->request->get['news_id']),      		
        		'separator' => $this->language->get('text_separator')
      		);	
			
				$this->data['heading_title'] = $this->language->get('text_error');
				
				$this->data['text_error'] = $this->language->get('text_error');
				
				$this->data['button_continue'] = $this->language->get('button_continue');
				
				$this->data['continue'] = $this->url->link('common/home');
				
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
				} else {
					$this->template = 'default/template/error/not_found.tpl';
				}
					
				$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);

				$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
			}
		
		}
	}
	public function writecomment() {
		$this->load->language('news/article');
		
		$this->load->model('catalog/ncomments');
		
		$json = array();
		
		if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 25)) {
			$json['error'] = $this->language->get('error_name');
		}
		
		if ((strlen(utf8_decode($this->request->post['text'])) < 25) || (strlen(utf8_decode($this->request->post['text'])) > 1000)) {
			$json['error'] = $this->language->get('error_text');
		}

		if (!isset($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
			$json['error'] = $this->language->get('error_captcha');
		}
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
			$this->model_catalog_ncomments->addComment($this->request->get['news_id'], $this->request->post);
			
			$json['success'] = $this->language->get('text_success');
		}
	
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}

}
?>
