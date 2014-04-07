# Media Library

## Overview

This package provides the ability to relate a piece of Media to any model via a polymorphic join table. Once correctly configured, create/edit views for the affected models will render the MediaBrowser field. The MediaBrowser field simply presents the user with existing Media instances and checkboxes to denote a relationship.

## Installation

`app/config/media.php` is used to configure which models are "mediable". It should look something like:

```php
	return array(
		'models' => array(
			'Bozboz\Admin\Models\Page' => array(
				'alias' => 'pages'
			)
		)
	);
```

The value of **alias** is used when accessing the related Page models on the Media instance (e.g. a Media instance has many Pages which can be accessed via $media->pages).

To get all Media instances for a given Page model, pass the Page model to Media::forModel(). This will return an instancce of Illuminate\Database\Eloquent\Relations\MorphToMany which contains the results. Actual model instances can be accessed by calling get() on the return value.
