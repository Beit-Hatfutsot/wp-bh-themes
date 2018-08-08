(function( $ ) {
'use strict';

    var $flowStrip = $('#donate-process-flow'),
        $csRadio = $('#custom-amount-radio'),
        $annualCheckBox = $('#annual-donation'),
        $csHotspot = $('.cs-hotspot'),
        $fixedAmountRadio = $('.fixed-amount'),
        $csField = $('#custom-amount-field'),
        $donationAmount = 0,
        $urlParams = new URLSearchParams(window.location.search),
        $fplan = $urlParams.get('fplan');
    
        if ( $fplan == 'gold' ) {
            $donationAmount = 700;
        } else if ( $fplan == 'premium' ) {
            $donationAmount = 1800;
        }

    function updateExampleImage() {
        $('#certificate-example').attr({
            'src': examplesUrls[activeType][activeLang]['src'],
            'alt': examplesUrls[activeType][activeLang]['alt']
        });
    }

    function displayDetailsState() {
        var $tabContentArea = $('#donate-process-options').find('.tab-content');

        $flowStrip.show();
        $('#donate-option-tabs').hide();
        $('.flow-amount').hide().prop('required',false);
        $tabContentArea.css('margin-top', '0');
        $('.tax-deduct').hide();
        $('.flow-details').show();
        $('#amount-fig').text($donationAmount);
    }

    function displayAmountState() {
        $('.flow-details').hide();
        $('#donate-layout-options').find($flowStrip).hide();
    }

    function validateDonationAmount() {

        var $amountAlert = $('#error-msg--amount'),
            $continueButton = $('#cont-to-details');

        if ( $donationAmount >= 5 && $donationAmount <= 40000 ) {
            $amountAlert.hide();
            $continueButton.attr('disabled', false);
        } else {
            $amountAlert.show();
            $continueButton.attr('disabled', true);
        }
    }

    $(document).ready(function () {

        $('#error-msg--amount').hide();

        if ( $urlParams.has('fplan') ) {
            displayDetailsState();
            $csRadio.val($donationAmount).prop('checked', true);

            if ( $urlParams.has('annual-donation') ) {
                $annualCheckBox.prop('checked', true);
            }

        } else {
            displayAmountState();
        }

    });

    $('#show-tribute').click(function(){

        var $tributeOnDemand = $('#tribute-gift').find('.on-demand');

        $tributeOnDemand.toggleClass('hide');
        $tributeOnDemand.attr( 'aria-expanded', function (i, currentState) {
            var newState = currentState == 'false' ? 'true' : 'false';
            return newState.toString();
        } );

    });

    $('#tribute-type').change(function () {
        activeType = $(this).val();
        $('#tribute-text').attr( 'placeholder', tribute_text_placehoder[activeType] );
        updateExampleImage();
    });

    $('#certificate-language').change(function () {
        activeLang = $(this).val();
        updateExampleImage();
    });

    $('#cont-to-details').click(function (event) {

        var $scrollTarget = $('#process-title').position();
        
        displayDetailsState();

        $('html, body').animate({
            scrollTop: $scrollTarget.top - 120}, 800);
        return false;
    });

    $('#need-name-on-receipt').click(function (event) {
        event.preventDefault();
        $('#name-on-receipt').removeClass('hide');
        $('#need-name-on-receipt').addClass('hide');
    });

    $csField.click(function () {
        $csRadio.prop("checked", true);
        $donationAmount = $csField.val();
        validateDonationAmount();
    });

    $csHotspot.click(function () {
        $csRadio.prop("checked", true);
        $donationAmount = $csField.val();
        validateDonationAmount();
    });

    $csField.keyup(function () {
        var cs = $csField.val();
        $csRadio.val(cs);
        $donationAmount = $csField.val();
        validateDonationAmount();
    });

    $fixedAmountRadio.click(function () {
        $donationAmount = $('input[name="donationAmount"]:checked').val();
        validateDonationAmount();
    })

})(jQuery);
