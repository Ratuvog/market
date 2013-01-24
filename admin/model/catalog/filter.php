<?php

class ModelCatalogFilter extends Model {

  public function addOption($data) {

    $this->db->query("INSERT INTO " . DB_PREFIX . "category_option SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "'");

    $option_id = $this->db->getLastId();

    foreach ($data['category_option_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_option_description SET option_id = '" . (int)$option_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

    if (isset($data['category_id'])) {
			foreach ($data['category_id'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_option_to_category SET option_id = '" . (int)$option_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

    if (isset($data['option_value'])) {
      foreach ($data['option_value'] as $option_value) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "category_option_value SET option_id = '" . (int)$option_id . "'");

        $value_id = $this->db->getLastId();

        foreach ($option_value['language'] as $language_id => $language) {
				  $this->db->query("INSERT INTO " . DB_PREFIX . "category_option_value_description SET value_id = '" . (int)$value_id . "', option_id = '" . (int)$option_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($language['name']) . "'");
				}
      }
    }
    $this->cache->delete('option');
  }

  public function editOption($option_id, $data) {

    $this->db->query("UPDATE " . DB_PREFIX . "category_option SET status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE option_id = '" . (int)$option_id . "'");

    $this->db->query("DELETE FROM " . DB_PREFIX . "category_option_description WHERE option_id = '" . (int)$option_id . "'");

    foreach ($data['category_option_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_option_description SET option_id = '" . (int)$option_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

    $this->db->query("DELETE FROM " . DB_PREFIX . "category_option_to_category WHERE option_id = '" . (int)$option_id . "'");

    if (isset($data['category_id'])) {
			foreach ($data['category_id'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_option_to_category SET option_id = '" . (int)$option_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

    $this->db->query("DELETE FROM " . DB_PREFIX . "category_option_value WHERE option_id = '" . (int)$option_id . "'");
    $this->db->query("DELETE FROM " . DB_PREFIX . "category_option_value_description WHERE option_id = '" . (int)$option_id . "'");

    if (isset($data['option_value'])) {
      foreach ($data['option_value'] as $value_id => $value) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "category_option_value SET option_id = '" . (int)$option_id . "', value_id = '" . (int)$value_id . "'");

        foreach ($value['language'] as $language_id => $language) {
				  $this->db->query("INSERT INTO " . DB_PREFIX . "category_option_value_description SET value_id = '" . (int)$value_id . "', option_id = '" . (int)$option_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($language['name']) . "'");
				}
      }
    }
    $this->cache->delete('option');
  }

  public function deleteOption($option_id) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "category_option WHERE option_id = '" . (int)$option_id . "'");
    $this->db->query("DELETE FROM " . DB_PREFIX . "category_option_description WHERE option_id = '" . (int)$option_id . "'");
    $this->db->query("DELETE FROM " . DB_PREFIX . "category_option_to_category WHERE option_id = '" . (int)$option_id . "'");
    $this->db->query("DELETE FROM " . DB_PREFIX . "category_option_value WHERE option_id = '" . (int)$option_id . "'");
    $this->db->query("DELETE FROM " . DB_PREFIX . "category_option_value_description WHERE option_id = '" . (int)$option_id . "'");
    $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_value WHERE option_id = '" . (int)$option_id . "'");
    $this->cache->delete('option');
  }

  public function getOption($option_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_option co LEFT JOIN " . DB_PREFIX . "category_option_description cod ON (co.option_id = cod.option_id) WHERE co.option_id = '" . (int)$option_id . "' ORDER BY co.sort_order");

    return $query->row;
  }

  public function getOptionByCategoriesId($categories_id) {

    $data = array();

    foreach ($categories_id as $category_id) {
		  $data[] = "category_id = '" . (int)$category_id . "'";
		}

    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_option co LEFT JOIN " . DB_PREFIX . "category_option_description cod ON (co.option_id = cod.option_id) WHERE co.option_id IN (SELECT option_id FROM " . DB_PREFIX . "category_option_to_category WHERE " . implode(" OR ", $data) . ") AND cod.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY co.sort_order");

    return $query->rows;
  }

  public function getOptionCategories($option_id) {
   $categories_id = array();

   $query = $this->db->query("SELECT c.category_id AS category_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_option_to_category cotc ON (c.category_id = cotc.category_id) WHERE cotc.option_id = '" . (int)$option_id . "'");

   foreach ($query->rows as $result) {
	   $categories_id[] = $result['category_id'];
	 }

   return $categories_id;
  }

  public function getOptionValues($option_id) {
   	// Start values
    $value_data = array();

    $value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_option_value WHERE option_id = '" . (int)$option_id . "'");

    foreach ($value_query->rows as $option_value) {
      // Start values description
      $category_option_value_description_data = array();

			$category_option_value_description = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_option_value_description WHERE value_id = '" . (int)$option_value['value_id'] . "'");

			foreach ($category_option_value_description->rows as $result) {
				$category_option_value_description_data[$result['language_id']] = array('name' => $result['name']);
			}

      $value_data[] = array(
        'value_id'    => $option_value['value_id'],
        'language'    => $category_option_value_description_data
      );
    }

		return $value_data;
  }

	public function getOptionDescriptions($option_id) {
		$option_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_option_description WHERE option_id = '" . (int)$option_id . "'");

		foreach ($query->rows as $result) {
			$option_description_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $option_description_data;
	}

  public function getOptions() {
    $option_data = array();

    $option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_option co LEFT JOIN " . DB_PREFIX . "category_option_description cod ON (co.option_id = cod.option_id) WHERE cod.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY sort_order");

    foreach ($option_query->rows as $option) {

      $category_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_option_to_category cotc ON (c.category_id = cotc.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = cotc.category_id) WHERE cotc.option_id = '" . (int)$option['option_id'] . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

      $values_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_option_value cov LEFT JOIN " . DB_PREFIX . "category_option_value_description covd ON (cov.value_id = covd.value_id) WHERE cov.option_id = '" . (int)$option['option_id'] . "' AND covd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY covd.name");

      $option_data[] = array(
        'option_id'     => $option['option_id'],
        'name'          => $option['name'],
        'categories'    => $category_query->rows,
        'values'        => $values_query->rows,
        'sort_order'    => $option['sort_order'],
        'status'        => $option['status']
      );
    }

    return $option_data;
  }

  public function getOptionsByCategoryId($category_id) {
    $option_data = array();

    $option_query = $this->db->query("SELECT co.option_id, cod.name FROM " . DB_PREFIX . "category_option co LEFT JOIN " . DB_PREFIX . "category_option_description cod ON (co.option_id = cod.option_id) LEFT JOIN " . DB_PREFIX . "category_option_to_category cotc ON (co.option_id = cotc.option_id) WHERE cotc.category_id = '" . (int)$category_id . "' ORDER BY co.sort_order");

    foreach ($option_query->rows as $option) {

      $values_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_option_value cov LEFT JOIN " . DB_PREFIX . "category_option_value_description covd ON (cov.value_id = covd.value_id) WHERE cov.option_id = '" . (int)$option['option_id'] . "'");

      $option_data[] = array(
        'option_id'     => $option['option_id'],
        'name'          => $option['name'],
        'values'        => $values_query->rows
      );
    }
    return $option_data;
  }

  public function getTotalOptions() {
    $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_option");

    return $query->row['total'];
  }

  public function getLastInsertedId() {
    $query = $this->db->query("SELECT MAX(value_id) AS last FROM " . DB_PREFIX . "category_option_value");

    return $query->row['last'];
  }

  public function showTable($table) {
    if (mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . DB_PREFIX . $table . "'"))) {
      return TRUE;
    } else {
      return FALSE;
    }
  }
  // Install filter tables

  public function createTables() {

		$sql = "
      CREATE TABLE `category_option` (
        `option_id` int(10) NOT NULL auto_increment,
        `status` int(1) default '0',
        `sort_order` int(10) default '0',
        PRIMARY KEY  (`option_id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

      CREATE TABLE `category_option_description` (
        `option_id` int(10) NOT NULL,
        `language_id` int(10) NOT NULL,
        `name` varchar(127) NOT NULL,
        PRIMARY KEY  (`option_id`,`language_id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

      CREATE TABLE `category_option_to_category` (
        `option_id` int(11) NOT NULL,
        `category_id` int(11) NOT NULL,
        PRIMARY KEY  (`category_id`,`option_id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

      CREATE TABLE `category_option_value` (
        `value_id` int(10) NOT NULL auto_increment,
        `option_id` int(10) default '0',
        PRIMARY KEY  (`value_id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

      CREATE TABLE `category_option_value_description` (
        `value_id` int(10) NOT NULL,
        `language_id` int(10) NOT NULL,
        `option_id` int(10) NOT NULL,
        `name` varchar(127) NOT NULL,
        PRIMARY KEY  (`value_id`,`language_id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

      CREATE TABLE `product_to_value` (
        `product_id` int(11) NOT NULL,
        `value_id` int(11) NOT NULL,
        `option_id` int(11) NOT NULL,
        PRIMARY KEY  (`product_id`,`value_id`,`option_id`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
    ";

		$query = '';

		foreach(explode(';', $sql) as $line) {
			$query = str_replace("CREATE TABLE `", "CREATE TABLE `" . DB_PREFIX, trim($line));
			if ($query != '') {
 			  $this->db->query($query);
      }
			$query = '';
		}

		if ($this->showTable(DB_PREFIX.'category_option')) {
      return TRUE;
    } else {
      return FALSE;
    }
	}
}

?>