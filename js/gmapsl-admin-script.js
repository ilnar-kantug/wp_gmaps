jQuery(document).ready(function ($) {
    /*start - toggle jquery checkbox*/
    $('.gmapsl-value').click(function () {
        var mainParent = $(this).parent('.gmapsl-toggle');
        if ($(mainParent).find('input.gmapsl-value').is(':checked')) {
            $(mainParent).addClass('active');
        } else {
            $(mainParent).removeClass('active');
        }
    });
    /*end - toggle jquery checkbox*/

    /*start - popup on the table page*/
    $('#silentPopUpOverlay').click(function () {
        $('#silentPopUp').hide();
        $('#silentPopUpOverlay').hide();
    });
    $('#silentPopUp span').click(function () {
        $('#silentPopUp').hide();
        $('#silentPopUpOverlay').hide();
    });
    /*end - popup on the table page*/
    
    $( "#gmaps_tabs" ).tabs();


});

//select text of a given element
function resmap_selectText(element) {
    var doc = document
        , text = doc.getElementById(element)
        , range, selection
        ;
    if (doc.body.createTextRange) {
        range = document.body.createTextRange();
        range.moveToElementText(text);
        range.select();
    } else if (window.getSelection) {
        selection = window.getSelection();
        range = document.createRange();
        range.selectNodeContents(text);
        selection.removeAllRanges();
        selection.addRange(range);
    }
}







/*ajax request to change an active parameter of a map(on the table page)*/
function gmapsl_change_active(sec_string, gmapsl_div_id, gmapsl_map_id) {
    var gmapsl_div = jQuery('#gmapsl-div-' + gmapsl_div_id);
    //alert(gmapsl_div.attr('data-toajax'));
    if (gmapsl_div.attr('data-toajax') == 0) {
        gmapsl_div.attr('data-toajax', '1');
    } else {
        gmapsl_div.attr('data-toajax', '0');
    }

    jQuery.ajax({
        type: "POST",
        data: {
            active: gmapsl_div.attr('data-toajax'),
            map_id: gmapsl_map_id,
            security_nonce: sec_string,
            action: 'gmapsl_change_active'
        },
        url: ajaxurl,
        beforeSend: function () {
            jQuery('#gmapsl-checkbox-' + gmapsl_div_id).prop( "disabled", true );
        },
        success: function (res) {
            //alert(res);
            jQuery('#silentPopUpOverlay').show();
            jQuery('#silentPopUp').show();
            jQuery('#silentPopUpText').text(res);
            jQuery('#gmapsl-checkbox-' + gmapsl_div_id).prop( "disabled", false );

        },
        error: function () {
            alert('Error!');
        },
        complete: function () {
            jQuery('#gmapsl-checkbox-' + gmapsl_div_id).prop( "disabled", false );
        }
    });
}