<?php

/**
 * Class Paging
 */
class Paging
{
    private $records;
    private $maxPerPage;
    private $numberOfPages;
    private $numberOfRecords;
    private $current;
    private $offset = 0;
    private static $key = 'pg';
    public $url;

    /**
     * Constructor
     *
     * @param $row
     * @param int $max
     */
    public function __construct($row, $max = 10)
    {
        $this->records = $row;
        $this->numberOfRecords = count($this->records);
        $this->maxPerPage = $max;
        $this->url = Url::getCurrentUrl(self::$key);
        $current = Url::getParam(self::$key);
        $this->current = !empty($current) ? $current : 1;
        $this->getNumberOfPages();
        $this->getOffset();
    }

    /**
     * Get the number of pages
     */
    private function getNumberOfPages()
    {
        $this->numberOfPages = ceil($this->numberOfRecords / $this->maxPerPage);
    }

    /**
     * Get the pagination page offset
     */
    private function getOffset()
    {
        $this->offset = ($this->current - 1) * $this->maxPerPage;
    }

    /**
     * Get the records
     *
     * @return array
     */
    public function getRecords()
    {
        $out = [];

        if ($this->numberOfPages > 1)
        {
            $last = ($this->offset + $this->maxPerPage);

            for ($i = $this->offset; $i < $last; $i++)
            {
                if ($i < $this->numberOfRecords)
                {
                    $out[] = $this->records[$i];
                }
            }
        }
        else
        {
            $out = $this->records;
        }

        return $out;
    }

    /**
     * Get pagination links
     *
     * @return string
     */
    private function getLinks()
    {
        if ($this->numberOfPages > 1)
        {
            $out = [];

            // First link
            if ($this->current > 1)
            {
                $out[] = "<a href=\"".$this->url."\">First</a>";
            }
            else
            {
                $out[] = "<span>First</span>";
            }

            // Previous link
            if ($this->current > 1)
            {
                // Previous page number
                $id = ($this->current - 1);

                $url = $id > 1 ?
                    $this->url."&amp;".self::$key."=".$id :
                    $this->url;

                $out[] = "<a href=\"{$url}\">Previous</a>";
            }
            else
            {
                $out[] = "<span>Previous</span>";
            }

            // Next link
            if ($this->current != $this->numberOfPages)
            {
                // Next page number
                $id = ($this->current + 1);

                $url = $this->url."&amp;".self::$key."=".$id;
                $out[] = "<a href=\"{$url}\">Next</a>";
            }
            else
            {
                $out[] = "<span>Next</span>";
            }

            if ($this->current != $this->numberOfPages)
            {
                $url = $this->url."&amp;".self::$key."=".$this->numberOfPages;
                $out[] = "<a href=\"{$url}\">Last</a>";
            }
            else
            {
                $out[] = "<span>Last</span>";
            }

            return "<li>".implode("</li><li>", $out)."</li>";
        }
    }

    /**
     * Get pagination
     *
     * @return string
     */
    public function getPaging()
    {
        $links = $this->getLinks();

        if (!empty($links))
        {
            $out = "<ul class=\"paging\">";
            $out .= $links;
            $out .= "</ul>";

            return $out;
        }
    }
}