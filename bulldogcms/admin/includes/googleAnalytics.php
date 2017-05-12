<?php
$siteSettingsQuery = "SELECT * FROM siteSettings WHERE siteSettingID = '1'";
$selectSiteSettings = mysqli_query($connection, $siteSettingsQuery);
while($row = mysqli_fetch_assoc($selectSiteSettings)) {
    $googleAnalyticsID = $row['googleAnalyticsID'];
    $gaClientID = $row['gaClientID'];
    $gaViewID = $row['gaViewID'];
}

?>
<h1 class="page-header">Google Analytics</h1>
<p><b>Note:</b>  If you do not see an <b>Access Google Analytics</b> button or Google Analytics graphs, you may be logged into Google with an account that does
 not have access to the Google Analytics for this site.  Go to Google and log out of the account and log back in with account that has Google Analytics
 access to this website.</p>


<!-- Step 1: Create the containing elements. -->
<div class="row">
    <section id="auth-button"></section>
     <div class="col-xs-12 col-md-6">
         <!--<h6>Sessions over the last month</h6>-->
        <section id="timeline"></section>
     </div>
    <div class="col-xs-12 col-md-6">
         <!--<h6>Devices used by Users over the last month</h6>-->
        <section id="browserChart"></section>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <h4>Number of sessions in each region and city</h4>
        <section id="cityChart"></section>
    </div>
    <div class="col-xs-12 col-md-6">
        <h4>Time in seconds Users spend on Average on each page</h4>
        <section id="viewChart"></section>
    </div>

</div>



<script>
    (function(w,d,s,g,js,fjs){
        g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
        js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
        js.src='https://apis.google.com/js/platform.js';
        fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
    }(window,document,'script'));
</script>

<script>
    gapi.analytics.ready(function() {

        // Step 3: Authorize the user.

        var CLIENT_ID = '<?php echo $gaClientID ?>';
        //var CLIENT_ID = '418812939384-rnld9pa7s27cfh74npo80lldhknm6s1q.apps.googleusercontent.com';

        gapi.analytics.auth.authorize({
            container: 'auth-button',
            clientid: CLIENT_ID,
            userInfoLabel:""
        });

        // Step 5: Create the timeline chart.
        var  timeline = new gapi.analytics.googleCharts.DataChart({
            reportType: 'ga',
            query: {
                'dimensions': 'ga:date',
                'metrics': 'ga:sessions',
                'start-date': '30daysAgo',
                'end-date': 'yesterday',
                'ids': "ga:<?php echo $gaViewID ?>"
            },
            chart: {
                type: 'LINE',
                container: 'timeline',
                options: {
                    title: 'Sessions over the last month'
                }
            }
        });
        // Step 6: Create a table chart showing top cities used by Customers

        var cityChart = new gapi.analytics.googleCharts.DataChart({
            reportType: 'ga',
            query: {
                'ids': "ga:<?php echo $gaViewID ?>",
                'start-date': '30daysAgo',
                'end-date': 'today',
                'dimensions': 'ga:region, ga:city',
                'metrics': 'ga:sessions',
                'sort': '-ga:sessions',
                'max-results': '10'
            },
            chart: {
                type: 'TABLE',
                container: 'cityChart',
                options: {
                    title: 'User location over the last month'

                }
            }
        });
        //Step 7: Display the bar chart
        var browserChart = new gapi.analytics.googleCharts.DataChart({
            reportType: 'ga',
            query: {
                'ids': "ga:<?php echo $gaViewID ?>",
                'start-date': '30daysAgo',
                'end-date': 'today',
                'dimensions': 'ga:browser',
                'metrics': 'ga:sessions',
                'sort': '-ga:sessions'

            },
            chart: {
                type: 'BAR',
                container: 'browserChart',
                options: {
                    title: 'Devices used by Users over the last month'

                }
            }
        });
        //Step 8: Provide table to show what parts of the website receive the most traffic
        var viewChart = new gapi.analytics.googleCharts.DataChart({
            reportType: 'ga',
            query: {
                'ids': "ga:<?php echo $gaViewID ?>",
                'start-date': '30daysAgo',
                'end-date': 'today',
                'metrics': 'ga:avgTimeOnPage',
                'dimensions': 'ga:pagePath',
                'sort': '-ga:avgTimeOnPage',
                'max-results': '10'


            },
            chart: {
                type: 'TABLE',
                container: 'viewChart',
                options: {
                    title: 'Time in seconds Users spend on Average on each page'

                }

            }
        });

        // Step 9:
        gapi.analytics.auth.on('success', function(response) {
            //hide the auth-button
            document.querySelector("#auth-button").style.display='none';

            timeline.execute();
            cityChart.execute();
            browserChart.execute();
            viewChart.execute();


        });

    });



</script>

<!-- ----------------------------------------------------
<h1 class="page-header">Google Analytics</h1>
-->

<!-- Step 1: Create the containing elements. -->

<!--
<section id="auth-button"></section>
<section id="timeline"></section>
-->

<!-- Step 2: Load the library. -->

<!--
<script>
(function(w,d,s,g,js,fjs){
    g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
        js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
        js.src='https://apis.google.com/js/platform.js';
        fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
    }(window,document,'script'));
</script>

<script>
gapi.analytics.ready(function() {

    // Step 3: Authorize the user.

    var CLIENT_ID = '<?php echo $gaClientID ?>';
    //var CLIENT_ID = '418812939384-rnld9pa7s27cfh74npo80lldhknm6s1q.apps.googleusercontent.com';

    gapi.analytics.auth.authorize({
            container: 'auth-button',
            clientid: CLIENT_ID,
            userInfoLabel:""
        });

        // Step 5: Create the timeline chart.
        var timeline = new gapi.analytics.googleCharts.DataChart({
            reportType: 'ga',
            query: {
        'dimensions': 'ga:date',
                'metrics': 'ga:sessions',
                'start-date': '30daysAgo',
                'end-date': 'yesterday',
                'ids': "ga:<?php echo $gaViewID ?>"
                //'ids': "ga:141818993"
            },
            chart: {
        type: 'LINE',
                container: 'timeline'
            }
        });

        gapi.analytics.auth.on('success', function(response) {
            //hide the auth-button
            document.querySelector("#auth-button").style.display='none';

            timeline.execute();

        });

    });
</script>
-->