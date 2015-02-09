<?php namespace Bozboz\MediaLibrary;

use Illuminate\Support\ServiceProvider;

class MediaLibraryServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('bozboz/media-library');
		$this->registerMediaHtmlMacro();
	}

	private function registerMediaHtmlMacro()
	{
		$this->app['html']->macro('media', [$this, 'mediaMacro']);
	}

	/**
	 * Render an HTML image tag based on Media of the first result of provided
	 * query $builder object, or fall back to optional $default filename.
	 *
	 * Example usage:
	 *
	 * HTML::media(Media::forModel($item), 'thumb', '/images/default.png', $item->name);
	 *
	 * @param  mixed  $builder
	 * @param  string  $size
	 * @param  string  $default
	 * @param  string  $alt
	 * @param  array  $attributes
	 * @return string
	 */
	public function mediaMacro($builder, $size = null, $default = null, $alt = null, $attributes = [])
	{
		$item = $builder->first();

		if ($item || $default) {
			$filename = $item ? $item->getFilename($size) : $default;
			$altText = $alt ? $alt : $item->caption;
			return $this->app['html']->image($filename, $altText, $attributes);
		}
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		require __DIR__ . '/../../routes.php';

		$this->app['events']->subscribe(new Subscribers\MediaEventHandler);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
