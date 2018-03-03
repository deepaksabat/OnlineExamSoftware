 $(document).ready(function () {
 	sidebarStatus = false;
 	$('#sidebarToggle').click(function () {
 		if (sidebarStatus == false) {
 			$('#wrapper').animate({
 				paddingRight: "30px"
 			}, 'medium');
 			$('#rightSidebar').animate({
 				right: "-370px"
 			}, 'medium');
 			sidebarStatus = true;
 			subjectStatus = false;
 		} else {
 			if ($(window).width() < 1367) {
 				$('#wrapper').animate({
 					paddingRight: "400px"
 					, paddingLeft: "90px"
 				}, 'medium');
 			} else {
 				$('#wrapper').animate({
 					paddingRight: "400px"
 					, paddingLeft: "120px"
 				}, 'medium');
 			};
 			$('#rightSidebar').animate({
 				right: "0px"
 			}, 'medium');
 			$('#subjectSidebar').animate({
 				left: "-370px"
 			}, 'medium');
 			sidebarStatus = false;
 			subjectStatus = true;
 		}
 	});
 	subjectStatus = false;
 	$('#subjectBar').click(function () {
 		if (subjectStatus == false) {
 			$('#wrapper').animate({
 				paddingLeft: "490px"
 				, paddingRight: "30px"
 			}, 'medium');
 			$('#subjectSidebar').animate({
 				left: "120px"
 			}, 'medium');
 			$('#rightSidebar').animate({
 				right: "-370px"
 			}, 'medium');
 			subjectStatus = true;
 			sidebarStatus = false;
 		} else {
 			if ($(window).width() < 1367) {
 				$('#wrapper').animate({
 					paddingLeft: "90px"
 				}, 'medium');
 			} else {

 				$('#wrapper').animate({
 					paddingLeft: "120px"
 				}, 'medium');
 			};

 			$('#subjectSidebar').animate({
 				left: "-370px"
 			}, 'medium');

 			subjectStatus = false;
 			sidebarStatus = true;
 		}
 	});


 });



 $(document).ready(function () {
 	$('[data-toggle="tooltip"]').tooltip();


 	var maxheight = 60;
 	var showText = "<i class='mdi mdi-plus-circle'></i>";
 	var hideText = "<i class='mdi mdi-minus-circle'></i>";

 	$('.collapstext').each(function () {
 		var text = $(this);
 		if (text.height() > maxheight) {
 			text.css({
 				'overflow': 'hidden'
 				, 'height': maxheight + 'px'
 			});
 			var link = $('<a href="#">' + showText + '</a>');
 			var linkDiv = $('<div class="pull-right collaps-button"></div>');
 			linkDiv.append(link);
 			$(this).after(linkDiv);

 			link.click(function (event) {
 				event.preventDefault();
 				if (text.height() > maxheight) {
 					$(this).html(showText);
 					text.css('height', maxheight + 'px');
 				} else {
 					$(this).html(hideText);
 					text.css('height', 'auto');
 				}
 			});
 		}
 	});
 });