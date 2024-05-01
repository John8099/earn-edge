<?php include("../backend/nodes.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("./components/head.php"); ?>

</head>

<body class="app">
  <?php include("./components/sidebar.php") ?>

  <div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
      <div class="container-xl">

        <h1 class="app-page-title">Dashboard</h1>

        <div class="row g-4 mb-4">
          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Total Sales</h4>
                <div class="stats-figure">₱ <?= number_format(getTotalSales(), 2) ?></div>

              </div><!--//app-card-body-->
            </div><!--//app-card-->
          </div><!--//col-->

          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Today Sales</h4>
                <div class="stats-figure">₱ <?= number_format(getTodayTotalSales(), 2) ?></div>

              </div><!--//app-card-body-->
            </div><!--//app-card-->
          </div><!--//col-->
          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Pending Orders</h4>
                <div class="stats-figure"><?= getCountPendingOrder() ?></div>

              </div><!--//app-card-body-->
            </div><!--//app-card-->
          </div><!--//col-->
          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Preparing Orders</h4>
                <div class="stats-figure"><?= getCountPreparingOrder() ?></div>

              </div><!--//app-card-body-->

            </div><!--//app-card-->
          </div><!--//col-->
        </div><!--//row-->

        <div class="row g-4 mb-4">
          <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
              <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto">
                    <h4 class="app-card-title">Monthly Sales</h4>
                  </div><!--//col-->

                </div><!--//row-->
              </div><!--//app-card-header-->
              <div class="app-card-body p-3 p-lg-4">

                <div class="chart-container">
                  <canvas id="canvas-linechart"></canvas>
                </div>
              </div><!--//app-card-body-->
            </div><!--//app-card-->
          </div><!--//col-->
          <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
              <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto">
                    <h4 class="app-card-title">Weekly Sales</h4>
                  </div><!--//col-->
                </div><!--//row-->
              </div><!--//app-card-header-->
              <div class="app-card-body p-3 p-lg-4">
                <div class="mb-3 d-flex">
                  <?php
                  $months = array(
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December"
                  );
                  ?>
                  <select class="form-select form-select-sm ms-auto d-inline-flex w-auto" id="selectWeekSales">
                    <?php foreach ($months as $month) : ?>
                      <option value="<?= array_search($month, $months) + 1 ?>" <?= date("F") == $month ? "selected" : "" ?>>
                        <?= $month ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="chart-container">
                  <canvas id="canvas-weekly"></canvas>
                </div>
              </div><!--//app-card-body-->
            </div><!--//app-card-->
          </div><!--//col-->

        </div><!--//row-->

        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
              <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto">
                    <h4 class="app-card-title">Monthly Total Orders</h4>
                  </div><!--//col-->

                </div><!--//row-->
              </div><!--//app-card-header-->
              <div class="app-card-body p-3 p-lg-4">
                <div class="chart-container">
                  <canvas id="canvas-barchart"></canvas>
                </div>
              </div><!--//app-card-body-->
            </div><!--//app-card-->
          </div><!--//col-->
          <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
              <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto">
                    <h4 class="app-card-title">Weekly Orders</h4>
                  </div><!--//col-->

                </div><!--//row-->
              </div><!--//app-card-header-->
              <div class="app-card-body p-3 p-lg-4">
                <div class="mb-3 d-flex">
                  <select class="form-select form-select-sm ms-auto d-inline-flex w-auto" id="selectWeekOrders">
                    <?php foreach ($months as $month) : ?>
                      <option value="<?= array_search($month, $months) + 1 ?>" <?= date("F") == $month ? "selected" : "" ?>>
                        <?= $month ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="chart-container">
                  <canvas id="canvas-weekly-orders"></canvas>
                </div>
              </div><!--//app-card-body-->
            </div><!--//app-card-->
          </div><!--//col-->
        </div>

      </div><!--//container-fluid-->
    </div><!--//app-content-->


  </div><!--//app-wrapper-->


  <?php include("./components/scripts.php") ?>
  <script>
    window.chartColors = {
      green: '#75c181',
      gray: '#a9b5c9',
      text: '#252930',
      border: '#e7e9ed'
    };

    var randomDataPoint = function() {
      return Math.round(Math.random() * 10000)
    };

    const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    var lineChartConfig = {
      type: 'line',

      data: {
        labels: labels,

        datasets: [{
          label: 'Sales',
          fill: false,
          backgroundColor: window.chartColors.green,
          borderColor: window.chartColors.green,
          data: [
            "<?= getLineChartData('2024-01-01') ?>",
            "<?= getLineChartData('2024-02-01') ?>",
            "<?= getLineChartData('2024-03-01') ?>",
            "<?= getLineChartData('2024-04-01') ?>",
            "<?= getLineChartData('2024-05-01') ?>",
            "<?= getLineChartData('2024-06-01') ?>",
            "<?= getLineChartData('2024-07-01') ?>",
            "<?= getLineChartData('2024-08-01') ?>",
            "<?= getLineChartData('2024-09-01') ?>",
            "<?= getLineChartData('2024-10-01') ?>",
            "<?= getLineChartData('2024-11-01') ?>",
            "<?= getLineChartData('2024-12-01') ?>"
          ],
        }]
      },
      options: {
        responsive: true,
        aspectRatio: 1.5,

        legend: {
          display: true,
          position: 'bottom',
          align: 'end',
        },

        tooltips: {
          mode: 'index',
          intersect: false,
          titleMarginBottom: 10,
          bodySpacing: 10,
          xPadding: 16,
          yPadding: 16,
          borderColor: window.chartColors.border,
          borderWidth: 1,
          backgroundColor: '#fff',
          bodyFontColor: window.chartColors.text,
          titleFontColor: window.chartColors.text,
          callbacks: {
            label: function(tooltipItem, data) {
              if (parseInt(tooltipItem.value) >= 1000) {
                return "₱ " + parseInt(tooltipItem.value).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
              } else {
                return '₱ ' + parseInt(tooltipItem.value).toFixed(2);
              }
            }
          },

        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            gridLines: {
              drawBorder: false,
              color: window.chartColors.border,
            },
            scaleLabel: {
              display: false,

            }
          }],
          yAxes: [{
            display: true,
            gridLines: {
              drawBorder: false,
              color: window.chartColors.border,
            },
            scaleLabel: {
              display: false,
            },
            ticks: {
              beginAtZero: true,
              userCallback: function(value, index, values) {
                return '₱' + value.toLocaleString();
              }
            },
          }]
        }
      }
    };
    var barChartConfig = {
      type: 'bar',

      data: {
        labels: labels,
        datasets: [{
          label: 'Orders',
          backgroundColor: window.chartColors.green,
          borderColor: window.chartColors.green,
          borderWidth: 1,
          // maxBarThickness: ,
          height: 100,
          width: 100,

          data: [
            "<?= getBarChartData('2024-01-01') ?>",
            "<?= getBarChartData('2024-02-01') ?>",
            "<?= getBarChartData('2024-03-01') ?>",
            "<?= getBarChartData('2024-04-01') ?>",
            "<?= getBarChartData('2024-05-01') ?>",
            "<?= getBarChartData('2024-06-01') ?>",
            "<?= getBarChartData('2024-07-01') ?>",
            "<?= getBarChartData('2024-08-01') ?>",
            "<?= getBarChartData('2024-09-01') ?>",
            "<?= getBarChartData('2024-10-01') ?>",
            "<?= getBarChartData('2024-11-01') ?>",
            "<?= getBarChartData('2024-12-01') ?>"
          ]
        }]
      },
      options: {
        responsive: true,
        aspectRatio: 1.5,
        legend: {
          position: 'bottom',
          align: 'end',
        },
        tooltips: {
          mode: 'index',
          intersect: false,
          titleMarginBottom: 10,
          bodySpacing: 10,
          xPadding: 16,
          yPadding: 16,
          borderColor: window.chartColors.border,
          borderWidth: 1,
          backgroundColor: '#fff',
          bodyFontColor: window.chartColors.text,
          titleFontColor: window.chartColors.text,

        },
        scales: {
          xAxes: [{
            display: true,
            gridLines: {
              drawBorder: false,
              color: window.chartColors.border,
            },

          }],
          yAxes: [{
            display: true,
            gridLines: {
              drawBorder: false,
              color: window.chartColors.borders,
            },


          }]
        }

      }
    }

    function weekCount(year, month_number) {

      var firstOfMonth = new Date(year, month_number - 1, 1);
      var lastOfMonth = new Date(year, month_number, 0);

      var used = firstOfMonth.getDay() + lastOfMonth.getDate();

      return Math.ceil(used / 7);
    }

    const salesWeekCount = weekCount(2024, Number($("#selectWeekSales").val()));
    const selectWeekOrders = weekCount(2024, Number($("#selectWeekOrders").val()));

    const weeklySalesLabel = [];
    const weeklyOrdersLabel = [];

    for (let i = 0; i < salesWeekCount; i++) {
      weeklySalesLabel.push(`Week ${i+1}`);
    }

    for (let i = 0; i < selectWeekOrders; i++) {
      weeklyOrdersLabel.push(`Week ${i+1}`);
    }

    var weeklySalesConfig = {
      type: 'line',

      data: {
        labels: weeklySalesLabel,

        datasets: [{
          label: 'Sales',
          fill: false,
          backgroundColor: window.chartColors.green,
          borderColor: window.chartColors.green,
          data: [],
        }]
      },
      options: {
        responsive: true,
        aspectRatio: 1.5,

        legend: {
          display: true,
          position: 'bottom',
          align: 'end',
        },

        tooltips: {
          mode: 'index',
          intersect: false,
          titleMarginBottom: 10,
          bodySpacing: 10,
          xPadding: 16,
          yPadding: 16,
          borderColor: window.chartColors.border,
          borderWidth: 1,
          backgroundColor: '#fff',
          bodyFontColor: window.chartColors.text,
          titleFontColor: window.chartColors.text,
          callbacks: {
            label: function(tooltipItem, data) {
              if (parseInt(tooltipItem.value) >= 1000) {
                return "₱ " + parseInt(tooltipItem.value).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
              } else {
                return '₱ ' + parseInt(tooltipItem.value).toFixed(2);
              }
            }
          },

        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            gridLines: {
              drawBorder: false,
              color: window.chartColors.border,
            },
            scaleLabel: {
              display: false,

            }
          }],
          yAxes: [{
            display: true,
            gridLines: {
              drawBorder: false,
              color: window.chartColors.border,
            },
            scaleLabel: {
              display: false,
            },
            ticks: {
              beginAtZero: true,
              userCallback: function(value, index, values) {
                return '₱' + value.toLocaleString();
              }
            },
          }]
        }
      }
    };

    var weeklyOrdersConfig = {
      type: 'bar',

      data: {
        labels: weeklyOrdersLabel,
        datasets: [{
          label: 'Orders',
          backgroundColor: window.chartColors.green,
          borderColor: window.chartColors.green,
          borderWidth: 1,
          data: []
        }]
      },
      options: {
        responsive: true,
        aspectRatio: 1.5,
        legend: {
          position: 'bottom',
          align: 'end',
        },
        tooltips: {
          mode: 'index',
          intersect: false,
          titleMarginBottom: 10,
          bodySpacing: 10,
          xPadding: 16,
          yPadding: 16,
          borderColor: window.chartColors.border,
          borderWidth: 1,
          backgroundColor: '#fff',
          bodyFontColor: window.chartColors.text,
          titleFontColor: window.chartColors.text,

        },
        scales: {
          xAxes: [{
            display: true,
            gridLines: {
              drawBorder: false,
              color: window.chartColors.border,
            },

          }],
          yAxes: [{
            display: true,
            gridLines: {
              drawBorder: false,
              color: window.chartColors.borders,
            },


          }]
        }

      }
    }

    var lineChartEl = document.getElementById('canvas-linechart').getContext('2d');
    var lineChart = new Chart(lineChartEl, lineChartConfig);

    var barChartEl = document.getElementById('canvas-barchart').getContext('2d');
    var barChart = new Chart(barChartEl, barChartConfig);

    var weekSalesEl = document.getElementById('canvas-weekly').getContext('2d');
    var weeklySales = new Chart(weekSalesEl, weeklySalesConfig);

    var weeklyOrdersEl = document.getElementById('canvas-weekly-orders').getContext('2d');
    var weeklyOrders = new Chart(weeklyOrdersEl, weeklyOrdersConfig);

    getWeekSalesData()
    getWeeklyOrdersData()

    function getWeekSalesData() {
      $.post("<?= SERVER_NAME . "/backend/nodes?action=get_week_sales" ?>", {
        month: $("#selectWeekSales").val(),
      }, (data, status) => {
        const resp = JSON.parse(data);

        const salesWeekCount = weekCount(2024, Number($("#selectWeekSales").val()));
        const weeklySalesLabel = [];

        for (let i = 0; i < salesWeekCount; i++) {
          weeklySalesLabel.push(`Week ${i+1}`);
        }

        weeklySales.data.labels = weeklySalesLabel;
        weeklySales.data.datasets[0].data = resp.totals

        weeklySales.update();

      }).fail(function(e) {
        swal.fire({
          title: "Error!",
          html: e.statusText,
          icon: "error",
        });
      });
    }

    function getWeeklyOrdersData() {
      $.post("<?= SERVER_NAME . "/backend/nodes?action=get_week_orders" ?>", {
        month: $("#selectWeekOrders").val(),
      }, (data, status) => {
        const resp = JSON.parse(data);

        const selectWeekOrders = weekCount(2024, Number($("#selectWeekOrders").val()));
        const weeklyOrdersLabel = [];

        for (let i = 0; i < selectWeekOrders; i++) {
          weeklyOrdersLabel.push(`Week ${i+1}`);
        }

        weeklyOrders.data.labels = weeklyOrdersLabel;
        weeklyOrders.data.datasets[0].data = resp.orders

        weeklyOrders.update();

      }).fail(function(e) {
        swal.fire({
          title: "Error!",
          html: e.statusText,
          icon: "error",
        });
      });
    }

    $("#selectWeekSales").on("change", function(e) {
      getWeekSalesData()
    })
    
    $("#selectWeekOrders").on("change", function(e) {
      getWeeklyOrdersData()
    })
  </script>
</body>

</html>