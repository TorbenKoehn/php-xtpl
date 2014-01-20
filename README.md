# What is XTPL?


XTPL is a **template system for PHP** that doesn't use any fancy, new syntax, but plain old HTML, or rather, XML.


# How does it work?

The XTPL **Parser** parses the XTPL file and handles specific nodes, if found.
The node plugins are loaded dynamically, which means features like mapping a whole extension over your HTML code that handle new and existing HTML elements are easily possible.

The output you get is **PHTML** which you can include in PHP.
PHTML is just **PHP with HTML**, which renders a dynamic, server-side processed HTML page.

If you don't want to handle the PHTML stuff by yourself, XTPL includes a Renderer that also caches for you, if you like.

# How to install?

You can install either via downloading the [ZIP from GitHub](https://github.com/TorbenKoehn/php-xtpl/archive/master.zip) or by using [Composer](http://getcomposer.org/)

To install using composer, you need to add the following info in your `composer.json`

```json
{
    "minimum-stability": "dev",
    "require": {
        "php": ">=5.3.0",
        "torbenkoehn/php-xtpl": "*"
    }
}

```

After that just run

```bash
$ composer install
```

to install the XTPL library and make it available for you to use.


# How to use?

You can either let the XTPL Renderer handle all the work or you can get your hands dirty and do it with the raw API.

The most easy way:
```php
    $xtpl = new Xtpl\Renderer;

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

It doesn't matter if you use the `.xtpl`-Extension or not.

Using display like that will `eval()` the code, and as we all know, eval is evil.
You better give the renderer a caching directory as the first argument

```php
    $xtpl = new Xtpl\Renderer( __DIR__.'/cache' );
```

This directory of course needs to be writable, but this will improve the performance of the system **greatly**.

Using this way, the renderer will handle all the caching on its own, you don't need to do a thing.

If you want to dig in the dirt you can also use the system in a more raw manner, like this:

```php
    $xtpl = $xtpl->renderFileToFile( 'your/xtpl', './phtml/your/xtpl.phtml' );
    extract( $yourTemplateArgs );
    include './phtml/your/xtpl.phtml';
```


**Note:** *For anything else, just look the codes above and in the docs below.*


# Basic Features

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

## Processing Instructions

You've already seen you can do inline PHP with a tag.
Actually, you can also just use the `<?php ... ?>` syntax in any XTPL file.
These are handled as **processing instructions** and are directly converted into elements.

The following processing instructions are available right now:

`<?php [your php code ] ?>`
Renders into a `<php>` element, which renders a real PHP block in the PHTML file.

`<?css [your CSS] ?>`
Renders into a valid `<style>` element

`<?js [your JavaScript] ?>`
Renders into a valid `<script>` element


## Extensions

XTPL can be extended in a really easy way.

The parser takes specific namespaces where it gets its nodes from.
You can add any namespace you like to provde new or existing, reworked elements to the parser.

Imagine you use a `<my-custom-tag>` tag inside your XTPL file.

The parser goes and looks for a `My\Custom\TagElement` class inside one of its extension namespaces
If found, it processes it and renders it as a valid XTPL Node.

Since newly added namespaces always get read first, it's easy to remove complete element namespaces this way.
The Bootstrap Extension you read about in the next chapter will give a good example to that.

The default namespaces are the following

`Xtpl\Nodes`
`Xtpl\Extensions`

To include a new namespace, you can either call
`$renderer->addExtension( 'Your\\Extension\\Namespace' );` on the `Xtpl\Renderer`
or
`$parser->addElementNamespace( 'Your\\Extension\\Namespace' );` on the `Xtpl\Parser`

To enable a XTPL Extension, you call
`$renderer->addXtplExtension( 'ExtensionName' )` on the `Xtpl\Renderer`
or
`$parser->addElementNamespace( 'Xtpl\\Extensions\\ExtensionName' );` on the `Xtpl\Parser`

Usually you should be working with the `Xtpl\Renderer`, just so you know.


## Default Extensions

While surely you can develop extensions by yourself easily, you don't have to.
XTPL actually brings a whole set of new elements into HTML.

You can either activate them by calling them by their complete namespace or you can include a single namespace to map them over your existing HTML.


### Single Extensions (`Xtpl\Extensions`)

Single Extensions are simple, single elements that just provide some utility features.

#### Email

The tag `<email>someone@example.com</email>` will be converted into `<a href="mailto:someone@example.com">someone@example.com</a>`

#### Html

The `<html>` tag has a new attribute called `version`.
Right now it only supports the value `5`, which makes it automatically add
`<!doctype html>` in front of your `<html>`-tag.

#### Head

The `<head>` Extension actually just adds the UTF-8 charset by default, if you didn't add one manually.

#### Br

The `<br>`-tag provides a new attribute `repeat`, that does exactly what you think it does.
`<br repeat="5" />` will render to `<br><br><br><br><br>`

This is useful for layouts more often than one might think.


### The Bootstrap Extension (`Xtpl\Extensions\Bootstrap`)

The Bootstrap Extension is a full set of new HTML elements that provide the whole functionality of Twitter's Bootstrap framework with the easiest markup you've ever seen.

**Note:** *You don't have to load bootstrap by yourself! XTPl actually takes care of that and handles script and CSS requirements for bootstrap automatically. This means, you also got jQuery once you have one bootstrap element in your code. Watch the generated DOM!*

There are two ways to use the bootstrap-extension.

#### Direct Calling

You can directly call bootstrap extensions by using their namespace. Remember, the `Xtpl\Extensions` namespace is always loaded.
With `<bootstrap-button theme="primary">My shiny button!</bootstrap-button>` you get a fully working Bootstrap-Button that automatically handles anything you do with it.

#### Extension Mapping

If you use Bootstrap for your whole project anyways, you can also just map the whole extension namespace over your XTPL file.
You can do this by enabling the Bootstrap Extension.
Just call `$renderer->addXtplExtension( 'Bootstrap' );` on your `Xtpl\Renderer`

The Bootstrap Extension brings **78 new elements** into your XTPL templates.
To see what they can you, you should better check out the following XTPL Templates

[https://github.com/TorbenKoehn/php-xtpl/tree/master/templates/bootstrap-extension](Bootstrap Extension Example Templates)

## Develop your own extensions

There actually is no documentation on how extension elements work right now.
You may just look at the existing Bootstrap-Extension to get a full view of how they are made.

[Boostrap Extension PHP Files](https://github.com/TorbenKoehn/php-xtpl/tree/master/library/Xtpl/Extensions/Bootstrap)

# Planned features and fixes

- Less and CoffeeScript integration
- Markdown Integration
- More dynamic processing instructions
- Improved DOM management in Nodes
- Improved interpolation on fixed value attributes (e.g. `<boostrap-button theme="{{theme}}" />` doesn't work right now)
- Twitter Bootstrap Collapse (Accordion), Carousel and Affix
- More Doc-Types
- More intelligent encoding detection and auto-generation
- More intelligent and nifty single extension elements





# Why is it called XTPL?


Honestly, because I didn't find any fancy, fitting name yet.
Maybe it will always be XTPL, maybe I change it at some time, I don't know

XTPL comes from XML and Template (TPL), which makes it XTPL. Nifty, I know.

I'm open for name suggestions.


# I have feedback, I'm interested, I want to contribute, I have a new name for this?

Please send an email to torben@devmonks.net and inform me.

I'm looking forward to talk to interested people :)


