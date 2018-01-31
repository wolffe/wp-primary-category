/**
 * Append primary category to dropdown selector
 *
 * @param categoryId    int Category ID
 * @param categoryLabel string Category name
 */
function addPrimaryCategory(categoryId, categoryLabel) {
    jQuery('#wppc_primary_category').append(jQuery('<option>', {
        value: categoryId,
        text: categoryLabel,
    }));
}

/**
 * Remove primary category from dropdown selector
 *
 * @param categoryId    int Category ID
 */
function removePrimaryCategory(categoryId) {
    jQuery('#wppc_primary_category option[value="' + categoryId + '"]').remove();
}

jQuery(document).ready(function() {
    /**
     * Add selected categories to primary category dropdown
     */
    jQuery('ul#categorychecklist input[type="checkbox"]').each(function() {
        if (jQuery(this).is(':checked')) {
            addPrimaryCategory(jQuery(this).val(), jQuery(this).parent().text());
        }
    });

    /**
     * Set primary category
     */
    var getPrimaryCategory = jQuery('#wppc_primary_category').data('primary-category');

    jQuery('#wppc_primary_category').val(getPrimaryCategory);

    /**
     * Add category to primary category dropdown on select
     */
    jQuery(document).on('click', 'ul#categorychecklist label', function() {
        var getCategoryId = jQuery(this).find('input[type=checkbox]'),
            getLabel = jQuery(this).text();

        if (getCategoryId.is(':checked')) {
            addPrimaryCategory(getCategoryId.val(),getLabel);
        } else {
            removePrimaryCategory(getCategoryId.val());
        }
    });
});
