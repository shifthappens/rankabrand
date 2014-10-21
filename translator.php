<?php

/* Very simple translator class to translate the app into multiple languages */

class Translator
{

	private $language;
	public	$phrases;
	

	public function __construct()
	{
		/* detecting and setting language */
		
			
		$this->setLanguage($lang);
		
		/* get language file for translations and process them, making the translator class ready for action */
		$this->prepareLanguage();		
	}
		
	public function setLanguage($lang)
	{
		if(empty($lang))
			return false;
		
		$this->language = trim($lang);
	}
	
	public function getLanguage()
	{
		return $this->language;
	}
	
	public function using($phrase)
	{
		$sanitized_phrase = $this->sanitizePhrase($phrase);
		
		error_log('[RABM] sanitized phrase: '.$sanitized_phrase);
		error_log('[RABM] phrases table count: '.print_r($this->phrases, true));
		error_log('[RABM] phrase translated: '.$this->phrases[$sanitized_phrase]);
		error_log('[RABM] phrase lookup test: '.$this->phrases['test']);

		return array_key_exists($sanitized_phrase, $this->phrases) ? $this->phrases[$sanitized_phrase] : $phrase;
	}
	
	public function say($phrase)
	{
		echo $this->using($phrase);
	}

	private function prepareLanguage()
	{
		$this->raw_language_file = $this->getLanguageFile();
		
		if($this->raw_language_file !== false)
		{
			$this->processLanguageFile();
			error_log('[RABM] Language table: '.print_r($this->phrases, true));
		}
		else
		{
			trigger_error('Could not load language file for language <b>'.$this->language.'</b> or file returned no translated phrases.', E_WARNING);
		}
	}
	
	private function getLanguageFile()
	{
		return file_get_contents('./languages/'.$this->language.'.txt');
	}
	
	private function processLanguageFile()
	{
		if(!isset($this->raw_language_file) || empty($this->raw_language_file))
			return false;
		
		//split all the ohrases by line
		$phrases = explode(PHP_EOL, $this->raw_language_file); //PHP_EOL is an end-of-line constant
		
		foreach($phrases as $string)
		{
			$translation = explode('=', $string);
			
			if(count($translation) == 2)
			{
				$phrase = $this->sanitizePhrase($translation[0]);
				$translated_phrase = $this->sanitizePhrase($translation[1]);
				
				$this->phrases[$phrase] = $translated_phrase;
			}
		}
	}
	
	private function sanitizePhrase($phrase)
	{
		str_replace('"', '', $phrase);
		$phrase = trim($phrase);
		
		return $phrase;
	}
}