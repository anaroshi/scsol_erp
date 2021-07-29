<?php

  function clearBrowserCache() {
    header("Pragma: no-cache");
    // HTTP/1.0
    header("Cache: no-cache");
    // HTTP/1.1
    header("Cache-Control: no-store, no-cache, must-revalidate"); 
    // 시간 파괴
    header("Last-Modified:".gmdate("D, d M Y H:i:s")."GMT");
    // 시간 덮어 씌움
    header("Expires:Mon, 26 Jul 1997 05:00:00 GMT");
  }
  clearBrowserCache(); 

?>