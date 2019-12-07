export default class FileUplaod {
    constructor() {
        this.fileField = document.querySelector('input[type="file"]');
        this.zoneUplaod = document.querySelector('.custom-file-label');
        if (this.fileField) {
            this.init()
        }
    }

    init() {
        this.fileField.addEventListener('change', this.change.bind(this));
        if(this.fileField.dataset.src !== ""){
            let img = this.zoneUplaod.querySelector('img');
            if (img === null) {
                img = document.createElement('img');
                this.zoneUplaod.appendChild(img);
                img.setAttribute('src', this.fileField.dataset.src);
            }
        }
    }

    change(){
        let file = this.fileField.files[0];
        let img = this.zoneUplaod.querySelector('img');
        if (img === null) {
            img = document.createElement('img');
            this.zoneUplaod.appendChild(img);
        }
        this.getBase64(file).then( (accept) => {
            img.setAttribute('src', accept);
            this.zoneUplaod.classList.add('uploaded');
        });
    }

    getBase64(file) {
        return new Promise(function (resolve, reject) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            let base64 = "null";
            reader.addEventListener('load', function () {
                base64 = reader.result;
                resolve(base64);
            });
        });
    }
    
}







