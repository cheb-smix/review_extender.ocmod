<?php echo $header; ?><?php echo $column_left;  ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-review-extender" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-review-extender" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-module-class"><?php echo $entry_module_class; ?></label>
            <div class="col-sm-10">
              <select name="module_class" class="form-control">
                <option value="L" <?php echo $module_class=="L"?"selected":""; ?>><?php echo $text_module_class_list; ?></option>
                <option value="F" <?php echo $module_class=="F"?"selected":""; ?>><?php echo $text_module_class_form; ?></option>
              </select>
              <?php if ($error_module_class) { ?>
              <div class="text-danger"><?php echo $error_module_class; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-check-orders"><?php echo $entry_check_orders; ?></label>
            <div class="col-sm-10">
              <select name="check_orders" class="form-control">
                <option value="1" <?php echo $check_orders?"selected":""; ?>><?php echo $text_orders_check; ?></option>
                <option value="0" <?php echo !$check_orders?"selected":""; ?>><?php echo $text_orders_skip; ?></option>
              </select>
              <?php if ($error_check_orders) { ?>
              <div class="text-danger"><?php echo $error_check_orders; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="limit" value="<?php echo $limit; ?>" placeholder="<?php echo $entry_limit; ?>" id="input-limit" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-type"><?php echo $entry_type; ?></label>
            <div class="col-sm-10">
              <select name="type" class="form-control">
                <option value="0" <?php echo $type=="0"?"selected":""; ?>><?php echo $text_store_review; ?></option>
                <option value="-1" <?php echo $type=="-1"?"selected":""; ?>><?php echo $text_products_review; ?></option>
              </select>
              <?php if ($error_type) { ?>
              <div class="text-danger"><?php echo $error_type; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-rating"><?php echo $entry_rating; ?></label>
            <div class="col-sm-10">
              <select name="rating" class="form-control">
                <option <?php echo $rating==5?"selected":"";?>>5</option>
                <option <?php echo $rating==4?"selected":"";?>>4</option>
                <option <?php echo $rating==3?"selected":"";?>>3</option>
                <option <?php echo $rating==2?"selected":"";?>>2</option>
                <option <?php echo $rating==1?"selected":"";?>>1</option>
              </select>
              <?php if ($error_rating) { ?>
              <div class="text-danger"><?php echo $error_rating; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$("[name=module_class]").on("change",function(){
  if($("[name=module_class]").val()=="L"){
    $("[name=check_orders]").closest(".form-group").hide();
    $("[name=limit],[name=type],[name=rating]").closest(".form-group").show();
  }else{
    $("[name=check_orders]").closest(".form-group").show();
    $("[name=limit],[name=type],[name=rating]").closest(".form-group").hide();
  }
});
$("[name=module_class]").trigger("change");
</script>
<?php echo $footer; ?>
