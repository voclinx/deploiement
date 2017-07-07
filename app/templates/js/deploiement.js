jQuery(document).ready(function () {
    jQuery("#deploiement-bt").click(function (e){
	if(	jQuery('input[name="environnement"]').val()!=null&&
		jQuery('input[name="environnement"]').val()!=""&&
		jQuery('input[name="vers"]').val()!=null&&
		jQuery('input[name="vers"]').val()!="")
	{
        	jQuery('#loader').show();
	}
    });
    jQuery(".glyph-deploy").click(function (e) {
        jQuery('form[name="form-deploiement"]').attr('action', '');
        id = jQuery(this).attr('data-id');
        link = 'index.php?action=livraison&id=' + id;
        jQuery('form[name="form-deploiement"]').attr('action', link);
    });

    jQuery(".status-deploy").hover(function (e){
        id = jQuery(this).attr('id');
        jQuery('div[id="'+id+'"]').show();
    });
    jQuery(".status-deploy").mouseleave(function (e){
        id = jQuery(this).attr('id');
        jQuery('div[id="'+id+'"]').hide();
    });
});
