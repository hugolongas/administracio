$(document).ready(function(){
	$("#fuCartell").on('change', function () {
		var file = $(this)[0].files[0];
		if(file.type.match('image.*'))
		{
			if (typeof (FileReader) != "undefined") {
				var reader = new FileReader();
				reader.onload = function (e) {
					$("#imgThumb").attr("src",e.target.result);
				}
				reader.readAsDataURL($(this)[0].files[0]);
			} else {
				alert("This browser does not support FileReader.");
			}
		}else{
			$("#fuCartell").val("");
		}
	});
});