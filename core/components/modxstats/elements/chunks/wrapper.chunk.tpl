<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MODX Community Statistics</title>

    <link href="[[+assets_url]]css/stats.css" rel="stylesheet">
    <link href="[[+assets_url]]rickshaw/rickshaw.min.css" rel="stylesheet">
</head>
<body>

<header>
    <h1>MODX Community Statistics</h1>
</header>

<div class="block-wrapper">
    <div class="block block-recent-posts">
        <div class="inner">
            <h2>Number of Recent Posts</h2>
            <p class="description">The Recent Posts forum page shows all posts that happened in the last 42 days. By keeping track of this metric you can get a good idea of the long term continued activity and how this fluctuates over time. </p>
            <div class="graph-container" id="graph-recent-posts">
                <div class="y_axis"></div>
                <div class="chart"></div>
            </div>
        </div>
    </div>
    <div class="block block-number-members">
        <div class="inner">
            <h2>Number of Members</h2>
            <p class="description">The absolute number of registered users on the MODX forums. </p>
            <div class="graph-container" id="graph-total-members">
                <div class="y_axis"></div>
                <div class="chart"></div>
            </div>
        </div>
    </div>
    <div class="block block-number-posts">
        <div class="inner">
            <h2>Number of Posts</h2>
            <p class="description">The absolute number of posts. </p>
            <div class="graph-container" id="graph-total-posts">
                <div class="y_axis"></div>
                <div class="chart"></div>
            </div>
        </div>
    </div>
    <div class="block block-number-threads">
        <div class="inner">
            <h2>Number of Threads</h2>
            <p class="description">The absolute number of threads on the forum. </p>
            <div class="graph-container" id="graph-total-threads">
                <div class="y_axis"></div>
                <div class="chart"></div>
            </div>
        </div>
    </div>
</div>

<h3>Raw Stats</h3>
<table>
    <thead>
    <tr>
        <td>Date</td>
        <td>Posts in last 42 days</td>
        <td>Post Count</td>
        <td>Thread Count</td>
        <td>Member Count</td>
    </tr>
    </thead>
    <tbody>
        [[+forum_totals]]
    </tbody>
</table>



<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="[[+assets_url]]/rickshaw/vendor/d3.min.js"></script>
<script src="[[+assets_url]]/rickshaw/vendor/d3.layout.min.js"></script>
<script src="[[+assets_url]]/rickshaw/rickshaw.min.js"></script>

<script>
$(document).on('ready', function() {
    // Fix block heights so they appear nicely side by side
    function newGraph (holder, dataUrl, series) {
        return new Rickshaw.Graph.Ajax({
            element: holder.find('.chart').get(0),
            min: 'auto',
            width: holder.width() - 50, // 50px padding from the y-axis
            height: 250,
            dataURL: dataUrl,
            onData: function (d) {
                //d[0].data = data;
                return d
            },
            onComplete: function (transport) {
                var graph = transport.graph;
                var detail = new Rickshaw.Graph.HoverDetail({
                    graph: graph,
                    yFormatter: function(y) {
                        return formatNumber(y);
                    }
                });

                var x_axis = new Rickshaw.Graph.Axis.Time({ graph: graph });
                x_axis.render();

                var y_axis = new Rickshaw.Graph.Axis.Y({
                    graph: graph,
                    orientation: 'left',
                    tickFormat: Rickshaw.Fixtures.Number.formatKMBT,
                    element: holder.find('.y_axis').get(0)
                });
                y_axis.render();
            },
            series: series
        });
    };

    newGraph($('#graph-recent-posts'), '[[+assets_url]]connector.php?action=web/stats/forum/recent', [
        {
            name: 'Recent Posts',
            color: '#c05020'
        }
    ]);
    newGraph($('#graph-total-members'), '[[+assets_url]]connector.php?action=web/stats/forum/members', [
        {
            name: 'Total # of Members',
            color: '#c05020'
        }
    ]);
    newGraph($('#graph-total-posts'), '[[+assets_url]]connector.php?action=web/stats/forum/posts', [
        {
            name: 'Posts',
            color: '#c05020'
        }
    ]);
    newGraph($('#graph-total-threads'), '[[+assets_url]]connector.php?action=web/stats/forum/threads', [
        {
            name: 'Threads',
            color: '#c05020'
        }
    ]);

    function formatNumber(num) {
        var parts = num.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    };
});
</script>

</body>
</html>
