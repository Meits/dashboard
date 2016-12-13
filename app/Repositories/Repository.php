<?php

namespace App\Repositories;

use Config;
use Gate;

abstract class Repository
{
	
    protected $model = FALSE;
	
	public function get($select = '*',$take = FALSE,$pagination = FALSE,$where = FALSE,$order = FALSE)
    {
        
		
		if(!is_object($this->model)) {
			return FALSE;
		}
       	
		$builder = $this->model->select($select);
		
		
        
        if($take) {
			
			$builder->take($take);
		}
		
		if($where) {
			$builder->where($where[0],$where[1]);
		}
		
		if($pagination) {
			return $this->check($builder->paginate(Config::get('settings.paginate')));
			
		}
		
		if($order) {
			$builder->orderBy($order[0],$order[1]);	
		}
		
		
		return $this->check($builder->get());

    }
	
	public function one($id = FALSE, $alias = FALSE,$attr = array()) {
		
		
		if($id) {
			$result = $this->model->find($id);
		}
		else if($alias) {
			$result = $this->model->where('alias',$alias)->first();
		}
		
		return $result;	
	}
    
    protected function check($result) {
		
		if($result->isEmpty()) {
			return FALSE;
		}
		
		$result->transform(function ($item, $key) {
			
		    $item->img = json_decode($item->img);

			return $item;
			
		});
		
		return $result;
	}
	
		
	
	public static function transliterate($string)
	{
		$str = mb_strtolower($string,'UTF-8');

		$glyph_array = array(
			'a' => 'а',
			'b' => 'б',
			'v' => 'в',
			'g' => 'г,ґ',
			'd' => 'д',
			'e' => 'е,є,э',
			'jo' => 'ё',
			'zh' => 'ж',
			'z' => 'з',
			'i' => 'и,і',
			'ji' => 'ї',
			'j' => 'й',
			'k' => 'к',
			'l' => 'л',
			'm' => 'м',
			'n' => 'н',
			'o' => 'о',
			'p' => 'п',
			'r' => 'р',
			's' => 'с',
			't' => 'т',
			'u' => 'у',
			'f' => 'ф',
			'kh' => 'х',
			'ts' => 'ц',
			'ch' => 'ч',
			'sh' => 'ш',
			'shch' => 'щ',
			'' => 'ъ',
			'y' => 'ы',
			'' => 'ь',
			'yu' => 'ю',
			'ya' => 'я',
		);

		foreach ($glyph_array as $letter => $glyphs) {
			$glyphs = explode(',', $glyphs);
			$str = str_replace($glyphs, $letter, $str);
		}

		//$str = preg_replace('#\&\#?[a-z0-9]+\;#ismu', '', $str);

		// Remove any duplicate whitespace, and ensure all characters are alphanumeric
		$str = preg_replace('/(\s|[^A-Za-z0-9\-])+/', '-', $str);

		// Trim dashes at beginning and end of alias
		$str = trim($str, '-');
		
		

		return $str;
	}
}