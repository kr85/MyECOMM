<?php

/**
 * Class Helper
 */
class Helper
{
    /**
     * Get active page
     *
     * @param null $page
     * @return null|string
     */
    public static function getActive($page = null)
    {
        if (!empty($page))
        {
            if (is_array($page))
            {
                $error = [];
                foreach ($page as $key => $value)
                {
                    if (Url::getParam($key) != $value)
                    {
                        array_push($error, $key);
                    }
                }

                return empty($error) ? " class=\"act\"" : null;
            }
        }

        return $page == Url::currentPage() ? " class=\"act\"" : null;
    }

    /**
     * Encode HTML.
     *
     * @param $string
     * @param int $case
     * @return mixed|string
     */
	public static function encodeHTML($string, $case = 2)
    {
		switch($case)
        {
			case 1:
			return htmlentities($string, ENT_NOQUOTES, 'UTF-8', false);
			break;			
			case 2:
			$pattern = '<([a-zA-Z0-9\.\, "\'_\/\-\+~=;:\(\)?&#%![\]@]+)>';
			// put text only, devided with html tags into array
			$textMatches = preg_split('/' . $pattern . '/', $string);
			// array for sanitised output
			$textSanitised = array();			
			foreach($textMatches as $key => $value)
            {
				$textSanitised[$key] = htmlentities(html_entity_decode($value, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
			}			
			foreach($textMatches as $key => $value)
            {
				$string = str_replace($value, $textSanitised[$key], $string);
			}			
			return $string;			
			break;
		}
	}
}