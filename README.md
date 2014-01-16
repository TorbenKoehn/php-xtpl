# What is XTPL?


XTPL is a template system for PHP that tries not to create new fancy language constructs or languages itself.
XTPL uses plain HTML tags to trigger specific template functions, display variables, loop through arrays etc.

It is based on XML parsing and requires strict XML templates, but allows you to use any HTML5 tag (or rather, **any** tag). While allowing that, it takes specific elements and enhances them with special functionality.

You can find a list of what can be done with these tags below (or soon)

This is server-side processed, enhanced HTML.

<br><br><br>

# Why is it called XTPL?


Honestly, because I didn't find any fancy, fitting name yet.
Maybe it will always be XTPL, maybe I change it at some time, I don't know

XTPL comes from XML and Template (TPL), which makes it XTPL. Nifty, I know.

I'm open for name suggestions.

<br><br><br>

# What else can I do with it?


You can enhance it. XTPL includes a small plugin system with some default extensions.
Based on the tags you use you can add new tags and classes that handle them.

You might think it just translates XML to HTML, but it actually creates a complete DOM with a bunch of traversing and manipulation methods in the background. This allows you to manipulate any specific point of the DOM from every specific or any other point that gets handled.
The implementation does **not** use DOMDocument of PHP but an own DOM implementation (that at least uses similar naming) that works different and more efficient for this kind of project.

An example might be Bootstrap-Extensions, that allow you to use bootstrap elements easily (e.g. `<bs-btn type="success">Success!!</bs-btn>`) and you don't even need to include any CSS or JS files by yourself, the elements can check if bootstrap is loaded or not by traversing the `<head>` element, if not, they can just `addChild()` a new `<script>` and `<link>` to it and it will be loaded when it's required.

The possibilities here are unlimited.
It works kind of like server-side HTML Custom Elements.

<br><br><br>

# What can it do right now?

Some basic features work already. Many, many, many, many more will follow soon.

## Include

Include a sub-template. You can pass variables to the sub-template, that work recursively with extended templates (templates that get included can still extend some other template)

    <body>

        <header>

            <include file="navigation" orientation="vertical" />
        </header>
    </body>

To use the `orientation` attribute in the included template (or any of its extended templates), you use `[[attributeName]]` in any attribute or text node.


## Extend

Templates can extend other templates. This feature is taken from the Jade template system.
This does nothing more than putting your current template DOM inside the extended template DOM, but allows for recursive block usage, global main-layouts and stuff like that.

    <xtpl extend="layout">

        <block name="content">
            <h1>Hey, is this XTPL?</h1>
            <p>
                Yeah, this is XTPL!
            </p>
        </block>

    </xtpl>

## Blocks

You can define a block and let other blocks add or replace content in it.

Imagine some kind of main layout you want to extend

    <xtpl>

        <html version="5">
            <head>
                <title>XTPL is awesome!</title>

                <block name="scripts">
                    <script src="jquery.js" />
                </block>

                <block name="styles">
                    <link rel="stylesheet" href="style.css" />
                </block>
            </head>
            <body>

                <block name="content">
                    Whatever is in here will be removed when some other block wants to replace something in here.
                </block>
            </body>
        </html>

    </xtpl>

And imagine the template you parse, which extends your main layout

    <xtpl extends="layout">

        <block name="scripts" mode="append">
            <script src="bootstrap.js" />
        </block>

        <block name="styles" mode="prepend">
            <link rel="stylesheet" href="bootstrap.css" />
        </block>

        <block name="content">

            <h1>My current content</h1>
            <p>
                This might be some static or dynamic content, whatever you prefer.
            </p>

        </block>
    </xtpl>

The resulting HTML will be this:

    <!doctype html>
    <html>
        <head>
            <title>XTPL is awesome!</title>

            <script src="jquery.js"></script>
            <script src="bootstrap.js"></script>

            <link rel="stylesheet" href="bootstrap.css">
            <link rel="stylesheet" href="style.css">
        </head>
        <body>

            <h1>My current content</h1>
            <p>
                This might be some static or dynamic content, whatever you prefer.
            </p>

        </body>
    </html>


People who played with Jade already should know this kind of template mechanism.


## Variables

What else, one of the most important parts.
There are two ways to use variables inside templates, the element-way and the attribute-way

The element-way:

    <var name="my.variable.name" />

is the same as

    <?php echo $my->variable->name; ?>

You can also set

    <var name="my.variable.name" value="New Value!" />

and you can use default values if the variable isn't set

    <var name="title" default="My Website Title!" />


And the attribute way to use variables:

    <nav class="nav nav-{{orientation}}">

    </nav>

which also works in basic text-nodes (not in tags or anything like that, so `<{{some-var}}>` isn't possible and shouldn't be)

So you can also do something like

    <p>
        Hey, this is some text and I don't want to use a tag now so I just {{output}} my variable named "output" here.
    </p>

As for attributes, if the variable is the only thing you have in your attribute value and the variable is null or false, it won't render the attribute itself.
This is useful for optional classes

    <a href="my-link.html" class="{{link.active}}">My link!</a>

if `$link->active` is `null` or `false`, this will render

    <a href="my-link.html">My link!</a>


Actually, this was a lie, it doesn't do this right now, but it will.


**But this uses the official `<var>` tag, doesn't it?**

Yes it does, but it won't affect it in any way. VarElement only reacts if there is at least a `name` attribute existent (And there is no reason to set one on a normal `<var>` element).
Everything else stays plain HTML.

A lie again. All `<var>` elements get stripped completely right now, but I already got this in mind :)


## Loops

There is only one kind of loop right now:

The for-loop (Which is also a foreach loop)
You might think it works like a for-loop, but right now it's really **only** a foreach loop

    <for each="my.posts" as="post">

        <article>
            <header>
                <h1>{{post.title}}</h1>
            </header>
            <p>
                {{item.content}}
            </p>
        </article>
    </for>

Now it already looks a bit like MDV, eeh? That's good, I guess. It's all the same syntax, everywhere.


##More stuff will follow soon...

<br><br><br>

# How does the compilation work?

The process is not finished, right now you can use the `Xtpl\Compiler` class to get up and running.

    $compiler = new \Xtpl\Compiler;

    $pthml = $compiler->compile( 'your/path/to/the/xtpl/file' );

It doesn't matter if you use the xtpl Extension or not.
And you're right, this doesn't produce HTML, but PHTML. This means, you don't just echo it, you rather save it up and some location and `include()` it. You have to `extract()` your template variables by yourself right now.

You might also `eval()` the PHTML, but eeeeeeh, someone will shoot me when I allow you that.
So don't.


**For anything else, just look in the `templates/` folder above or in the `index.php` file.**

<br><br><br>

# I'm interested, I can code, I want to help, I want to contribute [, I have a new name for this?]

Please send an email to torben@devmonks.net and inform me.

I'm looking forward to talk to interested people :)



