<?php
	mb_internal_encoding();

	class ExcerciseThird
	{
		private $char_array;
		private $dictionary;

		/**
		 *	Почему-то с stream_get_content произошла ошибка, из-за кодировки, моя php в консольке её не распознала, а решения не нашёл
		 * 	P.S. А ведь реально много слов можно составить из слова "самолет"
		 */
		const file_name = "russian.txt";

		private $result;

		private function checkElem($id, $index)
		{
			for ($i = 0; $i <= $id; $i ++) { 
				if ($this->param[$i] == $index)
				{
					return false;
				}
			}

			return true;
		}

		private function rec($result, $char_array, $oldvalue)
		{
			foreach ($char_array as $key => $value) {
				array_push($this->result, $oldvalue.$char_array[$key]);
				$this->rec($this->result, array_diff($char_array, [$char_array[$key]]), $oldvalue.$char_array[$key]);
			}
		}

		private function createDictionary()
		{
			$this->result = [];
			$char_array = $this->char_array;

			foreach ($char_array as $key => $value) {
				array_push($this->result, $char_array[$key]);
				$this->rec($this->result, array_diff($char_array, [$char_array[$key]]), $char_array[$key]);
			}
		}

		function __construct($char_array)
		{
			$this->char_array = $char_array;

			$this->dictionary = explode("\n", $this->getFileDictionary());

			$this->createDictionary();

			echo "Из слова \"".implode("", $char_array)."\" можно сделать:\n";

			$count = 0;
			foreach ($this->result as $key => $value)
			{
				$pos = array_search($value, $this->dictionary);
				
				if ($pos)
				{
					$count++;
					echo $this->dictionary[$pos]."\n";
				}
			}
			echo "Всего: '$count' слов.";
		}

		private function getFileDictionary()
		{
			$text = file_get_contents(ExcerciseThird::file_name);

			return $text;
		}
	}