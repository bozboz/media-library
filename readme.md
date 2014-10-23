# Media Library

## Overview

This package provides the ability to relate a piece of Media to any model via a polymorphic join table. Once correctly configured, create/edit views for the affected models will render the MediaBrowser field. The MediaBrowser field simply presents the user with existing Media to mark as being related.

## Installation

1. Add bozboz/media-library to `composer.json`:
```
	"require": {
		"bozboz/media-library": "0.2.*"
	}
```

2. Add the following to the `providers` array within `app/config/app.php`:
```
	'Bozboz\MediaLibrary\MediaLibraryServiceProvider',
	'Thapp\JitImage\JitImageServiceProvider'
```

3. Publish bozboz/media-library assets, migratons and configuration:
```
	./artisan config:publish bozboz/media-library
	./artisan asset:publish bozboz/media-library
	./artisan migrate:publish bozboz/media-library
```

4. Run `./artisan migrate`

5. Run `./artisan asset:publish bozboz/media-library`

6. Run `gulp`

7. Run `./artisan config:publish thapp/jitimage`

8. Open `app/config/packages/thapp/jitimage/config.php` and update with the following:
```
	use Bozboz\MediaLibrary\ImageFilters\Resize;
	use Bozboz\MediaLibrary\ImageFilters\ResizeAndCrop;

	return [
		...
		'recipes' => [
			'library' => new Resize(150, 0),
			'thumb' => new ResizeAndCrop(150, 150)
		]
	];
```

## Making models "mediable"

By default, only Pages will be mediable out of the box. You can define new media models inside `app/config/packages/bozboz/media-library/config.php`:
```
	'models' => [
		'Bozboz\Admin\Models\Page' => [
			'alias' => 'pages'
		]
	]
```

The value of **alias** is used when accessing the related Page models on the Media instance (e.g. a Media instance has many Pages which can be accessed via $media->pages).

## General information

This works by listening out for when a create/edit form is being built by using the MediaEventHandler subscriber. If the form being rendered is associated with a mediable model, a select box containing available Media is displayed to the user.

To get all Media instances for a given Page model, pass the Page model to Media::forModel(). This will return an instancce of Illuminate\Database\Eloquent\Relations\MorphToMany which contains the results. Actual model instances can be accessed by calling get() on the return value.
