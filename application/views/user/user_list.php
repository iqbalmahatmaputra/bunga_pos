<?php $this->load->view('templates/header');?>
<div class="row" style="margin-bottom: 20px">
	<div class="col-md-4">
		<h2>User List</h2>
	</div>
	<div class="col-md-4 text-center">
		<div id="message">
			<?php echo $this->session->userdata('message') != '' ? $this->session->userdata('message') : ''; ?>
		</div>
	</div>
	<div class="col-md-4 text-right">
		<div style="margin-top:20px;">
			<?php echo anchor(site_url('user/create'), 'Create', 'class="btn btn-primary"'); ?>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">

		<table class="table table-bordered table-striped" id="mytable">
			<thead>
				<tr>
					<th width="80px">No</th>
					<th>Nama User</th>
					<th>Password</th>
					<!-- <th>Foto</th> -->
					<th>Telfon</th>
					<th>Created At</th>
					<th>Is Active</th>
					<th>Status</th>
					<th width="200px">Action</th>
				</tr>
			</thead>

		</table>
	</div>
</div>
<?php $this->load->view('templates/footer');?><script type="text/javascript">
	$(document).ready(function () {
		$.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
			return {
				"iStart": oSettings._iDisplayStart,
				"iEnd": oSettings.fnDisplayEnd(),
				"iLength": oSettings._iDisplayLength,
				"iTotal": oSettings.fnRecordsTotal(),
				"iFilteredTotal": oSettings.fnRecordsDisplay(),
				"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
				"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
			};
		};

		var t = $("#mytable").dataTable({
			initComplete: function () {
				var api = this.api();
				$('#mytable_filter input')
					.off('.DT')
					.on('keyup.DT', function (e) {
						if (e.keyCode == 13) {
							api.search(this.value).draw();
						}
					});
			},
			oLanguage: {
				sProcessing: "loading..."
			},
			processing: true,
			serverSide: true,
			ajax: {
				"url": "<?php echo base_url(); ?>user/json",
				"type": "POST"
			},
			columns: [{
					"data": "id_user",
					"orderable": false
				}, {
					"data": "nama_user"
				}, {
					"data": "password"
				}, {
					"data": "telfon"
				}, {
					"data": "created_at"
				}, {
                    "data": "is_active",
                   
				}, {
					"data": "status"
				},
				{
					"data": "action",
					"orderable": false,
					"className": "text-center"
				}
			],
			order: [
				[0, 'desc']
			],
			rowCallback: function (row, data, iDisplayIndex) {
				var info = this.fnPagingInfo();
				var page = info.iPage;
				var length = info.iLength;
				var index = page * length + (iDisplayIndex + 1);
				$('td:eq(0)', row).html(index);
			}
		});
	});

</script>
