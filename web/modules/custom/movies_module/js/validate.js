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
                    // At this Point I could have added a property to disable
                    // the submit to add to the flow of the Front, however 
                    // for now this is assigned to the Back with the validation.
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
