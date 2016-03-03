<?php
$this->start('css');
echo $this->Html->css(array(
                            '../assets/js-graph-it/js-graph-it.css',
                        ));
$this->end();
$this->start('script');
echo $this->Html->js('assets/js-graph-it/js-graph-it.js');
$this->end();
?>

<table class="main_table" style="height: 100%;" >
		<tr>
			<td width="120" style="vertical-align: top; display: none;" class="menu">
				<ul id="menu">
					<li><a href="index.html">overview</a></li>
					<li><a href="story.html">story of this project</a></li>
					<li><a href="gettingstarted.html">getting started</a></li>
					<li><a href="http://sourceforge.net/forum/?group_id=170245">forum</a></li>
					<li><a href="http://sourceforge.net/tracker/?group_id=170245&atid=853532">bugs</a></li>
					<li><a href="http://sourceforge.net/projects/js-graph-it/">download</a></li>
				</ul>
			</td>
			<td style="vertical-align: top; padding: 0px;">
				<div id="mainCanvas" class="canvas" style="width: 100%; height: 500px;">

	<h1 id="title_block" class="block draggable" style="left: 30px; top: 20px;">The story of this project</h1>

	<div id="text_me" class="block draggable" style="left: 50px; top: 100px; width: 500px;">
	<p>I work as a software engineer in an italian company (yes, I'm italian and my code is better than my english,
	so, if you find anything wrong in my writing, please report the error) and we're currently developing a
	platform for building business processes graphically by linking functional blocks that we call nodes.
	A business process is then represented on this platform as a directed graph of nodes and edges.<br/>
	For monitoring purposes we use a separate web application and we thought that it would be great to have
	the processes represented graphically in html pages.</p>
	<p>This task has been (correctly) considered "low priority" for our job, but some brainstorming about it
	was already been done and some discussions arised, so I could not resist the challenge and I started
	doing some tests at home.</p>
	<p>As the first tests succeeded, I started thinking about a general library for representing this kind of
	graphs on html pages and then decided to start an open source project on Sourceforge.</p>
	</div>

	<div class="connector title_block text_me">
		<label class="destination-label">What's the problem?</label>
		<img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif"/>
	</div>

	<div id="text_javascript" class="block draggable" style="left: 200px; top: 330px; width: 500px;">
	<p>The basic idea of the project is to draw connectors between nodes using a composition of horizontal
	and vertical straight segments,	and this is obviously because HTML does not provide a way to draw lines
	or curves, so the only possible way is to use HTML elements "improperly".</p>
	<p>It is easy to realize that hand writing the HTML code to draw the connectors is neither simple nor fast and,
	since my work consists in "ease up the other's work" by building frameworks, the natural choice in this case
	is a Javascript library that automatically draws the connectors given the start and the end blocks.</p>
	</div>

	<div class="connector text_me text_javascript">
		<label class="destination-label">What to do?</label>
		<img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif"/>
	</div>

	<div id="two_strategies" class="block draggable" style="left: 50px; top: 500px; width: 500px;">
	<p>A colleague of mine (many thanks to him) suggested to use the borders of a table to draw 3 segments and this
	idea can be easily extended to draw a chain of any number of segments. Meanwhile, I was thinking about using
	thin div elements to draw the segments and then position them to build the "chain".</p>
	<p>The table strategy seemed to me to be more elegant, but after some test, I experienced the first problem
	with it: Microsoft Internet Explorer (ie for short) and Mozilla Firefox behave in slightly different ways
	when rendering tables with forced dimensions, the first considers the border dimension as part of the total,
	the latter does not and sometimes the segments result separated by 1 pixel.</p>
	<p>Another problem is that the tables are composed by many HTML elements (table, tr, td) and this requires more
	javascript code to be written.</p>
	<p>In conclusion, I decided to use the "div" strategy.</p>
	</div>

	<div class="connector text_javascript two_strategies">
		<label class="destination-label">How to do it?</label>
		<img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif"/>
	</div>

	<div id="declarative_strategy" class="block draggable" style="left: 200px; top: 720px; width: 500px;">
	<p>In order to minimize the work for the user that writes html pages with graphs, I choosed to use
	a "declarative strategy", i.e.: rather than ask the user to write javascript code to create the
	graph, I thought it would be great if he can simply declare that a html element is a node or a connector,
	or any other kind object involved in the graph.</p>
	<p>So, I decided to rely on css classes for this task in order to keep the document a valid html page and
	also ease up the definition of objects layout.</p>
	</div>

	<div class="connector two_strategies declarative_strategy">
		<label class="destination-label">How to define the graph?</label>
		<img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif"/>
	</div>

	<p id="whats_next" class="block draggable" style="left: 300px; top: 880px;">
		<a href="gettingstarted.html">Go on reading the "getting started" page!</a>
	</p>

	<div class="connector declarative_strategy whats_next">
		<label class="destination-label">What's next?</label>
		<img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif"/>
	</div>
				</div>
			</td>
		</tr>
	</table>
