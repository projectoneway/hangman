<?php

/**
 * @return int
 */
function deleteAllCache() {

    $CI = &get_instance();
    /* $cache_dir=$CI->config->item('cache_path');

      $dir = scandir($cache_dir);

      foreach ($dir as $file) {
      if (!is_dir($file)) {

      if (unlink($cache_dir . $file)) {

      }
      }
      }
     */
    $supportedCache = getSupportedCacheDriver();
    if($supportedCache!=false){
        $CI->cache->$supportedCache->clean();
        return true;
    }
}

/* * * check for server supported cache driver
 * * driver type (APC, File, MEMCHACHE)
 * * */

function getSupportedCacheDriver() {
   

    $CI = &get_instance();

    if(USE_CACHE==true){
        ///====check for APC support on server====
        if ($CI->cache->apc->is_supported()) {
            return 'apc';
        }

        ///====check for memcached support on server====
        elseif ($CI->cache->memcached->is_supported()) {
            return 'memcached';
        }

        ///====check for file support on server====
        elseif ($CI->cache->file->is_supported()) {
            return 'file';
        } 
    }
     return false;
}

?>