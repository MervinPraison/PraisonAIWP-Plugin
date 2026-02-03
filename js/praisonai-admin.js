jQuery(document).ready(function($) {
    $('#praisonai_toggle_api_key').on('click', function() {
        var apiKeyField = $('#praisonai_openai_api_key_field');
        var fieldType = apiKeyField.attr('type');
        if (fieldType === 'password') {
            apiKeyField.attr('type', 'text');
            $(this).text('Hide');
        } else {
            apiKeyField.attr('type', 'password');
            $(this).text('Show');
        }
    });
});
