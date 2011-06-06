// JavaScript Document


var Sunray = {
	
	
	// variables
	lastID : 0,
	fetchMore : true,
	extending : false,
	postFormLoaded : false,
	
	
	// init function called on page load
	init : function () {
		Sunray.extendPostList();
	
		$("#graylayer").css({ opacity: 0.7 });
		
		$("#addbutton").click( function() {
			if (Sunray.postFormLoaded)
			{
				Sunray.togglePostForm();
			}
			else
			{
				$("#postformlayer").load("Services/add.php", function() {
					Sunray.postFormLoaded = true;
					Sunray.togglePostForm();
				});
			}
		});
		
		$("#graylayer").click( function() {
			Sunray.togglePostForm();
		});
		$("#postformlayer").click( function() {
			Sunray.togglePostForm();
		});
	},
	
	
	// other functions
	
	extendPostList : function () {
		if (!Sunray.extending)
		{
			Sunray.extending = true;
			var ndiv = $("<div>")
			ndiv.load("Services/fetch.php", {id : Sunray.lastID }, function () {
				if (parseInt(ndiv.children(".amount").text(), 10) > 0)
				{
					$("#posts").append(ndiv.children(".posts"));
					Sunray.lastID = parseInt(ndiv.children(".last").text(), 10);
				}
				else
				{
					Sunray.fetchMore = false;
					$("#end").toggle();
				}
				Sunray.extending = false;
			});
		}
	},
	
	togglePostForm : function () {
		$("#graylayer").fadeToggle("fast");
		$("#postformlayer").fadeToggle("fast");
	}
	
}


$(document).ready( function () { 
	Sunray.init();
} );



$(function () {
	var $win = $(window);

    $win.scroll(function () {
    	if (($win.height() + $win.scrollTop() == $(document).height()) && Sunray.fetchMore) {
				Sunray.extendPostList();
        }
	});
});