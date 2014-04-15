<div class="pagination">

	<?php
	$i=0;
	
	while ($i < $totalPages){
		$i++;

		if($i == $page){ 

			echo '<span>' . $i . '</span>';

		} else {

			echo '<a href="?page=' . $i . '">' . $i . '</a>';

		 }

	}
	?>

</div>