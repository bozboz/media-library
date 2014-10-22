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

	public function testGetAttribute()
	{
		$media = new Media;
		$this->assertNull($media->someVarThatDoesNotExist);
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $media->pages);
	}

	public function testCall()
	{
		$media = new Media;
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\MorphToMany', $media->pages());
	}

	/**
	 * @expectedException BadMethodCallException
	 */
	public function testBadCall()
	{
		$media = new Media;
		$media->methodDoesNotExist();
	}

	public function testForModel()
	{
		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Relations\MorphToMany',
			Media::forModel(new \Bozboz\Admin\Models\Page)
		);
	}
}
