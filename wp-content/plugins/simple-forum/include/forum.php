<?php 

?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="#">Home</a></li>
  <li class="breadcrumb-item"><a href="#">Library</a></li>
  <li class="breadcrumb-item active">Data</li>
</ol>

<div class="container-fluid spf-wrapper">	
	<?php if ( isset($_GET['cat'])): // Muestra los topics de una categoria ?>
		<?php include_once('topics.php'); ?>
	<?php elseif(isset($_GET['topic'])): // Muestras un topic junto con los posts de los usuarios  ?>		
		<?php include_once('topic.php'); ?>			
	<?php else: ?>		
		<?php include_once('categories.php'); ?>
	<?php endif; ?>		
</div>


