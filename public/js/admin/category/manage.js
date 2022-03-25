$('#sort-categories-components-by-priority').on('click', function() {
    $('.categories-hierarchy-level').each(function() {
        // First check if admin enter an invalide priority value by mistake (character or empty string)
        let invalid_priority = false;
        let categories = $(this).find('.category-box').not($(this).find('.subcategories-box .category-box'));
        categories.each(function() {
            if(!parseInt($(this).find('.category-priority').first().val())) {
                invalid_priority = true;
                return false;
            }
        });
        if(invalid_priority) {
            print_top_message('A priority value of one of categories is invalid. (priority should be a number)', 'error');
            return;
        }
    
        // Reorder categories based on priority value in ascending order (using bubble sort)
        let count = categories.length;
        let i, j;
        for (i = 0; i < count-1; i++) {
            categories = $(this).find('.category-box').not($(this).find('.subcategories-box .category-box'));
            // (count-i-1) because last i elements will be in the right place
            for (j = 0; j < count-i-1; j++) {
                let categorya = $(categories[j]);
                let categoryb = $(categories[j+1]);
                let ca = parseInt(categorya.find('.category-priority').first().val());
                let cb = parseInt(categoryb.find('.category-priority').first().val());
    
                if(ca > cb) {
                    categorya.insertAfter(categoryb);
                    categories = $(this).find('.category-box').not($(this).find('.subcategories-box .category-box'));
                }
            }
        }
    });
});