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

    /**
     * Get the size of a image
     *
     * @param $image
     * @param $case
     * @return mixed
     */
    public static function getImageSize($image, $case)
    {
        if (is_file($image))
        {
            // 0 => width, 1 => height, 2 => type, 3 => attributes
            $size = getimagesize($image);
            return $size[$case];
        }
    }

    /**
     * Shorten the description of a product
     *
     * @param $string
     * @param int $length
     * @return string
     */
    public static function shortenString($string, $length = 150)
    {
        if (strlen($string) > $length)
        {
            $string = trim(substr($string, 0, $length));
            $string = substr($string, 0, strrpos($string, " "));
            $string .= "&hellip;";
        }
        else
        {
            $string .= "&hellip";
        }

        return $string;
    }

    public static function redirect($url = null)
    {
        if (!empty($url))
        {
            header("Location: {$url}");
            exit;
        }
    }
}