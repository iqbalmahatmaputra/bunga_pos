<?php $this->load->view('templates/header');?>
<style>
	.ax {
		overflow: scroll;
		height: 400px;
	}

	.card-body .angka {
		font-size: 3rem;
		text-align: center;
	}

</style>
<div class="row" style="margin-bottom: 20px">
	<div class="col-md-4">
		<h2>Dashboard</h2>
	</div>
</div>
<!-- -->
<div class="row mb-5">
	<div class="col-4">
		<div class="card card-custom gutter-b bg-info" style="height: 130px">
			<!--begin::Body-->
			<div class="card-body d-flex flex-column">
				<!--begin::Stats-->
				<div class="flex-grow-1">
					<div class="text-white font-weight-bold">Total Penjualan</div>
					<div class="text-white font-weight-bolder font-size-h2">Rp <?= $total['komplit'] ?></div>
				</div>
				<!--end::Stats-->
				<!--begin::Progress-->

				<!--end::Progress-->
			</div>
		</div>
	</div>
	<div class="col-3">
		<div class="card card-custom gutter-b" style="height: 130px">
			<!--begin::Body-->
			<div class="card-body d-flex flex-column">
				<!--begin::Stats-->
				<div class="flex-grow-1">
					<div class="text-dark-50 font-weight-bold">Total Penjualan (Hari Ini)</div>
					<div class="font-weight-bolder font-size-h2">Rp <?= $today ?></div>
				</div>
				<!--end::Stats-->
				<!--begin::Progress-->

				<!--end::Progress-->
			</div>
		</div>
	</div>
	<div class="col-2">
		<div class="card card-custom gutter-b" style="height: 130px">
			<!--begin::Body-->
			<div class="card-body d-flex flex-column">
				<!--begin::Stats-->
				<div class="flex-grow-1">
					<div class="text-dark-50 font-weight-bold">Transaksi (Hari Ini)</div>
					<div class="font-weight-bolder font-size-h2"><?= $jumlah ?></div>
				</div>
				<!--end::Stats-->
				<!--begin::Progress-->

				<!--end::Progress-->
			</div>
		</div>
	</div>
	<div class="col-3">
		<div class="card card-custom bg-success gutter-b" style="height: 130px">
			<!--begin::Body-->
			<div class="card-body d-flex flex-column">
				<!--begin::Stats-->
				<div class="flex-grow-1">
					<div class="text-white font-weight-bold">Produk Terlaris </div>
					<div class="text-white font-weight-bolder font-size-h3"><?= $nama ?></div>
				</div>
				<!--end::Stats-->
				<!--begin::Progress-->

				<!--end::Progress-->
			</div>
		</div>
	</div>
</div>
<div class="row">
	
	<div class="col-lg-12">
		<div class="card card-custom gutter-b">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-label">Activity Log</h3>
				</div>
			</div>
			<div class="card-body ax">

				<div class="timeline timeline-justified timeline-4">
					<div class="timeline-bar"></div>
					<?php 
		foreach($activity as $u){ 
		?>
					<div class="timeline-items">
						<div class="timeline-item">
							<div class="timeline-badge">
								<div class="bg-danger"></div>
							</div>

							<div class="timeline-label">
								<span class="text-primary font-weight-bold"><?php echo $u->waktu ?></span>
							</div>

							<div class="timeline-content">
								<?php echo $u->kegiatan ?>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>



	<?php $this->load->view('templates/footer'); ?>

<script>
var chartData = JSON.parse(`<?php echo $chart_data; ?>`);

            try {
  var chart = AmCharts.makeChart( "chartdiv", {
  "type": "serial",
  "theme":"light",
  "dataProvider": chartData,
  "valueAxes": [ {
"gridColor": "#FFFFFF",
"gridAlpha": 0.2,
"dashLength": 0
  } ],
  "gridAboveGraphs": true,
  "startDuration": 1,
  "graphs": [ {
"balloonText": "[[category]]: <b>[[value]]</b>",
"fillAlphas": 0.8,
"lineAlpha": 0.2,
"type": "column",
"valueField": "count"
  } ],
  "chartScrollbar": {
"graph": "g1",
"scrollbarHeight": 60,
"backgroundAlpha": 0,
"selectedBackgroundAlpha": 0.1,
"selectedBackgroundColor": "#888888",
"graphFillAlpha": 0,
"graphLineAlpha": 0.5,
"selectedGraphFillAlpha": 0,
"selectedGraphLineAlpha": 1,
"autoGridCount": true,
"color": "#AAAAAA",
"oppositeAxis": false
                    },
  "chartCursor": {
"categoryBalloonEnabled": false,
"cursorAlpha": 0,
"zoomable": false
  },
  "categoryField": "date",
  "categoryAxis": {
"gridPosition": "start",
"gridAlpha": 0,
"tickPosition": "start",
"tickLength": 20
  },
  "export": {
"enabled": true
  }
} );          
            }
            catch( e ) {
              console.log( e );
            }
</script>