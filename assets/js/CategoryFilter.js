export default class CategoryFilter {

	constructor(){
		this.filtersParent = document.querySelector('.filters');
		if(this.filtersParent) {
			this.init()
		}
	}

	init(){
		this.filters = this.filtersParent.querySelectorAll('span');
		Array.from(this.filters).forEach((filter) => filter.addEventListener('click',() => this.click(filter)))
	}

	async click(filter) {
		const field = document.querySelector('.filters + .row')
		const category = filter.dataset.category;


		const request = new Request(`ajax/artworks/${category}`, {
			method: 'post',
			headers: {
				'X-Requested-With' : 'XMLHttpRequest'
			},
			body: JSON.stringify({
				slug: category,
			})
		});

		const query = await fetch(request);
		const response = await query.json();
		
		console.log(response);
		this.displayArtwoks(response.view, field);
	}

	displayArtwoks(view, field) {
		field.remove();
		this.filtersParent.insertAdjacentHTML('afterend',view)
	}
}







