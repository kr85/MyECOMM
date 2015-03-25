<?php

use MyECOMM\Plugin;

$countries = $objCountry->getAll();

require_once('_header.php');
?>

<div class="listing country-list">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li>
                <strong>
                    Countries
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Countries</h1>
    </div>
    <div class="country-add-box">
        <form method="post" class="ajax" data-action="<?php
            echo $this->objUrl->getCurrent(['action', 'id'], false, ['action', 'add']);
        ?>">
            <table>
                <tr>
                    <td>
                        <label for="name" class="">
                            Country Name: <em>*</em>
                        </label>
                    </td>
                    <td>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="fld"
                            placeholder="Add a new country..."
                        />
                    </td>
                    <td>
                        <button class="button" type="submit">
                                <span>
                                    <span>Add</span>
                                </span>
                        </button>
                    </td>
                </tr>
                <tr>
                   <td colspan="3" class="valid_name"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<div class="clearfix"></div>
<form method="post" data-url="<?php echo $this->objUrl->getCurrent(
        ['action', 'id'],
        false,
        ['action', 'update', 'id']).'/'; ?>"
>
    <div id="countryList">
        <?php echo Plugin::get('admin'.DS.'country', [
            'rows' => $countries,
            'objUrl' => $this->objUrl
        ]); ?>
    </div>
</form>

<?php require_once('_footer.php') ?>