<?php

/**
 * Class Form
 */
class Form
{
    public function isPost($field = null)
    {
        if (!empty($field))
        {
            if (isset($_POST[$field]))
            {
                return true;
            }

            return false;
        }
        else
        {
            if (!empty($_POST))
            {
                return true;
            }

            return false;
        }
    }

    public function getPost($field = null)
    {
        if (!empty($field))
        {
            return $this->isPost($field) ? strip_tags($_POST[$field]) : null;
        }
    }

    public function stickySelect($field, $value, $default = null)
    {
        if ($this->isPost($field) && $this->getPost($field) == $value)
        {
            return " selected=\"selected\"";
        }
        else
        {
            return !empty($default) && $default == $value ?
                " selected=\"selected\"" :
                null;
        }
    }

    public function stickyText($field, $value = null)
    {
        if ($this->isPost($field))
        {
            return stripslashes($this->getPost($field));
        }
        else
        {
            return !empty($value) ? $value : null;
        }
    }

    /**
     * Get countries for select option for the form
     *
     * @param null $record
     * @return string
     */
    public function getCountriesSelect($record = null)
    {
        $objCountry = new Country();
        $countries = $objCountry->getCountries();

        if (!empty($countries))
        {
            $out = "<select name=\"country\" id=\"country\" class='sel'>";
            if (empty($record))
            {
                $out .= "<option value=\"\">Select one&hellip;</option>";
            }

            foreach ($countries as $country)
            {
                $out .= "<option value=\"";
                $out .= $country['id'];
                $out .= "\"";
                $out .= $this->stickySelect('country', $country['id'], $record);
                $out .= ">";
                $out .= $country['name'];
                $out .= "</option>";
            }

            $out .= "</select>";
            return $out;
        }
    }
}