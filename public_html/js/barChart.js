$(document).ready(function(){
    $.ajax({
      url: "../library/empRatingData.php?emp=" + employer,
      method: "GET",
      success: function(data) {
        var rating = [];
        var value = [];

        var ratingsData = JSON.parse(data);
        console.log(ratingsData);
  
        for(var i in ratingsData) {
          rating.push(ratingsData[i].rating);
          value.push(ratingsData[i].value);
        }
  
        var chartdata = {
          labels: rating,
          datasets : [
            {
              label: '',
              backgroundColor: ["#48d1cc", "#8e5ea2","#7fff00","#ff8c00","#dc143c",
                                "#6495ed", "#ffd700","#00ff7f","#ff69b4","#4b0092"],
              data: value
            }
          ]
        };
  
        var ctx = document.getElementById('empRating-bChart').getContext('2d');
  
        var barGraph = new Chart(ctx, {
          type: 'bar',
          data: chartdata,
          options: {
            plugins: {
                legend: {
                    display: false  // hide label at the top
                }
            },

            // fix y axis max value
            responsive: true,
            scales: {
            y: {
                beginAtZero: true,
                max: 5
                }
            }
          }
        });
      },
      error: function(data) {
        console.log("error");
        console.log(data);
      }
    });
  });
