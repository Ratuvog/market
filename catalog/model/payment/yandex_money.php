<?php
class ModelPaymentYandexMoney extends Model {
	public function getMethod($address, $total) {
		$setting = $this->config->get('yandex_money_setting');
		
		$status = FALSE;
		
		$this->load->language('payment/yandex_money');
		
		if ($this->config->get('yandex_money_status')) {
			$query = $this->db->query("
				SELECT *
				FROM " . DB_PREFIX . "zone_to_geo_zone
				WHERE geo_zone_id = '" . (int) $setting['geo_zone_id'] . "'
				AND   country_id  = '" . (int) $address['country_id' ] . "'
				AND  (zone_id     = '" . (int) $address['zone_id'    ] . "' OR zone_id = 0)"
			);
			
			if ($query->num_rows || !$setting['geo_zone_id']) {
				$status = TRUE;
			}
		}
		
		$method_data = array ();
		
		if ($status) {
			$method_data = array (
				'code'       => 'yandex_money',
				'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('yandex_money_sort_order')
			);
		}
		
		return $method_data;
	}
}
?>