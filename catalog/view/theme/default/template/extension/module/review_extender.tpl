
<?php if ($module_class=="L") { ?>
<?php if ($reviews) { ?>
  <legend><?php echo $heading_title; ?></legend>
  <div class="row">
  <?php foreach ($reviews as $review) { ?>
  <div class="col-12">
  <table class="table table-striped table-bordered">
    <tr>
      <td style="width: 50%;"><strong><?php echo $review['author']; ?></strong></td>
      <td class="text-right"><?php echo $review['date_added']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><p><?php echo $review['text']; ?></p>
        <?php for ($i = 1; $i <= 5; $i++) { ?>
        <?php if ($review['rating'] < $i) { ?>
        <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
        <?php } else { ?>
        <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
        <?php } ?>
        <?php } ?></td>
    </tr>
  </table>
  </div>
  <?php } ?>
<?php } ?>
<?php } elseif ($module_class=="F"){ ?>
<hr>
  <legend><?php echo $heading_title; ?></legend>
  <div class="row">
    <div class="col-12">
              <form class="form-horizontal" id="form-store-review">
                <div id="store-review"></div>
                <?php if ($review_guest && $allowed_to_review) { ?>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                    <input type="text" name="name" value="<?php echo $customer_name; ?>" id="input-store-name" class="form-control" />
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
                    <textarea name="text" rows="5" id="input-store-review" class="form-control"></textarea>
                    <div class="help-block"><?php echo $text_note; ?></div>
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label"><?php echo $entry_rating; ?></label>
                    &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                    <input type="radio" name="rating" value="1" />
                    &nbsp;
                    <input type="radio" name="rating" value="2" />
                    &nbsp;
                    <input type="radio" name="rating" value="3" />
                    &nbsp;
                    <input type="radio" name="rating" value="4" />
                    &nbsp;
                    <input type="radio" name="rating" value="5" />
                    &nbsp;<?php echo $entry_good; ?></div>
                </div>
                <?php echo $captcha; ?>
                <div class="buttons clearfix">
                  <div class="pull-right">
                    <button type="button" id="btnSubmit" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
                  </div>
                </div>
                <?php } else { ?>
                  <?php 
                    if(!$review_guest){
                      echo $text_login; 
                    }elseif($review_guest && !$allowed_to_review){
                      echo $text_no_orders;
                    }
                  ?>
                <?php } ?>
              </form>
    </div>
  </div>
  <script>
  $('#btnSubmit').on('click', function() {
    console.log(event.target);
    $.ajax({
      url: 'index.php?route=extension/module/review_extender/review',
      type: 'post',
      dataType: 'json',
      data: $("#form-store-review").serialize(),
      beforeSend: function() {
        $('#button-review').button('loading');
      },
      complete: function() {
        $('#button-review').button('reset');
      },
      success: function(json) {
        $('.alert-success, .alert-danger').remove();

        if (json['error']) {
          $('#store-review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
        }

        if (json['success']) {
          $('#store-review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

          $('input[name=\'name\']').val('');
          $('textarea[name=\'text\']').val('');
          $('input[name=\'rating\']:checked').prop('checked', false);
        }
      },
      error: function(data) {
        console.log(data.responseText);
      }
    });
  });
  </script>
<?php } ?>
