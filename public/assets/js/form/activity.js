$(function() {
	var predefinedActs = [
	"Hiking",
	"Yoga",
	"Zumba",
	"P90X",
	"Kick Boxing",
	"Swimming",
	"Yard Work",
	"Walk Dog",
	"Gardening",
	"Weight Training",
	"Elliptical",
	"Calisthenics",
	"Disc Golf",
	"Jogging",
	"Basketball"
	];
	
	$("#activity_text_input").autocomplete({
		source: predefinedActs
	});
});


