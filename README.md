# SymfonyRouter Plugin

SymfonyRouter is a plugin that extends how your default Router can be used. It
enables three new features:

* Add named routes
* Manipulate the params from a matched route
* Matches a route only if it conforms to a given condition

## Requirements

* CakePHP 2.x (tested on 2.4 and 2.5 but should work on every 2.x release)
* PHP 5.3 or later (should work on 5.2 but it is not tested)
* composer

## Installation

**Using [Composer](http://getcomposer.org/)**

Add the plugin to your project's `composer.json` - something like this:

```javascript
{
    "require": {
        "piotrpasich/cakephp-symfony-router": "dev-master"
    }
}
```

Then you need to install vendors:

```bash
cd app/Plugins/PowerRouter
composer install
```

Because this plugin has the type `cakephp-plugin` set in it's own
`composer.json`, composer knows to install it inside your `/Plugins` directory,
rather than in the usual vendors file. It is recommended that you add
`/Plugins/PowerRouter` to your .gitignore file.
Why? [read this](http://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md).

**Manual**

* Download this: http://github.com/piotrpasich/cakephp-symfony-router/zipball/master
* Unzip that download
* Copy the resulting folder to app/Plugins
* Rename the folder you just copied to `SymfonyRouter`

**GIT Submodule**

In your app directory type:

```bash
git submodule add git://github.com/piotrpasich/cakephp-symfony-router.git plugins/SymfonyRouter
git submodule init
git submodule update
```

**GIT Clone**

In your plugin directory type:

```bash
git clone git://github.com/piotrpasich/cakephp-symfony-router.git SymfonyRouter
```

## Usage

SymfonyRouter is a custom route class that extends on the CakeRoute. This way you
can use it to define your routes and take advantage of it's features. Using it
will make you able to use routing in CakePHP much easier than it is now.

In order to use the features from SymfonyRouter, first you need to load the plugin
adding the following line in your `app/Config/bootstrap.php`:

```php
//app/Config/bootstrap.php
CakePlugin::load('SymfonyRouter');
```

Later, import the library into your "app/Config/routes.php" file like this:

```php
//app/Config/routes.php
App::uses('SymfonyRouter', 'SymfonyRouter.Lib');
```

After that you can create own file in app/Config/router.yml like this:

```yml
home:
    path:      /
    defaults:  { controller: Home,  action: index }
blog:
    path:      /blog
    defaults:  { controller: Blog,  action: index }
blog_post:
    path:      /blog/{slug}
    defaults:  { controller: Blog,  action: post }
```

## Matching routes in templates views

To use this Plugin in your Views files and generate Urls you need to add a Helper in your Controller like

```php
//app/Controller/BlogController
class BlogController extends AppController
{

    public $helpers = array('SymfonyRouter.SymfonyRouter');

    /** ... **/
}
```

And then you can generate your url in View:

```php
//app/View/Blog/index

<?php echo $this->SymfonyRouter->getPath('blog_post', array('slug' => $post->getSlug())); ?>
<a href="<?php echo $this->SymfonyRouter->getPath('blog_post', array('slug' => $post->getSlug())); ?>"><?php echo $post->getSlug() ?></a>
```

#More information

You can find more information about hwo the Symfony's routing is working on http://symfony.com/doc/current/book/routing.html .

This plugin is mostly a bridge between Symfony routing bundle and CakePHP framework.

# License

The MIT License (MIT)

Copyright (c) 2014 Piotr Pasich

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.