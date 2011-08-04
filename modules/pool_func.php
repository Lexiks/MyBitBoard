<?php
	  
  function GetDifficultyData()
  {
    $difficulty = round(CurlGet('http://blockexplorer.com/q/getdifficulty'),2);
    $next_difficulty = round(CurlGet('http://blockexplorer.com/q/estimate'),2);
    $grow_difficulty = round(($next_difficulty-$difficulty)/$difficulty*100,2);
    return array('difficulty' => $difficulty, 'next_difficulty' => $next_difficulty, 'grow_difficulty' => $grow_difficulty);
  }

 
  function GetSharesData()
  {
      global $dip_api,$cz_api;
      $json_dip_data = CurlGet('http://deepbit.net/api/'.$dip_api);
      
      $data_dip = json_decode($json_dip_data,false);
      
      
      $json_cz_data = CurlGet('http://mining.bitcoin.cz/accounts/profile/json/'.$cz_api);
      $data_cz = json_decode($json_cz_data,false);
      

      

      $pool_data['cz']['shares_sum'] = 0;
      $pool_data['dip']['shares_sum'] = 0;
      foreach ($data_dip->workers as $key => $dip_worker)
      {
          $A = split('_',$key);
          $ukey = $A[1];
          $pool_data[$ukey]['dip']['alive'] =  $dip_worker->alive;
          $pool_data[$ukey]['dip']['shares'] =  $dip_worker->shares;
          $pool_data['dip']['shares_sum'] +=  $dip_worker->shares;
          $pool_data[$ukey]['dip']['stales'] =  $dip_worker->stales;
          
          $cz_worker =  $data_cz->workers->{'Lexiko.'.$ukey};
          $pool_data[$ukey]['cz']['alive'] =  $cz_worker->alive;
          $pool_data[$ukey]['cz']['shares'] =  $cz_worker->shares;
          $pool_data['cz']['shares_sum'] +=  $dip_worker->shares;
          $pool_data[$ukey]['cz']['score'] =  $cz_worker->stales;
          $pool_data[$ukey]['cz']['hashrate'] =  $cz_worker->stales;
          
      }
      
      $pool_data['cz']['confirmed_reward'] = $data_cz->confirmed_reward;
      $pool_data['cz']['estimated_reward'] = $data_cz->estimated_reward;
      $pool_data['cz']['unconfirmed_reward'] = $data_cz->unconfirmed_reward;
      $pool_data['cz']['wallet'] = $data_cz->wallet;
      
      $pool_data['dip']['confirmed_reward'] = $data_dip->confirmed_reward;
      $pool_data['dip']['hashrate'] = $data_dip->hashrate;
  
  return $pool_data;
  }
?>
