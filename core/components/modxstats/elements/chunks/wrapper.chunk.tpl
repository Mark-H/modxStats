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
    <a href="#community-stats">
        <div class="full-strip vanity title-bar">
            <div class="focus">
                <h1>MODX Community Statistics <time datetime="2014-06-07">Since June 7th, 2014</time> </h1>
            </div>
        </div>
    </a>
    <div class="vanity">
        <div class="focus padded">
            <p>At the end of each hour we fire off a request to the MODX Forums and the GitHub API to retrieve some key metrics about the MODX Community activity. These statistics are then stored and shown to you, right here. Scroll to the bottom of the page to find the raw numbers.</p>
            <p>Help improve this page! <a href="https://github.com/Mark-H/modxStats">Fork the repo on GitHub</a>, we very much appreciate pull requests. Some welcome improvements include..</p>
            <ul class="disc">
                <li>Taking the data and turning it into something more meaningful (week-over-week growth, for example)</li>
                <li>Design improvements</li>
                <li>Perhaps a way to download data; it is currently shown at the bottom in a simple table, but that will become unwieldy as more data is collected.</li>
            </ul>
        </div>
    </div>
</header>

<main class="vanity" id="community-stats">
    <div class="focus">
        <div class="block-wrapper">
            <div class="block block-recent-posts">
                <div class="inner">
                    <h2 id="recent-posts">Number of Recent Posts</h2>
                    <p class="description">The Recent Posts forum page shows all posts that happened in the last 42 days. By keeping track of this metric you can get a good idea of the long term continued activity and how this fluctuates over time. </p>
                    <div class="graph-container" id="graph-recent-posts">
                        <div class="y_axis"></div>
                        <div class="chart"></div>
                        <noscript>We're sorry, your browser does not support SVG graphics. <a href="http://caniuse.com/svg">Learn&nbsp;more</a>.</noscript>
                    </div>
                </div>
            </div>
            <div class="block block-number-members">
                <div class="inner">
                    <h2 id="number-of-members">Number of Members</h2>
                    <p class="description">The absolute number of registered users on the MODX forums. </p>
                    <div class="graph-container" id="graph-total-members">
                        <div class="y_axis"></div>
                        <div class="chart"></div>
                        <noscript>We're sorry, your browser does not support SVG graphics. <a href="http://caniuse.com/svg">Learn&nbsp;more</a>.</noscript>
                    </div>
                </div>
            </div>
            <div class="block block-number-posts">
                <div class="inner">
                    <h2 id="number-of-posts">Number of Posts</h2>
                    <p class="description">The absolute number of posts. </p>
                    <div class="graph-container" id="graph-total-posts">
                        <div class="y_axis"></div>
                        <div class="chart"></div>
                        <noscript>We're sorry, your browser does not support SVG graphics. <a href="http://caniuse.com/svg">Learn&nbsp;more</a>.</noscript>
                    </div>
                </div>
            </div>
            <div class="block block-number-threads">
                <div class="inner">
                    <h2 id="number-of-threads">Number of Threads</h2>
                    <p class="description">The absolute number of threads on the forum. </p>
                    <div class="graph-container" id="graph-total-threads">
                        <div class="y_axis"></div>
                        <div class="chart"></div>
                        <noscript>We're sorry, your browser does not support SVG graphics. <a href="http://caniuse.com/svg">Learn&nbsp;more</a>.</noscript>
                    </div>
                </div>
            </div>
            <div class="block block-number-github-open">
                <div class="inner">
                    <h2 id="open-issues-and-pull-requests">Open Issues &amp; Pull Requests</h2>
                    <p class="description">Find out what issues and pull requests are waiting to be addressed. We started tracking GitHub issues and pull requests on June 10th, 2014.</p>
                    <div class="graph-container" id="graph-total-github-open">
                        <div class="y_axis"></div>
                        <div class="chart"></div>
                        <noscript>We're sorry, your browser does not support SVG graphics. <a href="http://caniuse.com/svg">Learn&nbsp;more</a>.</noscript>
                    </div>
                </div>
            </div>
            <div class="block block-number-github-closed">
                <div class="inner">
                    <h2 id="closed-issues-and-pull-requests">Closed Issues &amp; Pull Requests</h2>
                    <p class="description">Shows you recent activity in terms of closing issues and pull requests. We started tracking GitHub issues and pull requests on June 10th, 2014.</p>
                    <div class="graph-container" id="graph-total-github-closed">
                        <div class="y_axis"></div>
                        <div class="chart"></div>
                        <noscript>We're sorry, your browser does not support SVG graphics. <a href="http://caniuse.com/svg">Learn&nbsp;more</a>.</noscript>
                    </div>
                </div>
            </div>
        </div>

        <div class="block-wrapper">
            <div class="block-raw-forum-stats">
                <h3>Raw Forum Stats</h3>
				<style type="text/css">
				  .raw-forum-stats td:nth-of-type(1):before { content: "Date"; }
				  .raw-forum-stats td:nth-of-type(2):before { content: "Posts in last 42 days"; }
				  .raw-forum-stats td:nth-of-type(3):before { content: "Post Count"; }
                  .raw-forum-stats td:nth-of-type(4):before { content: "Thread Count"; }
                  .raw-forum-stats td:nth-of-type(5):before { content: "Member Count"; }
				</style>
                <table class="raw-forum-stats">
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
                        [[+forum_stats]]
                    </tbody>
                </table>
            </div>
        </div>
        <div class="block-wrapper">
            <div class="block-raw-github-stats">
                <h3>Raw GitHub Stats</h3>
				<style type="text/css">
				  .raw-github-stats td:nth-of-type(1):before { content: "Date"; }
				  .raw-github-stats td:nth-of-type(2):before { content: "Open Issues"; }
				  .raw-github-stats td:nth-of-type(3):before { content: "Open Pull Requests"; }
                  .raw-github-stats td:nth-of-type(4):before { content: "Closed Issues"; }
                  .raw-github-stats td:nth-of-type(5):before { content: "Closed Pull Requests"; }
				</style>
                <table class="raw-github-stats">
                    <thead>
                    <tr>
                        <td>Date</td>
                        <td>Open Issues</td>
                        <td>Open Pull Requests</td>
                        <td>Closed Issues</td>
                        <td>Closed Pull Requests</td>
                    </tr>
                    </thead>
                    <tbody>
                        [[+github_stats]]
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="[[+assets_url]]rickshaw/vendor/d3.min.js"></script>
<script src="[[+assets_url]]rickshaw/vendor/d3.layout.min.js"></script>
<script src="[[+assets_url]]rickshaw/rickshaw.min.js"></script>

