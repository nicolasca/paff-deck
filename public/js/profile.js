$(function() {

if( $("#profile-page").length) {
  var url = $("#url").val();
  var userId = window.location.href.substring(window.location.href .lastIndexOf('/') + 1);
  $.getJSON(url+"/profil/chart/"+userId, function (result) {

  var ctx = document.getElementById("myChart").getContext('2d');

  var labels = [],data=[], colors = [];
    for (var faction in result ) {
           labels.push(faction);
           data.push(result[faction].length);
           colors.push(_random_rgba(0.6));
    }

  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: labels,
          datasets: [{
              data: data,
              borderWidth: 1,
              backgroundColor: colors
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true,
                      stepSize: 1
                  },
                  scaleLabel: {
                    display: true,
                    labelString: "Nombre de decks"
                  }
              }],
              xAxes: [{
                  ticks: {
                    autoSkip: false
                  }
              }]
          },
          tooltips: {
            enabled: false
          },
          legend: {
            display: false
          }
      }
      });

      });


      function _random_rgba(opacity) {
          var o = Math.round, r = Math.random, s = 255;
          return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + opacity + ')';
      }
    }

});
