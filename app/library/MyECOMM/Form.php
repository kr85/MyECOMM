<?php namespace MyECOMM;

/**
 * Class Form
 */
class Form {

    /**
     * Check if a field is posted
     *
     * @param null $field
     * @return bool
     */
    public function isPost($field = null) {

        if (!empty($field)) {
            if (isset($_POST[$field])) {
                return true;
            }

            return false;
        } else {
            if (!empty($_POST)) {
                return true;
            }

            return false;
        }
    }

    /**
     * Get post with field if available
     *
     * @param null $field
     * @return null|string
     */
    public function getPost($field = null) {

        if (!empty($field)) {
            return $this->isPost($field) ?
                strip_tags($_POST[$field]) :
                null;
        }

        return null;
    }

    /**
     * Keep select input after refresh
     *
     * @param $field
     * @param $value
     * @param null $default
     * @return null|string
     */
    public function stickySelect($field, $value, $default = null) {

        if ($this->isPost($field) && $this->getPost($field) == $value) {
            return " selected=\"selected\"";
        } else {
            return !Helper::isEmpty($default) && $default == $value ?
                " selected=\"selected\"" :
                null;
        }
    }

    /**
     * Keep text input after refresh
     *
     * @param $field
     * @param null $value
     * @return null|string
     */
    public function stickyText($field, $value = null) {
        if ($this->isPost($field)) {
            return stripslashes($this->getPost($field));
        } else {
            return !empty($value) ?
                $value :
                null;
        }
    }

    /**
     * Keep the radio button selection after a refresh
     *
     * @param null $field
     * @param null $value
     * @param null $data
     * @return null|string
     */
    public function stickyRadio($field = null, $value = null, $data = null) {
        $post = $this->getPost($field);
        if (!Helper::isEmpty($post)) {
            if ($post == $value) {
                return ' checked="checked"';
            }
        } else {
            return (!Helper::isEmpty($data) && $value == $data) ?
                ' checked="checked"' :
                null;
        }
        return null;
    }

    /**
     * Add a class to a html element
     *
     * @param null $field
     * @param null $value
     * @param null $data
     * @param null $class
     * @param bool $single
     * @return string
     */
    public function stickyRemoveClass(
        $field = null, $value = null, $data = null,
        $class = null, $single = false
    ) {
        $post = $this->getPost($field);
        if (!Helper::isEmpty($post)) {
            if ($post != $value) {
                return $single ?
                    ' class="'.$class.'"' :
                    ' '.$class;
            }
        } else {
            if ($value != $data) {
                return $single ?
                    ' class="'.$class.'"' :
                    ' '.$class;
            }
        }
        return null;
    }

    /**
     * Get countries for select option for the form
     *
     * @param null $record
     * @param string $name
     * @param bool $selectOption
     * @param null $class
     * @return null|string
     */
    public function getCountriesSelect(
        $record = null, $name = 'country', $selectOption = false, $class = null
    ) {

        $objCountry = new Country();
        $countries = $objCountry->getCountries();

        if (!empty($countries)) {

            $out = "<select
                        name='{$name}'
                        id='{$name}'
                        class='{$class}'";
            $out .= "title='Please select a country.'
                    >";

            if (empty($record) || $selectOption == true) {
                $out .= "<option value=''>Select one&hellip;</option>";
            }

            foreach ($countries as $country) {

                $out .= "<option value=\"";
                $out .= $country['id'];
                $out .= "\"";
                $out .= $this->stickySelect(
                    $name,
                    $country['id'],
                    $record
                );
                $out .= ">";
                $out .= $country['name'];
                $out .= "</option>";
            }

            $out .= "</select>";

            return $out;
        }

        return null;
    }

    /**
     * Get sections for select option for the form
     *
     * @param null $record
     * @param string $name
     * @param bool $selectOption
     * @param null $class
     * @return null|string
     */
    public function getSectionsSelect(
        $record = null, $name = 'section', $selectOption = false, $class = null
    ) {

        $objCatalog = new Catalog();
        $sections = $objCatalog->getSectionsIncludeDefault();

        if (!empty($sections)) {

            $out = "<select
                        name='{$name}'
                        id='{$name}'
                        class='{$class} sections-select'";
            $out .= "title='Please select a section.'>";

            if (Helper::isEmpty($record) || $selectOption == true) {
                $out .= "<option value=''>Select one&hellip;</option>";
            }

            foreach ($sections as $section) {

                $out .= "<option value=\"";
                $out .= $section['id'];
                $out .= "\"";
                $out .= $this->stickySelect(
                    $name,
                    $section['id'],
                    $record
                );
                $out .= ">";
                $out .= $section['name'];
                $out .= "</option>";
            }

            $out .= "</select>";
            return $out;
        }

        return null;
    }

