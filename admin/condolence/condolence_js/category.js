function editCategoryDetails(catId){
var dataString = "catID="+catId+"&action=editcategory";
	var pageUrl='http://localhost/funeral/admin/category_form_action.php';
	$.ajax({
		type: "POST",
		url:pageUrl,
		data: dataString,
		cache: false,
		success: function(data){
			alert('@@@@@@@@@@2');
			 var res = jQuery.parseJSON(data);
			 //alert(res);
		}
	});

}