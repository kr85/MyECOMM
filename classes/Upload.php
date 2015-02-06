<?php

    /**
     * Class Upload
     */
    class Upload {

        public $files = [];
        public $overwrite = false;
        public $errors = [];
        public $names = [];

        /**
         * Constructor
         */
        public function __construct() {

            $this->getUploads();
        }

        /**
         * Get all files to be uploaded
         */
        public function getUploads() {

            if (!empty($_FILES)) {
                foreach ($_FILES as $key => $value) {
                    $this->files[$key] = $value;
                }
            }
        }

        /**
         * Upload an image
         *
         * @param null $path
         * @return bool
         */
        public function upload($path = null) {

            if (!empty($path) && is_dir($path) && !empty($this->files)) {

                foreach ($this->files as $key => $value) {

                    $name = Helper::cleanString($value['name']);

                    if ($this->overwrite == false && is_file(
                            $path . DS . $name
                        )
                    ) {
                        $prefix = date('YmdHis', time());
                        $name = $prefix . "-" . $name;
                    }

                    if (!move_uploaded_file(
                        $value['tmp_name'],
                        $path . DS . $name
                    )
                    ) {
                        $this->errors[] = $key;
                    }

                    $this->names[] = $name;
                }

                return empty($this->errors) ?
                    true :
                    false;
            }

            return false;
        }
    }