<script>
$(document).on('ready', function() {
    // Fix block heights so they appear nicely side by side
    function newGraph (holder, dataUrl, series, options) {
        options = options || { };
        options = $.extend({ }, {
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
        }, options);
        return new Rickshaw.Graph.Ajax(options);
    };

    newGraph($('#graph-recent-posts'), '[[+assets_url]]connector.php?action=web/stats/forum/recent', [
        {
            name: 'Recent Posts',
            color: '#f68e1e'
        }
    ]);
    newGraph($('#graph-total-members'), '[[+assets_url]]connector.php?action=web/stats/forum/members', [
        {
            name: 'Total # of Members',
            color: '#f68e1e'
        }
    ]);
    newGraph($('#graph-total-posts'), '[[+assets_url]]connector.php?action=web/stats/forum/posts', [
        {
            name: 'Posts',
            color: '#f68e1e'
        }
    ]);
    newGraph($('#graph-total-threads'), '[[+assets_url]]connector.php?action=web/stats/forum/threads', [
        {
            name: 'Threads',
            color: '#f68e1e'
        }
    ]);
    newGraph($('#graph-total-github-open'), '[[+assets_url]]connector.php?action=web/stats/github/open', [
        {
            name: 'Open Pull Requests',
            color: '#0c0502'
        },{
            name: 'Open Issues',
            color: '#f68e1e'
        },
    ], {
        min: 0
    });
    newGraph($('#graph-total-github-closed'), '[[+assets_url]]connector.php?action=web/stats/github/closed', [
        {
            name: 'Closed Pull Requests',
            color: '#0c0502'
        },{
            name: 'Closed Issues',
            color: '#f68e1e'
        },
    ], {
        min: 0
    });

    function formatNumber(num) {
        var parts = num.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    };
});
</script>

</body>
</html>
