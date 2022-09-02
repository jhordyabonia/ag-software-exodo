define(['jquery'], ($)=>{
    'use strict';
    function hiddeOffertFields(val){
        if(val == 0) {
            $('[name*="offert"]').closest('div.admin__field').hide();
        }else{
            $('[name*="offert"]').closest('div.admin__field').show();
        }
        $('[name*="is_offert"]').closest('div.admin__field').show();
    };

    var mixin = {
        /**
         * @inheritdoc
         */
       onCheckedChanged: function () {
          let result = this._super();
          if(this.name == 'cms_block_form.cms_block_form.general.is_offert') {
              hiddeOffertFields(this.value());
          }
         return result;
        }
    };

    setTimeout(()=>{
        hiddeOffertFields($('[name*="is_offert"]').val());
    },500);

    return function (target) {
        return target.extend(mixin);
    };
});
