<?php $this->load->helper('url'); ?>

<!DOCTYPE html>
  <body>
  
  <h1>Importaando archivo CSV</h1>
  <form action="<?php echo site_url('inicio/importar'); ?>" method='post' enctype="multipart/form-data">
   Importar Archivo CSV : <input type='file' name='sel_file' size='20'>
   <input type='submit' name='submit' value='submit'>


  </form>
 </body>
</html>


