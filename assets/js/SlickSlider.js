
export default class SlickSlider {

	constructor($) {
		this.slickDiv = document.querySelector('.diapo');
		this.$ = $;
		if (this.slickDiv) {
			this.init();
		}
	}

	init() {
		this.slick = this.$('.diapo').slick({
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			dots: true,
			speed: 1000,
			autoplay: true,
			autoplaySpeed: 2000,
		});

	}

}







