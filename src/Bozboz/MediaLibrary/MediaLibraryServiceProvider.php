<?php namespace Bozboz\MediaLibrary;

use Illuminate\Support\ServiceProvider;
use Event;

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
		$html = $this->app['html'];

		$html->macro('media', function($item, $size = null, $default = null, $alt = null, $attributes = []) use ($html)
		{
			$item = $item->first();

			if ($item || $default) {
				$filename = $item ? $item->getFilename($size) : $default;
				return $html->image($filename, $alt, $attributes);
			}
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		require __DIR__ . '/../../routes.php';
		Event::subscribe(new Subscribers\MediaEventHandler);
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
