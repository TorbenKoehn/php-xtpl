# What is XTPL?


XTPL is a **template system for PHP** that tries not to create new fancy language constructs or languages itself.
XTPL uses **plain HTML tags** to trigger specific template functions, display variables, loop through arrays etc.

It is based on XML parsing and requires **strict XML templates**, but allows you to use any **HTML5** tag (or rather, **any** tag). While allowing that, it takes specific elements and enhances them with special functionality.

You can find a list of what can be done with these tags below.

This is **server-side processed, enhanced HTML**. It can do a lot of useful stuff.

The output you get is **PHTML** which you can include in PHP.
PHTML is just **PHP with HTML**, which renders a dynamic, server-side processed HTML page.


# What can it do right now?

Some basic features work already. Many, many, many, many more will follow soon.


## Blocks

You can define a block and let other blocks add or replace content in it.
This works recursively, this means that you can define blocks in a layout template, extend from that and just define the block contents.
You can also define blocks and then include the templates that specify the block content.

**my-page.xtpl**
```xml
<?xml version="1.0" encoding="utf-8" ?>
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
	            I'm some placeholder content, I won't stay here.
	        </block>
	    </body>
	</html>



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
        
        <p>
        	It actually doesn't matter what's in here, you can include stuff, you can have sub-blocks and sub-sub-blocks, XTPL can handle all of it.
        </p>

    </block>

</xtpl>
```

**Note**: *Indeed, you don't need to close script elements anymore.*

The resulting HTML will be this:

```html
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
        
        <p>
        	It actually doesn't matter what's in here, you can include stuff, you can have sub-blocks and sub-sub-blocks, XTPL can handle all of it.
        </p>

    </body>
</html>
```

Notice that the script block got appended, the style block got prepended and the content block replaced the previous content.

The target block is always the first block with its name that the parser finds, all other blocks will add to it (or not)

People who played with Jade already should know this kind of template mechanism.


## Extend

Templates can extend other templates. Again, if you're coming from Jade, you should already know the way it works.
This does nothing more than putting your current template DOM inside the extended template DOM, but allows for recursive block usage, global main-layouts and stuff like that.

Imagine you have a great main-layout

**layout.xtpl**
```xml
<?xml version="1.0" encoding="utf-8" ?>
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
	            I'm some placeholder content, I won't stay here.
	        </block>
	    </body>
	</html>

</xtpl>
```

and you render a template that extends it

**my-page.xtpl**
```xml
<?xml version="1.0" encoding="utf-8" ?>
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
        
        <p>
        	It actually doesn't matter what's in here, you can include stuff, you can have sub-blocks and sub-sub-blocks, XTPL can handle all of it.
        </p>

    </block>
</xtpl>
```

The resulting HTML will be this:

```html
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
        
        <p>
        	It actually doesn't matter what's in here, you can include stuff, you can have sub-blocks and sub-sub-blocks, XTPL can handle all of it.
        </p>

    </body>
</html>
```

There actually is no programatic limitation on how many levels you can extend, how many blocks there are or anything like that.
You can extend layouts as many levels deep as you like, even in included XTPLs.

Just try to avoid recursion

**Note**: *No really, recursion will fuck everything up right now I guess.*

## Includes

Include a sub-template. 
In the sub-template you got access to the template variables as well as the attributes of the include-element.

**my-page.xtpl**
```xml
<?xml version="1.0" encoding="utf-8"?>
<xtpl>

    <body>

		<block name="page-header" />
        <header>

            <include file="navigation" orientation="vertical" />
            
        </header>
    </body>
    
</xtpl>
```

**navigaton.xtpl**
```xml
<?xml version="1.0" encoding="utf-8"?>
<xtpl>

    <nav class="nav nav-[[orientation]]">
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#about-me">About me</a></li>
            <li><a href="#blog">Blog</a></li>
            <li><a href="#portfolio">Portfolio</a></li>
        </ul>
    </nav>
    
    <block name="page-header">
    	My Page Header
    </block>
    
</xtpl>
```

To use the `orientation` attribute in the included template (or any of its extended templates), you use `[[orientation]]` in any attribute or text node, take a look at the `class=""` attribute of the `<nav>` element. This also works on templates, that the included template extended.
`orientation` is just an example, you can use any attribute name or value you like (You could even load the value of the `file` attribute)

