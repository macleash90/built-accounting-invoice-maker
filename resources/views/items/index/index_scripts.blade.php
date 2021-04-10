<script>
	$(function() {
 
		//set datatable error to not display
		$.fn.dataTable.ext.errMode = 'none';
		// begin first table
		var dataTable = $('#built_table')
			.on('error.dt', function(e, settings, techNote, message) {
				//pass the error to the dataTableErrorFn function in /resources/layouts/app.blade.php
				dataTableErrorFn(e, settings, techNote, message);

			})
			.DataTable({
                dom: 'Bfrtip',
				responsive: true,

				buttons: [
                    'pageLength',
					'print',
					'copyHtml5',
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5',
				],                
                lengthMenu: [10, 20,30, 50],
				processing: true,
				serverSide: true,
				ordering: false,
				// pageLength: 10,
				ajax: {
					url: "{{route('items.paginate')}}",
					type: 'POST',
					'headers': {
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					},
					"data": function(d) {
                        
					}
				},
				columns: [{
						data: 'name',
					},
					{
						data: 'item_description'
                    },
                    {
						data: 'created_at',
                        'searchable': false 
                    },
					{
						data: 'actions',
						responsivePriority: -1
					},
				],
				columnDefs: [{
						targets: -1,
						title: 'Actions',
						orderable: false,
						render: function(data, type, full, meta) {
							
							return '\
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="View details">\
								<i class="fa fa-eye text-warning"></i>\
							</a>\
                            <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
								<i class="fa fa-edit text-primary"></i>\
							</a>\
                            <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Delete">\
								<i class="fa fa-trash text-danger"></i>\
							</a>\
						';
						},
					},

				],
			})

		//edit button
		$('#built_table').on('click', 'tr td i.fa-edit ',
			function() {
				var id = dataTable.row(this.closest('tr')).id();
				window.location.href = "/items/" + id + "/edit";
			});

            //view button
		$('#built_table').on('click', 'tr td i.fa-eye ',
			function() {
				var id = dataTable.row(this.closest('tr')).id();
				window.location.href = "/items/" + id;
			});

		//delete button
		$('#built_table').on('click', 'tr td i.fa-trash ',
			function() {
				var id = dataTable.row(this.closest('tr')).id();
				swal.fire({
					title: "Are you sure?",
					html: "Do you really want to delete this item?",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Yes, delete!"
				}).then(result => {
					if (result.value) {
						axios.delete('/items/' + id, {
								headers: {
									'X-CSRF-TOKEN': '{{ csrf_token() }}'
								},
								data: {

								}
							})
							.then(function(response) {
								toast.fire({
									icon: "success",
									title: response.data.message,
								});
								dataTable.draw()
							})
					}
				});
			});

		$("#submitFilters").on("click", function(e) {
			e.preventDefault();
			dataTable.draw();
		});



		function editCustomer(customer) {
			// e.preventDefault();
			var rowID = $(customer).attr('id');
			window.location.href = "/items/" + rowID;
		}
	});
</script>