<?php
  $data = "D645E824-40AF-11E5-B499-076DCF9FB888_1";
  $c = explode("_",$data);
  echo $c[0];
  echo "</br>";
  echo $c[1];

  $path = "DokumenPendaftaran/20211/0A7D990B-280C-4C56-93C5-40A88C32A44C/0A7D990B-280C-4C56-93C5-40A88C32A44C_1.jpeg";
  if(file_exists($path)){
    echo "file ada";
  }else {
    echo "file tidak ada";
  }
 ?>
