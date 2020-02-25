<div class="wrap">
    <form action="<?php echo esc_url(admin_url('admin.php')); ?>" method="GET" class="njt-fbpr-analytics-choose-account-frm">
        <input type="hidden" name="page" value="<?php echo $page_slug; ?>">
        <div class="njt-fb-pr-row">
            <div class="njt-fb-pr-col-12">
                <label for="account">
                    <?php _e('Choose Account: ', NJT_FB_PR_I18N); ?>
                </label>
                <select name="account" id="account" style="width: 200px;">
                    <?php
                    foreach ($admins as $admin_k => $admin_v) {
                        echo sprintf('<option value="%1$s" %2$s>%3$s (%1$s)</option>', $admin_k, selected($admin_k, $admin_id, false), $admin_v);
                    }
                    ?>
                </select>
                <label for="page_id">
                    <?php _e('Choose Page: ', NJT_FB_PR_I18N); ?>
                </label>
                <select name="page_id" id="page_id" style="width: 200px;">
                    <?php
                    foreach ($pages as $page_k => $page_v) {
                        echo sprintf('<option value="%1$s" %2$s>%3$s</option>', $page_v->sql_post_id, selected($page_v->sql_post_id, $page_id, false), $page_v->page_name);
                    }
                    ?>
                </select>

                <label for="year">
                    <?php _e('Choose Year: ', NJT_FB_PR_I18N); ?>
                </label>
                <select name="year" id="year" style="width: 200px;">
                    <?php
                    foreach ($years as $year_k => $year_v) {
                        echo sprintf('<option value="%1$s" %2$s>%3$s</option>', $year_v, selected($year_v, $year, false), $year_v);
                    }
                    ?>
                </select>
                <?php /*
                <input style="display: none" type="text" name="date" value="<?php echo esc_attr($date); ?>" class="njt-fbpr-input-date" placeholder="<?php esc_attr(_e('Choose date', NJT_FB_PR_I18N)); ?>" />
                */ ?>
                <button type="submit" class="button button-primary"><?php _e('Submit', NJT_FB_PR_I18N); ?></button>
            </div>  
        </div>
    </form>
</div>
<div style="width:100%;">
    <canvas id="canvas"></canvas>
</div>
<script>
    window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };
    var ctx = document.getElementById("canvas").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            datasets: <?php echo $analytics; ?>
        },
        options: {
            responsive: true,
            title:{
                display:true,
                text:'Auto Reply Chart'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Month'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Count'
                    }
                }]
            }
        }
    });
</script>