<?php

use MyECOMM\Catalog;
use MyECOMM\Helper;
use MyECOMM\Paging;

$id = $this->objUrl->get('id');

if (!empty($id)) {

    $objCatalog = new Catalog();
    $section = $objCatalog->getSection($id);

    if (!empty($section)) {

        $yes = $this->objUrl->getCurrent().'/remove/1';
        $no = 'javascript:history.go(-1)';

        $remove = $this->objUrl->get('remove');

        if (!empty($remove) && $section['categories_count'] == 0) {
            $objCatalog->removeSection($id);

            Helper::redirect(
                $this->objUrl->getCurrent([
                    'action',
                    'id',
                    'remove',
                    'search',
                    Paging::$key
                ]));
        }

        require_once('_header.php'); ?>
<div class="listing section-list">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li class="sections">
                <a href="/panel/sections" title="Go to Sections">Sections</a>
                <span>&nbsp;</span>
            </li>
            <li>
                <strong>
                    Remove
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Sections :: Remove</h1>
    </div>
    <p class="remove-yes-no">
        Are you sure you want to remove this section?
        <a href="<?php echo $yes; ?>">Yes</a> |
        <a href="<?php echo $no; ?>">No</a>
    </p>
</div>
<?php require_once('_footer.php');
    }
}
?>