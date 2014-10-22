<?php namespace Bozboz\MediaLibrary\Tests\Models;

use Bozboz\MediaLibrary\Models\Media;
use Mockery, TestCase, Config, Artisan;
use Illuminate\Database\Eloquent\Model as Eloquent;

class MediaTest extends \Bozboz\Admin\Tests\TestCase
{
	public function setUp()
	{
		parent::setUp();
		Artisan::call('migrate', array('--bench' => 'bozboz/media-library'));
	}

	public function tearDown()
	{
		Mockery::close();
	}

	public function testForModel()
	{
		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Relations\MorphToMany',
			Media::forModel(new \Bozboz\Admin\Models\Page)
		);
	}
}
