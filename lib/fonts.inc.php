<link href='http://fonts.googleapis.com/css?family=Pontano+Sans|Domine:400,700' rel='stylesheet' type='text/css'>

<style>

.pageContainer p, .pageContainer p a:link, .pageContainer p a:visited, .pageContainer p a:hover, .pageContainer .adminTable {
	font-family:'Pontano Sans', sans-serif!important;
	font-size:17px!important;
}
.pageContainer h2    {
	font-family: 'Domine', serif!important;
	font-weight:700;
	font-size:23px!important;
	color:<?php echo _link_color_; ?>!important;
	margin-top:20px!important;
}
fieldset{
	background-color:<?php echo _formbg_color_; ?>!important;
	_background-color:<?php echo _formbg_color_; ?>!important;
	border:none;
	border-radius:12px; 
}
a,a:link,a:hover,a:visited{ color: <?php echo _link_color_; ?>!important; }
.pageContainer .colored, .pageContainer .colored p a { background-color:<?php echo _formbg_color_; ?>!important; color:<?php echo _link_color_; ?>!important; }

/* buttons */
.pageContainer a.entervote {
	background: <?php echo $contest['btn1_color1']; ?>; /* Old browsers */
    /* IE9 SVG, needs conditional override of 'filter' to 'none' */
    background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzFlNTc5OSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiM4MGIzZDYiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
    background: -moz-linear-gradient(top,  <?php echo $contest['btn1_color1']; ?> 0%, <?php echo $contest['btn1_color2']; ?> 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $contest['btn1_color1']; ?>), color-stop(100%,<?php echo $contest['btn1_color2']; ?>)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  <?php echo $contest['btn1_color1']; ?> 0%,<?php echo $contest['btn1_color2']; ?> 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  <?php echo $contest['btn1_color1']; ?>9 0%,<?php echo $contest['btn1_color2']; ?> 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  <?php echo $contest['btn1_color1']; ?> 0%,<?php echo $contest['btn1_color2']; ?> 100%); /* IE10+ */
    background: linear-gradient(to bottom,  <?php echo $contest['btn1_color1']; ?> 0%,<?php echo $contest['btn1_color2']; ?> 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $contest['btn1_color1']; ?>', endColorstr='<?php echo $contest['btn1_color2']; ?>',GradientType=0 ); /* IE6-8 */

	color: #fff!important;
	text-shadow: none;
}
	
.pageContainer a.entervote:hover {
	background: <?php echo $contest['btn1_color2']; ?>; /* Old browsers */
    /* IE9 SVG, needs conditional override of 'filter' to 'none' */
    background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzFlNTc5OSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiM4MGIzZDYiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
    background: -moz-linear-gradient(top,  <?php echo $contest['btn1_color2']; ?> 0%, <?php echo $contest['btn1_color1']; ?> 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $contest['btn1_color2']; ?>), color-stop(100%,<?php echo $contest['btn1_color1']; ?>)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  <?php echo $contest['btn1_color2']; ?> 0%,<?php echo $contest['btn1_color1']; ?> 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  <?php echo $contest['btn1_color2']; ?> 0%,<?php echo $contest['btn1_color1']; ?> 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  <?php echo $contest['btn1_color2']; ?> 0%,<?php echo $contest['btn1_color1']; ?> 100%); /* IE10+ */
    background: linear-gradient(to bottom,  <?php echo $contest['btn1_color2']; ?> 0%,<?php echo $contest['btn1_color1']; ?> 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $contest['btn1_color2']; ?>', endColorstr='<?php echo $contest['btn1_color1']; ?>',GradientType=0 ); /* IE6-8 */

}

.pageContainer a.view {
	background: <?php echo $contest['btn2_color1']; ?>; /* Old browsers */
    /* IE9 SVG, needs conditional override of 'filter' to 'none' */
    background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzliMWYxZiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNkNjNlM2UiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
    background: -moz-linear-gradient(top,  <?php echo $contest['btn2_color1']; ?> 0%, <?php echo $contest['btn2_color2']; ?> 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $contest['btn2_color1']; ?>), color-stop(100%,<?php echo $contest['btn2_color2']; ?>)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  <?php echo $contest['btn2_color1']; ?> 0%,<?php echo $contest['btn2_color2']; ?> 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  <?php echo $contest['btn2_color1']; ?> 0%,<?php echo $contest['btn2_color2']; ?> 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  <?php echo $contest['btn2_color1']; ?> 0%,<?php echo $contest['btn2_color2']; ?> 100%); /* IE10+ */
    background: linear-gradient(to bottom,  <?php echo $contest['btn2_color1']; ?> 0%,<?php echo $contest['btn2_color2']; ?> 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $contest['btn2_color1']; ?>', endColorstr='<?php echo $contest['btn2_color2']; ?>',GradientType=0 ); /* IE6-8 */

	color: #fff!important;
	text-shadow: none;
}
	
.pageContainer a.view:hover {
	background: <?php echo $contest['btn2_color2']; ?>; /* Old browsers */
    /* IE9 SVG, needs conditional override of 'filter' to 'none' */
    background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzliMWYxZiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNkNjNlM2UiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
    background: -moz-linear-gradient(top,  <?php echo $contest['btn2_color2']; ?> 0%, <?php echo $contest['btn2_color1']; ?> 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $contest['btn2_color2']; ?>), color-stop(100%,<?php echo $contest['btn2_color1']; ?>)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  <?php echo $contest['btn2_color2']; ?> 0%,<?php echo $contest['btn2_color1']; ?> 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  <?php echo $contest['btn2_color2']; ?> 0%,<?php echo $contest['btn2_color1']; ?> 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  <?php echo $contest['btn2_color2']; ?> 0%,<?php echo $contest['btn2_color1']; ?> 100%); /* IE10+ */
    background: linear-gradient(to bottom,  <?php echo $contest['btn2_color2']; ?>  0%,<?php echo $contest['btn2_color1']; ?> 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $contest['btn2_color2']; ?>', endColorstr='<?php echo $contest['btn2_color1']; ?>',GradientType=0 ); /* IE6-8 */

}

</style>