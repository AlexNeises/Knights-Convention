(function() {
  $(document).ready(function() {
    $('#text_other').on('click', function() {
      if ($(this).is('[readonly]')) {
        return $('#check_other').click();
      }
    });
    $('#check_other').change(function() {
      if (this.checked) {
        $('#text_other').attr('readonly', false);
        return $('#text_other').focus();
      } else {
        return $('#text_other').attr('readonly', true);
      }
    });
    $('#text_district').on('click', function() {
      if ($(this).is('[readonly]')) {
        return $('#check_district').click();
      }
    });
    $('#check_district').change(function() {
      if (this.checked) {
        $('#text_district').attr('readonly', false);
        return $('#text_district').focus();
      } else {
        return $('#text_district').attr('readonly', true);
      }
    });
    $('#text_chaplain').on('click', function() {
      if ($(this).is('[readonly]')) {
        return $('#check_chaplain').click();
      }
    });
    $('#check_chaplain').change(function() {
      if (this.checked) {
        $('#text_chaplain').attr('readonly', false);
        return $('#text_chaplain').focus();
      } else {
        return $('#text_chaplain').attr('readonly', true);
      }
    });
  });

}).call(this);