The interpolation with `[[attributeName]]` works on attribute values and plain text nodes.


## Variables

What else, one of the most important parts.
There are two ways to use variables inside templates, there is a `<var>` element and you can use interpolation.

### The `<var>` element

```xml
    <var name="my.variable.name" />
```

is the same as

```php
    <?php echo $my->variable->name; ?>
```

You can also set

```xml
    <var name="my.variable.name" value="New Value!" />
```

and you can use default values if the variable isn't set (Which does an automatic `!empty()` check)

```xml
    <var name="title" default="My Website Title!" />
```

**But this uses the official `<var>` tag, doesn't it?**

Yes it does, but it won't affect it in any way. VarElement only reacts if there is at least a `name` attribute existent (And there is no reason to set one on a normal `<var>` element).
Everything else stays plain HTML.


### Interpolation

Variable interpolation works on attribute values and text nodes.
Something like `<{{var.name}}>` isn't possible and probably never will be.

```xml
    <nav class="nav nav-{{orientation}}">
    
		Hey, this is some text and I don't want to use a tag now so I just {{output}} my variable named "output" here.
		
    </nav>
```

**Note**: *If you think it makes sense using interpolation in `<php>` nodes, you can do it, but honestly, it makes no sense. You have access to the variables using plain `$varName` anyways. Even though, in some cases it may make sense, so it works.*


As for attributes, if the variable is the only thing you have in your attribute value and the variable is null or false, it won't render the attribute itself.
This is useful for optional classes

```xml
    <a href="my-link.html" class="{{link.active}}">My link!</a>
```

if `$link->active` is `null` or `false`, this will render

```xml
    <a href="my-link.html">My link!</a>
```

Actually, this was a lie, it doesn't do this right now, but it will soon.

You can also use default values and callbacks/filters in the expression-way of calling variables.

```xml
	<p>
		HEY, THE NEXT TEXT SHOULD ALSO BE {{someText(I dont have a Text):strtoupper:SomeClass.doSomeStaticStuff}}
	</p>
```


## Loops

There are for and foreach-loops right now. Both work with the `<for>` element.

A simple foreach-loop works like this:

```xml
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
```

You might also get the key as a variable with

```xml
<for each="my.posts" as="post" key="currentIndex">
```


The for loops is just a counter currently, you can do something for a limited amount of times and specify a start-point.
This is pretty useless right now, since you can't use interpolation for the `times` attribute, but this will surely be changed in the future.

A for-loop works like this:

```xml
<for times="5" as="i">
    ({{i}}): Hey, this should happen 5 times! 
</for>
```

## Conditions

Yes, they are in now!
XTPL supports `<if>`, `<else>` and `<elseif>` blocks.
The latter two always need to be **inside** the `if` element they refer to.

Possible checks via attribute are `empty`, `not-empty`, `set`, `not-set`, `cond` and `not-cond`

`cond` and `not-cond` just translate into plain PHP, it's like defining what's between the `(...)` of the if statement in PHP.


```xml
<if not-empty="myVar">
    Heeey, we made sure that {{myVar}} is not empty!
</if>
```

```xml
<if cond="!empty( $myVar ) and $myVar > 0">
    This gets printed if the condition is true
</if>
```

```xml
<if not-set="myVar">
    myVar is not set
    <else>
        myVar is set!
    </else>
</if>
```

It doesn't matter where in the node you put the else/else-if tags, they will always be rendered at the end automatically.
This is useful if you want to put your else-block at the top of a large if-block to improve readability.
```xml
<if not-set="myVar">
    myVar is not set
    <else>
        myVar is set!
    </else>
    and here is some more content<br>
    but this will only be rendered, if the if-block is true!
</if>
```

```xml
<if not-set="myVar">
    myVar is not set
    <elseif set="myVar">
        myVar is set
    </elseif>
    <else>
        This won't ever be printed.
    </else>
</if>
```

Play with it, get a feeling for it, it actually works!


## Inline PHP

You can use PHP-HTML-Tags to use plain PHP inside your template.
Through the XML restrictions you have to put complex code into `<![CDATA[ ... ]]>` tags.

