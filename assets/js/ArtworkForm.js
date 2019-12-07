export default class ArtworkForm {
    constructor() {
        this.radios = null;
        this.form = document.querySelector('form[name="artwork"]');
        if (this.form) {
            this.init()
        }
    }

    init() {
        this.radios = this.form.querySelectorAll('[name="artwork[category_type]"]');
        this.category = this.form.querySelector('#artwork_category')
        this.category_new = this.form.querySelector('#artwork_category_name')

        Array.from(this.radios).forEach((radio) => radio.addEventListener('click', () => this.action(radio)))
    }

    action(radio) {
        // if (radio.value) {
        //     this.category_new.attributes.setNamedItem('hidden', true);
        //     this.category.removeAttribute('hidden');
        // }
        // else {
        //     this.category.setAttribute('hidden', true);
        //     this.category_new.removeAttribute('hidden');
        // }
    }
}







