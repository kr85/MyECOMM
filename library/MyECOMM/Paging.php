<?php namespace MyECOMM;

/**
 * Class Paging
 */
class Paging {

    /**
     * @var Url|null Url instance
     */
    public $objUrl;

    /**
     * @var null The actual records
     */
    private $records;

    /**
     * @var int The maximum number of records per page
     */
    private $maxPerPage;

    /**
     * @var The number of pages
     */
    private $numberOfPages;

    /**
     * @var int The number of records
     */
    private $numberOfRecords;

    /**
     * @var bool|int The current page
     */
    private $current;

    /**
     * @var int The pagination offset
     */
    private $offset = 0;

    /**
     * @var string The key in the url
     */
    public static $key = 'pg';

    /**
     * @var string The url object instance
     */
    public $url;

    /**
     * Constructor
     *
     * @param null $objUrl
     * @param null $row
     * @param int $max
     */
    public function __construct($objUrl = null, $row = null, $max = 10) {
        $this->objUrl = is_object($objUrl) ? $objUrl : new Url();
        $this->records = $row;
        $this->numberOfRecords = count($this->records);
        $this->maxPerPage = $max;
        $this->url = $this->objUrl->getCurrent(self::$key);
        $current = $this->objUrl->get(self::$key);
        $this->current = !empty($current) ? $current : 1;
        $this->getNumberOfPages();
        $this->getOffset();
    }

    /**
     * Get the number of pages
     */
    private function getNumberOfPages() {
        $this->numberOfPages = ceil($this->numberOfRecords / $this->maxPerPage);
    }

    /**
     * Get the pagination page offset
     */
    private function getOffset() {
        $this->offset = ($this->current - 1) * $this->maxPerPage;
    }

    /**
     * Get the records
     *
     * @return array
     */
    public function getRecords() {
        $out = [];
        if ($this->numberOfPages > 1) {
            $last = ($this->offset + $this->maxPerPage);
            for ($i = $this->offset; $i < $last; $i++) {
                if ($i < $this->numberOfRecords) {
                    $out[] = $this->records[$i];
                }
            }
        } else {
            $out = $this->records;
        }
        return $out;
    }

    /**
     * Get pagination links
     *
     * @return string
     */
    private function getLinks() {
        if ($this->numberOfPages > 1) {
            $out = [];
            // First link
            if ($this->current > 1) {
                $out[] = "<a href=\"" . $this->url . PAGE_EXTENSION . "\">First</a>";
            } else {
                $out[] = "<span>First</span>";
            }
            // Previous link
            if ($this->current > 1) {
                // Previous page number
                $id = ($this->current - 1);
                $url = $id > 1 ?
                    $this->url . "/" . self::$key . "/" . $id . PAGE_EXTENSION :
                    $this->url . PAGE_EXTENSION;
                $out[] = "<a href=\"{$url}\">Previous</a>";
            } else {
                $out[] = "<span>Previous</span>";
            }
            // Next link
            if ($this->current != $this->numberOfPages) {
                // Next page number
                $id = ($this->current + 1);
                $url = $this->url . "/" . self::$key . "/" . $id . PAGE_EXTENSION;
                $out[] = "<a href=\"{$url}\">Next</a>";
            } else {
                $out[] = "<span>Next</span>";
            }

            if ($this->current != $this->numberOfPages) {
                $url = $this->url . "/" . self::$key . "/" . $this->numberOfPages . PAGE_EXTENSION;
                $out[] = "<a href=\"{$url}\">Last</a>";
            } else {
                $out[] = "<span>Last</span>";
            }
            return "<li>" . implode("</li><li>", $out) . "</li>";
        }
        return false;
    }

    /**
     * Get pagination
     *
     * @return string
     */
    public function getPaging() {
        $links = $this->getLinks();
        if (!empty($links)) {
            $out = "<ul class=\"paging\">";
            $out .= $links;
            $out .= "</ul>";
            return $out;
        }
        return false;
    }
}