```xml
	<php>echo $someVariable;</php>
	
	<php>while( $i < 10 ):</php>
		<span>{{i}}</span>
		<php>$++;</php>
	<php>endwhile;</php>

	<php><![CDATA[
	
		//Here you can use any kind of complex PHP code
		
		class SomeClass {}
		
		$instance = new SomeClass;
		$instance->something = 'SomeValue';
		
		var_dump( $instance );
	
	]]></php>
```

**More documentation following soon.**


# What else can I do with it?


You can enhance it. XTPL includes a plugin system with some default extensions.
Based on the tags you use you can add new tags and classes that handle them.

You might think it just translates XML to HTML, but it actually creates a complete DOM with a bunch of traversing and manipulation methods in the background. This allows you to manipulate any specific point of the DOM from every specific or any other point that gets handled.
The implementation does **not** use DOMDocument of PHP but an own DOM implementation (that at least uses similar naming) that works different and more efficient for this kind of project.

An example might be Bootstrap-Extensions, that allow you to use bootstrap elements easily (e.g. `<bs-btn type="success">Success!!</bs-btn>`) and you don't even need to include any CSS or JS files by yourself, the elements can check if bootstrap is loaded or not by traversing the `<head>` element, if not, they can just `addChild()` a new `<script>` and `<link>` to it and it will be loaded when it's required. Actually, there is a method called `addCss( $css )` in it that already does that for you :)

The possibilities here are unlimited.
It works kind of like server-side HTML Custom Elements.
With enough plugins you don't need a line of plain PHP to get your dynamic website working with pure HTML syntax.


To add an element plugin, create a PHP Class that extends from `Xtpl\Nodes\Element`, call it anything with `Element` in the end, put it into some namespace and let the parser know about your element namespace with

```php
$xtpl->getCompiler()->getParser()->addElementNamespace( 'Your\\Element\\Namespace' );
```

Then just go on rendering normally.

What will happen is that the parser will inflect the name of the HTML tag it processes and find a class that fits it.
e.g. an element like `<my-custom-tag>` will search for a class called `MyCustomTagElement` in the element namespaces of the parser. The DOM will then receive a new instance of this class instead of a plain `Element`-instance and allows you to modify the compiling and rendering process of that element.

In your class you have a bunch of DOM utilities to make your elements as mighty as possible.
Just take a look at the `Xtpl\Extensions` or the `Xtpl\Nodes` element namespaces to get a feeling for it.


# Planned features

- [ ] Less and CoffeeScript integration
- [ ] If-statements
- [ ] Medium-sized standard library
- [ ] Twitter Bootstrap elements
- [ ] Fancy filters (Markdown?)


# How does the compilation work?

You can either let the XTPL Renderer handle all the work or you can get your hands dirty and do it with the raw API.

The most easy way:
```php
    $xtpl = new \Xtpl\Renderer;

    $xtpl->displayFile( 'your/path/to/the/xtpl/file', array(
    	'title' => 'My Page Title',
    	'posts' => array(
    		0 => array(
    			'title' => 'Some post title',
    			'content' => 'bla bla bla bla bla'
    		)
    	)
    ) );
```

It doesn't matter if you use the xtpl Extension or not.

Using display like that will `eval()` the code, and as we all know, eval is evil.
You better give the renderer a caching directory as the first argument

```php
	$xtpl = new \Xtpl\Renderer( __DIR__.'/cache' );
```

This directory of course needs to be writable, but this will improve the performance of the system **greatly**.

Using this way, the renderer will handle all the caching on its own, you don't need to do a thing.

If you want to dig in the dirt you can also use the system in a more raw manner, like this:

```php
	$xtpl = $xtpl->renderFileToFile( 'your/xtpl', './phtml/your/xtpl.phtml' );
	extract( $yourTemplateArgs );
	include './phtml/your/xtpl.phtml';
```


**For anything else, just look the codes above.**


# Why is it called XTPL?


Honestly, because I didn't find any fancy, fitting name yet.
Maybe it will always be XTPL, maybe I change it at some time, I don't know

XTPL comes from XML and Template (TPL), which makes it XTPL. Nifty, I know.

I'm open for name suggestions.


# I have feedback, I'm interested, I want to contribute, I have a new name for this?

Please send an email to torben@devmonks.net and inform me.

I'm looking forward to talk to interested people :)


