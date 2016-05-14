Joomla.submitbutton = function(task)
{
	if (task == '')
	{
		return false;
	}
	else
	{
		var isValid=true;
		var msg = false;
		var action = task.split('.');
		if (action[1] != 'cancel' && action[1] != 'close')
		{
			var forms = $$('form.form-validate');
			for (var i=0;i<forms.length;i++)
			{
				if (!document.formvalidator.isValid(forms[i]))
				{
					isValid = false;
					break;
				}
			}
			if ($('jform_start_date').value > $('jform_end_date').value)
			{							
				isValid = false;
				alert(Joomla.JText._('COM_AVAILCAL_AVAILCAL_ERROR_DATE','Some values are unacceptable'));
				return false; 
			}	
		}
		
		
		if (isValid)
		{
			Joomla.submitform(task, document.getElementById('item-form'));
			
		}
		else
		{			
				alert(Joomla.JText._('COM_AVAILCAL_AVAILCAL_ERROR_UNACCEPTABLE','Some values are unacceptable'));
				return false;
			
		}
	}
};
