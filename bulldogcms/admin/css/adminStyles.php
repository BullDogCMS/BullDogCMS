/*styles for backend cms*/

/*set color variable*/
/*after and before for admin help panel*/
.cd-panel::after, .cd-panel::before, .cd-panel-close::before, .cd-panel-close::after {
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}

.cd-panel::after, .cd-panel::before, .cd-panel-close::before, .cd-panel-close::after {
	content: '';
}

body, html {
    height: 100%;
}

a {
	color: #222;
} a:hover, a:focus{
	color: #CC0033;
  }
.btn-link {
	color: #222;
} .btn-link:hover, .btn-link:focus {
	color: #CC0033;
  }

.navbar-nav>li>a {
	background-color: #CC0033;
    padding-top: 10px;
    padding-bottom: 10px;
}
.navbar-nav li a:hover, .navbar-nav li a:focus {
	background-color: #333;
}

.navbar-inverse .navbar-nav>li>a {
	color: whitesmoke;
	font-weight: bold;
	border-style: none none solid none;
	border-color: #FFCC00;
}

.navbar-inverse .navbar-collapse, .navbar-inverse .navbar-form {
	border-style: none;
}

.top-nav>li>a {
	color: #CC0033;
	font-weight: bold;
	background-color: #FFCC00;
}  .top-nav li a:hover, .top-nav li a:focus {
	color: #FFCC00;
	background-color: #CC0033;
}
.top-nav>li {
	float: right;
}

.sort-header {
list-style-type: none;
padding-top: 0;
padding-right: 0;
padding-bottom: 0;
padding-left: 0;
}

.filter-dropdown {
list-style-type: none;
font-weight: bold;
padding-top: 0;
padding-right: 0;
padding-bottom: 0;
padding-left: 30;
}

.navbar-inverse{
	border-style: none;
}

.side-nav{
	top: 50px;
}

.btn-primary{
	background-color: #CC0033;
	border-style: none;
} .btn-primary:hover, .btn-primary:focus{
	background-color: #222;
  }

.btn-filemanager{
	background-color: #BABBBE;
	border-style: none;
} .btn-primary:hover, .btn-primary:focus{
	  background-color: #222;
  }

.btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus, span.group-span-filestyle.input-group-btn:focus {
	outline: 5px auto #CC0033;
	outline-offset: -2px;
}

.form-control:focus {
	border-color: #CC0033;
	outline: 0;
	-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(186,18,43,.6);
	box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(186,18,43,.6);
}

.navbar-brand {
	padding: 3px 0 3px 15px;
}

.center-block {
	padding-left: 25px;
}

.btn-success {
	background-color: #FFCC00;
	color: #CC0033;
	border-color: #CC0033;
	font-weight: bold;
}
.btn-success:hover, .btn-success:focus {
	background-color: #222;
}

table {
    table-layout: fixed;
}

td {
    /* These are technically the same, but use both */
    overflow-wrap: break-word;
    word-wrap: break-word;

    word-break: keep-all;

    /* Adds a hyphen where the word breaks, if supported (No Blink) */
    -ms-hyphens: auto;
    -moz-hyphens: auto;
    -webkit-hyphens: auto;
    hyphens: auto;
}

table {
    background-color: #fff;
}

th.description {
    width: 50%;
}

/* Admin Help Side Panel */
/*  https://codyhouse.co/gem/css-slide-in-panel/  */
.cd-panel {
	position: fixed;
	top: 50px;
	left: 0;
	height: 100%;
	width: 100%;
	visibility: hidden;
	-webkit-transition: visibility 0s 0.6s;
	-moz-transition: visibility 0s 0.6s;
	transition: visibility 0s 0.6s;
}
.cd-panel::after {
	/* overlay layer */
	position: absolute;
	top: 50px;
	left: 0;
	width: 100%;
	height: 100%;
	background: transparent;
	cursor: pointer;
	-webkit-transition: background 0.3s 0.3s;
	-moz-transition: background 0.3s 0.3s;
	transition: background 0.3s 0.3s;
}
.cd-panel.is-visible {
	visibility: visible;
	-webkit-transition: visibility 0s 0s;
	-moz-transition: visibility 0s 0s;
	transition: visibility 0s 0s;
}
.cd-panel.is-visible::after {
	background: rgba(0, 0, 0, 0.6);
	-webkit-transition: background 0.3s 0s;
	-moz-transition: background 0.3s 0s;
	transition: background 0.3s 0s;
}
.cd-panel.is-visible .cd-panel-close::before {
	-webkit-animation: cd-close-1 0.6s 0.3s;
	-moz-animation: cd-close-1 0.6s 0.3s;
	animation: cd-close-1 0.6s 0.3s;
}
.cd-panel.is-visible .cd-panel-close::after {
	-webkit-animation: cd-close-2 0.6s 0.3s;
	-moz-animation: cd-close-2 0.6s 0.3s;
	animation: cd-close-2 0.6s 0.3s;
}

