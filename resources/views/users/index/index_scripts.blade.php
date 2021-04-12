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
					url: "{{route('users.paginate')}}",
					type: 'POST',
					'headers': {
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					},
					"data": function(d) {
                        d.status = $('select[id=status]').val();
					}
				},
				columns: [
					{
						data: 'name',
					},
					{
						data: 'email'
                    },
					{
						data: 'is_active'
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
				columnDefs: [
					{
						targets: -1,
						title: 'Actions',
						orderable: false,
						render: function(data, type, full, meta) {
							console.log(full)

							var activate_deactivate_btn = "";
							if(full.is_active == 1)
                {

					
                    activate_deactivate_btn = '<a href="javascript:;" id="' + full.id + '"  class="btn btn-sm btn-clean btn-icon" title="Deactivate Account"> <i data-name="' + full.name + '" data-id="' + full.id + '" class="fa fa-power-off text-danger"></i></a>';
                }
                else
                {
                    //activate account
                    activate_deactivate_btn = '<a href="javascript:;" id="' + full.id + '"  class="btn btn-sm btn-clean btn-icon" title="Activate Account"> <i data-name="' + full.name +'" data-id="'  + full.id + '" class="fas fa-bolt text-success"></i> </a>';
                }
				
							return activate_deactivate_btn;
						},
					},
					{
					width: '75px',
					targets: 2,
					render: function(data, type, full, meta) {
						var status = {
							0: {'title': 'In Active', 'state': 'danger'},
							1: {'title': 'Active', 'state': 'success'},
						};
						if (typeof status[data] == 'undefined') {
							return data;
						}
						return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
							'<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
					},
				},
				],
			})

		
			//disable account button
		$('#built_table').on('click', 'tr td a i.fa-power-off ',
			function() {
				var id = dataTable.row(this.closest('tr')).id();
				var name = $(this).attr("data-name");
				swal.fire({
					title: "Are you sure?",
					html: "Do you really want to disable <b>" + name + "</b>'s account ?",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Yes, de-activate!"
				}).then(result => {
					if (result.value) {
						axios.put('/users/disable-account/' + id, {
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

			//activate user account
			$('#built_table').on('click', 'tr td a i.fa-bolt ',
			function() {
				var id = $(this).attr("data-id");
				var name = $(this).attr("data-name");
				swal.fire({
					title: "Are you sure?",
					html: "Do you really want to activate <b>" + name + "</b>'s account ?",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Yes, Activate!"
				}).then(result => {
					if (result.value) {
						axios.put('/users/enable-account/' + id, {
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

	});
</script>