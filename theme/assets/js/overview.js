var speed = 1;
var graph_chart_revenue;
var graph_chart_sales;
var graph_chart_rankings;
var graph_chart_visits;
var chart_theme = 'office.Breeze6';

var _cat_headers = $('.table_headers_cat').html();
var _prod_headers = $('.table_headers_prod').html();

Chart.defaults.global.hover.intersect = false;

/**
 * Load DatePicker and Listener
 */
$(function() {   
    var start = moment().subtract(31, 'days');
    var end = moment().subtract(1, 'days');
    
    var datrangeconfig = {
        startDate: start,
        endDate: end,
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Bevestig",
            "cancelLabel": "Annuleren",
            "fromLabel": "Van",
            "toLabel": "Tot",
            "customRangeLabel": "Anders",
            "weekLabel": "W",
            "daysOfWeek": [
                "Zo",
                "Ma",
                "Di",
                "Wo",
                "Do",
                "Vr",
                "Za"
            ],
            "monthNames": [
                "Januari",
                "Februari",
                "Maart",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Augustus",
                "September",
                "Oktober",
                "November",
                "December"
            ],
            "firstDay": 1
        },
        ranges: {
           'Vandaag': [moment(), moment()],
           'Gisteren': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Laatste 7 dagen': [moment().subtract(7, 'days'), moment().subtract(1, 'days')],
           'Laatste 30 dagen': [moment().subtract(30, 'days'), moment().subtract(1, 'days')],
           'Deze maand': [moment().startOf('month'), moment().endOf('month')],
           'Vorige maand': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'Dit kwartaal': [moment().startOf('quarter'), moment().endOf('quarter')],
           'Dit jaar': [moment().startOf('year'), moment().endOf('year')],
        }
    };
    $('#reportrange').daterangepicker(datrangeconfig, doRefresh);
    doRefresh(start, end);
});

