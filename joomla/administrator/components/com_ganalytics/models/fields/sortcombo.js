function updateSortCombo(form){
	if(form == null){
		return;
	}
	var combo = form.find('.sortcombo');
	
	if(form.find('.dimensionscombo option').length < 2 && form.find('.metricscombo option').length < 2) {
		return;
	}
	
	var oldValue = combo.val();
	
	// we are initializing it
	if(combo.find('option').length < 2 && combo.find('option').val() != null) {
		oldValue = combo.find('option').val().split(',');
	}
	
	combo.multiselect2side('destroy');
	
	combo.html('');
	combo.append(jQuery('<option></option>').val('').html(''));
	
	form.find('.dimensionscombo :selected').each(function() {
		var option = jQuery(this);
		combo.append(jQuery('<option></option>').val(option.val()).html(option.html()));
		combo.append(jQuery('<option></option>').val('-'+option.val()).html('-'+option.html()));
	});
	form.find('.metricscombo :selected').each(function() {
		var option = jQuery(this);
		combo.append(jQuery('<option></option>').val(option.val()).html(option.html()));
		combo.append(jQuery('<option></option>').val('-'+option.val()).html('-'+option.html()));
	});
	
	if(oldValue != null && oldValue.length > 0) {
		var first = combo.children("option").not(":selected").first();
		jQuery.each(oldValue, function(index, item) {
			var option = combo.find("[value='" + item + "']");
			option.attr('selected', true);
			option.insertBefore(first);
		});
	}
	
	createMultiSelectCombo(form.find('.sortcombo'));
}

function createMultiSelectCombo(element){
	element.multiselect2side({
		optGroupSearch: false, // &nbps;
		search: false, //"<img src='components/com_ganalytics/libraries/jquery/multiselect/img/search.gif' />",
		labelTop: '+ +',
		labelBottom: '- -',
		labelUp: '+',
		labelDown: '-',
		labelSort: '',
		labelsx: null,
		labeldx: null
	});
}

jQuery(document).ready(function() {
	jQuery('.dimensionscombo').live('change', function() {
		updateSortCombo(jQuery(this).parents('form'));
	});
	jQuery('.metricscombo').live('change', function() {
		updateSortCombo(jQuery(this).parents('form'));
	});

	jQuery('.dimensionscombo').each(function() {
		updateSortCombo(jQuery(this).parents('form'));
	});
});