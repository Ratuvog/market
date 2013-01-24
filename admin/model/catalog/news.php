<?php
class ModelCatalogNews extends Model {
	public function addNews($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "news SET status = '" . (int)$this->request->post['status'] . "', acom = '" . (int)$this->request->post['acom'] . "', sort_order = '" . (int)$this->request->post['sort_order'] . "', date_added = now()");
		$news_id = $this->db->getLastId(); 
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news SET image = '" . $this->db->escape($data['image']) . "' WHERE news_id = '" . (int)$news_id . "'");
		}
		
		foreach (@$data['news_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_description SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_desc = '" . $this->db->escape($value['meta_desc']) . "', meta_key = '" . $this->db->escape($value['meta_key']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
		}
		if (isset($data['news_store'])) {
			foreach ($data['news_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_to_store SET news_id = '" . (int)$news_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		if (isset($data['news_ncategory'])) {
			foreach ($data['news_ncategory'] as $ncategory_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_to_ncategory SET news_id = '" . (int)$news_id . "', ncategory_id = '" . (int)$ncategory_id . "'");
			}
		}
		if (isset($data['news_related'])) {
			foreach ($data['news_related'] as $related_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_related SET news_id = '" . (int)$news_id . "', product_id = '" . (int)$related_id . "'");
			}
		}
		if (isset($data['news_layout'])) {
			foreach ($data['news_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "news_to_layout SET news_id = '" . (int)$news_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('news');
	}

	public function editNews($news_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "news SET status = '" . (int)$data['status'] . "', acom = '" . (int)$data['acom'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE news_id = '" . (int)$news_id . "'");
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "news SET image = '" . $this->db->escape($data['image']) . "' WHERE news_id = '" . (int)$news_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");
		foreach (@$data['news_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "news_description SET news_id = '" . (int)$news_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_desc = '" . $this->db->escape($value['meta_desc']) . "', meta_key = '" . $this->db->escape($value['meta_key']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_to_store WHERE news_id = '" . (int)$news_id . "'");

		if (isset($data['news_store'])) {
			foreach ($data['news_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_to_store SET news_id = '" . (int)$news_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_to_ncategory WHERE news_id = '" . (int)$news_id . "'");
		
		if (isset($data['news_ncategory'])) {
			foreach ($data['news_ncategory'] as $ncategory_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_to_ncategory SET news_id = '" . (int)$news_id . "', ncategory_id = '" . (int)$ncategory_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_related WHERE news_id = '" . (int)$news_id . "'");

		if (isset($data['news_related'])) {
			foreach ($data['news_related'] as $related_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "news_related SET news_id = '" . (int)$news_id . "', product_id = '" . (int)$related_id . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_to_layout WHERE news_id = '" . (int)$news_id . "'");
		
		if (isset($data['news_layout'])) {
			foreach ($data['news_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "news_to_layout SET news_id = '" . (int)$news_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news_id=" . (int)$news_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		$this->cache->delete('news');
	}
    public function copyNews($news_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE n.news_id = '" . (int)$news_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['status'] = '0';
						
			$data = array_merge($data, array('news_description' => $this->getNewsDescriptions($news_id)));
			$data = array_merge($data, array('news_ncategory' => $this->getNewsNcategories($news_id)));
			$data = array_merge($data, array('news_layout' => $this->getNewsLayouts($news_id)));
			$data = array_merge($data, array('news_store' => $this->getNewsStores($news_id)));
			$data = array_merge($data, array('news_related' => $this->getNewsRelated($news_id)));
			
			$this->addNews($data);
		}
	}
	public function deleteNews($news_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_to_ncategory WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_to_store WHERE news_id = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "news_related WHERE news_id = '" . (int)$news_id . "'");
		$this->cache->delete('news');
	}	

	public function getNewsStory($news_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$news_id . "'");
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'news_id=" . (int)$news_id . "') AS keyword FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$news_id . "'");
		
		return $query->row;
	}

	public function getNewsDescriptions($news_id) {
		$news_description_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_description WHERE news_id = '" . (int)$news_id . "'");
		foreach ($query->rows as $result) {
			$news_description_data[$result['language_id']] = array(
				'seo_title'   => $result['seo_title'],
				'seo_h1'      => $result['seo_h1'],
				'title'       => $result['title'],
				'description' => $result['description'],
				'meta_desc'   => $result['meta_desc'],
				'meta_key'    => $result['meta_key'],
			);
		}
		return $news_description_data;
	}
    public function getNewsStores($news_id) {
		$news_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_to_store WHERE news_id = '" . (int)$news_id . "'");

		foreach ($query->rows as $result) {
			$news_store_data[] = $result['store_id'];
		}
		
		return $news_store_data;
	}

	public function getNewsLayouts($news_id) {
		$news_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_to_layout WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$news_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $news_layout_data;
	}
	public function getNewsRelated($news_id) {
		$news_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_related WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$news_related_data[] = $result['product_id'];
		}
		
		return $news_related_data;
	}	
	public function getNewsNcategories($news_id) {
		$news_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_to_ncategory WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$news_category_data[] = $result['ncategory_id'];
		}

		return $news_category_data;
	}
	
	public function getNews() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY n.date_added");
	
		return $query->rows;
	}
	
	

	public function getNewsLimited($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'  ORDER BY n.date_added   ";
	
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
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
	
	public function getTotalNews() {
     	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news");
		return $query->row['total'];
	}	
}
?>
