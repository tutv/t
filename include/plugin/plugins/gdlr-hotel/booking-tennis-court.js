(function ($) {

	var $doc = $(document);

	$doc.ready(function () {

		$('#gdlr-check-in').datepicker();

		$('#gdlr-check-out').datetimepicker({
			datepicker: false,
			format    : 'H:i'
		});


	})
})(jQuery);
