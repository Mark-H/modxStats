modxStats
=========

Collects a number of stats about the MODX project and community and outputs them to the world.

Installation
============

To install modxStats, you'll need a working MODX 2.x installation running (Scheduler from modmore)[https://www.modmore.com/extras/scheduler/].

Clone the repository and create a config.core.php file in the root. Point it to your MODX core folder. **In the browser**, open the `_bootstrap/index.php` file. This will set up some settings and elements for a quick setup.

Next, open the Scheduler component in your MODX manager. There should be a task to refresh the forum totals. On the Runs tab, schedule a run for this task. After the first run, the task will automatically repeat every 24 hours to collect data about MODX.

You can use the installed modxStats snippet to output the statistics on a resource. The idea is to start graphing this data so you can start looking at trends and get a quick at a glance view of what the MODX community is up to.

License
=======

MIT. See LICENSE file.
