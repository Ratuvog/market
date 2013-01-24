<?php

class ModelCatalogFilter extends Model {

  public function getOptionByCategoriesId($categories_id) {

    $options_data = $this->cache->get('option.' . implode(".", $categories_id) . '.' . $this->config->get('config_language_id'));

    if(!$options_data && !is_array($options_data)) {
    
      $data = array();

      foreach ($categories_id as $category_id) {
    		$data[] = "category_id = '" . (int)$category_id . "'";
    	}
    
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_option co LEFT JOIN " . DB_PREFIX . "category_option_description cod ON (co.option_id = cod.option_id) WHERE co.option_id IN (SELECT option_id FROM " . DB_PREFIX . "category_option_to_category WHERE " . implode(" OR ", $data) . ") AND cod.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY co.sort_order");
      $this->cache->set('option.' . implode(".", $categories_id) . '.' . $this->config->get('config_language_id'), $query->rows);

      return $query->rows;
    }
    return $options_data;
  }

  public function getOptionValuesByProductId($product_id, $option_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_option_value cov LEFT JOIN " . DB_PREFIX . "category_option_value_description covd ON (cov.value_id = covd.value_id) LEFT JOIN " . DB_PREFIX . "product_to_value p2v ON (cov.value_id = p2v.value_id) WHERE p2v.product_id = '" . (int)$product_id . "' AND cov.option_id = '" . (int)$option_id . "' AND covd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cov.value_id");

    return $query->rows;
  }

  public function getOptionValues($option_id) {
   $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_option_value cov LEFT JOIN " . DB_PREFIX . "category_option_value_description covd ON (cov.value_id = covd.value_id) WHERE cov.option_id = '" . (int)$option_id . "' AND covd.language_id = '" . (int)$this->config->get('config_language_id')  . "' ORDER BY covd.`name` ASC");

   return $query->rows;
  }
  
  public function getTotalCategoryValueProducts($category_id, $value_id) {
    $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_category p2c LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_value p2v ON (p.product_id = p2v.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2c.category_id = '" . (int)$category_id . "' AND p2v.value_id = '" . (int)$value_id . "'");

    return $query->row['total'];
  }

}

?>