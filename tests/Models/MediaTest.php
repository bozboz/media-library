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

	public function testGetSizesSuccess()
	{
		$configMock = Mockery::mock('ConfigMock');
		$configMock->shouldReceive('get')->with('media.models')->once()->andReturn([
			'Bozboz\Admin\Models\Page' => [
				'alias' => 'pages',
				'sizes' => [
					'thumb' => [
						'width' => 1337,
						'height' => 7331
					]
				]
			],
			'Bozboz\Admin\Models\User' => [
				'alias' => 'users',
				'sizes' => [
					'large' => [
						'width' => 1000,
						'height' => 750
					],
					'small' => [
						'width' => 125,
						'height' => 75
					]
				]
			]
		]);
		Config::swap($configMock);

		$expectedOutput = [
			'pages/thumb' => '1/1337/7331',
			'users/large' => '1/1000/750',
			'users/small' => '1/125/75'
		];
		$actualOutput = Media::getSizes();
		$this->assertEquals($expectedOutput, $actualOutput);
	}

	/**
	 * @expectedException Bozboz\MediaLibrary\Exceptions\InvalidConfigurationException
	 */
	public function testGetSizesAliasException()
	{
		$configMock = Mockery::mock('ConfigMock');
		$configMock->shouldReceive('get')->with('media.models')->once()->andReturn([
			'foo' => []
		]);
		Config::swap($configMock);

		Media::getSizes();
	}
}