    /**
     * Get categories for select option for the form
     *
     * @param null $record
     * @param string $name
     * @param bool $selectOption
     * @param null $class
     * @return null|string
     */
    public function getCategoriesSelect(
        $record = null, $name = 'category', $selectOption = false, $class = null
    ) {

        $objCatalog = new Catalog();
        $categories = $objCatalog->getCategoriesIncludeDefault();

        if (!empty($categories)) {

            $out = "<select
                        name='{$name}'
                        id='{$name}'
                        class='{$class}'";
            $out .= "title='Please select a category.'>";

            if (Helper::isEmpty($record) || $selectOption == true) {
                $out .= "<option value=''>Select one&hellip;</option>";
            }

            foreach ($categories as $category) {

                $out .= "<option value=\"";
                $out .= $category['id'];
                $out .= "\"";
                $out .= $this->stickySelect(
                    $name,
                    $category['id'],
                    $record
                );
                $out .= ">";
                $out .= $category['name'];
                $out .= "</option>";
            }

            $out .= "</select>";
            return $out;
        }

        return null;
    }

    /**
     * Get section's categories for select option for the form
     *
     * @param null $sectionId
     * @param null $record
     * @param string $name
     * @return string
     */
    public function getSectionCategoriesSelect(
        $sectionId = null, $record = null, $name = 'category'
    ) {

        $objCatalog = new Catalog();
        $categories = $objCatalog->getCategoriesBySection($sectionId);

        if (!empty($categories)) {

            $out = "<select
                        name='{$name}'
                        id='{$name}'
                        class='categories-select'";
            $out .= "title='Please select a category.'>";

            foreach ($categories as $category) {

                $out .= "<option value=\"";
                $out .= $category['id'];
                $out .= "\"";
                $out .= $this->stickySelect(
                    $name,
                    $category['id'],
                    $record
                );
                $out .= ">";
                $out .= $category['name'];
                $out .= "</option>";
            }

            $out .= "</select>";
            return $out;
        } else {
            $category = $objCatalog->getCategory(0);
            $out = "<select
                        name='{$name}'
                        id='{$name}'";
            $out .= "title='Please select a category.'>";
            $out .= "<option value=\"";
            $out .= $category['id'];
            $out .= "\"";
            $out .= ">";
            $out .= $category['name'];
            $out .= "</option>";
            $out .= "</select>";
            return $out;
        }
    }

    /**
     * Get states for the form select option
     *
     * @param null $use
     * @param int $countryId
     * @param null $record
     * @param string $name
     * @param bool $selectOption
     * @param null $class
     * @return null|string
     */
    public function getCountryStatesSelect(
        $use = null, $countryId = 230, $record = null, $name = 'state', $selectOption = false,
        $class = null
    ) {
        $objCountry = new Country();

        if (!empty($record) && !empty($use) && $use == 'input') {
            if (is_numeric($record)) {
                $record = $objCountry->getStateById($record);
                $record = $record['name'];
            }

            $out = "<input
                   type='text'
                   name='{$name}'
                   id='{$name}''
                   class='input'";
            $out .= $class;
            $out .= ' title="Please enter a state."
                   value="';
            $out .= $this->stickyText($name, $record);
            $out .= '"/>';
            return $out;
        } else {
            $states = $objCountry->getStates($countryId);

            if (!empty($states)) {
                $out = "<select
                        name='{$name}'
                        id='{$name}'
                        class='{$class}'";
                $out .= "title='Please select your state.'
                    >";
                if (empty($record) || $selectOption == true) {
                    $out .= "<option value=''>Select one&hellip;</option>";
                }
                foreach ($states as $state) {
                    $out .= "<option value=\"";
                    $out .= $state['id'];
                    $out .= "\"";
                    $out .= $this->stickySelect(
                        $name,
                        $state['id'],
                        $record['id']
                    );
                    $out .= ">";
                    $out .= $state['name'];
                    $out .= "</option>";
                }
                $out .= "</select>";
                return $out;
            }
        }
        return null;
    }

    /**
     * Get posted fields
     *
     * @param null $expected
     * @return array
     */
    public function getPostArray($expected = null) {

        $out = [];

        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                if (!empty($expected)) {
                    if (in_array($key, $expected)) {
                        $out[$key] = strip_tags($value);
                    }
                } else {
                    $out[$key] = strip_tags($value);
                }
            }
        }

        return $out;
    }
}