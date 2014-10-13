<?php namespace Bozboz\MediaLibrary\Models;

use Eloquent, Input, Config;
use Bozboz\MediaLibrary\Validators\MediaValidator;
use Bozboz\MediaLibrary\Exceptions\InvalidConfigurationException;
use Bozboz\Admin\Models\Base;

class Media extends Base
{
	protected $table = 'media';
	protected $fillable = array('filename', 'type', 'caption');
	private $dynamicRelations = array();

	public function getValidator()
	{
		return new MediaValidator;
	}

	public function setFilenameAttribute($value)
	{
		if (Input::hasFile('filename')) {
			$file = Input::file('filename');
			$destinationPath = public_path() . '/media/' . strtolower($this->type) . '/';
			$uploadSuccess = $file->move($destinationPath, $file->getClientOriginalName());
			$this->attributes['filename'] = $file->getClientOriginalName();
		}
	}

	/**
	 * Override parent __call behaviour to retrieve and/or define dynamic relations
	 *
	 * @param string $method
	 * @param array $parameters
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
		$isDynamicRelation = array_key_exists($method, $this->dynamicRelations);

		if ($isDynamicRelation) {
			return $this->dynamicRelations[$method];
		} elseif ($this->relationshipExists($method)) {
			return $this->defineRelation($method);
		} else {
			return parent::__call($method, $parameters);
		}
	}

	/**
	 * Override parent getAttribute behaviour to retrieve dynamic relations
	 * 
	 * @param $key string
	 * @return mixed
	 */
	public function getAttribute($key)
	{
		$default = parent::getAttribute($key);
		if (is_null($default) && $this->relationshipExists($key)) {
			return $this->relations[$key] = $this->defineRelation($key)->getResults();
		}
		return $default;
	}

	/**
	 * Check if dynamic polymorphic relationship is defined
	 *
	 * @param $relation string
	 * @return boolean
	 */
	private function relationshipExists($relation)
	{
		$i = 0;
		$exists = false;
		$mediaModels = Config::get('media-library::models');
		$keys = array_keys($mediaModels);
		while ($i < count($keys) && !$exists) {
			$j = 0;
			$key = $keys[$i];
			$configs = $mediaModels[$key];
			while ($j < count($configs) && !$exists) {
				$exists = isset($configs[$j]['media_alias']) && $relation === $configs[$j]['media_alias'];
				$j++;
			}
			$i++;
		}

		return $exists;
	}

	/**
	 * Define and return polymorphic relationship
	 * 
	 * @param $relation string
	 * @return Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	private function defineRelation($relation)
	{
		foreach (Config::get('media-library::models') as $namespace => $configs) {
			foreach ($configs as $config) {
				if (isset($config['media_alias']) && $config['media_alias'] === $relation) {
					return $this->dynamicRelations[$relation] = $this->morphedByMany(
						$namespace,
						'mediable'
					);
				}
			}
		}
	}

	/**
	 * Accessor method to retrieve all media on a model
	 *
	 * @param $model Eloquent
	 * @return Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public static function forModel(Eloquent $model)
	{
		return $model->morphToMany(get_class(), 'mediable')->orderBy('sorting');
	}

	public function getFilename($size = null)
	{
		if (!is_null($size)) {
			$prefix = '/images/' . $size;
		} else {
			$prefix = '';
		}
		return $prefix . '/media/' . strtolower($this->type) . '/' . $this->filename;
	}
}