@-webkit-keyframes cd-close-1 {
	0%, 50% {
		-webkit-transform: rotate(0deg);
	}
	100% {
		-webkit-transform: rotate(45deg);
	}
}
@-moz-keyframes cd-close-1 {
	0%, 50% {
		-moz-transform: rotate(0deg);
	}
	100% {
		-moz-transform: rotate(45deg);
	}
}
@keyframes cd-close-1 {
	0%, 50% {
		-webkit-transform: rotate(0deg);
		-moz-transform: rotate(0deg);
		-ms-transform: rotate(0deg);
		-o-transform: rotate(0deg);
		transform: rotate(0deg);
	}
	100% {
		-webkit-transform: rotate(45deg);
		-moz-transform: rotate(45deg);
		-ms-transform: rotate(45deg);
		-o-transform: rotate(45deg);
		transform: rotate(45deg);
	}
}
@-webkit-keyframes cd-close-2 {
	0%, 50% {
		-webkit-transform: rotate(0deg);
	}
	100% {
		-webkit-transform: rotate(-45deg);
	}
}
@-moz-keyframes cd-close-2 {
	0%, 50% {
		-moz-transform: rotate(0deg);
	}
	100% {
		-moz-transform: rotate(-45deg);
	}
}
@keyframes cd-close-2 {
	0%, 50% {
		-webkit-transform: rotate(0deg);
		-moz-transform: rotate(0deg);
		-ms-transform: rotate(0deg);
		-o-transform: rotate(0deg);
		transform: rotate(0deg);
	}
	100% {
		-webkit-transform: rotate(-45deg);
		-moz-transform: rotate(-45deg);
		-ms-transform: rotate(-45deg);
		-o-transform: rotate(-45deg);
		transform: rotate(-45deg);
	}
}
.cd-panel-header {
	position: fixed;
	width: 90%;
	height: 55px;
	line-height: 50px;
	background: rgba(255, 255, 255, 0.96);
	z-index: 2;
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.08);
	-webkit-transition: top 0.3s 0s;
	-moz-transition: top 0.3s 0s;
	transition: top 0.3s 0s;
}
.cd-panel-header h1 {
	font-size: 16px;
	font-weight: bold;
	color: #89ba2c;
	padding-left: 5%;
}
.from-right .cd-panel-header, .from-left .cd-panel-header {
	top: -50px; /* used to be - */
}
.from-right .cd-panel-header {
	right: 0;
}
.from-left .cd-panel-header {
	left: 0;
}
.is-visible .cd-panel-header {
	top: 45px;
	-webkit-transition: top 0.3s 0.3s;
	-moz-transition: top 0.3s 0.3s;
	transition: top 0.3s 0.3s;
}
@media only screen and (min-width: 768px) {
	.cd-panel-header {
		width: 70%;
	}
    th.content {
        width: 25%;
    }
}
@media only screen and (min-width: 1170px) {
	.cd-panel-header {
		width: 50%;
	}
    th.content {
        width: 50%
    }
    #color-table {
        width: 75%
    }
}

.cd-panel-close {
	position: absolute;
	top: 0;
	right: 0;
	height: 100%;
	width: 60px;
	/* image replacement */
	display: inline-block;
	overflow: hidden;
	text-indent: 100%;
	white-space: nowrap;
}
.cd-panel-close::before, .cd-panel-close::after {
	/* close icon created in CSS */
	position: absolute;
	top: 22px;
	left: 20px;
	height: 3px;
	width: 20px;
	background-color: #424f5c;
	/* this fixes a bug where pseudo elements are slighty off position */
	-webkit-backface-visibility: hidden;
	backface-visibility: hidden;
}
.cd-panel-close::before {
	-webkit-transform: rotate(45deg);
	-moz-transform: rotate(45deg);
	-ms-transform: rotate(45deg);
	-o-transform: rotate(45deg);
	transform: rotate(45deg);
}
.cd-panel-close::after {
	-webkit-transform: rotate(-45deg);
	-moz-transform: rotate(-45deg);
	-ms-transform: rotate(-45deg);
	-o-transform: rotate(-45deg);
	transform: rotate(-45deg);
}
.no-touch .cd-panel-close:hover {
	background-color: #424f5c;
}
.no-touch .cd-panel-close:hover::before, .no-touch .cd-panel-close:hover::after {
	background-color: #ffffff;
	-webkit-transition-property: -webkit-transform;
	-moz-transition-property: -moz-transform;
	transition-property: transform;
	-webkit-transition-duration: 0.3s;
	-moz-transition-duration: 0.3s;
	transition-duration: 0.3s;
}
.no-touch .cd-panel-close:hover::before {
	-webkit-transform: rotate(220deg);
	-moz-transform: rotate(220deg);
	-ms-transform: rotate(220deg);
	-o-transform: rotate(220deg);
	transform: rotate(220deg);
}
.no-touch .cd-panel-close:hover::after {
	-webkit-transform: rotate(135deg);
	-moz-transform: rotate(135deg);
	-ms-transform: rotate(135deg);
	-o-transform: rotate(135deg);
	transform: rotate(135deg);
}

