</div>
</div>
</div>
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/sidebarmenu.js"></script>
<script src="assets/js/app.min.js"></script>
<script src="assets/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="assets/libs/simplebar/dist/simplebar.js"></script>
<script>
    makechart();

    function makechart() {
        $.ajax({
            url: "admin-index.php",
            method: "POST",
            data: {
                action: 'fetch'
            },
            dataType: "JSON",
            success: function(data) {
                var category = [];
                var total = [];
                var color = [];

                for (var count = 0; count < data.length; count++) {
                    category.push(data[count].category);
                    total.push(data[count].total);
                    color.push(data[count].color);
                }
                var chart_data = {
                    labels: category,
                    datasets: [{
                        label: 'Category',
                        backgroundColor: color,
                        color: '#fff',
                        data: total

                    }]
                };
                var options = {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0
                            }
                        }]
                    }
                };
                //for pie chart
                var group_chart1 = $('#pie_chart');
                var graph1 = new Chart(group_chart1, {
                    type: "pie",
                    data: chart_data
                });

                //for doughnut chart
                var group_chart2 = $('#doughnut_chart');
                var graph2 = new Chart(group_chart2, {
                    type: "doughnut",
                    data: chart_data
                });

                //for bar chart
                var group_chart3 = $('#bar_chart');
                var graph3 = new Chart(group_chart3, {
                    type: "bar",
                    data: chart_data,
                    options: options
                });
            }

        })
    }
</script>
<script src="assets\js\dashboard.js"></script>



</body>

</html>