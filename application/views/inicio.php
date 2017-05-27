<?php $this->load->helper('url'); ?>
<?php echo form_open_multipart('inicio/importar');?>


<!DOCTYPE html>
  <body>
  <h1>Importando archivo CSV</h1>
  <form action="<?php echo site_url('inicio/importar'); ?>" method='post' enctype="multipart/form-data">
   Importar Archivo CSV : <input type='file' name='archivo_csv' size='20'>
   <input type='submit' name='submit' value='submit'>
  </form>
 </body>
</html>


