(function ($) {
	var WidgetRadiantProgressBarHandler = function ($scope) {
		$('.rt-progressbar').each(function () {
			var elementPos = $(this).offset().top;
			var topOfWindow = $(window).scrollTop();
			var percent = $(this).find('.circle').attr('data-percent');
			var dcolor = $(this).find('.circle').attr('data-color');
			//var dcolor = 'red';
			var percentage = parseInt(percent, 10) / parseInt(100, 10);
			var animate = $(this).data('animate');
			if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
				$(this).data('animate', true);
				$(this).find('.circle').circleProgress({
					startAngle: -Math.PI / 2,
					value: percent / 100,
					size: 139,
					thickness: 10,
					emptyFill: "rgba(0,0,0, 0)",
					fill: {
						color: dcolor,
					}
				}).on('circle-animation-progress', function (event, progress, stepValue) {
					$(this).find('div').text((stepValue * 100).toFixed(0) + "%");
				}).stop();
			}
		});

		$('.ProgressBar--animateAll').each(function (options) {
			options = $.extend({
				animate: true,
				animateText: true
			}, options);

			var $this = $(this);
			var elementPos = $(this).offset().top;
			var topOfWindow = $(window).scrollTop();
			var $progressBar = $this;
			var $progressCount = $progressBar.find('.ProgressBar-percentage--count');
			var $circle = $progressBar.find('.ProgressBar-circle');
			var percentageProgress = $progressBar.attr('data-progress');
			var percentageRemaining = (100 - percentageProgress);
			var percentageText = $progressCount.parent().attr('data-progress');

			//Calcule la circonférence du cercle
			var radius = $circle.attr('r');
			var diameter = radius * 2;
			var circumference = Math.round(Math.PI * diameter);

			//Calcule le pourcentage d'avancement
			var percentage = circumference * percentageRemaining / 100;

			$circle.css({
				'stroke-dasharray': circumference,
				'stroke-dashoffset': percentage
			})

			if (elementPos < topOfWindow + $(window).height() - 30) {
				//Animation de la barre de progression
				if (options.animate === true) {
					$circle.css({
						'stroke-dashoffset': circumference
					}).animate({
						'stroke-dashoffset': percentage
					}, 3000)
				}

				//Animation du texte (pourcentage)
				if (options.animateText == true) {

					$({ Counter: 0 }).animate(
						{ Counter: percentageText },
						{
							duration: 3000,
							step: function () {
								$progressCount.text(Math.ceil(this.Counter) + '%');
							}
						});

				} else {
					$progressCount.text(percentageText + '%');
				}
			}
		});

		var $rtProgressbarContainer = $scope.find(".rt-progressbar-container");
		var settings = $rtProgressbarContainer.data("settings");
		if (settings !== undefined) {
			length = settings.progress_length;
			speed = settings.speed;
			var $progressbar = $rtProgressbarContainer.find(".rt-progressbar-bar");

			$progressbar.animate({
				width: length
			}, speed);
		}
	};

	var WidgetRadiantProgressBarScrollHandler = function ($scope, $) {
		elementorFrontend.waypoint($scope, function () {
			WidgetRadiantProgressBarHandler($(this));
		}, {
			offset: Waypoint.viewportHeight() - 150,
			triggerOnce: true
		});
	};

	$(window).on("elementor/frontend/init", function () {
		if (elementorFrontend.isEditMode()) {
			elementorFrontend.hooks.addAction(
				"frontend/element_ready/radiant-progressbar.default", WidgetRadiantProgressBarHandler);
		} else {
			elementorFrontend.hooks.addAction(
				"frontend/element_ready/radiant-progressbar.default", WidgetRadiantProgressBarScrollHandler);
		}
	});
})(jQuery);