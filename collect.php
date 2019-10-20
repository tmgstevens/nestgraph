<?php

require 'inc/config.php';
require 'nest-api-master/nest.class.php';

define('USERNAME', $config['nest_user']);
define('PASSWORD', $config['nest_pass']);

date_default_timezone_set($config['local_tz']);

function get_nest_data() {
  $nest = new Nest();
  $info = $nest->getDeviceInfo();
  $status = $nest->getStatus();
  $devices = (array)$status->device;
  $data = array('heating'      => ($info->current_state->heat == 1 ? 1 : 0),
		'timestamp'    => $info->network->last_connection,
		'target_temp'  => sprintf("%.02f", $info->target->temperature),
		'current_temp' => sprintf("%.02f", $info->current_state->temperature),
		'humidity'     => $info->current_state->humidity,
                'away'         => strpos($info->current_state->mode, "away"),
                'hot_water'    => $devices[$info->serial_number]->hot_water_active
		);
  return $data;
}

function c_to_f($c) {
  return ($c * 1.8) + 32;
}
  #if (!strpos($info->current_state->mode, "away")) {
  #printf("%.02f\n", $status->device[$info->serial_number]->hot_water_active);
  #$devices = (array)$status->device;
  #printf("Hot Water: %s\n", $devices[$info->serial_number]->hot_water_active);

?>