/**
 * Refresh statistieken pagina
 * @param {*} start 
 * @param {*} end 
 */
 function doRefresh(start, end) {
  moment.locale('nl');

  start_string = moment(start).lang("nl").format('YYYY-MM-DD');
  end_string = moment(end).lang("nl").format('YYYY-MM-DD');

  $('#reportrange span').html(moment(start).lang("nl").format('DD MMMM YYYY') + ' - ' + moment(end).lang("nl").format('DD MMMM YYYY'));
  $('#input_periode').val(moment(start).lang("nl").format('YYYY-MM-DD') + '#' + moment(end).lang("nl").format('YYYY-MM-DD'));

  var category = $('#overview_category').val();
  var level = $('#overview_level').val();
  
  var base_url = $('#js_site_url').val(); 

  $('.has-loader').addClass('has-loader-active');
  $.ajax({
      type: "POST", 
      url: base_url + "overview/stats",
      data: { start: start_string, end: end_string, category: category, level: level },
      cache: false,
      dataType: 'json',
      timeout: 100000,
      success: function (data) {
          $('.has-loader').removeClass('has-loader-active');

          // Chart Revenue
          graph_chart_revenue.data = data.Charts.RevenueSales.Revenue;
          graph_chart_revenue.update(750);

          // Chart Sales
          graph_chart_sales.data = data.Charts.RevenueSales.Sales;
          graph_chart_sales.update(750);

          // Chart Rankings
          graph_chart_rankings.data = data.Charts.RevenueSales.Rankings;
          graph_chart_rankings.update(750);

          // Chart Visits
          graph_chart_visits.data = data.Charts.RevenueSales.Visits;
          graph_chart_visits.update(750);

          // Set category table
          _cat_container = $('.table_headers');
          _cat_container.html(''); 
          _cat_container.append(_cat_headers); 
          if(data.Metrics !== undefined) {
            $.each(data.Metrics, function(key, value) {
              var conv_ration_org = (parseInt(value.CurrentOrders) / parseInt(value.CurrentProductvisits) * 100);
              var conv_ratio = round(conv_ration_org, 2);
              if(isNaN(conv_ration_org) || conv_ration_org == undefined || conv_ration_org <= 0) {
                conv_ratio = '-';
              } else {
                conv_ratio += '%';
              }

              urlslug = encodeURIComponent(value.Category);
              currentlevel = parseInt($('#overview_level').val());
              currentlevelnew = currentlevel + 1;

              if(currentlevel < 2) {
                link = '<a href="'+$('#js_site_url').val()+'overview/'+urlslug+'/'+currentlevelnew+'">'+value.Category+'</a>';
              } else {
                link = value.Category;
              }

              if(value.Category == "Total") {
                link = '<strong>Totals</strong>';
              }

              _cat_container.append('<div class="nk-tb-item">' +
                  '<div class="nk-tb-col tb-col-sm">' +
                  ' <span class="tb-lead">'+link+'</span>' +
                  '</div>' +
                  '<div class="nk-tb-col tb-col-sm">' +
                    '<span class="tb-sub">'+value.CurrentProductvisits+'</span>' +
                  '</div>' +
                  '<div class="nk-tb-col tb-col-sm">' +
                    '<span class="tb-sub">'+conv_ratio+'</span>' +
                  '</div>' +
                  '<div class="nk-tb-col tb-col-sm">' +
                    '<span class="tb-sub">'+value.CurrentOrders+'</span>' +
                  '</div>' +
                  '<div class="nk-tb-col tb-col-sm">' +
                    '<span class="tb-sub">€'+round(parseFloat(value.CurrentRevenue),2)+'</span>' +
                  '</div>' +
                  '<div class="nk-tb-col tb-col-sm">' +
                    '<span class="tb-sub">'+value.CurrentAvgRanking+'</span>' +
                  '</div>' +
              '</div>');
            });
          }

          // Check where rows is with al the Totals in it
          var keys = Object.keys(data.Metrics);
          var last = keys[keys.length-1];

          // Metric Rankings
          $('#stats_rankings .change').removeClass('text-success').removeClass('text-danger');
          if(!isNaN(data.Metrics[last].CurrentAvgRanking) > 0) {
            $('#stats_rankings .amount').html(data.Metrics[last].CurrentAvgRanking);
            var change = parseInt(data.Metrics[last].RankingChange);
            if(!isNaN(change) && change !== 0 && change != '0.00') {
              if(change > 0) {
                $('#stats_rankings .change').html('<em class="icon ni ni-arrow-long-up"></em> ' + change).addClass('text-success');
              } else {
                $('#stats_rankings .change').html('<em class="icon ni ni-arrow-long-down"></em> ' + change).addClass('text-danger');
              }
            } else {
              $('#stats_rankings .change').html('-');
            }
          } else if(data.Metrics[last].CurrentAvgRanking == NaN || data.Metrics[last].CurrentAvgRanking == undefined) {
            $('#stats_rankings .amount').html(0);
            $('#stats_rankings .change').html('0%');
          }

          // Metric Revenue
          $('#stats_revenue .change').removeClass('text-success').removeClass('text-danger');
          if(!isNaN(data.Metrics[last].CurrentRevenue) > 0) {
            $('#stats_revenue .amount').html(formatter.format(data.Metrics[last].CurrentRevenue).replace(/\s/g, ''));
            var change = parseInt(data.Metrics[last].revenueChange);
            if(!isNaN(change) && change !== 0 && change != '0.00') {
              if(change > 0) {
                $('#stats_revenue .change').html('<em class="icon ni ni-arrow-long-up"></em> ' + change + '%').addClass('text-success');
              } else {
                $('#stats_revenue .change').html('<em class="icon ni ni-arrow-long-down"></em> ' + change + '%').addClass('text-danger');
              }
            } else {
              $('#stats_revenue .change').html('-');
            }
          } else if(data.Metrics[last].CurrentRevenue == NaN || data.Metrics[last].CurrentRevenue == undefined) {
            $('#stats_revenue .amount').html(0);
            $('#stats_revenue .change').html('0%');
          }

          // Metric Sales
          $('#stats_sales .change').removeClass('text-success').removeClass('text-danger');
          if(!isNaN(data.Metrics[last].CurrentOrders)) {
            $('#stats_sales .amount').html(data.Metrics[last].CurrentOrders);
            var change = parseFloat(data.Metrics[last].orderChange).toFixed(2);
            console.log(change);
            if(!isNaN(change) && change !== 0 && change != '0.00') {
              if(change > 0) {
                $('#stats_sales .change').html('<em class="icon ni ni-arrow-long-up"></em> ' + change + '%').addClass('text-success');
              } else {
                $('#stats_sales .change').html('<em class="icon ni ni-arrow-long-down"></em> ' + change + '%').addClass('text-danger');
              }
            } else {
              $('#stats_sales .change').html('-');
            }
          } else if(data.Metrics[last].CurrentOrders == NaN || data.Metrics[last].CurrentOrders == undefined) {
            $('#stats_sales .amount').html(0);
            $('#stats_sales .change').html('0%');
          }

          // Metric Visits
          $('#stats_visits .change').removeClass('text-success').removeClass('text-danger');
          if(!isNaN(data.Metrics[last].CurrentProductvisits) > 0) {
            $('#stats_visits .amount').html(data.Metrics[last].CurrentProductvisits);
            var change = parseFloat(data.Metrics[last].visitChange).toFixed(2);
            console.log(change);
            if(!isNaN(change) && change !== 0 && change != '0.00') {
              if(change > 0) {
                $('#stats_visits .change').html('<em class="icon ni ni-arrow-long-up"></em> ' + change + '%').addClass('text-success');
              } else {
                $('#stats_visits .change').html('<em class="icon ni ni-arrow-long-down"></em> ' + change + '%').addClass('text-danger');
              }
            } else {
              $('#stats_visits .change').html('-');
            }
          } else if(data.Metrics[last].CurrentProductvisits == NaN || data.Metrics[last].CurrentProductvisits == undefined) {
            $('#stats_visits .amount').html(0);
            $('#stats_visits .change').html('0%');
          }

          // Set products table
          _cat_container_prod = $('.table_headers_prod');
          _cat_container_prod.html(''); 
          _cat_container_prod.append(_prod_headers); 
          if(data.Metrics_Products !== undefined) {
            $.each(data.Metrics_Products, function(key, value) {
              var conv_ration_org = (parseInt(value.CurrentOrders) / parseInt(value.CurrentProductvisits) * 100);
              var conv_ratio = round(conv_ration_org, 2);
              if(isNaN(conv_ration_org) || conv_ration_org == undefined || conv_ration_org <= 0) {
                conv_ratio = '-';
              } else {
                conv_ratio += '%';
              }

              if(value.Product != "Total") {
                _cat_container_prod.append('<div class="nk-tb-item">' +
                    '<div class="nk-tb-col tb-col-sm">' +
                    ' <span class="tb-lead truncated_col">'+value.Product+'</span>' +
                    '</div>' +
                    '<div class="nk-tb-col tb-col-sm">' +
                      '<span class="tb-sub">'+value.CurrentProductvisits+'</span>' +
                    '</div>' +
                    '<div class="nk-tb-col tb-col-sm">' +
                      '<span class="tb-sub">'+conv_ratio+'</span>' +
                    '</div>' +
                    '<div class="nk-tb-col tb-col-sm">' +
                      '<span class="tb-sub">'+value.CurrentOrders+'</span>' +
                    '</div>' +
                    '<div class="nk-tb-col tb-col-sm">' +
                      '<span class="tb-sub">€'+round(parseFloat(value.CurrentRevenue),2)+'</span>' +
                    '</div>' +
                    '<div class="nk-tb-col tb-col-sm">' +
                      '<span class="tb-sub">'+value.CurrentAvgRanking+'</span>' +
                    '</div>' +
                '</div>');
              }
              else
              {
                _cat_container_prod.append('');
                _cat_container_prod.append('<div class="nk-tb-item">' +

                    '<div class="nk-tb-col tb-col-sm" style="width: 500px;">' +
                    ' <span class="tb-lead truncated_col">'+value.Product+'</span>' +
                    '</div>' +
                    '<div class="nk-tb-col tb-col-sm">' +
                      '<span class="tb-sub">'+value.CurrentProductvisits+'</span>' +
                    '</div>' +
                    '<div class="nk-tb-col tb-col-sm">' +
                      '<span class="tb-sub">'+value.CurrentOrders+'</span>' +
                    '</div>' +
                    '<div class="nk-tb-col tb-col-sm">' +
                      '<span class="tb-sub">€'+round(parseFloat(value.CurrentRevenue),2)+'</span>' +
                    '</div>' +
                    '<div class="nk-tb-col tb-col-sm">' +
                      '<span class="tb-sub">'+value.CurrentAvgRanking+'</span>' +
                    '</div>' +
                '</div>');
              }

              
            });
          }

          // Notify user
          NioApp.Toast('Resport successfully updated.', 'success');
      },
      error: function (e) {
          $('.has-loader').removeClass('has-loader-active');
          NioApp.Toast('Error during refresh.', 'error');
      }
  });
}

