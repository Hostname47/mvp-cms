
let create_category_lock = true;
$('#create-category').on('click', function() {
    let wrapper = $('#create-category-section');
    // verify category inputs (in category.js file)
    if(!verify_category_inputs(wrapper)) return;
    if(!verify_category_parent(wrapper)) return;

    if(!create_category_lock) return;
    create_category_lock = false;

    let button = $(this);
    let spinner = button.find('.spinner');
    let buttonicon = button.find('.icon-above-spinner');

    button.addClass('dark-bs-disabled');
    buttonicon.addClass('none');
    spinner.removeClass('opacity0');
    spinner.addClass('inf-rotate');

    let data = {
        title: wrapper.find('.title').val(),
        title_meta: wrapper.find('.meta-title').val(),
        slug: wrapper.find('.slug').val(),
        description: wrapper.find('.description').val(),
    };
    let issubcategory = wrapper.find('.is-sub-category').val() == 'yes';
    if(issubcategory) {
        $('.hierarchy-category-id').each(function() {
            if($(this).is(':checked')) {
                data.parent_category_id = $(this).val();
                return false;
            }
        });
    }

    $.ajax({
        type: 'post',
        url: '/admin/categories',
        data: data,
        success: function(response) {
            window.location.href = response;
        },
        error: function(response) {
            button.removeClass('dark-bs-disabled');
            buttonicon.removeClass('none');
            spinner.addClass('opacity0');
            spinner.removeClass('inf-rotate');

            let errorObject = JSON.parse(response.responseText);
			let error = (errorObject.message) ? errorObject.message : (errorObject.error) ? errorObject.error : '';
			if(errorObject.errors) {
				let errors = errorObject.errors;
				error = errors[Object.keys(errors)[0]][0];
			}
			print_top_message(error, 'error');
            create_category_lock = true;
        }
    })
});
