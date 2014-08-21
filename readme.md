# Media Library

## Overview

This package provides the ability to relate a piece of Media to any model via a polymorphic join table. Once correctly configured, create/edit views for the affected models will render the MediaBrowser field. The MediaBrowser field simply presents the user with existing Media instances and checkboxes to denote a relationship.

## Installation

`src/config/config.php` is used to configure which models are "mediable". It should look something like:

```php
	return [
		'allowed_media_types' => ['Image', 'PDF'],
		'models' => [
			'Bozboz\Admin\Models\Page' => [
				'alias' => 'pages'
			]
		]
	];
```

If you wish to add to this configuration or override existing values, simply publish the config to the app by using "config:publish" artisan command.

## Additional sizes

You need to publish the `thapp/jitimage` config file and add an entry to the `recipes` array. Pleaase define a `library` size in order for the overview screen in the admin area to correctly display the images.

```
'recipes' => [
	'library' => new Resize(150, 0),
],

```

## General information

This works by listening out for when a create/edit form is being built by using the MediaEventHandler subscriber. If the form being rendered is associated with a mediable model, a select box containing available Media is displayed to the user.

The value of **alias** is used when accessing the related Page models on the Media instance (e.g. a Media instance has many Pages which can be accessed via $media->pages).

To get all Media instances for a given Page model, pass the Page model to Media::forModel(). This will return an instancce of Illuminate\Database\Eloquent\Relations\MorphToMany which contains the results. Actual model instances can be accessed by calling get() on the return value.