.cd-panel-container {
	position: fixed;
	width: 90%;
	height: 100%;
	top: 50px;
	background: #dbe2e9;
	z-index: 1;
	-webkit-transition-property: -webkit-transform;
	-moz-transition-property: -moz-transform;
	transition-property: transform;
	-webkit-transition-duration: 0.3s;
	-moz-transition-duration: 0.3s;
	transition-duration: 0.3s;
	-webkit-transition-delay: 0.3s;
	-moz-transition-delay: 0.3s;
	transition-delay: 0.3s;
}
.from-right .cd-panel-container {
	right: 0;
	-webkit-transform: translate3d(100%, 0, 0);
	-moz-transform: translate3d(100%, 0, 0);
	-ms-transform: translate3d(100%, 0, 0);
	-o-transform: translate3d(100%, 0, 0);
	transform: translate3d(100%, 0, 0);
}
.from-left .cd-panel-container {
	left: 0;
	-webkit-transform: translate3d(-100%, 0, 0);
	-moz-transform: translate3d(-100%, 0, 0);
	-ms-transform: translate3d(-100%, 0, 0);
	-o-transform: translate3d(-100%, 0, 0);
	transform: translate3d(-100%, 0, 0);
}
.is-visible .cd-panel-container {
	-webkit-transform: translate3d(0, 0, 0);
	-moz-transform: translate3d(0, 0, 0);
	-ms-transform: translate3d(0, 0, 0);
	-o-transform: translate3d(0, 0, 0);
	transform: translate3d(0, 0, 0);
	-webkit-transition-delay: 0s;
	-moz-transition-delay: 0s;
	transition-delay: 0s;
}
@media only screen and (min-width: 768px) {
	.cd-panel-container {
		width: 70%;
	}
}
@media only screen and (min-width: 1170px) {
	.cd-panel-container {
		width: 50%;
	}
}

.cd-panel-content {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	padding: 70px 5%;
	overflow: auto;
	/* smooth scrolling on touch devices */
	-webkit-overflow-scrolling: touch;
}
.cd-panel-content p {
	font-size: 12px;
	font-family: "Droid Serif", serif;
	color: #424f5c;
	line-height: 1.4;
	margin: 2em 0;
}
.cd-panel-content p:first-of-type {
	margin-top: 0;
}
@media only screen and (min-width: 768px) {
	.cd-panel-content p {
		font-size: 14px;
		line-height: 1.6;
	}
}
@media (max-width: 768px) {
    .cd-panel {
        margin-top: 50px;
    }

    th.description {
        width: 25%;
    }

    #username {
        width: 100px;
    }
}

.cd-btn {
	position: relative;
	color: #89ba2c;
	font-weight: bold;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	-webkit-transition: all 0.2s;
	-moz-transition: all 0.2s;
	transition: all 0.2s;
}
.cd-btn:hover {
	box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.5), 0 0 20px rgba(0, 0, 0, 0.3);
}
footer {
    margin: 10px 0px 0px 0px;
    padding: 20px;
    color: whitesmoke;
    background-color: #222;
    width: 100%;
    height: 50px;
}

.search-group {
    font-size: 1;
    border-radius: 5px;
    display: inline-block;
    float: right;
    margin-bottom: 10px;
    border-style: solid;
    border-color: #CC0033;
    width: 376px;
    height: 38px;
}

.txt-search {
    padding:6px 15px;
    left:-8px;
    border:none;
    outline:none;
}

.select-search {
    position:relative;
    padding:7px 0px;
    left:-5px;
    border:0;
    border-left: groove;
    outline:0;
}

.btn-search {
    position:relative;
    padding: 6px 15px;
    border-style: solid;
    border-color: #CC0033;
    border: 2px;
    outline: 2px;
    background-color: #CC0033;
    color: white;
}

.btn-search:hover, .btn-search:focus{
    background-color: #222;
}

@media (max-width: 390px){
.search-group {
margin-right: -15px;
}
}