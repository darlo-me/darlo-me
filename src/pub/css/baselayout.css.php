/* structural */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}

body {
    width: 80%;
    min-width: 40em;
    max-width: 80em;
    margin-left: auto;
    margin-right: auto;

    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}

body > * {
    flex-grow: 0;
}

body > #content {
    flex-grow: 1;
}

body > #header {
    display: flex;
    align-items: center;

		flex-wrap: wrap;
}

/* We hack a dummy block that prevents both his sliblings from growing past 15em */
body > #header:after {
    content: "";
    flex-grow: 999;
		width: 15em;
}

body > #header > header {
    text-align: center;
		flex-grow: 1;
}

body > #header > nav {
    display: flex;
    align-items: center;
    justify-content: center;
		flex-grow: 99;
}

body > #header > nav > * {
    flex-grow: 0;
}

body > #header > nav > a::before {
    content: "";
    height: 0.8em;
    width: 1px;
    display: inline-block;
    vertical-align: middle;
}
body > #header > nav > a::before {
    margin-right: 1em;
}

body > #header > nav > a {
    display: inline-block;
    white-space: nowrap;
    padding-right: 1em;
    margin-left: 1em;
}

body > #header > nav > a + a {
    margin-left: 0;
}

body > #content {
    width: 80%;
    margin-left: auto;
    margin-right: auto;
}

body > footer {
    min-width: 100%;
}

/* styling */

html {
    font-size: 1.5em;
    font-family: monospace;
}

h1 {
    text-align: center;
    margin: 1.4em 0;
}

a, a:hover, a:active, a:visited {
    text-decoration: inherit;
    color: inherit;
    outline: none;
}

p {
    text-align: justify;
}

#content a, footer a,
#content a:hover, footer a:hover {
    color: rgb(120, 120, 255);
}

#content a:hover, footer a:hover {
    text-decoration: underline;
}

body {
    box-sizing: border-box;
}

body > #header {
    font-family: monospace;
}

body > * {
    padding-top: 0.8em;
    padding-bottom: 0.8em;
}

body > * > *:first-child {
    margin-top: 0; /* flexbox doesnt collapse margins */
}

body > footer {
    text-align: center;
}

header a, nav a {
    padding: 0.2em 0;
}

header a {
    padding: 0 1em;
    font-size: 2.6em;
    font-weight: bold;
}

nav a::before {
    border-left: 1px solid rgb(200, 200, 200);
}
nav a:hover::before {
    border-left-color: rgb(160, 160, 255);
}

nav a {
    font-size: 2em;
}

details > summary {
    margin-left: 0;
    margin-top: 0.5em;
}
details > * {
    margin-left: 0.4em;
}
