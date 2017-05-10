$(document).ready ->
    $('#news_editor').crevasse previewer: $('#news_previewer')
    $('#text_other').on 'click', ->
        if $(@).is '[readonly]'
            $('#check_other').click()
    $('#check_other').change ->
        if @.checked
            $('#text_other').attr 'readonly', false
            $('#text_other').focus()
        else
            $('#text_other').attr 'readonly', true

    $('#text_district').on 'click', ->
        if $(@).is '[readonly]'
            $('#check_district').click()
    $('#check_district').change ->
        if @.checked
            $('#text_district').attr 'readonly', false
            $('#text_district').focus()
        else
            $('#text_district').attr 'readonly', true

    $('#text_chaplain').on 'click', ->
        if $(@).is '[readonly]'
            $('#check_chaplain').click()
    $('#check_chaplain').change ->
        if @.checked
            $('#text_chaplain').attr 'readonly', false
            $('#text_chaplain').focus()
        else
            $('#text_chaplain').attr 'readonly', true
    return