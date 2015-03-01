$(function () {
    "use strict";
    adminObject.clickReplace('.click_replace');
    adminObject.clickCallReload('.click_call_reload');
    adminObject.clickYesNoSingle('.click_yes_no_single');
    adminObject.clickRemoveRowConfirm('.click_remove_row_confirm');
    adminObject.clickAddRowConfirm('.click_add_row_confirm');
    adminObject.clickRemoveRow('.click_remove_row');
    adminObject.clickHideShow('.click_hide_show');
    adminObject.blurUpdateHideShow('.blur_update_hide_show');
    adminObject.sortRows($('.sort_rows'));
    adminObject.submitAjax();
    adminObject.selectRedirect('.select_redirect');
});