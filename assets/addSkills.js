const nbExistingSkills = document.querySelectorAll('input[type=text]').length;

jQuery(document).ready(() => {
    const $skillsCollectionHolder = $('ul.skills');
    $skillsCollectionHolder.data('index', $skillsCollectionHolder.find('input').length);

    $('body').on('click', '.add_item_link', (e) => {
        const $collectionHolderClass = $(e.currentTarget).data('collectionHolderClass');
        addFormToCollection($collectionHolderClass);
    });

    $skillsCollectionHolder.find('li').each(() => {
        addTagFormDeleteLink($(this));
    });
});

function addFormToCollection($collectionHolderClass) {
    var $collectionHolder = $('.' + $collectionHolderClass);
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);

    $collectionHolder.data('index', index);

    var $newFormLi = $('<li></li>').append(newForm);
    $collectionHolder.append($newFormLi);
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($formLi) {
    var $removeFormButton = $('<button type="button">Delete this tag</button>');
    $formLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        $formLi.remove();
    });
}

