<?php
  require('smarty/Smarty.class.php');

  $smarty = new Smarty;
  $smarty->debugging = false;
  $smarty->caching = false;
  $smarty->cache_lifetime = 120;
  $smarty->template_dir = $script_dir.'\\templates';
  $smarty->compile_dir = $script_dir.'\\templates_c';
  $smarty->cache_dir = $script_dir.'\\cache';

?>