	<!-- js files -->
	<script src="<?php echo BASE_URL; ?>js/jquery-1.10.1.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.validate.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.fancybox.pack.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.mousewheel-3.0.6.pack.js"></script>
	<script>
		$(document).ready(function() {
				
			$('.fancybox').fancybox();
			$('#previewpop').fancybox();
			$("#theForm").validate();

			$("a.preview").click(function(event){
				var gid = $(this).attr('id');
				$.ajax({
					type: "get",
					url: "lib/ajax.php",
					data: "id="+gid,
					dataType: 'html',
					success: function (data) {
						$('#preview').html(data);
						$('#previewpop').trigger('click'); 
					}
				});
			});

		});
	
	</script>

</body>
</html>