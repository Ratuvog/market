<?php
class ModelCatalogNews extends Model {
	public function getNewsStory($news_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id) WHERE n.news_id = '" . (int)$news_id . "'  AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		return $query->row;
	}

	public function getNews($data = array()) {
		$query = "SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id)";
		
		if (!empty($data['filter_ncategory_id'])) {
				$query .= " LEFT JOIN " . DB_PREFIX . "news_to_ncategory n2n ON (n.news_id = n2n.news_id)";			
			}
			
		$query .= " WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 
		
		if (!empty($data['filter_ncategory_id'])) {
				if (!empty($data['filter_sub_ncategory'])) {
					$implode_data = array();
					
					$implode_data[] = "n2n.ncategory_id = '" . (int)$data['filter_category_id'] . "'";
					
					$this->load->model('catalog/ncategory');
					
					$ncategories = $this->model_catalog_ncategory->getncategoriesByParentId($data['filter_ncategory_id']);
										
					foreach ($ncategories as $ncategory_id) {
						$implode_data[] = "n2n.ncategory_id = '" . (int)$ncategory_id . "'";
					}
								
					$query .= " AND (" . implode(' OR ', $implode_data) . ")";			
				} else {
					$query .= " AND n2n.ncategory_id = '" . (int)$data['filter_ncategory_id'] . "'";
				}
			}		
		$sql = $this->db->query($query);	
		return $sql->rows;
	}
	
	public function getNewsTop5($limit) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' ORDER BY n.date_added DESC LIMIT " . (int)$limit);
		return $query->rows;
	}
	
	public function getNewsLimited($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id) ";
		if (!empty($data['filter_ncategory_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "news_to_ncategory n2n ON (n.news_id = n2n.news_id)";			
			}
		$sql .= " WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";	
		
		if (!empty($data['filter_ncategory_id'])) {
				if (!empty($data['filter_sub_ncategory'])) {
					$implode_data = array();
					
					$implode_data[] = "n2n.ncategory_id = '" . (int)$data['filter_ncategory_id'] . "'";
					
					$this->load->model('catalog/ncategory');
					
					$ncategories = $this->model_catalog_ncategory->getncategoriesByParentId($data['filter_ncategory_id']);
										
					foreach ($ncategories as $ncategory_id) {
						$implode_data[] = "n2n.ncategory_id = '" . (int)$ncategory_id . "'";
					}
								
					$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
				} else {
					$sql .= " AND n2n.ncategory_id = '" . (int)$data['filter_ncategory_id'] . "'";
				}
			}		
		if (!empty($data['filter_name'])) {
				$sql .= " AND (";
											
				if (!empty($data['filter_name'])) {
					$implode = array();
					
					$words = explode(' ', $data['filter_name']);
					
					foreach ($words as $word) {
						if (!empty($data['filter_description'])) {
							$implode[] = "LCASE(nd.title) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(nd.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
						} else {
							$implode[] = "LCASE(nd.title) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
						}				
					}
					
					if ($implode) {
						$sql .= " " . implode(" AND ", $implode) . "";
					}
				}
				
				$sql .= ")";
			}
		if (!$this->config->get('config_bnews_order')) {
			$sql .= " ORDER BY n.date_added DESC ";
			} else {
			$sql .= " ORDER BY n.sort_order";	
		}	
        			
		if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
			
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getNewsLayoutId($news_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_to_layout WHERE news_id = '" . (int)$news_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return  $this->config->get('config_layout_news');
		}
	}
	public function getProductRelated($news_id) {
		$product_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_related nr LEFT JOIN " . DB_PREFIX . "news n ON (nr.news_id = n.news_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (nr.product_id = p2s.product_id) WHERE nr.news_id = '" . (int)$news_id . "' AND n.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		$this->load->model('catalog/product');
		foreach ($query->rows as $result) { 
			$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}
		
		return $product_data;
	}
	public function getTotalNews($data = array()) {
	$sql = "SELECT COUNT(DISTINCT n.news_id) AS total FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id)";
	if (!empty($data['filter_ncategory_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "news_to_ncategory n2n ON (n.news_id = n2n.news_id)";			
		}
	$sql .= " WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";	
	
	if (!empty($data['filter_ncategory_id'])) {
			if (!empty($data['filter_sub_ncategory'])) {
				$implode_data = array();
				
				$implode_data[] = "n2n.ncategory_id = '" . (int)$data['filter_ncategory_id'] . "'";
				
				$this->load->model('catalog/ncategory');
				
				$ncategories = $this->model_catalog_ncategory->getncategoriesByParentId($data['filter_ncategory_id']);
					
				foreach ($ncategories as $ncategory_id) {
					$implode_data[] = "n2n.ncategory_id = '" . (int)$ncategory_id . "'";
				}
							
				$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
			} else {
				$sql .= " AND n2n.ncategory_id = '" . (int)$data['filter_ncategory_id'] . "'";
			}
		}	
            if (!empty($data['filter_name'])) {
				$sql .= " AND (";
											
				if (!empty($data['filter_name'])) {
					$implode = array();
					
					$words = explode(' ', $data['filter_name']);
					
					foreach ($words as $word) {
						if (!empty($data['filter_description'])) {
							$implode[] = "LCASE(nd.title) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(nd.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
						} else {
							$implode[] = "LCASE(nd.title) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
						}				
					}
					
					if ($implode) {
						$sql .= " " . implode(" AND ", $implode) . "";
					}
				}
				
				$sql .= ")";
			}			
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
}
?>
