$(document).on('mouseover', '.remove', function () {
    $(this).closest('label').find('input').prop('disabled', true)
})

$(document).on('mouseout', '.remove', function () {
    $(this).closest('label').find('input').prop('disabled', false)
})

function removeImage(obj)
{
    $(obj).closest('label').remove();
}


function addMore()
{
    let nextImage = Math.floor(Math.random() * 26) + Date.now();

    $('#more__img').append(
        `<label class="upload-image" for="image${nextImage}">
            <input type="file" class="multiple-image" id="image${nextImage}" name="multiple_image[]" accept="image/*" onchange="loadPhoto(this, 'loadImage${nextImage}')">
            <img id="loadImage${nextImage}" class="img-responsive" style="display: none">
            <span class="remove" onclick="removeImage(this)"><i class="fas fa-times"></i></span>
        </label>`
    );
}

function addMoreByKey(obj)
{
    
    let key = $(obj).attr('key');
    let nextImage = Math.floor(Math.random() * 26) + Date.now() + '-' + key;


    $('#more__img').append(
        `<label class="upload-image upload-image-${key}" for="image${nextImage}">
            <input type="file" class="multiple-image multiple-image-${key}" id="image${nextImage}" name="variation_image_${ key }[]" accept="image/*" onchange="loadPhotoByKey(this, 'loadImage${nextImage}')">
            <img id="loadImage${nextImage}" class="img-responsive" style="display: none">
            <span class="remove" data-key="${key}" data-next-image="${nextImage}" onclick="removeImage(this)"><i class="fas fa-times"></i></span>
        </label>`
    );
}

function loadPhotoByKey(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#'+id).css('display','block');
            $('#'+id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function loadNewAddImagesWithKey(key)
{
    $('.upload-image').hide();
    if ($('.upload-image-'+key).closest('#more__img').attr('key') == key) {

        $('.upload-image-'+key).show()
    }
    
}


function loadPhoto(input,id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#'+id).css('display','block');
            $('#'+id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).on('click', '.check-image', function() {
    if($(this).find('.image-checked').prop("checked") === true){
        
        key = $(this).attr('key')

        parent_id = $(this).data('parent-id')
        image_path = $(this).data('image-path')
        appendImages(key, parent_id, image_path)
    }
    else if($(this).find('.image-checked').prop("checked") === false) {

        key = $(this).attr('key')
        parent_id = $(this).data('parent-id')

        removeImages(key, parent_id)
    }
});


$(document).ready(function () {
    $('#multipleImageModal').on('show.bs.modal', function (event) {

        let button = $(event.relatedTarget)
        let key = button.data('key');
        let product_variation_id = button.data('variation-id');
        let image_count = Number(button.data('image-count'));

        let modal = $(this)
        modal.find('.modal-body #more__img').attr('key', key);
        modal.find('.modal-body .check-image').attr('key', key);
        modal.find('.modal-body .add-more').attr('key', key);
        modal.find('.modal-body .add-more').addClass('add-more-' + key);
        modal.find('.modal-body .gallery-images').addClass('gallery-images-' + key);


        loadNewAddImagesWithKey(key)
        checkImageCheckedOrNot(key)

        if (image_count > 0) {
            getVariationImages(key, product_variation_id)
        } else {
            $('.gallery-images').empty()
        }
    })
});


function appendImages(key, parent_id, image_path)
{
    $('#appendVariationImages').append(`
        <input type="hidden" data-key="${key}" data-parent-id="${parent_id}" class="variation-image variation-image-${key}" name="multiple_variation_img_${key}[]" value="${image_path}">
        <input type="hidden" data-key="${key}" data-parent-id="${parent_id}" class="variation-image-parent-id" name="multiple_variation_img_parent_id_${key}[]" value="${parent_id}">
    `)
}


function appendDefaultVariationImagesInput()
{
    $('#appendDefaultVariationImagesInput').empty()

    // console.log($('.variation_sku').length)
    $('.variation_sku').each(function (key) {
        $('#appendDefaultVariationImagesInput').append(`
            <input type="hidden" name="variation_image_${ key }[]" value="">
            <input type="hidden" name="multiple_variation_img_${key}[]" value="">
            <input type="hidden" name="multiple_variation_img_parent_id_${key}[]" value="">
        `)
    })
}
appendDefaultVariationImagesInput()


function removeImages(key, parent_id)
{
    $('[data-parent-id]').each(function(){
        let _this_key = $(this).data('key');

        if ($(this).data('parent-id') == parent_id && _this_key == key) {
            $(this).remove();
        }
    })
}


function checkedImage(key)
{
    $('.variation-image-'+key).each(function () {
        let _this_path = $(this).val();

        $('.check-image').each(function () {

            let image_path = $(this).data('image-path');

            if (image_path == _this_path) {
                $(this).find('.image-checked').prop('checked', true);
            }
        })
    })
}


function checkImageCheckedOrNot(key)
{
    $('.image-checked').prop('checked', false).prop('disabled', false);
    $('.check-image').prop('disabled', false)

    checkedImage(key)
}


function imageCheckedAndDisabled(key)
{
    key = Number(key)

    if ($('.gallery-image-'+key).length > 0) {

        $('.image-checked').prop('checked', false).prop('disabled', false);
        $('.check-image').prop('disabled', false)

        $('.gallery-image-'+key).each(function () {
            let _this_path = $(this).data('image-path');

            $('.check-image').each(function () {

                let image_path = $(this).data('image-path');

                if (image_path == _this_path) {
                    $(this).prop('disabled', true)
                    $(this).find('.image-checked').prop('checked', true).prop('disabled', true);
                }
            })
        })

        checkedImage(key)
    }
}