<script>
function _jbox(r, status) {
	var message = r.message, 
	img = (status == 'error') ? '<img width="25" height="25" src="<?php echo URL_IMG_ROOT.'error.png' ?>">' : '<img width="25" height="25" src="<?php echo URL_IMG_ROOT.'success.png' ?>">';
	box = new jBox('Modal', {
		closeButton: 'title',
		delayOpen: 300,
		maxWidth: 600,
		minWidth: 100,
		title : img,
		onCloseComplete: function() {
			if (r.redirect) location.href = r.redirect;
		},
	}).setContent('<div >' + message + '</div>').open();
}
</script>