/**
 * Format currencies to Dutch format
 */
const formatter = new Intl.NumberFormat('nl-NL', {
  style: 'currency',
  currency: 'EUR',
  minimumFractionDigits: 1
})

!(function (NioApp, $) {
  "use strict";
  
  /**
   * Chart Revenue
   */
  function load_chart_revenue() {
    var options_chart_revenue = {
        animation: {
            duration: speed * 1.5,
            easing: 'easeInOutBack'
        },
        tooltips: {
            mode: 'index',
            intersect: false
        },
        maintainAspectRatio: false,
        plugins: {
          colorschemes: {
            scheme: chart_theme
          },
        },
        legend: {
            display: true,
            position: 'top'
        },
        scales: {
            xAxes: [{
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'DD MMM'
                    }
                }
            }],
            yAxes: [{
                id: 'A',
                type: 'linear',
                position: 'left',
            }]
        }
    };
    
    /* Init Stats */
    var stats_chart_revenue = document.getElementById('chart_revenue').getContext('2d');
    graph_chart_revenue = new Chart(stats_chart_revenue, {
        type: 'line',
        options: options_chart_revenue
    });
  }
  load_chart_revenue();
  // -------------------------------------

  /**
   * Chart Sales
   */
   function load_chart_sales() {
    var options_chart_sales = {
        animation: {
            duration: speed * 1.5,
            easing: 'easeInOutBack'
        },
        tooltips: {
            mode: 'index',
            intersect: false
        },
        maintainAspectRatio: false,
        plugins: {
          colorschemes: {
            scheme: chart_theme
          },
        },
        legend: {
            display: true,
            position: 'top'
        },
        scales: {
            xAxes: [{
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'DD MMM'
                    }
                }
            }],
            yAxes: [{
                id: 'A',
                type: 'linear',
                position: 'left',
            }]
        }
    };
    
    /* Init Stats */
    var stats_chart_sales = document.getElementById('chart_sales').getContext('2d');
    graph_chart_sales = new Chart(stats_chart_sales, {
        type: 'line',
        options: options_chart_sales
    });
  }
  load_chart_sales();
  // -------------------------------------

  /**
   * Chart Rankings
   */
   function load_chart_rankings() {
    var options_chart_rankings = {
        animation: {
            duration: speed * 1.5,
            easing: 'easeInOutBack'
        },
        tooltips: {
            mode: 'index',
            intersect: false
        },
        maintainAspectRatio: false,
        plugins: {
          colorschemes: {
            scheme: chart_theme
          },
        },
        legend: {
            display: true,
            position: 'top'
        },
        scales: {
            xAxes: [{
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'DD MMM'
                    }
                }
            }],
            yAxes: [{
                id: 'A',
                type: 'linear',
                position: 'left',
            }]
        }
    };
    
    /* Init Stats */
    var stats_chart_rankings = document.getElementById('chart_rankings').getContext('2d');
    graph_chart_rankings = new Chart(stats_chart_rankings, {
        type: 'line',
        options: options_chart_rankings
    });
  }
  load_chart_rankings();
  // -------------------------------------

  /**
   * Chart Rankings
   */
   function load_chart_visits() {
    var options_chart_visits = {
        animation: {
            duration: speed * 1.5,
            easing: 'easeInOutBack'
        },
        tooltips: {
            mode: 'index',
            intersect: false
        },
        maintainAspectRatio: false,
        plugins: {
          colorschemes: {
            scheme: chart_theme
          },
        },
        legend: {
            display: true,
            position: 'top'
        },
        scales: {
            xAxes: [{
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'DD MMM'
                    }
                }
            }],
            yAxes: [{
                id: 'A',
                type: 'linear',
                position: 'left',
            }]
        }
    };
    
    /* Init Stats */
    var stats_chart_visits = document.getElementById('chart_visits').getContext('2d');
    graph_chart_visits = new Chart(stats_chart_visits, {
        type: 'line',
        options: options_chart_visits
    });
  }
  load_chart_visits();
})(NioApp, jQuery);

// Tools
function round(num, decimalPlaces = 0) {
  num = Math.round(num + "e" + decimalPlaces);
  return Number(num + "e" + -decimalPlaces);
}