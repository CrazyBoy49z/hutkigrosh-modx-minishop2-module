[[!$tpl.mspHutkigrosh.success.instructions? &order_number={$order_number}]]
<div id="hutkigrosh_buttons" class="">
    {if $webpay_button_enabled}
    {if $webpay_status and $webpay_status == 'payed'}
        <div class="alert alert-success" id="hutkigrosh_message">{'hutkigrosh.webpay.msg.success' | lexicon}</div>
    {elseif $webpay_status and $webpay_status == 'failed'}
        <div class="alert alert-danger"
             id="hutkigrosh_message">{'hutkigrosh.webpay.msg.failed' | lexicon}</div>
    {/if}
        <div id="webpay" class="ty-checkout-complete__buttons-left">
            {$webpay_form|nofilter}
        </div>
        <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jQuery/jquery-1.11.0.min.js"></script>
        <script>
            var webpay_form_button = $('#webpay input[type="submit"]');
            webpay_form_button.addClass('btn btn-default btn-primary ms2_link');
        </script>
    {/if}
    {if $alfaclick_button_enabled}
        <div id="alfaclick" class="ty-checkout-complete__buttons-right">
            <input type="hidden" value="{$alfaclick_bill_id}" id="bill_id"/>
            <input type="hidden" value="{$order_number}" id="order_id"/>
            <input type="tel" maxlength="20" value="{$alfaclick_phone}" id="phone"/>
            <a class="btn btn-default btn-primary ms2_link"
               id="alfaclick_button">{'hutkigrosh.alfaclick.label' | lexicon}</a>
        </div>
        <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jQuery/jquery-1.11.0.min.js"></script>
        <script>
            jQuery(document).ready(function ($) {
                $('#alfaclick_button').click(function () {
                    $.post('{$alfaclick_url}',
                        {
                            phone: $('#phone').val(),
                            bill_id: $('#bill_id').val(),
                            order_id: $('#order_id').val()
                        }
                    ).done(function (result) {
                        if (result.trim() == 'ok') {
                            $('#hutkigrosh_message').remove();
                            $('#webpay').before('<div class="alert alert-success" id="hutkigrosh_message">{"hutkigrosh.alfaclick.msg.success" | lexicon}</div>');
                        } else {
                            $('#hutkigrosh_message').remove();
                            $('#webpay').before('<div class="alert alert-danger" id="hutkigrosh_message">{"hutkigrosh.alfaclick.msg.failed" | lexicon}</div>');
                        }
                    })
                })
            });
        </script>
    {/if}
</div>

