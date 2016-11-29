$(function (){
	$("#discharge_date").datepicker({
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
		yearRange: '1915:2016',

	});

	$("#date_expiry").datepicker({
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
		yearRange: '1915:2016',

	});

	$("#birth_date").datepicker({
    dateFormat: 'mm/dd/yy',
    defaultDate: '27/11/2016',
    changeMonth: true,
    changeYear: true,
    yearRange: '1915:2010',
	});
});
