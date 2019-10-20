<?php

require 'inc/config.php';
require 'nest-api-master/nest.class.php';

define('USERNAME', $config['nest_user']);
define('PASSWORD', $config['nest_pass']);
date_default_timezone_set($config['local_tz']);

$nest = new Nest();

$status = $nest->getStatus();
print_r($status);

$infos = $nest->getDeviceInfo();
print_r($infos);

stuff_we_care_about($infos, $status);

function stuff_we_care_about($info, $status) {
  echo "Heating             : ";
  printf("%s\n", ($info->current_state->heat == 1 ? 1 : 0));
  echo "Timestamp           : ";
  printf("%s\n", $info->network->last_connection);
  echo "Target temperature  : ";
  #if (!strpos($info->current_state->mode, "away")) {
    printf("%.02f\n", $info->target->temperature);
  #} else {
  #  printf("%.02f\n", $info->target->temperature);
  #}
  echo "Current temperature : ";
  printf("%.02f\n", $info->current_state->temperature);
  echo "Current humidity    : ";
  printf("%d\n", $info->current_state->humidity);
  echo "Eco temperature     : ";
  printf("%.02f\n", $info->current_state->eco_temperatures->low);
  #printf("%.02f\n", $status->device[$info->serial_number]->hot_water_active);
  $devices = (array)$status->device;
  printf("Hot Water: %s\n", $devices[$info->serial_number]->hot_water_active);

}

function c_to_f($c) {
  return ($c * 1.8) + 32;
}

