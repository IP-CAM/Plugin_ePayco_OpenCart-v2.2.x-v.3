<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-payco" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><img src="https://369969691f476073508a-60bf0867add971908d4f26a64519c2aa.ssl.cf5.rackcdn.com/logos/logo_epayco_200px.png" alt="ePayco" /> </h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
      <div style="color: #31708f; background-color: #d9edf7; border-color: #bce8f1;padding: 10px;border-radius: 5px;"><?php echo $text_info; ?>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-payco" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10" style="margin-top: 10px;">
              <!-- <select name="payco_status" id="input-status" class="form-control">
                <?php if ($payco_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select> -->
              <label for="payco_status">
                <input class="" style="margin-right: 10px;" type="checkbox" name="payco_status" id="payco_status" value="1" <?php if ( (int) $payco_status == 1 ):?> checked="true" <?php endif ?>><?php echo $entry_status_description; ?>
              </label>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-title"><?php echo $entry_title; ?></label>
            <div class="col-sm-10">
              <input type="text" name="payco_title" value="<?php echo $payco_title; ?>" placeholder="<?php echo substr($entry_title, 0, -1); ?>" id="input-merchant" class="form-control" />
              <p style="margin: 2px 5px;color: #afaeae;"><?php echo $entry_title_description; ?></p>
              <?php if ($error_title) { ?>
              <div class="text-danger"><?php echo $error_title; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-description"><?php echo $entry_description; ?></label>
            <div class="col-sm-10">
              <input type="text" name="payco_description" value="<?php echo $payco_description; ?>" placeholder="<?php echo substr($entry_description, 0, -1); ?>" id="input-merchant" class="form-control" />
              <p style="margin: 2px 5px;color: #afaeae;"><?php echo $entry_description_description; ?></p>
              <?php if ($error_description) { ?>
              <div class="text-danger"><?php echo $error_description; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-merchant"><?php echo $entry_merchant; ?></label>
            <div class="col-sm-10">
              <input type="text" name="payco_merchant" value="<?php echo $payco_merchant; ?>" placeholder="<?php echo substr($entry_merchant, 0, -1); ?>" id="input-merchant" class="form-control" />
              <p style="margin: 2px 5px;color: #afaeae;"><?php echo $entry_merchant_description; ?></p>
              <?php if ($error_merchant) { ?>
              <div class="text-danger"><?php echo $error_merchant; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-key"><?php echo $entry_key; ?></label>
            <div class="col-sm-10">
              <input type="text" name="payco_key" value="<?php echo $payco_key; ?>" placeholder="<?php echo substr($entry_key, 0, -1); ?>" id="input-key" class="form-control" />
              <p style="margin: 2px 5px;color: #afaeae;"><?php echo $entry_key_description; ?></p>
              <?php if ($error_key) { ?>
              <div class="text-danger"><?php echo $error_key; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-public_key"><?php echo $entry_public_key; ?></label>
            <div class="col-sm-10">
              <input type="text" name="payco_public_key" value="<?php echo $payco_public_key; ?>" placeholder="<?php echo substr($entry_public_key, 0, -1); ?>" id="input-public_key" class="form-control" />
              <p style="margin: 2px 5px;color: #afaeae;"><?php echo $entry_public_key_description; ?></p>
              <?php if ($error_public_key) { ?>
              <div class="text-danger"><?php echo $error_public_key; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-callback"><?php echo $entry_callback; ?></label>
            <div class="col-sm-10">
              <input placeholder="<?php echo substr($entry_callback, 0, -1); ?>" name="payco_callback" id="input-callback" class="form-control" value="<?php echo $payco_callback; ?>"/>
              <p style="margin: 2px 5px;color: #afaeae;"><?php echo $entry_callback_description; ?></p>
              <?php if ($error_callback) { ?>
              <div class="text-danger"><?php echo $error_callback; ?></div>
               <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-confirmation"><?php echo $entry_confirmation; ?></label>
            <div class="col-sm-10">
              <input placeholder="<?php echo substr($entry_confirmation, 0, -1); ?>" name="payco_confirmation" id="input-confirmation" class="form-control" value="<?php echo $payco_confirmation; ?>"/>
              <p style="margin: 2px 5px;color: #afaeae;"><?php echo $entry_confirmation_description; ?></p>
              <?php if ($error_confirmation) { ?>
              <div class="text-danger"><?php echo $error_confirmation; ?></div>
               <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_test; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <?php if ($payco_test) { ?>
                <input type="radio" name="payco_test" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="payco_test" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if (!$payco_test) { ?>
                <input type="radio" name="payco_test" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="payco_test" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
              <p style="margin: 5px 5px;color: #afaeae;"><?php echo $entry_test_description; ?></p>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-checkout-type"><?php echo $entry_checkout_type; ?></label>
            <div class="col-sm-10">
              <select name="payco_checkout_type" id="input-checkout-type" class="form-control">
           <!--      <option value="false" <?php if ( $payco_checkout_type == 'false' ):?> selected="true" <?php endif ?>>Onpage Checkout</option>
                <option value="true" <?php if ( $payco_checkout_type == 'true' ):?> selected="true" <?php endif ?>>Standart Checkout</option> -->
                <option value="true" selected="true">Standart Checkout</option>
              </select>
              <p style="margin: 5px 5px;color: #afaeae;"><?php echo $entry_checkout_type_description; ?></p>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-initial-order-status"><?php echo $entry_initial_order_status; ?></label>
            <div class="col-sm-10">
              <select name="payco_initial_order_status_id" id="input-initial-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $payco_initial_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <p style="margin: 5px 5px;color: #afaeae;"><?php echo $entry_initial_order_status_description; ?></p>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-final-order-status"><?php echo $entry_initial_order_status; ?></label>
            <div class="col-sm-10">
              <select name="payco_final_order_status_id" id="input-final-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $payco_final_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <p style="margin: 5px 5px;color: #afaeae;"><?php echo $entry_final_order_status_description; ?></p>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="payco_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $payco_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="payco_sort_order" value="<?php echo $payco_sort_order; ?>" placeholder="<?php echo substr($entry_sort_order, 0, -1); ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>