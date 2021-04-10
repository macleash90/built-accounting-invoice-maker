
		$('#export_print').on('click', function(e) {
			e.preventDefault();
			dataTable.button(0).trigger();
		});

		$('#export_copy').on('click', function(e) {
			e.preventDefault();
			dataTable.button(1).trigger();
		});

		$('#export_excel').on('click', function(e) {
			e.preventDefault();
			dataTable.button(2).trigger();
		});

		$('#export_csv').on('click', function(e) {
			e.preventDefault();
			dataTable.button(3).trigger();
		});

		$('#export_pdf').on('click', function(e) {
			e.preventDefault();
			dataTable.button(4).trigger();
		});