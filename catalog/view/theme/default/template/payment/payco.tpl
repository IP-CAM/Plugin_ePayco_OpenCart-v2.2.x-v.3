<!--<p style="color:red"><?php echo $alert_comision; ?></p>!-->

<div class="buttons">
  <div class="pull-right">
    <input id="button_confirm" type="submit" disabled="true" value="<?php echo $button_confirm; ?>" class="btn btn-primary" />
  </div>
</div>

<form id="epayco_form" style="display: none;">
    <script
        src="https://checkout.epayco.co/checkout.js"
        class="epayco-button"
        data-epayco-key="<?php echo $p_public_key; ?>"
        data-epayco-invoice ="<?php echo $p_id_invoice ?>"
        data-epayco-amount="<?php echo $p_amount; ?>"
        data-epayco-tax="<?php echo $p_tax; ?>"
        data-epayco-tax-base="<?php echo $p_amount_base; ?>"
        data-epayco-name="<?php echo $p_itemname; ?>"
        data-epayco-description="<?php echo $p_description; ?>"
        data-epayco-currency="<?php echo $p_currency_code; ?>"
        data-epayco-country="co"
        data-epayco-name-billing="<?php echo $p_billing_first_name.' '.$p_billing_last_name; ?>"
        data-epayco-address-billing="<?php echo $p_billing_address; ?>"
        data-epayco-email-billing="<?php echo $p_email; ?>"
        data-epayco-mobilephone-billing="<?php echo $p_billing_phone; ?>"
        data-epayco-test="<?php echo $p_test_mode; ?>"
        data-epayco-external="<?php echo $p_payco_checkout_type; ?>"
        data-epayco-response="<?php echo $p_url_response; ?>"
        data-epayco-confirmation="<?php echo $p_url_confirmation; ?>"
        data-extra1="<?php echo $p_extra1 ?>">
    </script>
</form>

<script type="text/javascript">
  $("#button_confirm").on( "click", function(e) {
    e.preventDefault();
    $( ".epayco-button-render" ).trigger( "click" );

  });

  document.getElementById("epayco_form").addEventListener("DOMNodeInserted", function (event) {
    document.getElementById("button_confirm").removeAttribute("disabled");
  }, false);
</script>