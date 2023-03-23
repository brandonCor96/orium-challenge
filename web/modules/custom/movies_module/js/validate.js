(function ($, Drupal) {
  Drupal.behaviors.moviesValidate = {
    attach: function (context, settings) {
        
        $(document).ready(function(){
            $('.js-form-item-release-date-0-value-date input').on('change', function(){
                const inputDate = new Date($(this).val());
                const currentDate = new Date();
                
                if (inputDate > currentDate) {
                    // Date is in the future
                    $(this).removeClass('is-valid');
                    $(this).addClass('is-invalid');
                    console.log('Date in future!!');
                } else {
                    // Date is not in the future
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                }
            });
        });        
    }
  };
})(jQuery, Drupal);
