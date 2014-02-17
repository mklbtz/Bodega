<?php $this->load->view('page_open'); ?>
<?php if (!empty($revenue_by_category) && !empty($revenue_over_time) && !empty($possible_years)): ?>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var year_data = google.visualization.arrayToDataTable([

            <?php
            echo "['" . implode("', '", array_keys($revenue_over_time[0])) . "'],\n";
            foreach ($revenue_over_time as $row) {
                echo "['{$row[$time_unit]}', {$row['revenue']}],\n";
            }
            ?>
        ]);

        var category_data = google.visualization.arrayToDataTable([

            <?php
            echo "['" . implode("', '", array_keys($revenue_by_category[0])) . "'],\n";
            foreach ($revenue_by_category as $row) {
                echo "['{$row['category']}', {$row['revenue']}],\n";
            }
            ?>
        ]);

        var year_options = {
          title: '<?php echo "Revenue per " . ucfirst($time_unit); ?>',
          colors: ['green', 'red'],
          curveType: 'none',
          vAxis: {format: '$#,###'},
        };

        var category_options = {
          title: 'Revenue by Category',
          colors: ['green', 'red'],
          hAxis: {format: '$#,###'},
        };


        var year_chart = new google.visualization.AreaChart(document.getElementById('year_chart_div'));
        year_chart.draw(year_data, year_options);

        var category_chart = new google.visualization.BarChart(document.getElementById('category_chart_div'));
        category_chart.draw(category_data, category_options);
      }
    </script>

    <?php echo "<h2>Statistics for " . $viewing_year . "</h2>"; ?>

    <form name='yearSelect' method='get' action='<?php echo site_url('/staff/statistics/') ?>'>
        <label>View: </label>
        <select name='year' onchange='yearSelect.submit()'>
        <?php 
        foreach ($possible_years as $row) {
            $temp = "<option value='{$row['year']}'";
            if ($row['year'] == $viewing_year) $temp .= " selected";
            $temp .= ">" . $row['year'] . "</option>";
            echo $temp;
        }
        ?>
        </select>
        <select name='unit' onchange='yearSelect.submit()'>
            <option value="month" <?php if ($time_unit == 'month') echo "selected"; ?>>By Month</option>
            <option value="week"<?php if ($time_unit == 'week') echo "selected"; ?>>By Week</option>
        </select>
    </form>

    <div id="year_chart_div" style="width: 1000px; height: 500px;"></div>
    <div id="category_chart_div" style="width: 1000px; height: 500px;"></div>
<?php endif; ?>
<?php $this->load->view('page_close');?>