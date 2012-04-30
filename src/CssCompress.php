<?php
/**
 * CSS Compress
 * 
 * @package		CssCompress
 * @author		ScarWu
 * @copyright	Copyright (c) 2012, ScarWu (http://scar.simcz.tw/)
 * @link		http://github.com/scarwu/CssCompress
 * @since		Version 1.0
 * @filesource
 */
 
class CssCompress {
	private static $_list = array();
	private static $_dest;
	
	public function __construct() {}

	/**
	 * 
	 */
	public static function Init($list, $dest) {
		if(!is_array($list)) {
			$list = realpath($list) . DIRECTORY_SEPARATOR;
			$handle = opendir($list);
			while($file = readdir($handle))
				if('.' != $file && '..' != $file)
					self::$_list[] = $list . $file;
			closedir($handle);
			
			sort(self::$_list);
		}
		else
			self::$_list = $list;
		
		self::$_dest = $dest;
	}
	
	/**
	 * Run CSS Compress
	 */
	public static function Run() {
		$_package = fopen(self::$_dest, 'w+');
		foreach((array)self::$_list as $file) {
			$css = file_get_contents($file);
			$css = self::Compress($css);
			fwrite($_package, $css);
		}
		fclose($_package);
	}
	
	/**
	 * Compress
	 */
	private static function Compress($css) {
		$css = preg_replace('/(\f|\n|\r|\t|\v)/', '', $css);
		$css = preg_replace('/\/\*.+?\*\//', '', $css);
		$css = preg_replace('/[ ]+/', ' ', $css);
		$css = str_replace(
			array(' ,', ', ', ': ', ' :', ' {', '{ ', ' }', '} ', ' ;', '; '),
			array(',', ',', ':', ':', '{', '{', '}', '}', ';', ';'),
			$css
		);
		return $css;
	}
}
